<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Loader;

use SprykerSdk\Spryk\Exception\SprykConfigNotValid;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationLoader implements SprykConfigurationLoaderInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    protected $configurationFinder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
     */
    protected $configurationMerger;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected $configurationExtender;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface
     */
    protected $configurationValidator;

    /**
     * @var string
     */
    protected $defaultDevelopmentMode;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface $configurationFinder
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface $configurationMerger
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface $configurationExtender
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface $configurationValidator
     * @param string $defaultDevelopmentMode
     */
    public function __construct(
        SprykConfigurationFinderInterface $configurationFinder,
        SprykConfigurationMergerInterface $configurationMerger,
        SprykConfigurationExtenderInterface $configurationExtender,
        ConfigurationValidatorInterface $configurationValidator,
        string $defaultDevelopmentMode
    ) {
        $this->configurationFinder = $configurationFinder;
        $this->configurationMerger = $configurationMerger;
        $this->configurationExtender = $configurationExtender;
        $this->configurationValidator = $configurationValidator;
        $this->defaultDevelopmentMode = $defaultDevelopmentMode;
    }

    /**
     * @param string $sprykName
     * @param string|null $currentMode
     *
     * @return array
     */
    public function loadSpryk(string $sprykName, ?string $currentMode = null): array
    {
        $sprykConfiguration = $this->configurationFinder->find($sprykName);
        $sprykConfiguration = Yaml::parse($sprykConfiguration->getContents());

        $sprykConfiguration = $this->buildMode($sprykConfiguration, $currentMode);

        $this->configurationValidate($sprykConfiguration);

        $sprykConfiguration = $this->configurationMerger->merge($sprykConfiguration, $currentMode);

        return $this->configurationExtender->extend($sprykConfiguration);
    }

    /**
     * @param array $sprykConfiguration
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykConfigNotValid
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
     * @param string|null $currentMode
     *
     * @return array
     */
    protected function buildMode(array $sprykConfiguration, ?string $currentMode = null): array
    {
        if (!isset($sprykConfiguration['mode'])) {
            $sprykConfiguration['mode'] = $this->defaultDevelopmentMode;
        }

        if ($currentMode !== null && $sprykConfiguration['mode'] === 'all') {
            $sprykConfiguration['mode'] = $currentMode;
        }

        return $sprykConfiguration;
    }
}
