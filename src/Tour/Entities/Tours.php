<?php

namespace Tour\Entities;

// use Countable;
// use ArrayAccess;
use ArrayObject;
use Tour\Entities\Tour;

class Tours extends ArrayObject
//implements Countable, ArrayAccess
{
    // private $tours = [];

    // public function count()
    // {
    //     return count($this->tours);
    // }

    public function add(Tour $tour)
    {
        $this->append($tour);
    }
}
