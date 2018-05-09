<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Module;

use Codeception\Module;
use Codeception\TestInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CleanUpModule extends Module
{
    /**
     * @param \Codeception\TestInterface $test
     *
     * @return void
     */
    public function _before(TestInterface $test): void
    {
        $finder = new Finder();
        $finder->in($this->getRootDirectory())->notPath('/config/');

        $filesystem = new Filesystem();
        $filesystem->remove($finder);
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return codecept_data_dir();
    }
}
