<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer;

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
