<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest;

use Codeception\Actor;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class SprykConsoleTester extends Actor
{
    use _generated\SprykConsoleTesterActions;

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return codecept_data_dir();
    }

    /**
     * @param string $module
     *
     * @return string
     */
    public function getModuleDirectory(string $module = 'FooBar'): string
    {
        return sprintf('%svendor/spryker/spryker/Bundles/%s/', $this->getRootDirectory(), $module);
    }

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getConsoleTester(Command $command)
    {
        $application = new Application();
        $application->add($command);

        $command = $application->find($command->getName());

        return new CommandTester($command);
    }
}
