<?php

namespace spec\Wukanac;

use Wukanac\TableFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TableFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TableFormatter::class);
    }

    function it_has_method_tableToCsv()
    {
        $matrix = [];
        $row1 = [
            'col1' => 'val11',
            'col2' => 'val12'
        ];
        $row2 = [
            'col1' => 'val21',
            'col2' => 'val22'
        ];
        $matrix[] = $row1;
        $matrix[] = $row2;
        $this->tableToCsv($matrix)->shouldBe('col1|col2'."\n".'val11|val12'."\n".'val21|val22'."\n");
    }
}
