<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest;

use Codeception\Actor;
use Codeception\Stub;
use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Spryk\SprykConfig;
use Spryker\Spryk\SprykFacade;
use Spryker\Spryk\SprykFactory;
use Symfony\Component\Console\Application;
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
class SprykIntegrationTester extends Actor
{
    use _generated\SprykIntegrationTesterActions;

    /**
     * @param \Codeception\Test\Unit $testClass
     * @param array $arguments
     *
     * @return void
     */
    public function run(Unit $testClass, array $arguments): void
    {
        $sprykName = $this->getSprykName($testClass);

        $command = new SprykRunConsole();
        $tester = $this->getConsoleTester($command, $sprykName);

        $arguments += [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => $sprykName,
        ];

        $tester->execute($arguments, ['interactive' => false]);
    }

    /**
     * @param \Codeception\Test\Unit $testClass
     *
     * @return string
     */
    protected function getSprykName(Unit $testClass): string
    {
        $classNameFragments = explode('\\', get_class($testClass));
        $classNameShort = array_pop($classNameFragments);
        $sprykName = substr($classNameShort, 0, -4);

        return $sprykName;
    }

    /**
     * @param \Spryker\Spryk\Console\SprykRunConsole $command
     * @param string $sprykName
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getConsoleTester(SprykRunConsole $command, string $sprykName)
    {
        $command->setFacade($this->getFacadeWithMockedConfig());

        $application = new Application();
        $application->add($command);

        $command = $application->find($command->getName());

        $this->addExecutedSpryk($sprykName);

        return new CommandTester($command);
    }

    /**
     * @param string $module
     *
     * @return string
     */
    public function getModuleDirectory(string $module = 'FooBar'): string
    {
        return sprintf('%s/tests/_data/vendor/spryker/spryker/Bundles/%s/', $this->getRootDirectory(), $module);
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
        $sprykFacade->setFactory($sprykFactory);

        return $sprykFacade;
    }

    /**
     * @return object|\Spryker\Spryk\SprykConfig
     */
    protected function getSprykConfigMock()
    {
        $sprykConfig = Stub::make(new SprykConfig(), [
            'getRootDirectory' => function () {
                return $this->getRootDirectory() . DIRECTORY_SEPARATOR . 'tests/_data/';
            },
            'getSprykDirectories' => function () {
                return [$this->getRootDirectory() . DIRECTORY_SEPARATOR . 'config/spryk/spryks/'];
            },
            'getRootSprykDirectories' => function () {
                return [$this->getRootDirectory() . DIRECTORY_SEPARATOR . 'config/spryk/'];
            },
            'getTemplateDirectories' => function () {
                return [$this->getRootDirectory() . DIRECTORY_SEPARATOR . 'config/spryk/templates/'];
            },
        ]);

        return $sprykConfig;
    }

    /**
     * @return string
     */
    protected function getRootDirectory(): string
    {
        return realpath(__DIR__ . '/../../');
    }
}
