<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\PhpParser;

class ParserFactory
{
    const PREFER_PHP7 = 1;
    const PREFER_PHP5 = 2;
    const ONLY_PHP7 = 3;
    const ONLY_PHP5 = 4;
    /**
     * Creates a Parser instance, according to the provided kind.
     *
     * @param int        $kind  One of ::PREFER_PHP7, ::PREFER_PHP5, ::ONLY_PHP7 or ::ONLY_PHP5
     * @param Lexer|null $lexer Lexer to use. Defaults to emulative lexer when not specified
     * @param array      $parserOptions Parser options. See ParserAbstract::__construct() argument
     *
     * @return Parser The parser instance
     */
    public function create($kind, $lexer = null, $parserOptions = []) : \ConfigTransformer202107154\PhpParser\Parser
    {
        if (null === $lexer) {
            $lexer = new \ConfigTransformer202107154\PhpParser\Lexer\Emulative();
        }
        switch ($kind) {
            case self::PREFER_PHP7:
                return new \ConfigTransformer202107154\PhpParser\Parser\Multiple([new \ConfigTransformer202107154\PhpParser\Parser\Php7($lexer, $parserOptions), new \ConfigTransformer202107154\PhpParser\Parser\Php5($lexer, $parserOptions)]);
            case self::PREFER_PHP5:
                return new \ConfigTransformer202107154\PhpParser\Parser\Multiple([new \ConfigTransformer202107154\PhpParser\Parser\Php5($lexer, $parserOptions), new \ConfigTransformer202107154\PhpParser\Parser\Php7($lexer, $parserOptions)]);
            case self::ONLY_PHP7:
                return new \ConfigTransformer202107154\PhpParser\Parser\Php7($lexer, $parserOptions);
            case self::ONLY_PHP5:
                return new \ConfigTransformer202107154\PhpParser\Parser\Php5($lexer, $parserOptions);
            default:
                throw new \LogicException('Kind must be one of ::PREFER_PHP7, ::PREFER_PHP5, ::ONLY_PHP7 or ::ONLY_PHP5');
        }
    }
}
