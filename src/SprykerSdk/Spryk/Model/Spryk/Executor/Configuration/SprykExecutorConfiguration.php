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
    protected $sprykName;

    /**
     * @var string[]
     */
    protected $includeOptionalSubSpryks;

    /**
     * @var string|null
     */
    protected $targetModule;

    /**
     * @var string|null
     */
    protected $targetModuleOrganization;

    /**
     * @var string|null
     */
    protected $targetModuleLayer;

    /**
     * @var string|null
     */
    protected $dependentModule;

    /**
     * @var string|null
     */
    protected $dependentModuleOrganization;

    /**
     * @var string|null
     */
    protected $dependentModuleLayer;

    /**
     * @param string $sprykName
     * @param string[] $includeOptionalSubSpryks
     * @param string $targetModuleName
     * @param string $dependentModuleName
     */
    public function __construct(
        string $sprykName,
        array $includeOptionalSubSpryks,
        string $targetModuleName,
        string $dependentModuleName
    ) {
        $this->sprykName = $sprykName;
        $this->includeOptionalSubSpryks = $includeOptionalSubSpryks;
        $this->parseTargetModuleName($targetModuleName);
        $this->parseDependentModuleName($dependentModuleName);
    }

    /**
     * @return string
     */
    public function getSprykName(): string
    {
        return $this->sprykName;
    }

    /**
     * @return string[]
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

        $explodedTargetModuleName = explode('.', $targetModuleName);

        if (count($explodedTargetModuleName) === 2) {
            $this->targetModuleOrganization = $explodedTargetModuleName[0];
            $this->targetModule = $explodedTargetModuleName[1];

            return;
        }

        if (count($explodedTargetModuleName) === 3) {
            $this->targetModuleOrganization = $explodedTargetModuleName[0];
            $this->targetModule = $explodedTargetModuleName[1];
            $this->targetModuleLayer = $explodedTargetModuleName[2];

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

        $explodedDependentModuleName = explode('.', $dependentModuleName);

        if (count($explodedDependentModuleName) === 2) {
            $this->dependentModuleOrganization = $explodedDependentModuleName[0];
            $this->dependentModule = $explodedDependentModuleName[1];

            return;
        }

        if (count($explodedDependentModuleName) === 3) {
            $this->dependentModuleOrganization = $explodedDependentModuleName[0];
            $this->dependentModule = $explodedDependentModuleName[1];
            $this->dependentModuleLayer = $explodedDependentModuleName[2];

            return;
        }

        $this->dependentModule = $dependentModuleName;
    }
}
