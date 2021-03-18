<?php

namespace Cpx;

final class Package
{
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;    
    }

    public function hasValidName(): bool
    {
        if ($this->isRemote()) return true;

        preg_match('/^[a-z0-9]([_.-]?[a-z0-9]+)*\/[a-z0-9](([_.]?|-{0,2})[a-z0-9]+)*$/', $this->name, $matches);

        return count($matches) > 0;
    }

    public function isInstalledLocally(): bool
    {
        return is_dir(Utils::localComposerDirectory($this->name));
    }

    public function isInstalledGlobally(): bool
    {
        return is_dir(Utils::globalComposerDirectory($this->name));
    }

    public function isRemote(): bool
    {
        return Utils::stringStartsWith($this->name, 'http://')
            || Utils::stringStartsWith($this->name, 'https://');
    }

    public function getJson(string $key = null)
    {
        $path = $this->isInstalledLocally()
            ? Utils::localComposerDirectory($this->name.DIRECTORY_SEPARATOR.'composer.json')
            : Utils::globalComposerDirectory($this->name.DIRECTORY_SEPARATOR.'composer.json');

        $data = json_decode(
            file_get_contents($path), true
        );

        return $key ? $data[$key] : $data;
    }

    public function findBinary()
    {
        $binaries = $this->getJson('bin');

        if (! $binaries || count($binaries) === 0) {
            Console::error("The package {$this->name} does not have any binaries.");
        }

        $parts = explode('/', $binaries[0]);

        return $this->isInstalledLocally()
            ? Utils::localComposerDirectory('bin'.DIRECTORY_SEPARATOR.array_pop($parts))
            : Utils::globalComposerDirectory('bin'.DIRECTORY_SEPARATOR.array_pop($parts));
    }
}