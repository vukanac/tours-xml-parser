<?php

namespace Tour;

use Tour\XmlEntities\Departure as DepartureXml;
use Tour\XmlEntities\Tour as TourXml;
// use Toure\Entities\Departure;
use Tour\Entities\Tours;
use Tour\Entities\Tour;
use SimpleXMLElement;
use Money\Money;

class XmlParser
{
    private $tours;
    private $toursXmlObj;

    public function __construct()
    {
        $this->tours = new Tours();
    }

    /**
     * Convert xml to str
     *
     * @param  string $xmlStr Xml string
     * @return string         CSV string - Pipe (|) separated
     */
    public function xmlToCSV($xmlStr)
    {
        $this->loadXmlString($xmlStr);

        
        //return $outputText;
    }

    public function loadXmlString($xmlStr)
    {
        $toursXmlObj = new SimpleXMLElement($xmlStr);
        $this->tours = $this->parseXmlObjToTouresObjectTree($this->tours, $toursXmlObj);
        unset($this->toursXmlObj);
    }

    private function parseXmlObjToTouresObjectTree(Tours $tours, SimpleXMLElement $toursXmlObj)
    {
        foreach ($toursXmlObj as $tourXmlObj) {
            $tour = $this->parseTourXmlToEntity($tourXmlObj);
            $tours->add($tour);
        }
        return $tours;
    }
    public function parseTourXmlToEntity($tourXmlObj)
    {
        $tour = new Tour();
        $tourParser = new TourXml($tourXmlObj);
        $tour->setCode($tourParser->getCode());
        $tour->setDuration($tourParser->getDuration());
        $tour->setTitle($tourParser->getTitle());
        $tour->setInclusions($tourParser->getInclusions());

        // $departuresXml = $tourParser->getDepartures();
        // foreach ($departuresXml as $departureXml) {
            
        // }

        return $tour;
    }

    /**
     * Get minimal price for tour from all departures
     *
     * @return \Money\Money  Money representing amount and courrency
     */
    public function getMinPrice()
    {
        $departures = $this->getDepartures();
        if (count($departures) == 0) {
            throw new \Exception('No available departures to calculate minimal price!');
        }

        $minPrice = current($departures)->getFinalPrice();
        foreach ($departures as $one) {
            if ($minPrice->greaterThan($one->getFinalPrice())) {
                $minPrice = $one->getFinalPrice();
            }
        }
        return $minPrice;
    }

    public function getTours()
    {
        return $this->tours;
    }
}
