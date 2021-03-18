<?php

namespace Cpx;

final class Cpx
{
    private static $version = '0.0.1';

    private static $argv = [];

    public static function run($argv)
    {
        self::maybeShowHelpMessage($argv);
    }

    private static function maybeShowHelpMessage($argv)
    {
        array_shift($argv);

        if (count($argv) > 0 && ! (count($argv) === 1 && $argv[0] === '--help')) {
            return (self::$argv = $argv);
        }

        Console::bold(function () {
            Console::info('cpx v'.static::$version.PHP_EOL);
        });

        Console::warning('Quickly execute Composer package binaries locally, globally or from a URL.'.PHP_EOL);
        Console::write('Syntax: cpx [package] <options>'.PHP_EOL);
        Console::write('Example: cpx laravel/installer new my-project-name');

        exit(0);
    }
}