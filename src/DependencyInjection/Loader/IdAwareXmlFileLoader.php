<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\Symplify\ConfigTransformer\DependencyInjection\Loader;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use ConfigTransformer202107154\Nette\Utils\Strings;
use ConfigTransformer202107154\Symfony\Component\Config\FileLocatorInterface;
use ConfigTransformer202107154\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107154\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202107154\Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use ConfigTransformer202107154\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202107154\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer202107154\Symplify\ConfigTransformer\Naming\UniqueNaming;
use ConfigTransformer202107154\Symplify\ConfigTransformer\ValueObject\SymfonyVersionFeature;
use ConfigTransformer202107154\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * Mimics https://github.com/symfony/symfony/commit/b8c68da0107a4f433dd414a355ea5589da0da0e8 for Symfony 3.3-
 */
final class IdAwareXmlFileLoader extends \ConfigTransformer202107154\Symfony\Component\DependencyInjection\Loader\XmlFileLoader
{
    /**
     * @var string
     */
    private const ID = 'id';
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var int|null
     */
    private $count;
    /**
     * @var \Symplify\ConfigTransformer\Configuration\Configuration
     */
    private $configuration;
    /**
     * @var \Symplify\ConfigTransformer\Naming\UniqueNaming
     */
    private $uniqueNaming;
    /**
     * @var \Symplify\ConfigTransformer\Collector\XmlImportCollector
     */
    private $xmlImportCollector;
    public function __construct(\ConfigTransformer202107154\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \ConfigTransformer202107154\Symfony\Component\Config\FileLocatorInterface $fileLocator, \ConfigTransformer202107154\Symplify\ConfigTransformer\Configuration\Configuration $configuration, \ConfigTransformer202107154\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer202107154\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->configuration = $configuration;
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
        parent::__construct($containerBuilder, $fileLocator);
        $this->privatesCaller = new \ConfigTransformer202107154\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function import($resource, $type = null, $ignoreErrors = \false, $sourceResource = null, $exclude = null) : void
    {
        $this->xmlImportCollector->addImport($resource, $ignoreErrors);
    }
    /**
     * @param string|null $type
     */
    public function load($resource, $type = null) : void
    {
        $path = $this->locator->locate($resource);
        $xml = $this->privatesCaller->callPrivateMethod($this, 'parseFileToDOM', [$path]);
        $this->container->fileExists($path);
        $defaults = $this->privatesCaller->callPrivateMethod($this, 'getServiceDefaults', [$xml, $path]);
        $this->processAnonymousServices($xml, $path);
        // imports
        $this->privatesCaller->callPrivateMethod($this, 'parseImports', [$xml, $path]);
        // parameters
        $this->privatesCaller->callPrivateMethod($this, 'parseParameters', [$xml, $path]);
        // extensions
        $this->privatesCaller->callPrivateMethod($this, 'loadFromExtensions', [$xml]);
        // services
        try {
            $this->privatesCaller->callPrivateMethod($this, 'parseDefinitions', [$xml, $path, $defaults]);
        } finally {
            $this->instanceof = [];
            $this->registerAliasesForSinglyImplementedInterfaces();
        }
    }
    private function processAnonymousServices(\DOMDocument $domDocument, string $file) : void
    {
        $this->count = 0;
        $definitions = [];
        $suffix = '~' . \ConfigTransformer202107154\Symfony\Component\DependencyInjection\ContainerBuilder::hash($file);
        $domxPath = new \DOMXPath($domDocument);
        $domxPath->registerNamespace('container', self::NS);
        $definitions = $this->processAnonymousServicesInArguments($domxPath, $suffix, $file, $definitions);
        /** @var DOMNodeList<DOMNode> $nodeWithIds */
        $nodeWithIds = $domxPath->query('//container:services/container:service[@id]');
        $hasNamedServices = (bool) $nodeWithIds->length;
        // anonymous services "in the wild"
        $anonymousServiceNodes = $domxPath->query('//container:services/container:service[not(@id)]');
        if ($anonymousServiceNodes !== \false) {
            /** @var DOMElement $node */
            foreach ($anonymousServiceNodes as $node) {
                $id = $this->createAnonymousServiceId($hasNamedServices, $node, $file);
                $node->setAttribute(self::ID, $id);
                $definitions[$id] = [$node, $file, \true];
            }
        }
        // resolve definitions
        \uksort($definitions, 'strnatcmp');
        $inversedDefinitions = \array_reverse($definitions);
        foreach ($inversedDefinitions as $id => [$domElement, $file]) {
            $definition = $this->privatesCaller->callPrivateMethod($this, 'parseDefinition', [$domElement, $file, new \ConfigTransformer202107154\Symfony\Component\DependencyInjection\Definition()]);
            if ($definition !== null) {
                $this->setDefinition($id, $definition);
            }
        }
    }
    /**
     * @return mixed[]
     */
    private function processAnonymousServicesInArguments(\DOMXPath $domxPath, string $suffix, string $file, array $definitions) : array
    {
        $nodes = $domxPath->query('//container:argument[@type="service"][not(@id)]|//container:property[@type="service"][not(@id)]|//container:bind[not(@id)]|//container:factory[not(@service)]|//container:configurator[not(@service)]');
        if ($nodes !== \false) {
            /** @var DOMElement $node */
            foreach ($nodes as $node) {
                // get current service id
                $parentNode = $node->parentNode;
                \assert($parentNode instanceof \DOMElement);
                // @see https://stackoverflow.com/a/28944/1348344
                $parentServiceId = $parentNode->getAttribute('id');
                $services = $this->privatesCaller->callPrivateMethod($this, 'getChildren', [$node, 'service']);
                if ($services !== []) {
                    $id = $this->createUniqueServiceNameFromClass($services[0], $parentServiceId);
                    $node->setAttribute(self::ID, $id);
                    $node->setAttribute('service', $id);
                    $definitions[$id] = [$services[0], $file];
                    $services[0]->setAttribute(self::ID, $id);
                    // anonymous services are always private
                    // we could not use the constant false here, because of XML parsing
                    $services[0]->setAttribute('public', 'false');
                }
            }
        }
        return $definitions;
    }
    private function createUniqueServiceNameFromClass(\DOMElement $serviceDomElement, string $parentServiceId) : string
    {
        $class = $serviceDomElement->getAttribute('class');
        $serviceName = $parentServiceId . '.' . $this->createServiceNameFromClass($class);
        return $this->uniqueNaming->uniquateName($serviceName);
    }
    private function createServiceNameFromClass(string $class) : string
    {
        $serviceName = \ConfigTransformer202107154\Nette\Utils\Strings::replace($class, '#\\\\#', '.');
        $serviceName = \strtolower($serviceName);
        return $this->uniqueNaming->uniquateName($serviceName);
    }
    private function createAnonymousServiceId(bool $hasNamedServices, \DOMElement $domElement, string $file) : string
    {
        $className = $domElement->getAttribute('class');
        if ($hasNamedServices) {
            return $this->createServiceNameFromClass($className);
        }
        if (!$this->configuration->isAtLeastSymfonyVersion(\ConfigTransformer202107154\Symplify\ConfigTransformer\ValueObject\SymfonyVersionFeature::SERVICE_WITHOUT_NAME)) {
            return $this->createServiceNameFromClass($className);
        }
        $hashedFileName = \hash('sha256', $file);
        return \sprintf('%d_%s', ++$this->count, $hashedFileName);
    }
}
