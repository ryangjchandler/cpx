<?php

namespace Cpx;

use TitasGailius\Terminal\Terminal;

final class InstallPackage
{
    public static function execute(Package $package)
    {
        Console::info("Installing {$package->name}...");

        $response = Terminal::builder()
            ->enableTty()
            ->run("composer global require {$package->name} --quiet");

        $response->throw();

        return true;
    }
}