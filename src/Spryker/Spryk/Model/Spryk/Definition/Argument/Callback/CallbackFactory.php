<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollection;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolver;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface;

class CallbackFactory
{
    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface
     */
    public function createCallbackArgumentResolver(): CallbackArgumentResolverInterface
    {
        return new CallbackArgumentResolver(
            $this->createCallbackCollection()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface
     */
    public function createCallbackCollection(): CallbackCollectionInterface
    {
        return new CallbackCollection([
            $this->createZedFactoryMethodNameCallback(),
            $this->createZedBusinessModelTargetFilenameCallback(),
            $this->createZedBusinessModelInterfaceTargetFilenameCallback(),
            $this->createZedBusinessModelSubDirectoryCallback(),
            $this->createZedPresentationTwigFilterActionCallback(),
            $this->createZedTestMethodNameCallback(),
            $this->createClassNameShortCallback(),
            $this->createControllerNameCallback(),
            $this->createActionNameCallback(),
        ]);
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedFactoryMethodNameCallback(): CallbackInterface
    {
        return new ZedBusinessFactoryMethodNameCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedBusinessModelTargetFilenameCallback(): CallbackInterface
    {
        return new ZedBusinessModelTargetFilenameCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedBusinessModelInterfaceTargetFilenameCallback(): CallbackInterface
    {
        return new ZedBusinessModelInterfaceTargetFilenameCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedBusinessModelSubDirectoryCallback(): CallbackInterface
    {
        return new ZedBusinessModelSubDirectoryCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedPresentationTwigFilterActionCallback(): CallbackInterface
    {
        return new ZedPresentationTwigNormalizeFileNameCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedTestMethodNameCallback(): CallbackInterface
    {
        return new ZedTestMethodNameCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createClassNameShortCallback(): CallbackInterface
    {
        return new ClassNameShortCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createControllerNameCallback(): CallbackInterface
    {
        return new ControllerNameCallback();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createActionNameCallback(): CallbackInterface
    {
        return new ActionNameCallback();
    }
}
