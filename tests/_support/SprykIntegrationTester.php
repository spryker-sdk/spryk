<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest;

use Codeception\Actor;
use Codeception\Stub;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Spryk\SprykConfig;
use Spryker\Spryk\SprykFacade;
use Spryker\Spryk\SprykFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\VarDumper\VarDumper;

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
class SprykIntegrationTester extends Actor
{
    use _generated\SprykIntegrationTesterActions;

    /**
     * @param \Spryker\Spryk\Console\SprykRunConsole $command
     * @param string $sprykName
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getConsoleTester(SprykRunConsole $command, string $sprykName)
    {
        $application = new Application();
        $application->add($command);

        $command->setFacade($this->getFacadeWithMockedConfig());

        $command = $application->find($command->getName());

        $this->addExecutedSpryk($sprykName);
        return new CommandTester($command);
    }

    /**
     * @return \Spryker\Spryk\SprykFacade
     */
    protected function getFacadeWithMockedConfig(): SprykFacade
    {
        $sprykConfig = $this->getSprykConfigMock();

        $sprykFactory = new SprykFactory();
        $sprykFactory->setConfig($sprykConfig);

        $sprykFacade = new SprykFacade();

        return $sprykFacade;
    }

    /**
     * @return object|\Spryker\Spryk\SprykConfig
     */
    protected function getSprykConfigMock()
    {
        echo '<pre>' . PHP_EOL . VarDumper::dump(realpath(__DIR__)) . PHP_EOL . 'Line: ' . __LINE__ . PHP_EOL . 'File: ' . __FILE__ . die();

        $sprykConfig = Stub::make(new SprykConfig(), [
            'getRootDirectory' => function () {
                return true;
            },
        ]);

        return $sprykConfig;
    }
}
