<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;

class DevelopmentModeModule extends Module
{
    /**
     * @var array
     */
    protected $config = [
        'developmentMode' => 'core',
    ];

    /**
     * @return string
     */
    public function getDevelopmentMode(): string
    {
        return $this->config['developmentMode'];
    }
}
