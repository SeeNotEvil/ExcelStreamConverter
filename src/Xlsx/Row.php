<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;


class Row {

    private $cells = [] ;

    /**
     * Row constructor.
     * @param $cells|
     */
    public function __construct($cells = [])
    {
        $this->cells = $cells ;
    }

    /**
     * @param $cells
     */
    public function setCells($cells)
    {
        $this->cells = $cells ;
    }

    /**
     * @return array
     */
    public function getCells()
    {
        return $this->cells ;
    }

}