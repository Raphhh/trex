<?php
namespace TRex\Iterator;

/**
 * Class SortTypeTest
 * @package TRex\Iterator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class SortTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests default behavior of getValue.
     */
    public function testGetValue()
    {
        $sortType = new SortType(SortType::VALUE_SORT_TYPE);
        $this->assertSame('sort', $sortType->getValue());
    }

    /**
     * Tests getValue for a callback.
     */
    public function testGetValueForCallback()
    {
        $sortType = new SortType(SortType::VALUE_SORT_TYPE);
        $this->assertSame('usort', $sortType->getValue(true));
    }
}
 