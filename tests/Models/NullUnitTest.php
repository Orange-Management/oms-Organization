<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Organization\tests\Models;

use Modules\Organization\Models\NullUnit;

/**
 * @internal
 */
final class NullUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Organization\Models\NullUnit
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Organization\Models\Unit', new NullUnit());
    }

    /**
     * @covers Modules\Organization\Models\NullUnit
     * @group module
     */
    public function testId() : void
    {
        $null = new NullUnit(2);
        self::assertEquals(2, $null->getId());
    }
}
