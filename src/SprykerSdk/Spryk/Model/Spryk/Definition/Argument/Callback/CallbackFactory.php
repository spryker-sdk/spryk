<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
            $this->createCallbackCollection(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface
     */
    public function createCallbackCollection(): CallbackCollectionInterface
    {
        return new CallbackCollection([
            $this->createZedFactoryMethodNameCallback(),
            $this->createZedCommunicationFactoryMethodNameCallback(),
            $this->createZedBusinessModelTargetFilenameCallback(),
            $this->createZedCommunicationModelTargetFilenameCallback(),
            $this->createZedBusinessModelInterfaceTargetFilenameCallback(),
            $this->createZedCommunicationModelInterfaceTargetFilenameCallback(),
            $this->createZedBusinessModelSubDirectoryCallback(),
            $this->createZedTestMethodNameCallback(),
            $this->createClassNameShortCallback(),
            $this->createEnsureControllerSuffixCallback(),
            $this->createRemoveControllerSuffixCallback(),
            $this->createEnsureActionSuffixCallback(),
            $this->createRemoveActionSuffixCallback(),
            $this->createEnsureRestAttributesTransferAffixCallback(),
            $this->createGlueProcessorModelTargetFilenameCallback(),
            $this->createGlueProcessorModelInterfaceTargetFilenameCallback(),
            $this->createGlueProcessorModelSubDirectoryCallback(),
            $this->createGlueProcessorFactoryMethodNameCallback(),
            $this->createGlueResourceInterfaceTargetFilenameCallback(),
            $this->createGlueResourceTargetFilenameCallback(),
            $this->createEnsureResourceSuffixCallback(),
            $this->createEnsureInterfaceSuffixCallback(),
            $this->createRemoveRestApiSuffixCallback(),
        ]);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createZedCommunicationFactoryMethodNameCallback(): CallbackInterface
    {
        return new ZedCommunicationFactoryMethodNameCallback();
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
    public function createZedCommunicationModelTargetFilenameCallback(): CallbackInterface
    {
        return new ZedCommunicationModelTargetFilenameCallback();
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
    public function createZedCommunicationModelInterfaceTargetFilenameCallback(): CallbackInterface
    {
        return new ZedCommunicationModelInterfaceTargetFilenameCallback();
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

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createEnsureRestAttributesTransferAffixCallback(): CallbackInterface
    {
        return new EnsureRestAttributesTransferAffixCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createGlueProcessorModelTargetFilenameCallback(): CallbackInterface
    {
        return new GlueProcessorModelTargetFilenameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createGlueProcessorModelInterfaceTargetFilenameCallback(): CallbackInterface
    {
        return new GlueProcessorModelInterfaceTargetFilenameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createGlueProcessorModelSubDirectoryCallback(): CallbackInterface
    {
        return new GlueProcessorModelSubDirectoryCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createGlueProcessorFactoryMethodNameCallback(): CallbackInterface
    {
        return new GlueProcessorFactoryMethodNameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createGlueResourceInterfaceTargetFilenameCallback(): CallbackInterface
    {
        return new GlueResourceInterfaceTargetFilenameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createGlueResourceTargetFilenameCallback(): CallbackInterface
    {
        return new GlueResourceTargetFilenameCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createEnsureResourceSuffixCallback(): CallbackInterface
    {
        return new EnsureResourceSuffixCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createEnsureInterfaceSuffixCallback(): CallbackInterface
    {
        return new EnsureInterfaceSuffixCallback();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function createRemoveRestApiSuffixCallback(): CallbackInterface
    {
        return new RemoveRestApiSuffixCallback();
    }
}
