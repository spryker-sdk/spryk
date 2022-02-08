<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer;

use SprykerSdk\Spryk\SprykConfig;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class TemplateRenderer implements TemplateRendererInterface
{
    /**
     * @var \Twig\Environment
     */
    protected $renderer;

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param array<\Twig\Extension\ExtensionInterface> $extensions
     */
    public function __construct(SprykConfig $config, array $extensions)
    {
        $loader = new FilesystemLoader($config->getTemplateDirectories());

        $renderer = new Environment($loader, $config->getTwigConfiguration());
        $renderer->addExtension(new DebugExtension());

        foreach ($extensions as $extension) {
            $renderer->addExtension($extension);
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
     * @param string $templateString
     * @param array $arguments
     *
     * @return string
     */
    public function renderString(string $templateString, array $arguments): string
    {
        $template = $this->renderer->createTemplate($templateString);

        return $template->render($arguments);
    }

    /**
     * @param string $template
     *
     * @return string
     */
    public function getSource(string $template): string
    {
        /** @var \Twig\Loader\ChainLoader $loader */
        $loader = $this->getLoader();

        /** @var \Twig\Source $source */
        $source = $loader->getSourceContext($template);

        return $source->getCode();
    }

    /**
     * @return \Twig\Loader\LoaderInterface
     */
    protected function getLoader(): LoaderInterface
    {
        return $this->renderer->getLoader();
    }
}
