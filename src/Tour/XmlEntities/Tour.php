<?php

namespace Tour\XmlEntities;

use SimpleXMLElement;
use Tour\XmlEntities\Departure;

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
        $str = (string) $this->tourXmlObj->Title;
        return $this->cleanUpHtmlToOneLinePlainText($str);
    }

    public function getDuration()
    {
        return intval((string) $this->tourXmlObj->Duration);
    }

    public function getInclusions()
    {
        $str = (string) $this->tourXmlObj->Inclusions;
        return $this->cleanUpHtmlToOneLinePlainText($str);
    }

    /**
     * Get a list of departures
     *
     * @return array An array of Departure(s)
     */
    public function getDepartures()
    {
        if (count($this->tourXmlObj->DEP) == 0) {
            throw new \Exception('No available departures to calculate minimal price!');
        }

        $departures = [];
        foreach ($this->tourXmlObj->DEP as $oneDeparture) {
            $departures[] = new Departure($oneDeparture);
        }
        return $departures;
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
}
