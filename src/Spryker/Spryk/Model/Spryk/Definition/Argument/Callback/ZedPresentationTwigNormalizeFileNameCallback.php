<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ZedPresentationTwigNormalizeFileNameCallback implements CallbackInterface
{
    const ACTION = 'Action';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ZedPresentationTwigNormalizeFileNameCallback';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $targetFilename = $argumentCollection->getArgument('targetFilename')->getValue();
        $targetFileNameWithoutExtension = $this->getTargetFileNameWithoutExtension($targetFilename);

        return $targetFileNameWithoutExtension . '.twig';
    }

    /**
     * @param string $targetFilename
     *
     * @return string
     */
    protected function getTargetFileNameWithoutExtension(string $targetFilename): string
    {
        $targetFileNameWithoutExtension = str_replace('.twig', '', $targetFilename);

        if (substr($targetFileNameWithoutExtension, -strlen(static::ACTION)) === static::ACTION) {
            $targetFileNameWithoutExtension = substr($targetFilename, 0, strlen(static::ACTION) - 1);
        }

        return $targetFileNameWithoutExtension;
    }
}
