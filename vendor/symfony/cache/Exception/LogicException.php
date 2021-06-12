<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106129\Symfony\Component\Cache\Exception;

use ConfigTransformer202106129\Psr\Cache\CacheException as Psr6CacheInterface;
use ConfigTransformer202106129\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\ConfigTransformer202106129\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \ConfigTransformer202106129\Psr\Cache\CacheException, \ConfigTransformer202106129\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \ConfigTransformer202106129\Psr\Cache\CacheException
    {
    }
}
