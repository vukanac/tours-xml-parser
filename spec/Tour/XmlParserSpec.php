<?php

namespace spec\Tour;

use Tour\XmlParser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Money\Money;


class XmlParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(XmlParser::class);
    }
    // function it_(FilesystemInterface $filesystem)
    // {
    //     $adapter = new League\Flysystem\Adapter\NullAdapter;
    //     $filesystem = new League\Flysystem\Filesystem($adapter);

    //     $file = 'data/tours.xml';
    //     $contents = $filesystem->read($file);


    // }
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
    function it_has_mathod_xmlToCSV()
    {
        $inputXml = $this->getXml();
        $outputText = $this->getOutputText();
        $this->xmlToCSV($inputXml)->shouldBe($outputText);
    }

    function it_can_get_title()
    {
        $inputXml = $this->getXml();
        // $outputText = $this->getOutputText();
        $this->loadXmlString($inputXml);
        $this->getTitle()->shouldBe('Anzac & Egypt Combo Tour');
    }
    function it_can_get_code()
    {
        $inputXml = $this->getXml();
        // $outputText = $this->getOutputText();
        $this->loadXmlString($inputXml);
        $this->getCode()->shouldBe('AE-19');
    }
    function it_can_get_duration()
    {
        $inputXml = $this->getXml();
        // $outputText = $this->getOutputText();
        $this->loadXmlString($inputXml);
        $this->getDuration()->shouldBe(18);
    }

    function it_can_get_inclusions()
    {
        $inputXml = $this->getXml();
        // $outputText = $this->getOutputText();
        $this->loadXmlString($inputXml);
        $this->getInclusions()->shouldBe('The tour price cover the following services: Accommodation; 5, 4 and 3 star hotels');
    }

    function it_can_get_min_price()
    {
        $inputXml = $this->getXml();
        $this->loadXmlString($inputXml);
        $this->getMinPrice()->shouldBeLike(Money::EUR('142720'));
    }
    function it_can_get_departures()
    {
        $inputXml = $this->getXml();
        $this->loadXmlString($inputXml);
        $this->getDepartures()[1]->getFinalPrice()->shouldBeLike(Money::EUR('142720'));
    }

    function it_can_get_departure_discount()
    {
        $inputXml = $this->getXml();
        $this->loadXmlString($inputXml);
        $this->getDepartures()[0]->getDiscount()->shouldBe(0.15);
    }

    function it_can_get_departure_price()
    {
        $inputXml = $this->getXml();
        $this->loadXmlString($inputXml);
        $this->getDepartures()[0]->getPrice()->shouldBeLike(Money::EUR('172400'));
    }

    function it_should_get_departure_discount_without_discount_set()
    {
        $inputXml = $this->getXml();
        $this->loadXmlString($inputXml);
        $this->getDepartures()[2]->getDiscount()->shouldBe(0);
    }

    function it_should_throw_error_if_no_departures()
    {
        $inputXml = $this->getXmlWithuthDepartures();
        $this->loadXmlString($inputXml);
        $this->shouldThrow('\Exception')->duringGetDepartures();
        // $this->getDepartures()[2]->getDiscount()->shouldBe(0);
    }

    public function getXml()
    {
        return <<<EOD
<?xml version="1.0"?>
<TOURS>
    <TOUR>
        <Title><![CDATA[Anzac &amp; Egypt Combo Tour]]></Title>
        <Code>AE-19</Code>
        <Duration>18</Duration>
        <Start>Istanbul</Start>
        <End>Cairo</End>
        <Inclusions>
            <![CDATA[<div style="margin: 1px 0px; padding: 1px 0px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; text-align: justify; line-height: 19px; color: rgb(6, 119, 179);">The tour price&nbsp; cover the following services: <b style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Accommodation</b>; 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;</div>]]>
        </Inclusions>
        <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>
    <TOUR>
        <Title>Simple Title</Title>
        <Code>CODE-19</Code>
        <Duration>35</Duration>
        <Start>Vienna</Start>
        <End>Vienna</End>
        <Inclusions>
            Plain Inclusions text

        </Inclusions>
        <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>
</TOURS>
EOD;
    }

    public function getXmlWithuthDepartures()
    {
        return <<<EOD
<?xml version="1.0"?>
<TOURS>
    <TOUR>
        <Title><![CDATA[Anzac &amp; Egypt Combo Tour]]></Title>
        <Code>AE-19</Code>
        <Duration>18</Duration>
        <Start>Istanbul</Start>
        <End>Cairo</End>
        <Inclusions>
            <![CDATA[<div style="margin: 1px 0px; padding: 1px 0px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; text-align: justify; line-height: 19px; color: rgb(6, 119, 179);">The tour price&nbsp; cover the following services: <b style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Accommodation</b>; 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;</div>]]>
        </Inclusions>
    </TOUR>
</TOURS>
EOD;
    }
    public function getXmlWithMultipleTours()
    {
        return <<<EOD
<?xml version="1.0"?>
<TOURS>
    <TOUR>
        <Title><![CDATA[Anzac &amp; Egypt Combo Tour]]></Title>
        <Code>AE-19</Code>
        <Duration>18</Duration>
        <Start>Istanbul</Start>
        <End>Cairo</End>
        <Inclusions>
            <![CDATA[<div style="margin: 1px 0px; padding: 1px 0px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; text-align: justify; line-height: 19px; color: rgb(6, 119, 179);">The tour price&nbsp; cover the following services: <b style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Accommodation</b>; 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;</div>]]>
        </Inclusions>
        <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>
    <TOUR>
        <Title>Simple Tour Title</Title>
        <Code>CO-35</Code>
        <Duration>37</Duration>
        <Start>Vienna</Start>
        <End>Vienna</End>
        <Inclusions>
            Plain Inclusions text

        </Inclusions>
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
    </TOUR>
    <TOUR>
        <Title>Train Tour</Title>
        <Code>CO-10</Code>
        <Duration>6</Duration>
        <Start>London</Start>
        <End>Paris</End>
        <Inclusions>
            <![CDATA[<div>Another Tour With Trains</div>]]>
        </Inclusions>
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>
</TOURS>
EOD;
    }

    public function getOutputText()
    {
        return 'Title|Code|Duration|Inclusions|MinPrice|
Anzac & Egypt Combo Tour|AE-19|18|The tour price cover the following services: Accommodation; 5, 4 and 3 star hotels|1427.20
';
    }
    public function getOutputTextWithMultipleTours()
    {
        return 'Title|Code|Duration|Inclusions|MinPrice|
Anzac & Egypt Combo Tour|AE-19|18|The tour price cover the following services: Accommodation; 5, 4 and 3 star hotels|1427.20
Simple Tour Title|CO-35|37|Plain Inclusions text|1427.20
Train Tour|CO-10|6|Another Tour With Trains|1784.00
';
    }
}
