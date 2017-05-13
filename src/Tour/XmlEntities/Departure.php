<?php

namespace Tour\XmlEntities;

// Parser
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

use SimpleXMLElement;

class Departure
{
    private $code;
    private $price;
    private $discount;
    private $finalPrice;
    
    /**
     * Example of xml:
     *     <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
     */
    public function __construct(SimpleXMLElement $oneDepartureXmlObj)
    {
        $this->xmlObj = $oneDepartureXmlObj;
    }

    public function getCode()
    {
        return (string) $this->xmlObj['DepartureCode'];
    }

    public function getStartDate()
    {
        return (string) $this->xmlObj['Starts'];
    }

    public function getPrice()
    {
        return (string) $this->xmlObj['EUR'];
    }

    public function getDiscount()
    {
        // with discount:
        // <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        // without discount
        // <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
        
        if (!isset($this->xmlObj['DISCOUNT'])) {
            return '0';
        }

        $str = (string) $this->xmlObj['DISCOUNT'];
        $str = trim($str);
        $str = rtrim($str, '%');
        return $str;
    }
}
