<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

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
    public const CLIENT_FACTORY = 'Spryker\Client\FooBar\FooBarFactory';
    public const CLIENT_DEPENDENCY_PROVIDER = 'Spryker\Client\FooBar\FooBarDependencyProvider';

    public const CLIENT_CLIENT_BRIDGE = 'Spryker\Client\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const CLIENT_CLIENT_BRIDGE_INTERFACE = 'Spryker\Client\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const CLIENT_SERVICE_BRIDGE = 'Spryker\Client\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const CLIENT_SERVICE_BRIDGE_INTERFACE = 'Spryker\Client\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const YVES_CONTROLLER = 'Spryker\Yves\FooBar\Controller\FooBarController';
    public const YVES_FACTORY = 'Spryker\Yves\FooBar\FooBarFactory';
    public const YVES_CONFIG = 'Spryker\Yves\FooBar\FooBarConfig';
    public const YVES_ROUTE_PROVIDER = 'Spryker\Yves\FooBar\Plugin\Router\FooBarRouteProviderPlugin';
    public const YVES_DEPENDENCY_PROVIDER = 'Spryker\Yves\FooBar\FooBarDependencyProvider';
    public const YVES_CLIENT_BRIDGE = 'Spryker\Yves\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const YVES_CLIENT_BRIDGE_INTERFACE = 'Spryker\Yves\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const YVES_SERVICE_BRIDGE = 'Spryker\Yves\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const YVES_SERVICE_BRIDGE_INTERFACE = 'Spryker\Yves\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const ZED_CONTROLLER = 'Spryker\Zed\FooBar\Communication\Controller\IndexController';
    public const ZED_CONFIG = 'Spryker\Zed\FooBar\FooBarConfig';
    public const ZED_BUSINESS_FACTORY = 'Spryker\Zed\FooBar\Business\FooBarBusinessFactory';
    public const ZED_DEPENDENCY_PROVIDER = 'Spryker\Zed\FooBar\FooBarDependencyProvider';

    public const GLUE_CONTROLLER = 'Spryker\Glue\FooBar\Controller\BarController';
    public const GLUE_CONFIG = 'Spryker\Glue\FooBar\FooBarConfig';
    public const GLUE_BUSINESS_FACTORY = 'Spryker\Glue\FooBar\FooBarFactory';
    public const GLUE_DEPENDENCY_PROVIDER = 'Spryker\Glue\FooBar\FooBarDependencyProvider';
    public const GLUE_RESOURCE_MAPPER = 'Spryker\Glue\FooBar\Processor\Mapper\FooBarMapper';
    public const GLUE_RESOURCE_MAPPER_INTERFACE = 'Spryker\Glue\FooBar\Processor\Mapper\FooBarMapperInterface';
    public const GLUE_CLIENT_BRIDGE = 'Spryker\Glue\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const GLUE_CLIENT_BRIDGE_INTERFACE = 'Spryker\Glue\FooBar\Dependency\Client\FooBarToZipZapClientInterface';

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

    public const DATA_IMPORT_BUSINESS_FACTORY = 'Spryker\Zed\FooBar\Business\FooBarBusinessFactory';

    public const ZED_CHECKOUT_DO_SAVE_ORDER_PLUGIN = 'Spryker\Zed\FooBar\Communication\Plugin\Checkout\TestPaymentCheckoutDoSaveOrderPlugin';
    public const ZED_CHECKOUT_POST_SAVE_PLUGIN = 'Spryker\Zed\FooBar\Communication\Plugin\Checkout\TestPaymentCheckoutPostSavePlugin';
    public const ZED_CHECKOUT_PRE_CONDITION_PLUGIN = 'Spryker\Zed\FooBar\Communication\Plugin\Checkout\TestPaymentCheckoutPreConditionPlugin';
    public const ZED_ORDER_PAYMENT_EXPANDER_PLUGIN = 'Spryker\Zed\FooBar\Communication\Plugin\TestPaymentOrderPaymentExpanderPlugin';
    public const ZED_PAYMENT_METHOD_FILTER_PLUGIN = 'Spryker\Zed\FooBar\Communication\Plugin\Payment\TestPaymentPaymentMethodFilterPlugin';
    public const ZED_PLUGIN_OMS_COMMAND_BY_ORDER_PLUGIN = 'Spryker\Zed\FooBar\Communication\Plugin\Oms\Command\TestPaymentCommandByOrder';

    public const YVES_PLUGIN_SUB_FORM_PLUGIN = 'Spryker\Yves\FooBar\Plugin\TestPaymentSubFormPlugin';

    public const PROJECT_CONFIG_YVES = 'Pyz\Yves\FooBar\FooBarConfig';
    public const PROJECT_CONFIG_ZED = 'Pyz\Zed\FooBar\FooBarConfig';
    public const PROJECT_CONFIG_CLIENT = 'Pyz\Client\FooBar\FooBarConfig';

    public const PROJECT_CONTROLLER_ZED = 'Pyz\Zed\FooBar\Communication\Controller\IndexController';

    public const PROJECT_BRIDGE = 'Pyz\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge';
    public const PROJECT_BRIDGE_INTERFACE = 'Pyz\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeInterface';

    public const PROJECT_FACADE = 'Pyz\Zed\FooBar\Business\FooBarFacade';
    public const PROJECT_FACADE_TEST = 'Pyz\Zed\FooBar\Business\FooBarFacadeTest';
    public const PROJECT_FACADE_INTERFACE = 'Pyz\Zed\FooBar\Business\FooBarFacadeInterface';

    public const PROJECT_REPOSITORY = 'Pyz\Zed\FooBar\Persistence\FooBarRepository';
    public const PROJECT_REPOSITORY_INTERFACE = 'Pyz\Zed\FooBar\Persistence\FooBarRepositoryInterface';

    public const PROJECT_ENTITY_MANAGER = 'Pyz\Zed\FooBar\Persistence\FooBarEntityManager';
    public const PROJECT_ENTITY_MANAGER_INTERFACE = 'Pyz\Zed\FooBar\Persistence\FooBarEntityManagerInterface';

    public const PROJECT_CLIENT_CONFIG = 'Pyz\Client\FooBar\FooBarConfig';
    public const PROJECT_CLIENT = 'Pyz\Client\FooBar\FooBarClient';
    public const PROJECT_CLIENT_INTERFACE = 'Pyz\Client\FooBar\FooBarClientInterface';
    public const PROJECT_CLIENT_FACTORY = 'Pyz\Client\FooBar\FooBarFactory';
    public const PROJECT_CLIENT_DEPENDENCY_PROVIDER = 'Pyz\Client\FooBar\FooBarDependencyProvider';

    public const PROJECT_CLIENT_CLIENT_BRIDGE = 'Pyz\Client\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const PROJECT_CLIENT_CLIENT_BRIDGE_INTERFACE = 'Pyz\Client\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const PROJECT_CLIENT_SERVICE_BRIDGE = 'Pyz\Client\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const PROJECT_CLIENT_SERVICE_BRIDGE_INTERFACE = 'Pyz\Client\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const PROJECT_YVES_CONTROLLER = 'Pyz\Yves\FooBar\Controller\FooBarController';
    public const PROJECT_YVES_FACTORY = 'Pyz\Yves\FooBar\FooBarFactory';
    public const PROJECT_YVES_CONFIG = 'Pyz\Yves\FooBar\FooBarConfig';
    public const PROJECT_YVES_ROUTE_PROVIDER = 'Pyz\Yves\FooBar\Plugin\Router\FooBarRouteProviderPlugin';
    public const PROJECT_YVES_DEPENDENCY_PROVIDER = 'Pyz\Yves\FooBar\FooBarDependencyProvider';
    public const PROJECT_YVES_CLIENT_BRIDGE = 'Pyz\Yves\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const PROJECT_YVES_CLIENT_BRIDGE_INTERFACE = 'Pyz\Yves\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const PROJECT_YVES_SERVICE_BRIDGE = 'Pyz\Yves\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const PROJECT_YVES_SERVICE_BRIDGE_INTERFACE = 'Pyz\Yves\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const PROJECT_ZED_CONTROLLER = 'Pyz\Zed\FooBar\Communication\Controller\IndexController';
    public const PROJECT_ZED_CONFIG = 'Pyz\Zed\FooBar\FooBarConfig';
    public const PROJECT_ZED_BUSINESS_FACTORY = 'Pyz\Zed\FooBar\Business\FooBarBusinessFactory';
    public const PROJECT_ZED_DEPENDENCY_PROVIDER = 'Pyz\Zed\FooBar\FooBarDependencyProvider';

    public const PROJECT_GLUE_CONTROLLER = 'Pyz\Glue\FooBar\Controller\BarController';
    public const PROJECT_GLUE_CONFIG = 'Pyz\Glue\FooBar\FooBarConfig';
    public const PROJECT_GLUE_BUSINESS_FACTORY = 'Pyz\Glue\FooBar\FooBarFactory';
    public const PROJECT_GLUE_DEPENDENCY_PROVIDER = 'Pyz\Glue\FooBar\FooBarDependencyProvider';
    public const PROJECT_GLUE_RESOURCE_MAPPER = 'Pyz\Glue\FooBar\Processor\Mapper\FooBarMapper';
    public const PROJECT_GLUE_RESOURCE_MAPPER_INTERFACE = 'Pyz\Glue\FooBar\Processor\Mapper\FooBarMapperInterface';
    public const PROJECT_GLUE_CLIENT_BRIDGE = 'Pyz\Glue\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const PROJECT_GLUE_CLIENT_BRIDGE_INTERFACE = 'Pyz\Glue\FooBar\Dependency\Client\FooBarToZipZapClientInterface';

    public const PROJECT_ZED_FACADE_BRIDGE = 'Pyz\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge';
    public const PROJECT_ZED_FACADE_BRIDGE_INTERFACE = 'Pyz\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeInterface';
    public const PROJECT_ZED_CLIENT_BRIDGE = 'Pyz\Zed\FooBar\Dependency\Client\FooBarToZipZapClientBridge';
    public const PROJECT_ZED_CLIENT_BRIDGE_INTERFACE = 'Pyz\Zed\FooBar\Dependency\Client\FooBarToZipZapClientInterface';
    public const PROJECT_ZED_SERVICE_BRIDGE = 'Pyz\Zed\FooBar\Dependency\Service\FooBarToZipZapServiceBridge';
    public const PROJECT_ZED_SERVICE_BRIDGE_INTERFACE = 'Pyz\Zed\FooBar\Dependency\Service\FooBarToZipZapServiceInterface';

    public const PROJECT_ZED_FACADE = 'Pyz\Zed\FooBar\Business\FooBarFacade';
    public const PROJECT_ZED_FACADE_TEST = 'PyzTest\Zed\FooBar\Business\FooBarFacadeTest';
    public const PROJECT_ZED_FACADE_INTERFACE = 'Pyz\Zed\FooBar\Business\FooBarFacadeInterface';

    public const PROJECT_ZED_REPOSITORY = 'Pyz\Zed\FooBar\Persistence\FooBarRepository';
    public const PROJECT_ZED_REPOSITORY_INTERFACE = 'Pyz\Zed\FooBar\Persistence\FooBarRepositoryInterface';

    public const PROJECT_ZED_ENTITY_MANAGER = 'Pyz\Zed\FooBar\Persistence\FooBarEntityManager';
    public const PROJECT_ZED_ENTITY_MANAGER_INTERFACE = 'Pyz\Zed\FooBar\Persistence\FooBarEntityManagerInterface';

    public const PROJECT_DATA_IMPORT_BUSINESS_FACTORY = 'Pyz\Zed\FooBar\Business\FooBarBusinessFactory';

    public const PROJECT_ZED_CHECKOUT_DO_SAVE_ORDER_PLUGIN = 'Pyz\Zed\FooBar\Communication\Plugin\Checkout\TestPaymentCheckoutDoSaveOrderPlugin';
    public const PROJECT_ZED_CHECKOUT_POST_SAVE_PLUGIN = 'Pyz\Zed\FooBar\Communication\Plugin\Checkout\TestPaymentCheckoutPostSavePlugin';
    public const PROJECT_ZED_CHECKOUT_PRE_CONDITION_PLUGIN = 'Pyz\Zed\FooBar\Communication\Plugin\Checkout\TestPaymentCheckoutPreConditionPlugin';
    public const PROJECT_ZED_ORDER_PAYMENT_EXPANDER_PLUGIN = 'Pyz\Zed\FooBar\Communication\Plugin\TestPaymentOrderPaymentExpanderPlugin';
    public const PROJECT_ZED_PAYMENT_METHOD_FILTER_PLUGIN = 'Pyz\Zed\FooBar\Communication\Plugin\Payment\TestPaymentPaymentMethodFilterPlugin';
    public const PROJECT_ZED_PLUGIN_OMS_COMMAND_BY_ORDER_PLUGIN = 'Pyz\Zed\FooBar\Communication\Plugin\Oms\Command\TestPaymentCommandByOrder';

    public const PROJECT_YVES_PLUGIN_SUB_FORM_PLUGIN = 'Pyz\Yves\FooBar\Plugin\TestPaymentSubFormPlugin';
}
