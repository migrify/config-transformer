<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106130\Symfony\Component\ErrorHandler\ErrorRenderer;

use ConfigTransformer202106130\Symfony\Component\ErrorHandler\Exception\FlattenException;
use ConfigTransformer202106130\Symfony\Component\VarDumper\Cloner\VarCloner;
use ConfigTransformer202106130\Symfony\Component\VarDumper\Dumper\CliDumper;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202106130\Symfony\Component\VarDumper\Dumper\CliDumper::class);
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CliErrorRenderer implements \ConfigTransformer202106130\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(\Throwable $exception) : \ConfigTransformer202106130\Symfony\Component\ErrorHandler\Exception\FlattenException
    {
        $cloner = new \ConfigTransformer202106130\Symfony\Component\VarDumper\Cloner\VarCloner();
        $dumper = new class extends \ConfigTransformer202106130\Symfony\Component\VarDumper\Dumper\CliDumper
        {
            protected function supportsColors() : bool
            {
                $outputStream = $this->outputStream;
                $this->outputStream = \fopen('php://stdout', 'w');
                try {
                    return parent::supportsColors();
                } finally {
                    $this->outputStream = $outputStream;
                }
            }
        };
        return \ConfigTransformer202106130\Symfony\Component\ErrorHandler\Exception\FlattenException::createFromThrowable($exception)->setAsString($dumper->dump($cloner->cloneVar($exception), \true));
    }
}
