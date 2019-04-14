<?php


require __DIR__.'/vendor/autoload.php' ;

$path = "" ;

$factory = new \SeeNotEvil\ExcelConverter\ConverterFactory();
$converter = $factory->create(\SeeNotEvil\ExcelConverter\ConverterFactory::TYPE_XLSX) ;
$converter->setFilePath($path) ;

try {
    $converter->convert(20, function ($data) {

    }) ;
} catch (\Exception $e) {
    echo $e->getMessage() ;
}
