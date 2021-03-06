<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107154\Symfony\Component\HttpKernel\Controller;

use ConfigTransformer202107154\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use ConfigTransformer202107154\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202107154\Symfony\Component\HttpFoundation\Response;
use ConfigTransformer202107154\Symfony\Component\HttpKernel\Exception\HttpException;
use ConfigTransformer202107154\Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * Renders error or exception pages from a given FlattenException.
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 * @author Matthias Pigulla <mp@webfactory.de>
 */
class ErrorController
{
    private $kernel;
    private $controller;
    private $errorRenderer;
    public function __construct(\ConfigTransformer202107154\Symfony\Component\HttpKernel\HttpKernelInterface $kernel, $controller, \ConfigTransformer202107154\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface $errorRenderer)
    {
        $this->kernel = $kernel;
        $this->controller = $controller;
        $this->errorRenderer = $errorRenderer;
    }
    public function __invoke(\Throwable $exception) : \ConfigTransformer202107154\Symfony\Component\HttpFoundation\Response
    {
        $exception = $this->errorRenderer->render($exception);
        return new \ConfigTransformer202107154\Symfony\Component\HttpFoundation\Response($exception->getAsString(), $exception->getStatusCode(), $exception->getHeaders());
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $code
     */
    public function preview($request, $code) : \ConfigTransformer202107154\Symfony\Component\HttpFoundation\Response
    {
        /*
         * This Request mimics the parameters set by
         * \Symfony\Component\HttpKernel\EventListener\ErrorListener::duplicateRequest, with
         * the additional "showException" flag.
         */
        $subRequest = $request->duplicate(null, null, ['_controller' => $this->controller, 'exception' => new \ConfigTransformer202107154\Symfony\Component\HttpKernel\Exception\HttpException($code, 'This is a sample exception.'), 'logger' => null, 'showException' => \false]);
        return $this->kernel->handle($subRequest, \ConfigTransformer202107154\Symfony\Component\HttpKernel\HttpKernelInterface::SUB_REQUEST);
    }
}
