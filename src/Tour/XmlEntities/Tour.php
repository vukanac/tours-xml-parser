<?php

namespace Tour\XmlEntities;

use SimpleXMLElement;

class Tour
{
    private $tourXmlObj;

    public function __construct(SimpleXMLElement $tourXmlObj)
    {
        $this->tourXmlObj = $tourXmlObj;
    }

    public function getCode()
    {
        return (string) $this->tourXmlObj->Code;
    }

    public function getTitle()
    {
        return html_entity_decode((string) $this->tourXmlObj->Title);
    }

    public function getDuration()
    {
        return intval((string) $this->tourXmlObj->Duration);
    }

    public function getInclusions()
    {
        $str = (string) $this->tourXmlObj->Inclusions;
        $str = $this->cleanUpHtmlToOneLinePlainText($str);
        return $str;
    }

    

    /**
     * Clean up Html string to plain text in one line.
     *
     * @param  string $str HTML code with text
     * @return string      Plain text
     */
    public function cleanUpHtmlToOneLinePlainText($str)
    {
        // strip_tags will not convert div, p and br to new line
        // convert p and div to br
        $tags = ['p', 'div'];
        foreach ($tags as $tag) {
            $pattern = '/<'.$tag.'(.*?)>((.*?)+)\<\/'.$tag.'>/';
            $replacement = '<br>${2}<br>';
            $str = preg_replace($pattern, $replacement, $str);
        }
        // TODO: Check to do the same for 'style="display: block;"';

        // standardise <br> tag
        $pattern = '/<br[^>]*>/i';
        $replacement = '${2}<br>';
        $str = preg_replace($pattern, $replacement, $str);

        // convert <br> to new line
        $str = str_replace('<br>', "\n", $str);

        // Use either Option A or Option B for convert &nbsp; to space
        //
        // Option A:
        // convert &nbsp; to space instead of to one hidden character \xA0 with html_entity_decode
        $str = str_replace('&nbsp;', ' ', $str);

        // strip_tags will not convert div, p and br to new line
        $str = strip_tags($str);
        // convert all &xzy; to chars, also &nbsp; to one hidden character \xA0 (\xC2\xA0)
        $str = html_entity_decode($str);

        // Option B:
        // convert all hidden chars \xA0 (\xC2\xA0) to space - represent `&nbsp;`
        // $str = str_replace("\xC2\xA0", ' ', $str);

        // convert all hidden chars to space, replace multiple spaces
        $str = preg_replace("/\\s+/iu", ' ', $str);

        // trim spaces and hidden chars from edges
        $str = trim($str);

        return $str;
    }

    /**
     * Get a list of departures
     *
     * @return array An array of Departure(s)
     */
    public function getDepartures()
    {
        // if (count($this->tourXmlObj->DEP) == 0) {
        //     throw new \Exception('No available departures to calculate minimal price!');
        // }

        $departures = [];
        // foreach ($this->toursXmlObj->DEP as $oneDeparture) {
        //     $departure = $this->getDeparture($oneDeparture);
        //     $departures[] = $departure;
        // }
        return $departures;
    }

    /**
     * Convert XML Departure node to Departure entity
     *
     * @param  SimpleXMLElement $oneDeparture [description]
     * @return Departure                      [description]
     */
    // private function getDeparture(SimpleXMLElement $oneDeparture)
    // {
    //     //
    //     // <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
    //     //
    //     $code = (string) $oneDeparture['DepartureCode'];
    //     $price = (string) $oneDeparture['EUR'];
    //     $discount = isset($oneDeparture['DISCOUNT'])
    //         ? (str_replace('%', '', trim(
    //             (string) $oneDeparture['DISCOUNT']
    //         )))
    //         : '0';
    //     //
    //     $departure = new Departure($code, $price, $discount);

    //     return $departure;
    // }
}
