<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Module;

use Codeception\Module;
use Roave\BetterReflection\BetterReflection;

class AssertionModule extends Module
{
    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    public function assertClassHasMethod(string $className, string $methodName)
    {
        $reflection = new BetterReflection();
        $classInfo = $reflection->classReflector()->reflect($className);
        $classInfo->hasMethod($methodName);

        $this->assertTrue($classInfo->hasMethod($methodName), sprintf('Expected that class "%s" has method "%s" but method not found.', $className, $methodName));
    }
}
