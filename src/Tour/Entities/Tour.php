<?php

namespace Tour\Entities;

class Tour
{
    private $code;
    private $title;
    private $duration;
    private $inclusions;
    private $departures;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setInclusions($inclusions)
    {
        $this->inclusions = $inclusions;
    }

    public function getInclusions()
    {
        return $this->inclusions;
    }

    public function getDepartures()
    {
        return $this->departures;
    }

    public function setDepartures(Departures $departures)
    {
        $this->departures = $departures;
    }

    /**
     * Get minimal price for tour from all departures
     *
     * @return \Money\Money  Money representing amount and courrency
     */
    public function getMinPrice()
    {
        $departures = $this->getDepartures();
        if ($departures->count() == 0) {
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
}
