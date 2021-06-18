<?php

declare (strict_types=1);
namespace ConfigTransformer202106188\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202106188\PhpParser\Builder\Use_;
use ConfigTransformer202106188\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202106188\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202106188\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}