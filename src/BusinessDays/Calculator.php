<?php

namespace BusinessDays;


/**
 * Class Calculator
 *
 * @package BusinessDays
 */
class Calculator {
    const MONDAY    = 1;
    const TUESDAY   = 2;
    const WEDNESDAY = 3;
    const THURSDAY  = 4;
    const FRIDAY    = 5;
    const SATURDAY  = 6;
    const SUNDAY    = 7;
    
    const WEEK_DAY_FORMAT = 'N';
    const HOLIDAY_FORMAT  = 'm-d';
    const FREE_DAY_FORMAT = 'Y-m-d';
    
    /** @var \DateTime[] */
    private $holidays = array();
    /** @var \DateTime[] */
    private $freeDays = array();
    /** @var int[] */
    private $freeWeekDays = array(self::SATURDAY, self::SUNDAY);
    
    /**
     * @param \DateTime[] $holidays Array of holidays that repeats each year. (Only month and date is used to match).
     *
     * @return $this
     */
    public function setHolidays(array $holidays) {
        $this->holidays = $holidays;
    }
    /**
     * @return \DateTime[]
     */
    private function getHolidays() {
        return $this->holidays;
    }
    
    /**
     * @param \DateTime[] $freeDays Array of free days that dose not repeat.
     *
     * @return $this
     */
    public function setFreeDays(array $freeDays) {
        $this->freeDays = $freeDays;
    }
    /**
     * @return \DateTime[]
     */
    private function getFreeDays() {
        return $this->freeDays;
    }
    
    /**
     * @param int[] $freeWeekDays Array of days of the week which are not business days.
     *
     * @return $this
     */
    public function setFreeWeekDays(array $freeWeekDays) {
        $this->freeWeekDays = $freeWeekDays;
    }
    /**
     * @return int[]
     */
    private function getFreeWeekDays() {
        if (count($this->freeWeekDays) >= 7) {
            throw new \InvalidArgumentException('Too many non business days provided');
        }
        return $this->freeWeekDays;
    }

    /**
     * @param int $x
     *
     * @return $x
     */
    private function determineSign($x) {
    	 return $x > 0 ? 1 : -1;
    }
    
    /**
     * @param int $howManyDays
     *
     * @return $newBusinessDate
     */
    public function addBusinessDays(\DateTime $date, $amount) {
        if ($amount === 0 || is_nan($amount)) { return $date; }

        $sign = $this->determineSign($amount);
        $absIncrement = abs($amount);
        $newdate = clone $date;
        $iterator = 0;
        while ($iterator < $absIncrement) {
            $newdate->modify($sign . ' day');
            if ($this->isBusinessDay($newdate)) {
                $iterator++;
            }
        }
        return $newdate;
    }
    
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isBusinessDay(\DateTime $date) {
        if ($this->isFreeWeekDayDay($date) || $this->isHoliday($date) || $this->isFreeDay($date)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isFreeWeekDayDay(\DateTime $date) {
        $currentWeekDay = (int)$date->format(self::WEEK_DAY_FORMAT);
        if (in_array($currentWeekDay, $this->getFreeWeekDays())) {
            return true;
        }
        return false;
    }
    
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isHoliday(\DateTime $date) {
        $holidayFormatValue = $date->format(self::HOLIDAY_FORMAT);
        foreach ($this->getHolidays() as $holiday) {
            if ($holidayFormatValue == $holiday->format(self::HOLIDAY_FORMAT)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isFreeDay(\DateTime $date) {
        $freeDayFormatValue = $date->format(self::FREE_DAY_FORMAT);
        foreach ($this->getFreeDays() as $freeDay) {
            if ($freeDayFormatValue == $freeDay->format(self::FREE_DAY_FORMAT)) {
                return true;
            }
        }
        return false;
    }
}
