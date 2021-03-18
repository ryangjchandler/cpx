<?php

namespace Cpx;

use TitasGailius\Terminal\Terminal;

final class UninstallPackage
{
    public static function execute(Package $package)
    {
        Console::info("Removing {$package->name}...");

        $response = Terminal::builder()
            ->enableTty()
            ->run("composer global remove {$package->name} --quiet");

        $response->throw();

        return true;
    }
}