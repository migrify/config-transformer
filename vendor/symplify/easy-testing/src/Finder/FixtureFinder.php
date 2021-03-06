<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\Symplify\EasyTesting\Finder;

use ConfigTransformer202107154\Symfony\Component\Finder\Finder;
use ConfigTransformer202107154\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202107154\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var \Symplify\SmartFileSystem\Finder\FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\ConfigTransformer202107154\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \ConfigTransformer202107154\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
