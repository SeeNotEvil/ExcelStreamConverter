<?php

namespace SeeNotEvil\ExcelConverter ;

class ConverterFactory {

    const TYPE_XLSX = "xlsx" ;

    /**
     * @var array
     */
    private static $typeClasses = [
        self::TYPE_XLSX => "SeeNotEvil\ExcelConverter\Xlsx"
    ];

    /**
     * @param $extension
     * @param array $config
     * @return mixed
     * @throws ConvertException
     */
    public function create($extension, $config = []) {
        if(!isset(self::$typeClasses[$extension])) {
            throw new ConvertException("Undefined extension {$extension}") ;
        }

        $class = self::$typeClasses[$extension]."\Converter";
        if(!class_exists($class)) {
            throw new ConvertException("Not isset class {$class}") ;
        }

        return new $class($config) ;
    }

}