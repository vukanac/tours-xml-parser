<?php

namespace Tour\Entities;

class Tour
{
    private $code;
    private $title;
    private $duration;
    private $inclusions;
    private $departures;


    /**
     * Set Code
     * @param string $code Tour Code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get Tour Code
     * @return string Tour Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Tour Title
     * @param string $title Tour Title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get Tour Title
     *
     * @return string Tour Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Tour Duration
     *
     * @param string $duration Tour Douration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get Tour Duration
     *
     * @return string Tour Duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set Tour Inclusions
     *
     * @param string $inclusions Tour Inclusions
     */
    public function setInclusions($inclusions)
    {
        $this->inclusions = $inclusions;
    }

    /**
     * Get Tour Inclusions
     *
     * @param string Tour Inclusions
     */
    public function getInclusions()
    {
        return $this->inclusions;
    }

    /**
     * Get Tour Departures
     *
     * @param string $inclusions Tour Inclusions
     */
    public function getDepartures()
    {
        return $this->departures;
    }

    /**
     * Set Tour Departures
     *
     * @param string Tour Departures
     */
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
