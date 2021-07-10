<?php

declare (strict_types=1);
namespace ConfigTransformer202107101\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107101\PhpParser\Node;
use ConfigTransformer202107101\PhpParser\Node\Stmt\Property;
use ConfigTransformer202107101\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202107101\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202107101\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
