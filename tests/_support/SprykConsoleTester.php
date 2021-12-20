<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest;

use Codeception\Actor;
use Codeception\Stub;
use SprykerSdk\Spryk\Console\AbstractSprykConsole;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\SprykFacade;
use SprykerSdk\Spryk\SprykFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Inherited Methods
 *
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
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getConsoleTester(Command $command): CommandTester
    {
        if ($command instanceof AbstractSprykConsole) {
            $command->setFacade($this->getFacadeWithMockedConfig());
        }

        $application = new Application();
        $application->add($command);

        $command = $application->find($command->getName());

        return new CommandTester($command);
    }

    /**
     * @return \SprykerSdk\Spryk\SprykFacade
     */
    protected function getFacadeWithMockedConfig(): SprykFacade
    {
        $sprykConfig = $this->getSprykConfigMock();

        $sprykFactory = new SprykFactory();
        $sprykFactory->setConfig($sprykConfig);

        $sprykFacade = new SprykFacade();
        $sprykFacade->setFactory($sprykFactory);

        return $sprykFacade;
    }

    /**
     * @return \SprykerSdk\Spryk\SprykConfig|object
     */
    protected function getSprykConfigMock()
    {
        $sprykConfig = Stub::make(new SprykConfig(), [
            'getRootDirectory' => function () {
                return $this->getRootDirectory();
            },
            'getSprykDirectories' => function () {
                return [$this->getRootDirectory() . 'config/spryk/spryks/'];
            },
            'getRootSprykDirectories' => function () {
                return [$this->getRootDirectory() . 'config/spryk/'];
            },
            'getTemplateDirectories' => function () {
                return [$this->getRootDirectory() . 'config/spryk/templates/'];
            },
            'getDefaultDevelopmentMode' => function () {
                return $this->getDevelopmentMode();
            },
        ]);

        return $sprykConfig;
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return realpath(__DIR__ . '/../../tests/_data/') . DIRECTORY_SEPARATOR;
    }
}
