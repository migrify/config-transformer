<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer202107154\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107154\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer202107154\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer202107154\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer202107154\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer202107154\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer202107154\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer202107154\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
