<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
