<?php

namespace spec\Tour\Entities;

use Tour\Entities\Tour;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Tour\Entities\Departure;
use Tour\Entities\Departures;

class TourSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Tour::class);
    }

    function it_has_methods()
    {
        $this->setCode('XA');
        $this->setTitle('Title');
        $this->setDuration(18);
        $this->setInclusions('Something is included');

        $this->getCode()->shouldBe('XA');
        $this->getTitle()->shouldBe('Title');
        $this->getDuration()->shouldBe(18);
        $this->getInclusions()->shouldBe('Something is included');
    }

    function it_can_get_departures_collection()
    {
        $this->setDepartures(new Departures());
        $this->getDepartures()->shouldHaveType(Departures::class);
    }
}
