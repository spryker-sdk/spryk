<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Module;

interface ClassName
{
    const CONFIG_YVES = 'Spryker\Yves\FooBar\FooBarConfig';
    const CONFIG_ZED = 'Spryker\Zed\FooBar\FooBarConfig';

    const CONTROLLER_ZED = 'Spryker\Zed\FooBar\Communication\Controller\IndexController';

    const CLIENT = 'Spryker\Client\FooBar\FooBarClient';
    const CLIENT_INTERFACE = 'Spryker\Client\FooBar\FooBarClientInterface';

    const BRIDGE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge';
    const BRIDGE_INTERFACE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeInterface';

    const FACADE = 'Spryker\Zed\FooBar\Business\FooBarFacade';
    const FACADE_TEST = 'SprykerTest\Zed\FooBar\Business\FooBarFacadeTest';
    const FACADE_INTERFACE = 'Spryker\Zed\FooBar\Business\FooBarFacadeInterface';

    const REPOSITORY = 'Spryker\Zed\FooBar\Persistence\FooBarRepository';
    const REPOSITORY_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarRepositoryInterface';

    const ENTITY_MANAGER = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManager';
    const ENTITY_MANAGER_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManagerInterface';
}
