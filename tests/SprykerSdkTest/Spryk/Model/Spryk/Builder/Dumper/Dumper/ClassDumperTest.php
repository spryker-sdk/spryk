<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Model\Spryk\Builder\Dumper\Dumper;

use Codeception\Test\Unit;

/**
 * @group SprykerSdkTest
 * @group Spryk
 * @group Builder
 * @group Dumper
 * @group ClassDumperTest
 */
class ClassDumperTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testOrderStatements(): void
    {
        $fileResolver = $this->tester->getFileResolver();
        $resolved = $fileResolver->resolve(codecept_data_dir() . '/../_support/Fixtures/Dumper/UnorderedClass.php');

        $classDumper = $this->tester->getClassDumper();
        $classDumper->dump([$resolved]);

        $expectedContent = file_get_contents(codecept_data_dir() . '/../_support/Fixtures/Dumper/OrderedClass.php');

        $this->assertSame($expectedContent, $resolved->getContent());
    }
}
