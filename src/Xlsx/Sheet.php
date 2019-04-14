<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;


use SeeNotEvil\ExcelConverter\File;

class Sheet extends File {

    const TAG_ROW = "row" ;

    private $reader ;

    /**
     * Sheet constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        parent::__construct($filePath);
        $this->reader = new \XMLReader ;
        $this->reader->open($filePath) ;
    }

    /**
     * @return Row|null
     */
    public function getNextRow() {

        while ($this->reader->read()) {
            if($this->reader->name == self::TAG_ROW && $this->reader->nodeType == \XMLReader::ELEMENT) {
                $xmlRow = simplexml_load_string($this->reader->readOuterXML());

                $cells = [] ;
                foreach ($xmlRow->c as $xmlCell) {
                    if (isset($xmlCell['t']) && $xmlCell['t'] == 's') {
                        $cell = new Cell(Cell::TYPE_STRING) ;
                    } else {
                        $cell = new Cell(Cell::TYPE_NUM) ;
                    }
                    $cell->setValue($xmlCell->v->__toString()) ;
                    $cells[] = $cell ;
                }
                return new Row($cells) ;
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