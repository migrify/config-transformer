<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107154\Symfony\Component\HttpKernel\DataCollector;

use ConfigTransformer202107154\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202107154\Symfony\Component\HttpFoundation\Response;
use ConfigTransformer202107154\Symfony\Contracts\Service\ResetInterface;
/**
 * DataCollectorInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface DataCollectorInterface extends \ConfigTransformer202107154\Symfony\Contracts\Service\ResetInterface
{
    /**
     * Collects data for the given Request and Response.
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Throwable|null $exception
     */
    public function collect($request, $response, $exception = null);
    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName();
}
