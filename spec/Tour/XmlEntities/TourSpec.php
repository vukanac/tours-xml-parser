<?php

namespace spec\Tour\XmlEntities;

use Tour\XmlEntities\Tour;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use SimpleXMLElement;

class TourSpec extends ObjectBehavior
{
    function let()
    {
        $xmlObj = new SimpleXMLElement($this->getXml());
        $this->beConstructedWith($xmlObj->TOUR);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tour::class);
    }

    function it_has_method_code()
    {
        $this->getCode()->shouldBeString();
        $this->getCode()->shouldBe('AE-19');
    }

    function it_has_method_title()
    {
        $this->getTitle()->shouldBeString();
        $this->getTitle()->shouldBe('Combo Tour');
    }

    function it_has_method_duration()
    {
        $this->getDuration()->shouldBeInteger();
        $this->getDuration()->shouldBe(18);
    }

    function it_has_method_inclusions()
    {
        $this->getInclusions()->shouldBeString();
        $this->getInclusions()->shouldBe('Accommodation');
    }

    function it_has_method_departures()
    {
        $this->getDepartures()->shouldBeArray();
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

    function it_clean_html()
    {
        $this->cleanUpHtmlToOneLinePlainText('&lt;')->shouldBe('<');
        $this->cleanUpHtmlToOneLinePlainText(' ')->shouldBe('');
        $this->cleanUpHtmlToOneLinePlainText('x   x ')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText("x\nx")->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText("x\tx")->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText("x\rx")->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x&nbsp;x ')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText(' &nbsp;x &nbsp;  x&nbsp; &nbsp;')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<br>x')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<br/>x')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<br />x')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<BR/>x')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<p>x</p>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<p>x</p>x')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<p>x</p><p>x</p>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<div>x</div>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<div>x</div>x')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<div>x</div><div>x</div>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<div>x</div><div>x</div>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<div>x</div><p>x</p>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('<div class="test">x</div><p style="margin:10;">x</p>')->shouldBe('x x');
        $this->cleanUpHtmlToOneLinePlainText('x<br class="test" />x')->shouldBe('x x');
        // $this->cleanUpHtmlToOneLinePlainText(' 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;')->shouldBe('5, 4'."\xC2\xA0".'and'."\xC2\xA0".'3 star hotels'."\xC2\xA0".''."\xC2\xA0".'');
        $this->cleanUpHtmlToOneLinePlainText(' 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;')
                ->shouldBe('5, 4 and 3 star hotels');
        $this->cleanUpHtmlToOneLinePlainText('<div style="margin: 1px 0px; padding: 1px 0px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; text-align: justify; line-height: 19px; color: rgb(6, 119, 179);">The tour price&nbsp; cover the following services: <b style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Accommodation</b>; 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;</div>')
            ->shouldBe('The tour price cover the following services: Accommodation; 5, 4 and 3 star hotels');
        
    }

}
