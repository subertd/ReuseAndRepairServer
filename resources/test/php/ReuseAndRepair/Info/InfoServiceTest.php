<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/9/2015
 * Time: 12:29 PM
 */

namespace ReuseAndRepair\Info;

require_once("../main/php/ReuseAndRepair/Info/InfoService.php");

use PHPUnit_Framework_TestCase;

class InfoServiceTest extends PHPUnit_Framework_TestCase {

    const WHAT = "what";

    const INTEGER_STRING = "5";

    const NON_NUMERIC_STRING = "Tom's Rustic House of Waffles";

    const NON_INTEGER_STRING = "3.14";

    /**
     * @var InfoService
     */
    private $infoService;

    function setUp()
    {
        $this->infoService = new InfoService();
    }

    function testGetWhat_integerValueForWhat_shouldReturnParsedInt()
    {
        $argument = [InfoServiceTest::WHAT => InfoServiceTest::INTEGER_STRING];
        $expected = (int)InfoServiceTest::INTEGER_STRING;
        $actual = $this->infoService->getWhat($argument);
        $message = "When passing an array with an integer value for 'what',
            should return the parsed int";

        $this->assertEquals($expected, $actual, $message);
    }

    function testGetWhat_noValueForWhat_shouldReturnInfoAll()
    {
        $argument = array();
        $expected = INFO_ALL;
        $actual = $this->infoService->getWhat($argument);
        $message = "When there is no parameter for 'what',
            should default to INFO_ALL";

        $this->assertEquals($expected, $actual, $message);
    }

    function testGetWhat_nonNumericValueForWhat_shouldReturnInfoAll()
    {
        $argument = [InfoServiceTest::WHAT => InfoServiceTest::NON_NUMERIC_STRING ];
        $expected = INFO_ALL;
        $actual = $this->infoService->getWhat($argument);
        $message = "When the value for 'what' is not numeric,
            should default to INFO_ALL";

        $this->assertEquals($expected, $actual, $message);
    }

    function testGetWhat_nonIntegerValueForWhat_shouldReturnInfoAll()
    {
        $argument = [InfoServiceTest::WHAT => InfoServiceTest::NON_INTEGER_STRING ];
        $expected = INFO_ALL;
        $actual = $this->infoService->getWhat($argument);
        $message = "When the value of 'what' is not an integer,
            should default to INFO_ALL";

        $this->assertEquals($expected, $actual, $message);
    }
}
