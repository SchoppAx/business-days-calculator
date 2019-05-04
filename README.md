business-days-calculator
========================

Business Days Calculator


[![Build Status](https://travis-ci.org/SchoppAx/business-days-calculator.png?branch=master)](https://travis-ci.org/SchoppAx/business-days-calculator) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/SchoppAx/business-days-calculator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SchoppAx/business-days-calculator/)[![Coverage Status](https://coveralls.io/repos/SchoppAx/business-days-calculator/badge.png?branch=master)](https://coveralls.io/r/SchoppAx/business-days-calculator?branch=master) [![Latest Stable Version](https://poser.pugx.org/SchoppAx/business-days-calculator/v/stable.png)](https://packagist.org/packages/SchoppAx/business-days-calculator) [![License](https://poser.pugx.org/andrejsstepanovs/business-days-calculator/license.png)](https://packagist.org/packages/andrejsstepanovs/business-days-calculator)

## Install

* If you're using Composer to manage dependencies, you can use

```sh
composer require SchoppAx/business-days-calculator
```

or add to your composer.json file:

    "require": {
        "SchoppAx/business-days-calculator": "1.*",
    }

# Example

``` php
use \BusinessDays\Calculator;

$holidays = [
    new \DateTime('2000-12-31'),
    new \DateTime('2001-01-01')
];

$freeDays = [
    new \DateTime('2000-12-28')
];

$freeWeekDays = [
    Calculator::SATURDAY,
    Calculator::SUNDAY
];

$calculator = new Calculator();
$calculator->setFreeWeekDays($freeWeekDays); // repeat every week
$calculator->setHolidays($holidays);         // repeat every year
$calculator->setFreeDays($freeDays);         // don't repeat

$result = $calculator->addBusinessDays(new \DateTime('2000-12-27', 3);    // add X working days
echo $result->format('Y-m-d');               // 2001-01-03

$result = $calculator->addBusinessDays(new \DateTime('2000-01-03', -3);   // substract X working days
echo $result->format('Y-m-d');               // 2001-12-27


```
