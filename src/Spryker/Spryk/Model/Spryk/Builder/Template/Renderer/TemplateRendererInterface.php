<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Renderer;

interface TemplateRendererInterface
{
    /**
     * @param string $template
     * @param array $arguments
     *
     * @return string
     */
    public function render(string $template, array $arguments): string;

    /**
     * @param string $templateString
     * @param array $arguments
     *
     * @return string
     */
    public function renderString(string $templateString, array $arguments): string;

    /**
     * @param string $template
     *
     * @return string
     */
    public function getSource(string $template): string;
}
