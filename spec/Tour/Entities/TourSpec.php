<?php

namespace spec\Tour\Entities;

use Tour\Entities\Tour;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Tour\Entities\Departures;
use Tour\Entities\Departure;
use Money\Money;

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

    function it_can_get_min_price()
    {
        $departures = new Departures();
        $departures->add(new Departure('AA-01', Money::EUR(900)));      // 9.00
        $departures->add(new Departure('AA-02', Money::EUR(1000), 0.3));// 7.00 = 10.00 x 30% discount
        $departures->add(new Departure('AA-03', Money::EUR(800)));      // 8.00
        $this->setDepartures($departures);
        $this->getMinPrice()->shouldBeLike(Money::EUR(700));
    }
}
