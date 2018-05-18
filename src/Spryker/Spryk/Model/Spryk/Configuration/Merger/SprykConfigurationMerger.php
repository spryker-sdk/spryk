<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Merger;

use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationMerger implements SprykConfigurationMergerInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    protected $configurationFinder;

    /**
     * @var string
     */
    protected $rootSprykName;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface $configurationFinder
     * @param string $rootSprykName
     */
    public function __construct(SprykConfigurationFinderInterface $configurationFinder, string $rootSprykName = 'spryk')
    {
        $this->configurationFinder = $configurationFinder;
        $this->rootSprykName = $rootSprykName;
    }

    /**
     * @param array $sprykDefinition
     *
     * @return array
     */
    public function merge(array $sprykDefinition): array
    {
        if (!$this->configurationFinder->has($this->rootSprykName)) {
            return $sprykDefinition;
        }

        $rootConfiguration = $this->configurationFinder->find($this->rootSprykName);
        $rootConfiguration = Yaml::parse($rootConfiguration->getContents());

        return $this->doMerge($rootConfiguration, $sprykDefinition);
    }

    /**
     * @param array $rootConfiguration
     * @param array $sprykDefinition
     *
     * @return array
     */
    protected function doMerge(array $rootConfiguration, array $sprykDefinition): array
    {
        $mergedConfiguration = [];
        foreach ($sprykDefinition as $key => $value) {
            if ($key !== 'arguments') {
                $mergedConfiguration[$key] = $value;
            }
            if ($key === 'arguments') {
                $arguments = [];
                foreach ($sprykDefinition[$key] as $argumentName => $argumentValue) {
                    if (!isset($rootConfiguration['arguments'][$argumentName])) {
                        $arguments[$argumentName] = $argumentValue;
                        continue;
                    }

                    $mergeType = $rootConfiguration['arguments'][$argumentName]['type'];
                    if ($mergeType === 'prepend') {
                        $arguments[$argumentName] = $rootConfiguration['arguments'][$argumentName]['value'] . $argumentValue;
                    }
                }
                $mergedConfiguration['arguments'] = $arguments;
            }
        }

        return $mergedConfiguration;
    }
}
