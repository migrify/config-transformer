<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer20210610\Symfony\Component\ExpressionLanguage\Node;

use ConfigTransformer20210610\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class UnaryNode extends \ConfigTransformer20210610\Symfony\Component\ExpressionLanguage\Node\Node
{
    private const OPERATORS = ['!' => '!', 'not' => '!', '+' => '+', '-' => '-'];
    public function __construct(string $operator, \ConfigTransformer20210610\Symfony\Component\ExpressionLanguage\Node\Node $node)
    {
        parent::__construct(['node' => $node], ['operator' => $operator]);
    }
    public function compile(\ConfigTransformer20210610\Symfony\Component\ExpressionLanguage\Compiler $compiler)
    {
        $compiler->raw('(')->raw(self::OPERATORS[$this->attributes['operator']])->compile($this->nodes['node'])->raw(')');
    }
    public function evaluate(array $functions, array $values)
    {
        $value = $this->nodes['node']->evaluate($functions, $values);
        switch ($this->attributes['operator']) {
            case 'not':
            case '!':
                return !$value;
            case '-':
                return -$value;
        }
        return $value;
    }
    public function toArray() : array
    {
        return ['(', $this->attributes['operator'] . ' ', $this->nodes['node'], ')'];
    }
}
