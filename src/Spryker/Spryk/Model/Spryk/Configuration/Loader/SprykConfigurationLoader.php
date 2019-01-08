<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Loader;

use Spryker\Spryk\Exception\SprykConfigNotValid;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationLoader implements SprykConfigurationLoaderInterface
{
    protected const NAME_MODE_DEFAULT = 'core';

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    protected $configurationFinder;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
     */
    protected $configurationMerger;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected $configurationExtender;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface
     */
    protected $configurationValidator;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface $configurationFinder
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface $configurationMerger
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface $configurationExtender
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface $configurationValidator
     */
    public function __construct(
        SprykConfigurationFinderInterface $configurationFinder,
        SprykConfigurationMergerInterface $configurationMerger,
        SprykConfigurationExtenderInterface $configurationExtender,
        ConfigurationValidatorInterface $configurationValidator
    ) {
        $this->configurationFinder = $configurationFinder;
        $this->configurationMerger = $configurationMerger;
        $this->configurationExtender = $configurationExtender;
        $this->configurationValidator = $configurationValidator;
    }

    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function loadSpryk(string $sprykName, ?string $sprykMode = null): array
    {
        $sprykConfiguration = $this->configurationFinder->find($sprykName);
        $sprykConfiguration = Yaml::parse($sprykConfiguration->getContents());

        $sprykConfiguration = $this->buildMode($sprykConfiguration, $sprykMode);

        if ($sprykMode !== null && $sprykConfiguration['mode'] !== $sprykMode) {
            return [];
        }

        $this->configurationValidate($sprykConfiguration);

        $sprykConfiguration = $this->configurationMerger->merge($sprykConfiguration);

        return $this->configurationExtender->extend($sprykConfiguration);
    }

    /**
     * @param array $sprykConfiguration
     *
     * @throws \Spryker\Spryk\Exception\SprykConfigNotValid
     *
     * @return void
     */
    protected function configurationValidate(array $sprykConfiguration): void
    {
        $validationErrorMessages = $this->configurationValidator->validate($sprykConfiguration);

        if ($validationErrorMessages === []) {
            return;
        }

        throw new SprykConfigNotValid(implode(PHP_EOL, $validationErrorMessages));
    }

    /**
     * @param array $sprykConfiguration
     * @param string|null $sprykMode
     *
     * @return array
     */
    protected function buildMode(array $sprykConfiguration, ?string $sprykMode = null): array
    {
        $defaultMode = static::NAME_MODE_DEFAULT;

        if (!isset($sprykConfiguration['mode'])) {
            $sprykConfiguration['mode'] = $defaultMode;
        }

        if ($sprykMode !== null && $sprykConfiguration['mode'] === 'both') {
            $sprykConfiguration['mode'] = $sprykMode;
        }

        return $sprykConfiguration;
    }
}
