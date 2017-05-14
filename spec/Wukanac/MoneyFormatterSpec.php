<?php

namespace spec\Wukanac;

use Wukanac\MoneyFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

// Parser
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

// Format
// use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class MoneyFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MoneyFormatter::class);
    }

    function it_has_method_decimalMoneyFormat()
    {
        $m = Money::EUR(100);
        $this->decimalMoneyFormat($m)->shouldBe('1.00');
    }
}
