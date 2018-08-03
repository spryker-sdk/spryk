<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder;

use Spryker\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Navigation\NavigationSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Schema\SchemaSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Structure\StructureSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\TemplateFilter;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\TemplateSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Template\UpdateYmlSpryk;
use Spryker\Spryk\Model\Spryk\Filter\FilterFactory;
use Spryker\Spryk\SprykConfig;
use Twig\TwigFilter;

class SprykBuilderFactory
{
    /**
     * @var \Spryker\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Filter\FilterFactory
     */
    protected $filterFactory;

    /**
     * @param \Spryker\Spryk\SprykConfig $config
     * @param \Spryker\Spryk\Model\Spryk\Filter\FilterFactory $filterFactory
     */
    public function __construct(SprykConfig $config, FilterFactory $filterFactory)
    {
        $this->config = $config;
        $this->filterFactory = $filterFactory;
    }

    /**
     * @return \Spryker\Spryk\SprykConfig
     */
    public function getConfig(): SprykConfig
    {
        return $this->config;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface[]
     */
    public function getSprykBuilder(): array
    {
        return [
            $this->createStructureSpryk(),
            $this->createTemplateSpryk(),
            $this->createUpdateYmlSpryk(),
            $this->createMethodSpryk(),
            $this->createNavigationSpryk(),
            $this->createSchemaSpryk(),
        ];
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createStructureSpryk(): SprykBuilderInterface
    {
        return new StructureSpryk(
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createTemplateSpryk(): SprykBuilderInterface
    {
        return new TemplateSpryk(
            $this->createTemplateRenderer(),
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createUpdateYmlSpryk(): SprykBuilderInterface
    {
        return new UpdateYmlSpryk(
            $this->createTemplateRenderer(),
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createMethodSpryk(): SprykBuilderInterface
    {
        return new MethodSpryk(
            $this->createTemplateRenderer()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createNavigationSpryk(): SprykBuilderInterface
    {
        return new NavigationSpryk(
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createSchemaSpryk(): SprykBuilderInterface
    {
        return new SchemaSpryk(
            $this->getConfig()->getRootDirectory(),
            $this->filterFactory->createCamelCaseFilter()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    public function createTemplateRenderer(): TemplateRendererInterface
    {
        return new TemplateRenderer(
            $this->getConfig()->getTemplateDirectories(),
            $this->getFilterCollection()
        );
    }

    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilterCollection(): array
    {
        return [
            $this->createCamelBackFilter(),
            $this->createClassNameShortFilter(),
            $this->createDasherizeFilter(),
            $this->createUnderscoreFilter(),
            $this->createCamelCaseFilter(),
        ];
    }

    /**
     * @return \Twig\TwigFilter
     */
    protected function createCamelBackFilter(): TwigFilter
    {
        return new TemplateFilter($this->filterFactory->createCamelBackFilter(), 'camelBack');
    }

    /**
     * @return \Twig\TwigFilter
     */
    protected function createClassNameShortFilter(): TwigFilter
    {
        return new TemplateFilter($this->filterFactory->createClassNameShortFilter(), 'classNameShort');
    }

    /**
     * @return \Twig\TwigFilter
     */
    protected function createDasherizeFilter(): TwigFilter
    {
        return new TemplateFilter($this->filterFactory->createDasherizeFilter(), 'dasherize');
    }

    /**
     * @return \Twig\TwigFilter
     */
    protected function createUnderscoreFilter(): TwigFilter
    {
        return new TemplateFilter($this->filterFactory->createUnderscoreFilter(), 'underscored');
    }

    /**
     * @return \Twig\TwigFilter
     */
    protected function createCamelCaseFilter(): TwigFilter
    {
        return new TemplateFilter($this->filterFactory->createCamelCaseFilter(), 'camelCased');
    }
}
