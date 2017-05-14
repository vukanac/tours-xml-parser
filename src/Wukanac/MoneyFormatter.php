<?php

namespace Wukanac;

// Parser
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

// Format
// use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class MoneyFormatter
{
    public function decimalMoneyFormat(Money $money)
    {
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money); // outputs 1.00
    }
}
