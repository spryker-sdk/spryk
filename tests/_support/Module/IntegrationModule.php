<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Module;

use Codeception\Module;
use PHPUnit\Framework\IncompleteTestError;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;
use Symfony\Component\Finder\Finder;

class IntegrationModule extends Module
{
    /**
     * @var array
     */
    protected static $executedSpryks = [];

    /**
     * @param string $spryk
     *
     * @return $this
     */
    public function addExecutedSpryk(string $spryk): IntegrationModule
    {
        static::$executedSpryks[$spryk] = $spryk;

        return $this;
    }

    /**
     * @param array $settings
     *
     * @return void
     */
    public function _beforeSuite($settings = []): void
    {
        OptionsContainer::setOptions([
            'module' => 'FooBar',
        ]);
    }

    /**
     * @throws \PHPUnit\Framework\IncompleteTestError
     *
     * @return void
     */
    public function _afterSuite()
    {
        OptionsContainer::clearOptions();

        $allSpryks = $this->getAllSpryks();

        $diff = array_diff(static::$executedSpryks, $allSpryks);

        if (count($diff) > 0) {
            throw new IncompleteTestError(sprintf('Not all spryks executed! Please add tests for the following spryks: %s'), implode(', ', $diff));
        }
    }

    /**
     * @return string[]
     */
    protected function getAllSpryks(): array
    {
        $configDirectory = APPLICATION_ROOT_DIR . 'config/spryks/';
        $finder = new Finder();
        $finder->in($configDirectory);

        $allSpryks = [];

        foreach ($finder as $fileInfo) {
            $sprykName = str_replace('.' . $fileInfo->getExtension(), '', $fileInfo->getFilename());
            $allSpryks[] = $sprykName;
        }

        return $allSpryks;
    }
}
