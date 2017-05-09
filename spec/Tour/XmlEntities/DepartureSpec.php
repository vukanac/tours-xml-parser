<?php

namespace spec\Tour\XmlEntities;

use Tour\XmlEntities\Departure;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


use Money\Money;

class DepartureSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('x', '100', 10);
        $this->shouldHaveType(Departure::class);
        $this->getCode()->shouldBe('x');
        $this->getPrice()->shouldBeLike(Money::EUR('10000'));
        $this->getDiscount()->shouldBe(0.1);
        $this->getFinalPrice()->shouldBeLike(Money::EUR('9000'));
    }
}
