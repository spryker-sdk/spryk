# Spryker Spryk

[![Build Status](https://travis-ci.com/spryker/spryk.svg?token=7jVDNZFJxpvBrFetYhbF&branch=master)](https://travis-ci.com/spryker/spryk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spryker/spryk/badges/quality-score.png?b=master&s=ebca747a3c5798a911ff1beaae498b6101af74f6)](https://scrutinizer-ci.com/g/spryker/spryk/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/spryker/spryk/badge.svg?branch=master&t=2ga4h9)](https://coveralls.io/github/spryker/spryk?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![PHPStan](https://img.shields.io/badge/PHPStan-L7-green.svg)](https://github.com/phpstan/phpstan)

## Documentation

https://spryker.atlassian.net/wiki/spaces/CORE/pages/188481752/Spryks

# What are Spryks?

Spryks are some sort of code generators for Spryker. Writing code is often a very repetitive task and you often need to write a lot code just to follow Spryker's clean and complex architecture.
To take a way the monkey work from writing wir up code and move faster towards writing business code Spryks are born.

Spryks are written with the help of yml files. The filename of the yml file represents also the Spryk name. In most cases the Spryk yml contains arguments which are needed to fullfill the Spryk build run. Almost all Spryks need the module name to run properly. Some Spryks require much more arguments.

The vast majority of the Spryks need to execute other Spryks before the called Spryk can run. For example Add a Zed Business Facade needs to have a properly created module before the Facade itself can be created. Therefore Spryks have pre and post Spryks and with the call of one Spryk many things can and will be created for you.

## How to use Spryks?

Currently we support two ways to work with Spryks.

1. Console based.
2. Ui based.

### Spryk Console

The console tool for working with Spryks is written with Symfony's Console component. To work with the Spryk Console you need to add it to your `ConsoleDependencyProvider`.

Currently available commands are `SprykDumpConsole` and `SprykRunConsole`. 

To get a list of all available spryks run `vendor/bin/console spryk:dump`. 
To execute one Spryk run `vendor/bin/console spryk:run {SPRYK NAME}`.

When you run a Spryk, the console will ask you for all needed arguments to build the Spryk. You also have the ability to pass all known arguments on the console by using `--{argument name}={argument value}`.


### SprykGui

We also provide a UI build inside the Zed application to build Spryks UI based. For the UI you need to run `composer require --dev spryker/spryk-gui`

When the SprykGui module is installed you can navigation to it inside Zed. The first page you see contains a list of all available Spryks. After you clicked on of the Spryks a form will be displayed and will give you the ability to enter all argument values the Spryk needs to run.


# How to build Spryks?




