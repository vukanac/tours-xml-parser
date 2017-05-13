<?php

namespace spec\Tour\Entities;

use Tour\Entities\Departure;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Money\Money;

class DepartureSpec extends ObjectBehavior
{
    function let()
    {
        $code = 'XA-10';
        $price = Money::EUR('10000'); // 100.00 EUR
        $discount = 0.1; // 10%
        $this->beConstructedWith($code, $price, $discount);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Departure::class);
    }
    function it_has_methods()
    {
        $this->getCode()->shouldBe('XA-10');
        $this->getPrice()->shouldBeLike(Money::EUR('10000'));
        $this->getDiscount()->shouldBe(0.1);
        $this->getFinalPrice()->shouldBeLike(Money::EUR('9000'));
    }
    function it_can_be_instantiated_without_discount()
    {
        $this->beConstructedWith('XZ', Money::EUR('30000'));
        $this->getDiscount()->shouldBe(0);
        $this->getFinalPrice()->shouldBeLike(Money::EUR('30000'));
    }
    function it_should_throw_exception_on_null_discount()
    {
        $this->shouldThrow('\Exception')->during(
            '__construct',
            ['XZ', Money::EUR('30000'), null]
        );
    }
    function it_should_throw_exception_on_bad_discount()
    {
        $this->shouldThrow('\Exception')->during(
            '__construct',
            ['XZ', Money::EUR('30000'), 'discount_not_numeric']
        );
    }
}
