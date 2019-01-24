<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollection;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolver;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface;

class CallbackFactory
{
    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface
     */
    public function createCallbackArgumentResolver(): CallbackArgumentResolverInterface
    {
        return new CallbackArgumentResolver(
            $this->createCallbackCollection()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface
     */
    public function createCallbackCollection(): CallbackCollectionInterface
    {
        return new CallbackCollection([
            $this->createZedFactoryMethodNameCallback(),
            $this->createZedBusinessModelTargetFilenameCallback(),
            $this->createZedBusinessModelInterfaceTargetFilenameCallback(),
            $this->createZedBusinessModelSubDirectoryCallback(),
            $this->createZedTestMethodNameCallback(),
            $this->createClassNameShortCallback(),
            $this->createEnsureControllerSuffixCallback(),
            $this->createRemoveControllerSuffixCallback(),
            $this->createEnsureActionSuffixCallback(),
            $this->createRemoveActionSuffixCallback(),
        ]);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedFactoryMethodNameCallback(): CallbackInterface
    {
        return new ZedBusinessFactoryMethodNameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedBusinessModelTargetFilenameCallback(): CallbackInterface
    {
        return new ZedBusinessModelTargetFilenameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedBusinessModelInterfaceTargetFilenameCallback(): CallbackInterface
    {
        return new ZedBusinessModelInterfaceTargetFilenameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedBusinessModelSubDirectoryCallback(): CallbackInterface
    {
        return new ZedBusinessModelSubDirectoryCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedTestMethodNameCallback(): CallbackInterface
    {
        return new ZedTestMethodNameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createClassNameShortCallback(): CallbackInterface
    {
        return new ClassNameShortCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createEnsureControllerSuffixCallback(): CallbackInterface
    {
        return new EnsureControllerSuffixCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createRemoveControllerSuffixCallback(): CallbackInterface
    {
        return new RemoveControllerSuffixCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createEnsureActionSuffixCallback(): CallbackInterface
    {
        return new EnsureActionSuffixCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createRemoveActionSuffixCallback(): CallbackInterface
    {
        return new RemoveActionSuffixCallback();
    }
}
