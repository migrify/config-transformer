<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\SymfonyVersionFeature;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;

final class AutoBindNodeFactory
{
    /**
     * @var string
     */
    public const TYPE_SERVICE = 'service';

    /**
     * @var string
     */
    public const TYPE_DEFAULTS = 'defaults';

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        CommonNodeFactory $commonNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        Configuration $configuration
    ) {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->configuration = $configuration;
    }

    /**
     * Decorated node with:
     * ->autowire()
     * ->autoconfigure()
     * ->bind()
     */
    public function createAutoBindCalls(array $yaml, MethodCall $methodCall, string $type): MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall, $type);
            }

            if ($key === YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall, $type);
            }

            if ($key === YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall, $type);
            }

            if ($key === YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[YamlKey::BIND]);
            }
        }

        return $methodCall;
    }

    private function createBindMethodCall(MethodCall $methodCall, array $bindValues): MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new MethodCall($methodCall, YamlKey::BIND, $args);
        }

        return $methodCall;
    }

    private function createAutowire($value, MethodCall $methodCall, string $type): MethodCall
    {
        if ($value === true) {
            return new MethodCall($methodCall, YamlKey::AUTOWIRE);
        }

        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }

        $args = [new Arg($this->commonNodeFactory->createFalse())];
        return new MethodCall($methodCall, YamlKey::AUTOWIRE, $args);
    }

    private function createAutoconfigure($value, MethodCall $methodCall, string $type)
    {
        if ($value === true) {
            return new MethodCall($methodCall, YamlKey::AUTOCONFIGURE);
        }

        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }

        $args = [new Arg($this->commonNodeFactory->createFalse())];
        return new MethodCall($methodCall, YamlKey::AUTOCONFIGURE, $args);
    }

    private function createPublicPrivate($value, MethodCall $methodCall, string $type): MethodCall
    {
        if ($value !== false) {
            return new MethodCall($methodCall, 'public');
        }

        // default value
        if ($type === self::TYPE_DEFAULTS) {
            if ($this->configuration->isAtLeastSymfonyVersion(SymfonyVersionFeature::PRIVATE_SERVICES_BY_DEFAULT)) {
                return $methodCall;
            }

            return new MethodCall($methodCall, 'private');
        }

        $args = [new Arg($this->commonNodeFactory->createFalse())];
        return new MethodCall($methodCall, 'public', $args);
    }
}
