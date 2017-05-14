<?php

namespace spec\Tour\Entities;

use Tour\Entities\Departures;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Tour\Entities\Departure;
use ArrayAccess;
use ArrayObject;
use Money\Money;
use Countable;

class DeparturesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Departures::class);
        $this->shouldImplement(Countable::class);
        $this->shouldImplement(ArrayAccess::class);
        $this->shouldHaveType(ArrayObject::class);
    }

    function it_is_addable()
    {
        $departure = new Departure('XZ', Money::EUR('30000'));
        $this->add($departure);
    }

    function it_is_countable()
    {
        $this->shouldHaveCount(0);
        $departure = new Departure('XZ', Money::EUR('30000'));
        $this->add($departure);
        $this->shouldHaveCount(1);
        $this->add($departure);
        $this->shouldHaveCount(2);
    }

    function it_can_get_one_departure()
    {
        $departure = new Departure('XZ', Money::EUR('30000'));
        $this->add($departure);
        $this[0]->shouldHaveType(Departure::class);
    }
}
