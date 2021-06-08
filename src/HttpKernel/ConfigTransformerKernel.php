<?php

declare (strict_types=1);
namespace ConfigTransformer20210608\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer20210608\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer20210608\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer20210608\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer20210608\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer20210608\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer20210608\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer20210608\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer20210608\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer20210608\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
