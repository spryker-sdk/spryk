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
class SprykTester extends Actor
{
    use _generated\SprykTesterActions;

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return codecept_data_dir();
    }

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getRunConsoleTester(Command $command)
    {
        $application = new Application();
        $application->add($command);

        $command = $application->find('spryk:run');

        return new CommandTester($command);
    }

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getDumpConsoleTester(Command $command)
    {
        $application = new Application();
        $application->add($command);

        $command = $application->find('spryk:dump');

        return new CommandTester($command);
    }
}
