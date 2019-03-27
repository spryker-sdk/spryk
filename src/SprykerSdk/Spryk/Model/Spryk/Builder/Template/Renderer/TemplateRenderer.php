<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer;

use SprykerSdk\Spryk\Exception\TwigException;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\SourceContextLoaderInterface;

class TemplateRenderer implements TemplateRendererInterface
{
    /**
     * @var \Twig\Environment
     */
    protected $renderer;

    /**
     * @param array $templateDirectories
     * @param \Twig\Extension\ExtensionInterface[] $extensions
     */
    public function __construct(array $templateDirectories, array $extensions)
    {
        $loader = new FilesystemLoader($templateDirectories);

        $renderer = new Environment($loader, [
            'debug' => true,
        ]);
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
     * @throws \SprykerSdk\Spryk\Exception\TwigException
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
     * @return \Twig\Loader\LoaderInterface
     */
    protected function getLoader()
    {
        return $this->renderer->getLoader();
    }
}
