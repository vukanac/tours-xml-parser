<?php

namespace Tour\Entities;

use ArrayObject;
use Tour\Entities\Departure;

class Departures extends ArrayObject
{
    public function add(Departure $departure)
    {
        $this->append($departure);
    }
}
