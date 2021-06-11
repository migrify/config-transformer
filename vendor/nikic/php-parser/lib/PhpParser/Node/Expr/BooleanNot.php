<?php

declare (strict_types=1);
namespace ConfigTransformer202106114\PhpParser\Node\Expr;

use ConfigTransformer202106114\PhpParser\Node\Expr;
class BooleanNot extends \ConfigTransformer202106114\PhpParser\Node\Expr
{
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a boolean not node.
     *
     * @param Expr $expr       Expression
     * @param array               $attributes Additional attributes
     */
    public function __construct(\ConfigTransformer202106114\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['expr'];
    }
    public function getType() : string
    {
        return 'Expr_BooleanNot';
    }
}