<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;

use SeeNotEvil\ExcelConverter\ConvertException;

class Exception extends ConvertException {

    const ERROR_UNZIP_ARCHIVE = "Error unzip archive" ;

    /**
     * @throws Exception
     */
    public static function triggerErrorUnzip() {
        throw new self(self::ERROR_UNZIP_ARCHIVE) ;
    }

}