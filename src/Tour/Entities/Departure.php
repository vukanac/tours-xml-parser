<?php

namespace Tour\Entities;

use Money\Money;

class Departure
{
    private $code;
    private $price;
    private $discount = 0;
    private $finalPrice;

    /**
     * Instantiate Departure
     *
     * @param string        $code     Departure code
     * @param \Money\Money  $price    Price of departure
     * @param float         $discount Optional discount as decimal value (0.15 for 15%). Default is 0.
     */
    public function __construct($code, Money $price, $discount = 0)
    {
        $this->code = $code;
        $this->price = $price;

        if (!is_numeric($discount)) {
            throw new \Exception('Discount is not set to numeric value!');
        }
        $this->discount = $discount;
        $this->finalPrice = $price->multiply((1 - $this->discount));
    }

    /**
     * Get Departure Code
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get Departure Discount
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Get Departure Price
     * @return \Money\Money
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get Final Price
     * @return \Money\Money
     */
    public function getFinalPrice()
    {
        return $this->finalPrice;
    }
}
