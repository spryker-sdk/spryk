# Spryk Module
[![CI](https://github.com/spryker-sdk/spryk/workflows/CI/badge.svg?branch=master)](https://github.com/spryker-sdk/spryk/actions?query=workflow%3ACI+branch%3Amaster)
[![Latest Stable Version](https://poser.pugx.org/spryker-sdk/spryk/v/stable.svg)](https://packagist.org/packages/spryker-sdk/spryk)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

## Installation

```
composer require --dev spryker-sdk/spryk
```

This is a development only "require-dev" module. Please make sure you include it as such.

# What are Spryks?

Spryks are some sort of code generators for Spryker. Writing code is often a very repetitive task and you often need to write a lot code just to follow Spryker's clean and complex architecture.
To take a way the monkey work from writing wir up code and move faster towards writing business code Spryks are born.

Spryks are written with the help of yml files. The filename of the yml file represents also the Spryk name. In most cases the Spryk yml contains arguments which are needed to fullfill the Spryk build run. Almost all Spryks need the module name to run properly. Some Spryks require much more arguments.

The vast majority of the Spryks need to execute other Spryks before the called Spryk can run. For example Add a Zed Business Facade needs to have a properly created module before the Facade itself can be created. Therefore Spryks have pre and post Spryks and with the call of one Spryk many things can and will be created for you.

# How to use Spryks?

- `vendor/bin/spryk-run` - Runs Spryks in your project
- `vendor/bin/spryk-dump` - Lists all available Spryks
- `vendor/bin/spryk-build` - Builds a cache file for all Spryk arguments


Examples:

1. To get a list of top level spryks run `vendor/bin/spryk-dump`.
2. To get a list of all available spryks run `vendor/bin/spryk-dump --level=all`.
3. To get a list of all options available for a specific spryk run `vendor/bin/spryk-dump {SPRYK NAME}`.
4. To execute one Spryk run `vendor/bin/spryk-run {SPRYK NAME}`.
5. To reflect changes in Spryk arguments and generate a new cache for them run `vendor/bin/spryk-build`.

When you run a Spryk, the console will ask you for all needed arguments to build the Spryk. You also have the ability to pass all known arguments on the console by using `--{argument name}={argument value}`.

