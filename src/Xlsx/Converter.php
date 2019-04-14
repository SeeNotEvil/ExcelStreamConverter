<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;

use SeeNotEvil\ExcelConverter\ConverterArrayStream;

class Converter extends ConverterArrayStream {

    const ERROR_UNZIP_ARCHIVE = "Error unzip archive" ;

    private $fileXlsx ;
    private $tmpDirectory = __DIR__."/tmp" ;

    public function setFilePath($filePath)
    {
        $this->fileXlsx = new File($filePath, $this->tmpDirectory) ;
        return $this ;
    }

    /**
     * @param $chunkSize
     * @param $callback
     * @throws Exception
     */
    public function convert($chunkSize, $callback)
    {
        $sheetList = $this->fileXlsx->getSheetList() ;
        $shared = $this->fileXlsx->getShared() ;

        $resultList = [] ;
        foreach ($sheetList as $sheet) {
            /** @var Sheet $sheet */
            while ($row = $sheet->getNextRow()) {
                /** @var Row $row */
                $cells = $row->getCells() ;
                $resultRow = [] ;
                foreach ($cells as $cell) {
                    /** @var Cell $cell */
                    if($cell->isNum()) {
                        $resultRow[] = $cell->getValue() ;
                        continue ;
                    }
                    if($cell->isString()) {
                        $resultRow[] = $shared->getCellValue($cell->getValue()) ;
                    }

                }
                $resultList[] = $resultRow ;
                if(count($resultList) === $chunkSize) {
                    call_user_func($callback, $resultList) ;
                    $resultList = [] ;
                }
            }
        }

    }


}