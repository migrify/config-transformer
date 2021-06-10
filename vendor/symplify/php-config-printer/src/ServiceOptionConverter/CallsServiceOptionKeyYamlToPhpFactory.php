<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer20210610\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer20210610\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use ConfigTransformer20210610\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class CallsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer20210610\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer20210610\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createCalls($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer20210610\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::CALLS;
    }
}
