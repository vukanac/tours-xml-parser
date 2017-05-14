<?php

namespace Tour\XmlEntities;

use SimpleXMLElement;

class Departure
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $discount;

    /**
     * Instantiate XML Departure Parser
     *
     * Example of xml:
     *     <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
     *
     * @param SimpleXMLElement $oneDepartureXmlObj Departure part of XML
     */
    public function __construct(SimpleXMLElement $oneDepartureXmlObj)
    {
        $this->xmlObj = $oneDepartureXmlObj;
    }

    /**
     * Get Departure Code from XML Object
     *
     * @return string
     */
    public function getCode()
    {
        return (string) $this->xmlObj['DepartureCode'];
    }

    /**
     * Get Departure Start Date from XML Object
     *
     * @return string
     */
    public function getStartDate()
    {
        return (string) $this->xmlObj['Starts'];
    }

    /**
     * Get Departure Price from XML Object
     *
     * @return string
     */
    public function getPrice()
    {
        return (string) $this->xmlObj['EUR'];
    }

    /**
     * Get Departure Discount from XML Object
     *
     * If no discount value, function will return zero string '0'.
     *
     * @return string  String representing numeric value of discount as percent without % sign
     */
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
