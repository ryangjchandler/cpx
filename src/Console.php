<?php

namespace Cpx;

use Closure;

final class Console
{
    private static $styleStack = [];

    public static function bold(Closure $callback)
    {
        self::$styleStack[] = "\033[1m";

        $callback();

        static::reset();
    }

    public static function write(string $output)
    {
        static::reset();
        echo $output.PHP_EOL;
    }

    public static function info(string $output)
    {
        $styles = implode('', static::$styleStack);

        echo "\e[0;32m{$styles}{$output}".PHP_EOL;

        static::reset();
    }

    public static function warning(string $output)
    {
        $styles = implode('', static::$styleStack);

        echo "\e[0;33m{$styles}{$output}".PHP_EOL;

        static::reset();
    }

    public static function error(string $output)
    {
        $styles = implode('', static::$styleStack);

        echo "\e[0;31m{$styles}{$output}".PHP_EOL;
        
        static::reset();
        
        exit(1);
    }

    public static function reset()
    {
        self::$styleStack = [];

        echo "\e[0m";
    }
}