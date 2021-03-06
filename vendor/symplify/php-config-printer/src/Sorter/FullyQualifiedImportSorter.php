<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\Symplify\PhpConfigPrinter\Sorter;

use ConfigTransformer202107154\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer202107154\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class FullyQualifiedImportSorter
{
    /**
     * @var array<string, int>
     */
    private const TYPE_ORDER = [\ConfigTransformer202107154\Symplify\PhpConfigPrinter\ValueObject\ImportType::CLASS_TYPE => 0, \ConfigTransformer202107154\Symplify\PhpConfigPrinter\ValueObject\ImportType::CONSTANT_TYPE => 1, \ConfigTransformer202107154\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE => 2];
    /**
     * @param FullyQualifiedImport[] $imports
     *
     * @return FullyQualifiedImport[]
     */
    public function sortImports(array $imports) : array
    {
        $sortByFullQualifiedCallback = function ($left, $right) : int {
            return \strcmp($left->getFullyQualified(), $right->getFullyQualified());
        };
        \usort($imports, $sortByFullQualifiedCallback);
        $sortByTypeCallback = function ($left, $right) : int {
            return self::TYPE_ORDER[$left->getType()] <=> self::TYPE_ORDER[$right->getType()];
        };
        \usort($imports, $sortByTypeCallback);
        return $imports;
    }
}
