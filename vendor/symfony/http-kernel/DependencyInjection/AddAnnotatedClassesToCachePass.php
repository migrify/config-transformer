<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106199\Symfony\Component\HttpKernel\DependencyInjection;

use ConfigTransformer202106199\Composer\Autoload\ClassLoader;
use ConfigTransformer202106199\Symfony\Component\Debug\DebugClassLoader as LegacyDebugClassLoader;
use ConfigTransformer202106199\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202106199\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202106199\Symfony\Component\ErrorHandler\DebugClassLoader;
use ConfigTransformer202106199\Symfony\Component\HttpKernel\Kernel;
/**
 * Sets the classes to compile in the cache for the container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddAnnotatedClassesToCachePass implements \ConfigTransformer202106199\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $kernel;
    public function __construct(\ConfigTransformer202106199\Symfony\Component\HttpKernel\Kernel $kernel)
    {
        $this->kernel = $kernel;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\ConfigTransformer202106199\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $annotatedClasses = $this->kernel->getAnnotatedClassesToCompile();
        foreach ($container->getExtensions() as $extension) {
            if ($extension instanceof \ConfigTransformer202106199\Symfony\Component\HttpKernel\DependencyInjection\Extension) {
                $annotatedClasses = \array_merge($annotatedClasses, $extension->getAnnotatedClassesToCompile());
            }
        }
        $existingClasses = $this->getClassesInComposerClassMaps();
        $annotatedClasses = $container->getParameterBag()->resolveValue($annotatedClasses);
        $this->kernel->setAnnotatedClassCache($this->expandClasses($annotatedClasses, $existingClasses));
    }
    /**
     * Expands the given class patterns using a list of existing classes.
     *
     * @param array $patterns The class patterns to expand
     * @param array $classes  The existing classes to match against the patterns
     */
    private function expandClasses(array $patterns, array $classes) : array
    {
        $expanded = [];
        // Explicit classes declared in the patterns are returned directly
        foreach ($patterns as $key => $pattern) {
            if ('\\' !== \substr($pattern, -1) && \false === \strpos($pattern, '*')) {
                unset($patterns[$key]);
                $expanded[] = \ltrim($pattern, '\\');
            }
        }
        // Match patterns with the classes list
        $regexps = $this->patternsToRegexps($patterns);
        foreach ($classes as $class) {
            $class = \ltrim($class, '\\');
            if ($this->matchAnyRegexps($class, $regexps)) {
                $expanded[] = $class;
            }
        }
        return \array_unique($expanded);
    }
    private function getClassesInComposerClassMaps() : array
    {
        $classes = [];
        foreach (\spl_autoload_functions() as $function) {
            if (!\is_array($function)) {
                continue;
            }
            if ($function[0] instanceof \ConfigTransformer202106199\Symfony\Component\ErrorHandler\DebugClassLoader || $function[0] instanceof \ConfigTransformer202106199\Symfony\Component\Debug\DebugClassLoader) {
                $function = $function[0]->getClassLoader();
            }
            if (\is_array($function) && $function[0] instanceof \ConfigTransformer202106199\Composer\Autoload\ClassLoader) {
                $classes += \array_filter($function[0]->getClassMap());
            }
        }
        return \array_keys($classes);
    }
    private function patternsToRegexps(array $patterns) : array
    {
        $regexps = [];
        foreach ($patterns as $pattern) {
            // Escape user input
            $regex = \preg_quote(\ltrim($pattern, '\\'));
            // Wildcards * and **
            $regex = \strtr($regex, ['\\*\\*' => '.*?', '\\*' => '[^\\\\]*?']);
            // If this class does not end by a slash, anchor the end
            if ('\\' !== \substr($regex, -1)) {
                $regex .= '$';
            }
            $regexps[] = '{^\\\\' . $regex . '}';
        }
        return $regexps;
    }
    private function matchAnyRegexps(string $class, array $regexps) : bool
    {
        $isTest = \false !== \strpos($class, 'Test');
        foreach ($regexps as $regex) {
            if ($isTest && \false === \strpos($regex, 'Test')) {
                continue;
            }
            if (\preg_match($regex, '\\' . $class)) {
                return \true;
            }
        }
        return \false;
    }
}
