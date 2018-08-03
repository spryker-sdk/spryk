<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Renderer;

use Spryker\Spryk\Exception\TwigException;
use Twig\Extension\DebugExtension;
use Twig\Loader\SourceContextLoaderInterface;
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
     * @param \Twig\TwigFilter[] $filterCollection
     */
    public function __construct(array $templateDirectories, array $filterCollection)
    {
        $loader = new Twig_Loader_Filesystem($templateDirectories);

        $chainLoader = new Twig_Loader_Chain();
        $chainLoader->addLoader($loader);
        $chainLoader->addLoader(new Twig_Loader_String());

        $renderer = new Twig_Environment($chainLoader, [
            'debug' => true,
        ]);
        $renderer->addExtension(new DebugExtension());

        foreach ($filterCollection as $filter) {
            $renderer->addFilter($filter);
        }

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
     * @throws \Spryker\Spryk\Exception\TwigException
     *
     * @return string
     */
    public function getSource(string $template): string
    {
        $loader = $this->getLoader();

        if (!($loader instanceof SourceContextLoaderInterface)) {
            throw new TwigException('Loader expected to be an instance of SourceContextLoaderInterface!');
        }

        return $loader->getSourceContext($template)->getCode();
    }

    /**
     * @return \Twig_LoaderInterface
     */
    protected function getLoader()
    {
        return $this->renderer->getLoader();
    }
}
