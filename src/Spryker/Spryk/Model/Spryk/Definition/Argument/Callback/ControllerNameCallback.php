<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ControllerNameCallback implements CallbackInterface
{
    protected const CONTROLLER_SUFFIX = 'Controller';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ControllerNameCallback';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $controllerClassName = $argumentCollection->getArgument('controller')->getValue();
        if (mb_substr($controllerClassName, - mb_strlen(static::CONTROLLER_SUFFIX)) === static::CONTROLLER_SUFFIX) {
            $controllerClassName = mb_substr($controllerClassName, 0, mb_strlen($controllerClassName) - mb_strlen(static::CONTROLLER_SUFFIX));
        }

        return ucfirst($controllerClassName);
    }
}
