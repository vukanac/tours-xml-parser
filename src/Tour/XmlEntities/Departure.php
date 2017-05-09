<?php

namespace Tour\XmlEntities;

// Parser
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

class Departure
{
    private $code;
    private $price;
    private $discount;
    private $finalPrice;
    
    public function __construct($code, $price, $discount)
    {
        // Money Parser require to parse a string
        $price = (string) $price;

        // Code cannot be empty
        if (empty($code)) {
            throw new \Exception('Code is required!');
        }
        
        // Price can be set to 0
        if (!isset($price) || !is_numeric($discount)) {
            throw new \Exception('Price is not set!');
        }

        // Notify if price is Zero - looks like an error
        // TODO: Remove this check if not appropriate - if Zero is legitimate
        if (empty($price)) {
            throw new \Exception('Price is zero!');
        }

        // Discount must be set, at least to 0
        if (!isset($discount) || !is_numeric($discount)) {
            throw new \Exception('Discount is not set to numeric value!');
        }

        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        $money = $moneyParser->parse($price, 'EUR');

        $this->code = $code;
        $this->price = $money;
        $this->discount = $discount/100;
        $this->finalPrice = $money->multiply((1 - $this->discount));
    }

    public function getFinalPrice()
    {
        return $this->finalPrice;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCode()
    {
        return $this->code;
    }
}
