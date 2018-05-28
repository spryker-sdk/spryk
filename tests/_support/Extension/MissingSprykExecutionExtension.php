<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Extension;

use Codeception\Event\SuiteEvent;
use Codeception\Events;
use Codeception\Extension;
use SprykTest\Module\IntegrationModule;
use Symfony\Component\Finder\Finder;

class MissingSprykExecutionExtension extends Extension
{
    /**
     * @var array
     */
    public static $events = [
        Events::SUITE_AFTER => 'afterSuite',
    ];

    /**
     * @param \Codeception\Event\SuiteEvent $e
     *
     * @return void
     */
    public function afterSuite(SuiteEvent $e): void
    {
        $missingSpryks = $this->getMissingSpryks();

        if (count($missingSpryks) > 0) {
            $this->output->writeln(' ');
            $this->output->writeln(sprintf('<fg=yellow>%s spryks are not executed!</>', count($missingSpryks)));
            $this->output->writeln(' ');
            $this->output->writeln('Please add tests for the following spryks:');
            $this->output->writeln(implode(', ', $missingSpryks));
        }
    }

    /**
     * @return string[]
     */
    protected function getMissingSpryks(): array
    {
        $executedSpryks = IntegrationModule::getExecutedSpryks();
        $allSpryks = $this->getAllSpryks();

        return array_diff($allSpryks, $executedSpryks);
    }

    /**
     * @return string[]
     */
    protected function getAllSpryks(): array
    {
        $configDirectory = realpath(__DIR__ . '/../../../config/spryk/spryks/');
        $finder = new Finder();
        $finder->in($configDirectory);

        $allSpryks = [];

        foreach ($finder as $fileInfo) {
            $sprykName = str_replace('.' . $fileInfo->getExtension(), '', $fileInfo->getFilename());
            $allSpryks[] = $sprykName;
        }

        sort($allSpryks);

        return $allSpryks;
    }
}
