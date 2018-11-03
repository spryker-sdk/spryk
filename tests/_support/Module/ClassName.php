<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Module;

interface ClassName
{
    public const CONFIG_YVES = 'Spryker\Yves\FooBar\FooBarConfig';
    public const CONFIG_ZED = 'Spryker\Zed\FooBar\FooBarConfig';

    public const CONTROLLER_ZED = 'Spryker\Zed\FooBar\Communication\Controller\IndexController';

    public const CLIENT = 'Spryker\Client\FooBar\FooBarClient';
    public const CLIENT_INTERFACE = 'Spryker\Client\FooBar\FooBarClientInterface';

    public const BRIDGE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge';
    public const BRIDGE_INTERFACE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeInterface';

    public const FACADE = 'Spryker\Zed\FooBar\Business\FooBarFacade';
    public const FACADE_TEST = 'SprykerTest\Zed\FooBar\Business\FooBarFacadeTest';
    public const FACADE_INTERFACE = 'Spryker\Zed\FooBar\Business\FooBarFacadeInterface';

    public const REPOSITORY = 'Spryker\Zed\FooBar\Persistence\FooBarRepository';
    public const REPOSITORY_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarRepositoryInterface';

    public const ENTITY_MANAGER = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManager';
    public const ENTITY_MANAGER_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManagerInterface';
}
