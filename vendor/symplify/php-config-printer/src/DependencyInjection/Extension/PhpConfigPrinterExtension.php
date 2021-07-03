<?php

declare (strict_types=1);
namespace ConfigTransformer202107031\Symplify\PhpConfigPrinter\DependencyInjection\Extension;

use ConfigTransformer202107031\Symfony\Component\Config\FileLocator;
use ConfigTransformer202107031\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107031\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer202107031\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \ConfigTransformer202107031\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \ConfigTransformer202107031\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \ConfigTransformer202107031\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202107031\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
