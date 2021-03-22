<?php

namespace Cpx;

use TitasGailius\Terminal\Terminal;

final class RunPackageBinary
{
    public static function local(Package $package)
    {
        $binary = $package->findBinary();

        if (! is_executable($binary)) {
            Console::error("The package {$package->name}'s binary is not executable.");
        }

        $command = implode(' ', [
            PHP_BINARY,
            $binary,
            ...Cpx::arguments(false)
        ]);

        $response = Terminal::builder()
            ->enableTty()
            ->run($command);

        $response->throw();

        Console::write($response->output());
    }

    public static function global(Package $package)
    {
        static::local($package);
    }

    public static function remote(Package $package)
    {
        if (strpos($package->name, 'github.com') === false) {
            Console::error('You can only execute remote GitHub Gists or repositories.');
        }

        Console::warning('Executing remote binaries is still in development.');
    }
    
    public static function temporary(Package $package)
    {
        $installed = InstallPackage::execute($package);

        if (! $installed) {
            Console::error('Something went wrong. Please try again.');
        }

        RunPackageBinary::global($package);

        $uninstalled = UninstallPackage::execute($package);

        if (! $uninstalled) {
            Console::error('Something went wrong. Please try again.');
        }
    }
}