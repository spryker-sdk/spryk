<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Renderer;

use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\ArrayCastFilter;
use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\ClassNameShortFilter;
use Spryker\Spryk\Model\Spryk\Builder\Template\Filter\DasherizeFilter;
use Twig\Extension\DebugExtension;
use Twig_Environment;
use Twig_Loader_Filesystem;

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
        $renderer = new Twig_Environment($loader, [
            'debug' => true,
        ]);
        $renderer->addExtension(new DebugExtension());
        $renderer->addFilter(new DasherizeFilter());
        $renderer->addFilter(new ArrayCastFilter());
        $renderer->addFilter(new ClassNameShortFilter());

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
     * @return \Twig_Loader_Filesystem|\Twig_LoaderInterface
     */
    protected function getLoader(): Twig_Loader_Filesystem
    {
        return $this->renderer->getLoader();
    }
}
