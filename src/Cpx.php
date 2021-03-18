<?php

namespace Cpx;

use Exception;
use TitasGailius\Terminal\Terminal;

final class Cpx
{
    private static $version = '0.1.2';

    private static $argv = [];

    public static function run($argv)
    {
        self::maybeShowHelpMessage($argv);

        $package = new Package(
            static::$argv[0]
        );

        if (! $package->hasValidName()) {
            Console::bold(fn () =>
                Console::error("The package name {$package->name} is not valid.")
            );
        }

        if ($package->isInstalledLocally()) {
            RunPackageBinary::local($package);
        } elseif ($package->isInstalledGlobally()) {
            RunPackageBinary::global($package);
        } elseif ($package->isRemote()) {
            RunPackageBinary::remote($package);
        } else {
            RunPackageBinary::temporary($package);
        }

        exit(0);
    }

    public static function argument(int $index, $default = null)
    {
        return self::$argv[$index] ?? $default;
    }

    public static function arguments($withName = true)
    {
        $arguments = self::$argv;

        if (! $withName) {
            array_shift($arguments);
        }

        return $arguments;
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
