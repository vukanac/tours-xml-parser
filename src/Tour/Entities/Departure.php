<?php

namespace Tour\Entities;

use Money\Money;

class Departure
{
    private $code;
    private $price;
    private $discount = 0;
    private $finalPrice;

    public function __construct($code, Money $price, $discount = null)
    {
        $this->code = $code;
        $this->price = $price;

        if (!is_null($discount)) {
            if (!is_numeric($discount)) {
                throw new \Exception('Discount is not set to numeric value!');
            }
            $this->discount = $discount;
        }
        $this->finalPrice = $price->multiply((1 - $this->discount));
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getFinalPrice()
    {
        return $this->finalPrice;
    }
}
