<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer20210610\PhpParser\Node\Expr\AssignOp;
class Minus extends \ConfigTransformer20210610\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Minus';
    }
}
