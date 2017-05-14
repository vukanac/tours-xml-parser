<?php

namespace spec\Tour\Exporters;

use Tour\Exporters\CsvExporter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Tour\Entities\Departures;
use Tour\Entities\Departure;
use Tour\Entities\Tours;
use Tour\Entities\Tour;
use Money\Money;

class CsvExporterSpec extends ObjectBehavior
{
    function let(Tours $tours)
    {
        $this->beConstructedWith($tours);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(CsvExporter::class);
    }

    function it_should_throw_error_if_no_departures(Tours $tours)
    {
        // no tours
        $this->shouldThrow('\Exception')->during(
            '__construct',
            [$tours]
        );
        // $this->beConstructedWith($tours);
    }

    function it_has_method_getCsvContent()
    {
        $tours = new Tours();
        $departures = new Departures();
        $departures->add(new Departure('XAD-1', Money::EUR('124')));
        $tour = new Tour();
        $tour->setCode('XA-1');
        $tour->setTitle('TTL XA-1');
        $tour->setInclusions('TTL XA-1');
        $tour->setDuration(10);
        $tour->setDepartures($departures);
        $tours->add($tour);

        $this->beConstructedWith($tours);
        $this->getCsvContent()->shouldBe($this->getOutputText());
    }

    public function getOutputText()
    {
        return 'Title|Code|Duration|Inclusions|MinPrice
TTL XA-1|XA-1|10|TTL XA-1|1.24
';
    }
}
