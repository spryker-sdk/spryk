<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Renderer;

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
}
