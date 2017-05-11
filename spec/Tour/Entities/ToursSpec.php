<?php

namespace spec\Tour\Entities;

use Tour\Entities\Tours;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Countable;
use ArrayAccess;
use ArrayObject;
use Tour\Entities\Tour;

class ToursSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Tours::class);
        $this->shouldImplement(Countable::class);
        $this->shouldImplement(ArrayAccess::class);
        $this->shouldHaveType(ArrayObject::class);
    }

    function it_is_countable()
    {
        $this->shouldHaveCount(0);
    }

    function it_is_addable()
    {
        $tour = new Tour();
        $this->add($tour);
    }
}
