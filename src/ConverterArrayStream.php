<?php

namespace SeeNotEvil\ExcelConverter;

abstract class ConverterArrayStream {

    protected $config = [] ;

    public function __construct($config = [])
    {
        $this->config = $config ;
    }

    abstract public function setFilePath($filePath) ;
    abstract public function convert($chunkSize, $callback) ;


}