<?php

namespace Cpx;

use Exception;
use TitasGailius\Terminal\Terminal;

final class Utils
{
    public static function globalComposerDirectory($path = '')
    {
        $response = Terminal::run('composer config --list --global');

        preg_match('/\[home\](.*)/', $response->output(), $matches);
    
        if (count($matches) < 2) {
            throw new Exception('Could not find Composer\'s global directory.');
        }
    
        return trim($matches[1]).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public static function localComposerDirectory($path = '')
    {
        return static::cwd('vendor').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public static function cwd($path = '')
    {
        return getcwd().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}