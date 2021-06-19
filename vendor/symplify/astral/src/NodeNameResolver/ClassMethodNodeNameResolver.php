<?php

declare (strict_types=1);
namespace ConfigTransformer202106199\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202106199\PhpParser\Node;
use ConfigTransformer202106199\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202106199\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202106199\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106199\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202106199\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202106199\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
