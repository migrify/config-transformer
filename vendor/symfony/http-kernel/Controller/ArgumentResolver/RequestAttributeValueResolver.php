<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021061210\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ConfigTransformer2021061210\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer2021061210\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ConfigTransformer2021061210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields a non-variadic argument's value from the request attributes.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class RequestAttributeValueResolver implements \ConfigTransformer2021061210\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(\ConfigTransformer2021061210\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer2021061210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        return !$argument->isVariadic() && $request->attributes->has($argument->getName());
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\ConfigTransformer2021061210\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer2021061210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        (yield $request->attributes->get($argument->getName()));
    }
}
