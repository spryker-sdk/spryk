<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Renderer;

use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\CamelBackFilter;
use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\ClassNameShortFilter;
use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\DasherizeFilter;
use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\UnderscoreFilter;
use Twig\Extension\DebugExtension;
use Twig_Environment;
use Twig_Loader_Chain;
use Twig_Loader_Filesystem;
use Twig_Loader_String;

class TemplateRenderer implements TemplateRendererInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $renderer;

    /**
     * @param string[] $templateDirectories
     */
    public function __construct(array $templateDirectories)
    {
        $loader = new Twig_Loader_Filesystem($templateDirectories);

        $chainLoader = new Twig_Loader_Chain();
        $chainLoader->addLoader($loader);
        $chainLoader->addLoader(new Twig_Loader_String());

        $renderer = new Twig_Environment($chainLoader, [
            'debug' => true,
        ]);
        $renderer->addExtension(new DebugExtension());
        $renderer->addFilter(new DasherizeFilter());
        $renderer->addFilter(new UnderscoreFilter());
        $renderer->addFilter(new ClassNameShortFilter());
        $renderer->addFilter(new CamelBackFilter());

        $this->renderer = $renderer;
    }

    /**
     * @param string $template
     * @param array $arguments
     *
     * @return string
     */
    public function render(string $template, array $arguments): string
    {
        return $this->renderer->render($template, $arguments);
    }

    /**
     * @param string $template
     *
     * @return string
     */
    public function getSource(string $template): string
    {
        $loader = $this->getLoader();

        return $loader->getSourceContext($template)->getCode();
    }

    /**
     * @return \Twig_LoaderInterface|\Twig_Loader_Chain
     */
    protected function getLoader()
    {
        return $this->renderer->getLoader();
    }
}
