<?php
namespace Tests;

use BusinessDays\Calculator;


/**
 * Class CalculatorTest
 *
 * @package Tests
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Calculator */
    private $_sut;

    public function setUp()
    {
        $this->_sut = new Calculator();
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return include __DIR__ . '/fixtures/business_days.php';
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string      $message
     * @param \DateTime   $startDate
     * @param int         $howManyDays
     * @param \DateTime   $expected
     * @param int[]       $nonBusinessDays
     * @param \DateTime[] $freeDays
     * @param \DateTime[] $holidays
     */
    public function testReturnsExpected(
        $message,
        \DateTime $startDate,
        $howManyDays,
        \DateTime $expected,
        array $nonBusinessDays = array(),
        array $freeDays = array(),
        array $holidays = array()
    ) {
        $this->_sut->setFreeDays($freeDays);
        $this->_sut->setHolidays($holidays);
        $this->_sut->setFreeWeekDays($nonBusinessDays);

        $response = $this->_sut->addBusinessDays($startDate, $howManyDays);

        $this->assertEquals($response, $expected, $message);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTooManyBusinessDaysException()
    {
        $date = new \DateTime('2000-01-01');
        
        $nonBusinessDays = [
            Calculator::MONDAY,
            Calculator::TUESDAY,
            Calculator::WEDNESDAY,
            Calculator::THURSDAY,
            Calculator::FRIDAY,
            Calculator::SATURDAY,
            Calculator::SUNDAY
        ];

        $this->_sut->setFreeWeekDays($nonBusinessDays);
        $this->_sut->addBusinessDays($date, 1);
    }

    public function testThatPassedParameterIsNotChangedByReferenceInSut()
    {
        $date = new \DateTime('2000-01-01');

        $responseDate = $this->_sut->addBusinessDays($date, 1);

        $this->assertNotEquals($date, $responseDate);
    }
}
