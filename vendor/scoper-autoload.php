<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('ComposerAutoloaderInit8f25f5b6013d055b9c0106fd82337495', false) && !interface_exists('ComposerAutoloaderInit8f25f5b6013d055b9c0106fd82337495', false) && !trait_exists('ComposerAutoloaderInit8f25f5b6013d055b9c0106fd82337495', false)) {
    spl_autoload_call('ConfigTransformer202107101\ComposerAutoloaderInit8f25f5b6013d055b9c0106fd82337495');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('ConfigTransformer202107101\Normalizer');
}
if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
    spl_autoload_call('ConfigTransformer202107101\JsonException');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
    spl_autoload_call('ConfigTransformer202107101\Attribute');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
    spl_autoload_call('ConfigTransformer202107101\Stringable');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
    spl_autoload_call('ConfigTransformer202107101\UnhandledMatchError');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
    spl_autoload_call('ConfigTransformer202107101\ValueError');
}
if (!class_exists('ReturnTypeWillChange', false) && !interface_exists('ReturnTypeWillChange', false) && !trait_exists('ReturnTypeWillChange', false)) {
    spl_autoload_call('ConfigTransformer202107101\ReturnTypeWillChange');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequire8f25f5b6013d055b9c0106fd82337495')) {
    function composerRequire8f25f5b6013d055b9c0106fd82337495() {
        return \ConfigTransformer202107101\composerRequire8f25f5b6013d055b9c0106fd82337495(...func_get_args());
    }
}
if (!function_exists('parseArgs')) {
    function parseArgs() {
        return \ConfigTransformer202107101\parseArgs(...func_get_args());
    }
}
if (!function_exists('showHelp')) {
    function showHelp() {
        return \ConfigTransformer202107101\showHelp(...func_get_args());
    }
}
if (!function_exists('formatErrorMessage')) {
    function formatErrorMessage() {
        return \ConfigTransformer202107101\formatErrorMessage(...func_get_args());
    }
}
if (!function_exists('preprocessGrammar')) {
    function preprocessGrammar() {
        return \ConfigTransformer202107101\preprocessGrammar(...func_get_args());
    }
}
if (!function_exists('resolveNodes')) {
    function resolveNodes() {
        return \ConfigTransformer202107101\resolveNodes(...func_get_args());
    }
}
if (!function_exists('resolveMacros')) {
    function resolveMacros() {
        return \ConfigTransformer202107101\resolveMacros(...func_get_args());
    }
}
if (!function_exists('resolveStackAccess')) {
    function resolveStackAccess() {
        return \ConfigTransformer202107101\resolveStackAccess(...func_get_args());
    }
}
if (!function_exists('magicSplit')) {
    function magicSplit() {
        return \ConfigTransformer202107101\magicSplit(...func_get_args());
    }
}
if (!function_exists('assertArgs')) {
    function assertArgs() {
        return \ConfigTransformer202107101\assertArgs(...func_get_args());
    }
}
if (!function_exists('removeTrailingWhitespace')) {
    function removeTrailingWhitespace() {
        return \ConfigTransformer202107101\removeTrailingWhitespace(...func_get_args());
    }
}
if (!function_exists('regex')) {
    function regex() {
        return \ConfigTransformer202107101\regex(...func_get_args());
    }
}
if (!function_exists('execCmd')) {
    function execCmd() {
        return \ConfigTransformer202107101\execCmd(...func_get_args());
    }
}
if (!function_exists('ensureDirExists')) {
    function ensureDirExists() {
        return \ConfigTransformer202107101\ensureDirExists(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \ConfigTransformer202107101\setproctitle(...func_get_args());
    }
}
if (!function_exists('array_is_list')) {
    function array_is_list() {
        return \ConfigTransformer202107101\array_is_list(...func_get_args());
    }
}
if (!function_exists('enum_exists')) {
    function enum_exists() {
        return \ConfigTransformer202107101\enum_exists(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \ConfigTransformer202107101\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \ConfigTransformer202107101\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \ConfigTransformer202107101\dd(...func_get_args());
    }
}

return $loader;
