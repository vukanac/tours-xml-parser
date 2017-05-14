<?php

namespace Wukanac;

class TableFormatter
{
    private $delimiter;
    private $enclosure;
    private $escapeChar;

    public function __construct($delimiter = ",", $enclosure = '', $escapeChar = '')
    {
        // @TODO: Add Exporter Strategy: CSV, CSV Excell, Pipe
        // - CSV (native, quoted),
        // - CSV (native, quoted, semi-colon separated ';'),
        // - CSV for Excell (with BOM for UTF-8),
        // - Pipe without quotes

        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escapeChar = $escapeChar;
    }

    /**
     * Convert 2D associative array into CSV string
     *
     * @param  array  $table Matrix
     * @return string        Data content formated as CSV
     */
    public function tableToCsv(array $table)
    {
        if (count($table) == 0) {
            return null;
        }
        $handler = fopen('php://memory', 'w');

        // $this->addBom($handler);
        $this->addHeader($handler, $table);
        foreach ($table as $row) {
            $this->addRow($handler, $row);
        }
        rewind($handler);
        $csvContent = stream_get_contents($handler);
        fclose($handler);

        return $csvContent;
    }

    /**
     * Add BOM
     *
     * If you want make UTF-8 file for excel, use this:
     * Add BOM to fix UTF-8 in Excel
     * $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF));
     *
     * @param resource &$handler Reference to external resource (memory or file handler)
     */
    private function addBom(&$handler)
    {
        fputs($handler, (chr(0xEF) . chr(0xBB) . chr(0xBF)));
    }

    private function addHeader($handler, array $table)
    {
        // header
        $this->addRow($handler, array_keys(reset($table)));
    }

    private function addRow($handler, array $row)
    {
        // Strategy 1: fputcsv - Double quote enclosed strings with spaces, good for CSV
        // -----------------------------------------------------------------------------
        // // Title|Code|Duration|Inclusions|MinPrice
        // // "Anzac & Egypt Combo Tour"|AE-19|18|"The ... star hotels"|1427.20
        // fputcsv($handler, $row, '|');

        // Strategy 2: putRowWithoutQuotes - Row without quotes
        // -----------------------------------------------------------------------------
        // Title|Code|Duration|Inclusions|MinPrice
        // Anzac & Egypt Combo Tour|AE-19|18|The ... star hotels|1427.20
        $this->putRowWithoutQuotes($handler, $row, '|');
    }

    /**
     * Add delimited Row and without Quotes
     *
     * @param  resource $handle    Resource pointer
     * @param  array    $fields    Values in one array as Row
     * @param  string   $delimiter One char as separator of fields
     */
    private function putRowWithoutQuotes($handle, array $fields, $delimiter = ",") //, $enclosure = '"', $escapeChar = "\\")
    {
        $lineContent = implode($delimiter, $fields);
        fputs($handle, $lineContent . "\n");
    }
}
