<?php

use Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(SetList::PHP_74);

    $containerConfigurator->parameters()->set(Option::SKIP, [
        ChangeAndIfToEarlyReturnRector::class,
        ChangeOrIfReturnToEarlyReturnRector::class,
        ClosureToArrowFunctionRector::class,
        RemoveUselessParamTagRector::class,
        RemoveUnusedPromotedPropertyRector::class,
        RemoveUselessReturnTagRector::class,
        ReturnBinaryAndToEarlyReturnRector::class,
        SimplifyUselessVariableRector::class,
        TypedPropertyRector::class,
    ]);
};
