<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;

use SeeNotEvil\ExcelConverter\File;

class Shared extends File {

    const MAX_BUFFER_SIZE = 5242880; //5мб
    const TAG_SI = "si" ;

    protected $buffer = [] ;
    protected $bufferSize = 0 ;
    protected $reader = null ;
    protected $currentLine = -1;

    /**
     * Shared constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        parent::__construct($filePath);
        $this->reader = new \XMLReader ;
        $this->reader->open($filePath) ;
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setKeyBuffer($key, $value)
    {
        $size = strlen($key) + strlen($value) ;
        $this->bufferSize = $size + $this->bufferSize ;
        if($this->bufferSize > self::MAX_BUFFER_SIZE) {
            $this->bufferSize = $size ;
            $this->clearBuffer() ;
        }
        $this->buffer[$key] = $value ;
    }

    /**
     * @param $key
     * @return bool|mixed
     */
    protected function getKeyBuffer($key)
    {
        return isset($this->buffer[$key]) ? $this->buffer[$key] : false ;
    }


    protected function clearBuffer()
    {
        $this->buffer = [] ;
        $this->bufferSize = 0 ;
    }


    protected function rewind()
    {
        $this->reader->close();
        $this->reader->open($this->filePath) ;
    }

    /**
     * @param $num
     * @return bool|mixed|string|null
     */
    public function getCellValue($num)
    {
        if($value = $this->getKeyBuffer($num)) {
            return $value ;
        }

        if($num < $this->currentLine) {
            $this->rewind() ;
        }

        while ($this->reader->read()) {

            if($this->reader->name == self::TAG_SI && $this->reader->nodeType == \XMLReader::ELEMENT) {
                $this->currentLine++ ;

                $xmlSi = simplexml_load_string($this->reader->readOuterXML());
                if($num == $this->currentLine) {
                    $value = $xmlSi->t->__toString() ;
                    $this->setKeyBuffer($num, $value) ;
                    return $value ;
                }
            }

        }

        return null ;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->reader->close() ;
    }
}