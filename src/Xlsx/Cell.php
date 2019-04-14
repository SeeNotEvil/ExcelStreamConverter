<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;

class Cell {

    const TYPE_STRING = "string" ;
    const TYPE_NUM = "num" ;

    private $type ;
    private $value ;

    public function __construct($type, $value = "")
    {
        $this->type = $type ;
        $this->value = $value ;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isString()
    {
        return $this->type === self::TYPE_STRING ;
    }

    /**
     * @return bool
     */
    public function isNum()
    {
        return $this->type === self::TYPE_NUM ;
    }

}