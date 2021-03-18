> ✨ Help support the maintenance of this package by [sponsoring me](https://github.com/sponsors/ryangjchandler).

# `cpx`

Quickly execute [Composer](https://getcomposer.org) package binaries from anywhere. ⚡️

## Installation

Run the following command to install `cpx`.

```bash
composer global require cpx/cpx
```

This will install the `cpx` binary into Composer's `vendor/bin` folder, so ensure you have this folder in your `$PATH`.

## Usage

Currently you can use `cpx` for three different things:

1. Running locally installed binaries, similar to `composer exec`.
2. Running globally installed binaries.
3. Running a package binary globally without having to install it.

Each of these conditions are checked in that order.

1. If a package is already installed locally, that will be executed.
2. If a package is already installed globally, that will be executed.
3. If neither of those conditions are met, the package will be temporarily installed and executed.

```bash
cpx laravel/installer new my-site
```

Running the command above will try to find an executable binary inside of the `laravel/installer` package. If it finds one, it will execute it and pass through any extra arguments originally provided to `cpx` (excluding the package name).

> `cpx` only supports packages with a single binary at the moment. There are plans to expand this in the future so that functionality is inline with `npx`.

## Roadmap

`cpx` covers the basic functionality already, but there's always room for improvement.

* Support executing remote scripts / binaries, e.g. Gist files, GitHub repositories that aren't on Packagist.
* Support executing a specific binary from packages with multiple binaries.
* Support executing a specific version of a package that is already installed globally.
