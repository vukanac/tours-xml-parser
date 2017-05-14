<?php

require_once 'vendor/autoload.php';

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Wukanac\MoneyFormatter;
use Tour\XmlParser;

// Warning: If your CSV document was created or is read on a Macintosh computer,
// add the following lines before using the library to help PHP detect line ending.
if (!ini_get("auto_detect_line_endings")) {
    ini_set("auto_detect_line_endings", '1');
}

// read, write, seek
echo 'Memory use      : ' . ini_get('memory_limit') . PHP_EOL;


$adapter = new Local(__DIR__);
$filesystem = new Filesystem($adapter);

$fileXmlSource = 'data/tours-big.xml';
$fileCsvResult = 'data/tours-big.csv';


$xmlStart = <<<EOD
<?xml version="1.0"?>
<TOURS>
EOD;
$xmlTour = <<<EOD
    <TOUR>
        <Title><![CDATA[Anzac &amp; Egypt Combo Tour]]></Title>
        <Code>AE-19</Code>
        <Duration>18</Duration>
        <Start>Istanbul</Start>
        <End>Cairo</End>
        <Inclusions>
            <![CDATA[<div style="margin: 1px 0px; padding: 1px 0px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; text-align: justify; line-height: 19px; color: rgb(6, 119, 179);">The tour price&nbsp; cover the following services: <b style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Accommodation</b>; 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;</div>]]>
        </Inclusions>
        <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>
EOD;
$xmlEnd = <<<EOD
</TOURS>
EOD;


// Generate N tours in XML
$xmlBody = '';
for ($i = 0; $i < 20000; $i++) {
    $xmlBody .= $xmlTour . PHP_EOL;
}
$inputXmlStr = $xmlStart . $xmlBody. $xmlEnd;

// save to file
//$filesystem->put($fileXmlSource, $inputXmlStr);
// load from file
//$inputXmlStr = $filesystem->read($fileXmlSource);

// echo $inputXmlStr;

$xmlParser = new XmlParser();

// Print results to console:
// $outputText = $xmlParser->xmlToCSV($inputXmlStr);
// echo $outputText
// save to file
// $filesystem->put($fileCsvResult, $outputText);

// or
// Save directly to file
$filesystem->put($fileCsvResult, $xmlParser->xmlToCSV($inputXmlStr));

echo "File `{$fileXmlSource}` is converted to `{$fileCsvResult}`." . PHP_EOL;
echo 'Number of tours parsed: ' . $xmlParser->getTours()->count() . PHP_EOL;

echo 'Memory use      : ' . round(memory_get_usage()/1048576, 2) . 'M' . PHP_EOL;
echo 'Peak Memory use : ' . round(memory_get_peak_usage()/1048576, 2) . 'M' . PHP_EOL;
echo 'N: ' . $i . PHP_EOL;