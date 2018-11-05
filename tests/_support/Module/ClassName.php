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
    public const CONFIG_CLIENT = 'Spryker\Client\FooBar\FooBarConfig';

    public const CONTROLLER_ZED = 'Spryker\Zed\FooBar\Communication\Controller\IndexController';

    public const BRIDGE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge';
    public const BRIDGE_INTERFACE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeInterface';

    public const FACADE = 'Spryker\Zed\FooBar\Business\FooBarFacade';
    public const FACADE_TEST = 'SprykerTest\Zed\FooBar\Business\FooBarFacadeTest';
    public const FACADE_INTERFACE = 'Spryker\Zed\FooBar\Business\FooBarFacadeInterface';

    public const REPOSITORY = 'Spryker\Zed\FooBar\Persistence\FooBarRepository';
    public const REPOSITORY_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarRepositoryInterface';

    public const ENTITY_MANAGER = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManager';
    public const ENTITY_MANAGER_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManagerInterface';

    public const CLIENT_CONFIG = 'Spryker\Client\FooBar\FooBarConfig';
    public const CLIENT = 'Spryker\Client\FooBar\FooBarClient';
    public const CLIENT_INTERFACE = 'Spryker\Client\FooBar\FooBarClientInterface';

    public const YVES_FACTORY = 'Spryker\Yves\FooBar\FooBarFactory';
    public const YVES_CONFIG = 'Spryker\Yves\FooBar\FooBarConfig';
    public const YVES_DEPENDENCY_PROVIDER = 'Spryker\Yves\FooBar\FooBarDependencyProvider';
    public const YVES_CLIENT_BRIDGE = 'Spryker\Yves\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const YVES_CLIENT_BRIDGE_INTERFACE = 'Spryker\Yves\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const YVES_SERVICE_BRIDGE = 'Spryker\Yves\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const YVES_SERVICE_BRIDGE_INTERFACE = 'Spryker\Yves\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const ZED_CONTROLLER = 'Spryker\Zed\FooBar\Communication\Controller\IndexController';
    public const ZED_CONFIG = 'Spryker\Zed\FooBar\FooBarConfig';
    public const ZED_BUSINESS_FACTORY = 'Spryker\Zed\FooBar\Business\FooBarBusinessFactory';
    public const ZED_DEPENDENCY_PROVIDER = 'Spryker\Zed\FooBar\FooBarDependencyProvider';

    public const ZED_FACADE_BRIDGE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge';
    public const ZED_FACADE_BRIDGE_INTERFACE = 'Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeInterface';
    public const ZED_CLIENT_BRIDGE = 'Spryker\Zed\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const ZED_CLIENT_BRIDGE_INTERFACE = 'Spryker\Zed\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const ZED_SERVICE_BRIDGE = 'Spryker\Zed\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const ZED_SERVICE_BRIDGE_INTERFACE = 'Spryker\Zed\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const ZED_FACADE = 'Spryker\Zed\FooBar\Business\FooBarFacade';
    public const ZED_FACADE_TEST = 'SprykerTest\Zed\FooBar\Business\FooBarFacadeTest';
    public const ZED_FACADE_INTERFACE = 'Spryker\Zed\FooBar\Business\FooBarFacadeInterface';

    public const ZED_REPOSITORY = 'Spryker\Zed\FooBar\Persistence\FooBarRepository';
    public const ZED_REPOSITORY_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarRepositoryInterface';

    public const ZED_ENTITY_MANAGER = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManager';
    public const ZED_ENTITY_MANAGER_INTERFACE = 'Spryker\Zed\FooBar\Persistence\FooBarEntityManagerInterface';
}
