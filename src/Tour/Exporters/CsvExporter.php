<?php

namespace Tour\Exporters;

use Wukanac\MoneyFormatter;
use Wukanac\TableFormatter;
use Tour\Entities\Tours;

class CsvExporter
{
    /**
     * @var Tours
     */
    private $tours;

    /**
     * @param Tours $tours
     */
    public function __construct(Tours $tours)
    {
        if ($tours->count() == 0) {
            throw new \Exception('Tours does not have any Tour data');
        }
        $this->tours = $tours;
    }

    /**
     * Get Formatted CSV Content of Tours
     *
     * @return string Pipe formatted CSV
     */
    public function getCsvContent()
    {
        $moneyFormatter = new MoneyFormatter();
        $tableFormatter = new TableFormatter('|');

        foreach ($this->tours as $tour) {
            $row = [
                'Title' => $tour->getTitle(),
                'Code' => $tour->getCode(),
                'Duration' => $tour->getDuration(),
                'Inclusions' => $tour->getInclusions(),
                'MinPrice' => $moneyFormatter->decimalMoneyFormat($tour->getMinPrice()),
            ];
            $table[] = $row;
        }

        return $tableFormatter->tableToCsv($table);
    }
}
