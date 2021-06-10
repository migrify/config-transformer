<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer20210610\Symfony\Component\VarDumper\Caster;

use ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * Casts a caster's Stub.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
 */
class StubCaster
{
    public static function castStub(\ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub $c, array $a, \ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        if ($isNested) {
            $stub->type = $c->type;
            $stub->class = $c->class;
            $stub->value = $c->value;
            $stub->handle = $c->handle;
            $stub->cut = $c->cut;
            $stub->attr = $c->attr;
            if (\ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub::TYPE_REF === $c->type && !$c->class && \is_string($c->value) && !\preg_match('//u', $c->value)) {
                $stub->type = \ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub::TYPE_STRING;
                $stub->class = \ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub::STRING_BINARY;
            }
            $a = [];
        }
        return $a;
    }
    public static function castCutArray(\ConfigTransformer20210610\Symfony\Component\VarDumper\Caster\CutArrayStub $c, array $a, \ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        return $isNested ? $c->preservedSubset : $a;
    }
    public static function cutInternals($obj, array $a, \ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        if ($isNested) {
            $stub->cut += \count($a);
            return [];
        }
        return $a;
    }
    public static function castEnum(\ConfigTransformer20210610\Symfony\Component\VarDumper\Caster\EnumStub $c, array $a, \ConfigTransformer20210610\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        if ($isNested) {
            $stub->class = $c->dumpKeys ? '' : null;
            $stub->handle = 0;
            $stub->value = null;
            $stub->cut = $c->cut;
            $stub->attr = $c->attr;
            $a = [];
            if ($c->value) {
                foreach (\array_keys($c->value) as $k) {
                    $keys[] = !isset($k[0]) || "\0" !== $k[0] ? \ConfigTransformer20210610\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . $k : $k;
                }
                // Preserve references with array_combine()
                $a = \array_combine($keys, $c->value);
            }
        }
        return $a;
    }
}
