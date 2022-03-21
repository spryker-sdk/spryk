<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Navigation;

use Laminas\Filter\FilterChain;
use Laminas\Filter\StringToLower;
use Laminas\Filter\Word\CamelCaseToDash;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;

class NavigationSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    public const ARGUMENT_CONTROLLER = 'controller';

    /**
     * @var string
     */
    public const ARGUMENT_ACTION = 'controllerMethod';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'navigation';
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());
        $simpleXMLElement = $resolved->getSimpleXmlElement();

        $dasherizeFilter = $this->getDasherizeFilter();

        $module = $dasherizeFilter->filter($this->getModuleName());
        $controller = $dasherizeFilter->filter($this->getController());
        $action = $dasherizeFilter->filter($this->getAction());

        $parentNode = $simpleXMLElement->$module;

        if (!$parentNode) {
            $parentNode = current((array)$simpleXMLElement->children());
        }

        $page = $parentNode->pages->addChild($module);
        $page->addChild('label', $this->getModuleName());
        $page->addChild('title', $this->getModuleName());
        $page->addChild('bundle', $module);
        $page->addChild('controller', $controller);
        $page->addChild('action', $action);

        $this->log(sprintf('Added navigation entry in <fg=green>%s</>', $this->getTargetPath()));
    }

    /**
     * @return string
     */
    protected function getController(): string
    {
        return $this->getStringArgument(static::ARGUMENT_CONTROLLER);
    }

    /**
     * @return string
     */
    protected function getAction(): string
    {
        return $this->getStringArgument(static::ARGUMENT_ACTION);
    }

    /**
     * @return \Laminas\Filter\FilterChain
     */
    protected function getDasherizeFilter(): FilterChain
    {
        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToDash())
            ->attach(new StringToLower());

        return $filterChain;
    }
}
