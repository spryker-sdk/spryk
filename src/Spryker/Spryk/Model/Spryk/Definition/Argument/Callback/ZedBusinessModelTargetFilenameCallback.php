<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ZedBusinessModelTargetFilenameCallback implements CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ZedBusinessModelTargetFilenameCallback';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $className = $argumentCollection->getArgument('className')->getValue();
        $classNameFragments = explode('\\', $className);
        $requiredClassNameFragments = array_slice($classNameFragments, 5);

        $partialClassName = implode(DIRECTORY_SEPARATOR, $requiredClassNameFragments) . '.php';

        return $partialClassName;
    }
}
