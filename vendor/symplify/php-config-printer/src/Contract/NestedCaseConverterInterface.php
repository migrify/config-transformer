<?php

declare (strict_types=1);
namespace ConfigTransformer202107054\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202107054\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107054\PhpParser\Node\Stmt\Expression;
}
