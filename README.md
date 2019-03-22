# Spryk Module

[![Build Status](https://travis-ci.org/spryker-sdk/spryk.svg?branch=master)](https://travis-ci.org/spryker-sdk/spryk)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

## Installation

```
composer require --dev spryker-sdk/spryk
```

This is a development only "require-dev" module. Please make sure you include it as such.

## How to use Spryks?

Currently we support two ways to work with Spryks.

1. Console based.
2. Ui based.

### Spryk Console

The console tool for working with Spryks is written with Symfony's Console component. To work with the Spryk Console you need to add it to your `ConsoleDependencyProvider`:

```
namespace Pyz\Zed\Console;

use SprykerSdk\Spryk\Console\SprykDumpConsole;
use SprykerSdk\Spryk\Console\SprykBuildConsole;
use SprykerSdk\Spryk\Console\SprykRunConsole;
 
class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    protected function getConsoleCommands(Container $container)
    {
        if (Environment::isDevelopment()) {
            $commands[] = new SprykRunConsole();
            $commands[] = new SprykBuildConsole();
            $commands[] = new SprykDumpConsole();
        }
        ...
 
    }
}
```

Currently available commands are `SprykDumpConsole` and `SprykRunConsole`. 

1. To get a list of all available spryks run `vendor/bin/console spryk:dump`. 
2. To get a list of all options available for a specific spryk run `vendor/bin/console spryk:dump {SPRYK NAME}`. 
3. To execute one Spryk run `vendor/bin/console spryk:run {SPRYK NAME}`.
4. To optimize searching of configurations run `vendor/bin/console spryk:build`.

When you run a Spryk, the console will ask you for all needed arguments to build the Spryk. You also have the ability to pass all known arguments on the console by using `--{argument name}={argument value}`.


### SprykGui

We also provide a [UI](https://github.com/spryker-sdk/spryk-gui) built inside the Zed application to use Spryks UI based. For the UI you need to run `composer require --dev spryker-sdk/spryk-gui`

When the SprykGui module is installed you can navigation to it inside Zed. The first page you see contains a list of all available Spryks. After you clicked on of the Spryks a form will be displayed and will give you the ability to enter all argument values the Spryk needs to run.

# What are Spryks?

Spryks are some sort of code generators for Spryker. Writing code is often a very repetitive task and you often need to write a lot code just to follow Spryker's clean and complex architecture.
To take a way the monkey work from writing wir up code and move faster towards writing business code Spryks are born.

Spryks are written with the help of yml files. The filename of the yml file represents also the Spryk name. In most cases the Spryk yml contains arguments which are needed to fullfill the Spryk build run. Almost all Spryks need the module name to run properly. Some Spryks require much more arguments.

The vast majority of the Spryks need to execute other Spryks before the called Spryk can run. For example Add a Zed Business Facade needs to have a properly created module before the Facade itself can be created. Therefore Spryks have pre and post Spryks and with the call of one Spryk many things can and will be created for you.

## Currently we support the following Spryk types:

- template
- structure
- method

### Template Spryk

A template Spryk adds a new file to your filesystem and uses twig as render engine. Twig gives you the ability to easily create file from a template with placeholders e.g. for `module` or `organization`. The template Spryk will at least need the `template` argument defined. This argument tells the Spryk what template should be used to fullfill your task.

Template Spryks can have as many arguments defined as you will need in the template which should be build.

### Structure Spryk

A structure Spryk creates directory structure you define. The CreateSprykerModule Spryk e.g. contains the definition of directories the Spryk has to create for you. The main argument in the structure Spryk is the directories argument. Here you can add a list of directories which have to be created.

### Method Spryk

The method Spryk is able to add methods to a specified target e.g. `Spryker\Zed\FooBar\Business\FooBarFacade` it needs some more arguments to fullfill the task as the prior mentioned Spryks. 

To get an idea what your Spryk needs take a look into the already existing Spryks.  

# How to create a Spryk?

In most cases it is very easy to create a Spryk. As the whole Spryk Tool is covered by tests you also have to start by adding a test for the Spryk you want to create.

If you only need to add a new Spryk configuration you will start by adding an Integration test for the new Spryk definition. You need to add the name of the Spryk you want to test. E.g. AddMySuperNiceFile and add the assertion to have this file created after you executed the test.

When this is done run the Integration tests with `vendor/bin/codecept run Integration -g {YOUR TEST GROUP}` and see the test failing. You will get a message that the Spryk definition was not found by the given name, so add the definition file for you new Spryk. 

You need to add your Spryk definition file into `config/spryk/spryks/` on project or core level:

```
project OR package root directory
│
└─── config/
│   └─── spryk/
│   │    └─── spryks/
│   │         │   ...
│   │         │   spryk-name.yml
│   │         │   ...
│   └─── ...
```

If you selected the template Spryk, you will most likely see the error that the defined template file could not be found. In this case you need to add your template to `config/spryk/templates/` on project or core level:

```
project OR package root directory
│
└─── config/
│   └─── spryk/
│   │    └─── templates/
│   │         │   ...
│   │         │   template-name.twig
│   │         │   ...
│   └─── ...
```

When this is done re-run your tests. Now you should see a green test.
