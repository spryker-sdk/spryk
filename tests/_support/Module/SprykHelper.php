<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\Dumper\ClassDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderFactory;
use SprykerSdk\Spryk\Model\Spryk\Filter\FilterFactory;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\SprykFactory;

class SprykHelper extends Module
{
    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface
     */
    public function getFileResolver(): FileResolverInterface
    {
        return $this->getSprykBuilderFactory()->createFileResolver();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\Dumper\ClassDumperInterface
     */
    public function getClassDumper(): ClassDumperInterface
    {
        return $this->getSprykFactory()->createClassDumper();
    }

    /**
     * @return \SprykerSdk\Spryk\SprykFactory
     */
    protected function getSprykFactory(): SprykFactory
    {
        return new SprykFactory();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderFactory
     */
    protected function getSprykBuilderFactory(): SprykBuilderFactory
    {
        return new SprykBuilderFactory(new SprykConfig(), new FilterFactory());
    }
}
