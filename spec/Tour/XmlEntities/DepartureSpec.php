<?php

namespace spec\Tour\XmlEntities;

use Tour\XmlEntities\Departure;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use SimpleXMLElement;
use Money\Money;

class DepartureSpec extends ObjectBehavior
{
    function let()
    {
        $xmlObj = new SimpleXMLElement($this->getXml());
        $this->beConstructedWith($xmlObj->TOUR->DEP);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Departure::class);
    }

    function it_has_method_code()
    {
        $this->getCode()->shouldBeString();
        $this->getCode()->shouldBe('AN-17');
    }

    function it_has_method_starts()
    {
        $this->getStartDate()->shouldBe('04/19/2015');
    }

    function it_has_method_price()
    {
        $this->getPrice()->shouldBe('1724');
    }

    function it_has_method_discount()
    {
        $this->getDiscount()->shouldBe('15');
    }

    function it_has_method_with_no_discount()
    {
        $xmlObj = new SimpleXMLElement($this->getXml());
        $this->beConstructedWith($xmlObj->TOUR->DEP[2]);
        $this->getDiscount()->shouldBe('0');
    }

    public function getXml()
    {
        return <<<EOD
<?xml version="1.0"?>
<TOURS>
    <TOUR>
        <Title><![CDATA[Combo Tour]]></Title>
        <Code>AE-19</Code>
        <Duration>18</Duration>
        <Start>Istanbul</Start>
        <End>Cairo</End>
        <Inclusions><![CDATA[Accommodation]]></Inclusions>
        <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>
</TOURS>
EOD;
    }

}
