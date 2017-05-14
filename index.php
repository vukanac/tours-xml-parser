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

// Preapre for read and write to file
// - posible to use external services: AWS, Google, FTP, ...
$adapter = new Local(__DIR__);
$filesystem = new Filesystem($adapter);

$fileXmlSource = 'data/tours.xml';
$fileCsvResult = 'data/tours.csv';

// load from file
$inputXmlStr = $filesystem->read($fileXmlSource);

$xmlParser = new XmlParser();
$outputText = $xmlParser->xmlToCSV($inputXmlStr);

// save to file
$filesystem->put($fileCsvResult, $outputText);

echo "File `{$fileXmlSource}` is converted to `{$fileCsvResult}`." . PHP_EOL;
echo 'Number of tours parsed: ' . $xmlParser->getTours()->count() . PHP_EOL;

echo 'Memory use      : ' . round(memory_get_usage()/1048576, 2) . 'M' . PHP_EOL;
echo 'Peak Memory use : ' . round(memory_get_peak_usage()/1048576, 2) . 'M' . PHP_EOL;
