<?php

namespace SprykerSdkTest\Spryk\Integration\Spryker\Zed\Business;

use Codeception\Test\Unit;
use SprykerSdkTest\SprykIntegrationTester;

/**
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Spryker
 * @group Zed
 * @group Business
 * @group AddCrudFacadeTest
 */
class AddCrudFacadeTest extends Unit
{
    protected SprykIntegrationTester $tester;

    /**
     * @return void
     */
    public function testAddCrudFacade(): void
    {
        $this->markTestSkipped('Add tests when it can be done. The file does not do anything yet');

        $this->tester->run($this, [
            '--module' => 'NewModuleType',
            '--organization' => 'TestOrganization',
        ]);
    }
}
