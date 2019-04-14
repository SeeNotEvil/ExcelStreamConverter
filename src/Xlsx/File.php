<?php

namespace SeeNotEvil\ExcelConverter\Xlsx ;

class File extends \SeeNotEvil\ExcelConverter\File {

    private $tmpDirectory ;

    const PATH_SHEETS_DIR = "/xl/worksheets/" ;
    const PATH_SHARED_DIR = "/xl" ;

    const PATTERN_SHEET_FILE = "^sheet\d+\.xml" ;

    protected $isUnziped = false ;

    /**
     * XlsxFile constructor.
     * @param $filePath
     * @param $tmpDirectory
     */
    public function __construct($filePath, $tmpDirectory)
    {
        parent::__construct($filePath);
        $this->tmpDirectory = $tmpDirectory ;
    }

    /**
     * @throws Exception
     */
    protected function unZipArchive()
    {
        if(!$this->isUnziped) {
            $zipArchive = new \ZipArchive() ;
            if ($zipArchive->open($this->filePath) !== TRUE) {
                Exception::triggerErrorUnzip() ;
            }
            $zipArchive->extractTo($this->tmpDirectory) ;
            $zipArchive->close() ;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getSheetList() {
        $this->unZipArchive() ;

        $sheetsList = [] ;
        $dir = $this->tmpDirectory.self::PATH_SHEETS_DIR ;
        $dh = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
            if(preg_match("/".self::PATTERN_SHEET_FILE."/ui", $filename)) {
                $sheetsList[] = new Sheet($dir.$filename) ;
            }
        }
        return $sheetsList ;
    }

    /**
     * @return Shared
     * @throws Exception
     */
    public function getShared() {
        $this->unZipArchive();
        $path  =$this->tmpDirectory.self::PATH_SHARED_DIR. "/sharedStrings.xml" ;
        return new Shared($path) ;
    }

    public function __destruct()
    {
        parent::__destruct();
        if(is_dir($this->tmpDirectory)) {
            $this->rmdir($this->tmpDirectory) ;
        }
    }


}
