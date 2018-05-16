<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Module;

use Codeception\Module;
use Symfony\Component\Finder\Finder;
use Symfony\Component\VarDumper\VarDumper;

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
     * @return void
     */
    public function _afterSuite()
    {
        $allSpryks = $this->getAllSpryks();

        $diff = array_diff(static::$executedSpryks, $allSpryks);

        if (count($diff) > 0) {
            die('Not all spryks executed');
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

        echo '<pre>' . PHP_EOL . VarDumper::dump($allSpryks) . PHP_EOL . 'Line: ' . __LINE__ . PHP_EOL . 'File: ' . __FILE__ . die();
    }
}
