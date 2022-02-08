<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Executor\Configuration;

class SprykExecutorConfiguration implements SprykExecutorConfigurationInterface
{
    /**
     * @var string
     */
    protected string $sprykName;

    /**
     * @var array<string>
     */
    protected array $includeOptionalSubSpryks;

    /**
     * @var string|null
     */
    protected ?string $targetModule = null;

    /**
     * @var string|null
     */
    protected ?string $targetModuleOrganization = null;

    /**
     * @var string|null
     */
    protected ?string $targetModuleLayer = null;

    /**
     * @var string|null
     */
    protected ?string $dependentModule = null;

    /**
     * @var string|null
     */
    protected $dependentModuleOrganization;

    /**
     * @var string|null
     */
    protected ?string $dependentModuleLayer = null;

    /**
     * @param string $sprykName
     * @param array<string> $includeOptionalSubSpryks
     * @param string $targetModuleName
     * @param string $dependentModuleName
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface
     */
    public function prepare(
        string $sprykName,
        array $includeOptionalSubSpryks,
        string $targetModuleName,
        string $dependentModuleName
    ): SprykExecutorConfigurationInterface {
        $this->sprykName = $sprykName;
        $this->includeOptionalSubSpryks = $includeOptionalSubSpryks;
        $this->parseTargetModuleName($targetModuleName);
        $this->parseDependentModuleName($dependentModuleName);

        return $this;
    }

    /**
     * @return string
     */
    public function getSprykName(): string
    {
        return $this->sprykName;
    }

    /**
     * @return array<string>
     */
    public function getIncludeOptionalSubSpryks(): array
    {
        return $this->includeOptionalSubSpryks;
    }

    /**
     * @return string|null
     */
    public function getTargetModule(): ?string
    {
        return $this->targetModule;
    }

    /**
     * @return string|null
     */
    public function getTargetModuleOrganization(): ?string
    {
        return $this->targetModuleOrganization;
    }

    /**
     * @return string|null
     */
    public function getTargetModuleLayer(): ?string
    {
        return $this->targetModuleLayer;
    }

    /**
     * @return string|null
     */
    public function getDependentModule(): ?string
    {
        return $this->dependentModule;
    }

    /**
     * @return string|null
     */
    public function getDependentModuleOrganization(): ?string
    {
        return $this->dependentModuleOrganization;
    }

    /**
     * @return string|null
     */
    public function getDependentModuleLayer(): ?string
    {
        return $this->dependentModuleLayer;
    }

    /**
     * @param string $targetModuleName
     *
     * @return void
     */
    protected function parseTargetModuleName(string $targetModuleName): void
    {
        if (!$targetModuleName) {
            return;
        }

        $targetModuleNameParts = explode('.', $targetModuleName);

        if (count($targetModuleNameParts) === 2) {
            $this->targetModuleOrganization = $targetModuleNameParts[0];
            $this->targetModule = $targetModuleNameParts[1];

            return;
        }

        if (count($targetModuleNameParts) === 3) {
            $this->targetModuleOrganization = $targetModuleNameParts[0];
            $this->targetModule = $targetModuleNameParts[1];
            $this->targetModuleLayer = $targetModuleNameParts[2];

            return;
        }

        $this->targetModule = $targetModuleName;
    }

    /**
     * @param string $dependentModuleName
     *
     * @return void
     */
    protected function parseDependentModuleName(string $dependentModuleName): void
    {
        if (!$dependentModuleName) {
            return;
        }

        $dependentModuleNameParts = explode('.', $dependentModuleName);

        if (count($dependentModuleNameParts) === 2) {
            $this->dependentModuleOrganization = $dependentModuleNameParts[0];
            $this->dependentModule = $dependentModuleNameParts[1];

            return;
        }

        if (count($dependentModuleNameParts) === 3) {
            $this->dependentModuleOrganization = $dependentModuleNameParts[0];
            $this->dependentModule = $dependentModuleNameParts[1];
            $this->dependentModuleLayer = $dependentModuleNameParts[2];

            return;
        }

        $this->dependentModule = $dependentModuleName;
    }
}
