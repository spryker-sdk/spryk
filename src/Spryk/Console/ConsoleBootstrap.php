<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use Spryker\Zed\Console\Business\Model\Environment;
use Symfony\Component\Console\Application;

class ConsoleBootstrap extends Application
{
    /**
     * @param string $name
     * @param string $version
     */
    public function __construct(string $name = 'Spryker', string $version = '1')
    {
        Environment::initialize();

        parent::__construct($name, $version);
    }
}
