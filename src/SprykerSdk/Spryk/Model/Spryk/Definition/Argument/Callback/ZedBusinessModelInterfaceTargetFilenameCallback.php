<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ZedBusinessModelInterfaceTargetFilenameCallback implements CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ZedBusinessModelInterfaceTargetFilenameCallback';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $className = $argumentCollection->getArgument('className')->getValue();
        if (strpos($className, '\\') !== false) {
            $classNameFragments = explode('\\', $className);

            $className = array_pop($classNameFragments);
        }

        return $className . 'Interface.php';
    }
}
