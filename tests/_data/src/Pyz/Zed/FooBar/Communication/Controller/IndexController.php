<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\FooBar\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\FooBar\Communication\FooBarCommunicationFactory getFactory()
 * @method \Pyz\Zed\FooBar\Business\FooBarFacadeInterface getFacade()
 */
class IndexController extends AbstractController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
    }
}
