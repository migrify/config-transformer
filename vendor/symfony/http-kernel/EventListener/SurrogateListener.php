<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107036\Symfony\Component\HttpKernel\EventListener;

use ConfigTransformer202107036\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ConfigTransformer202107036\Symfony\Component\HttpKernel\Event\ResponseEvent;
use ConfigTransformer202107036\Symfony\Component\HttpKernel\HttpCache\HttpCache;
use ConfigTransformer202107036\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;
use ConfigTransformer202107036\Symfony\Component\HttpKernel\KernelEvents;
/**
 * SurrogateListener adds a Surrogate-Control HTTP header when the Response needs to be parsed for Surrogates.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SurrogateListener implements \ConfigTransformer202107036\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $surrogate;
    public function __construct(\ConfigTransformer202107036\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface $surrogate = null)
    {
        $this->surrogate = $surrogate;
    }
    /**
     * Filters the Response.
     */
    public function onKernelResponse(\ConfigTransformer202107036\Symfony\Component\HttpKernel\Event\ResponseEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $kernel = $event->getKernel();
        $surrogate = $this->surrogate;
        if ($kernel instanceof \ConfigTransformer202107036\Symfony\Component\HttpKernel\HttpCache\HttpCache) {
            $surrogate = $kernel->getSurrogate();
            if (null !== $this->surrogate && $this->surrogate->getName() !== $surrogate->getName()) {
                $surrogate = $this->surrogate;
            }
        }
        if (null === $surrogate) {
            return;
        }
        $surrogate->addSurrogateControl($event->getResponse());
    }
    public static function getSubscribedEvents() : array
    {
        return [\ConfigTransformer202107036\Symfony\Component\HttpKernel\KernelEvents::RESPONSE => 'onKernelResponse'];
    }
}
