<?php

namespace SeeNotEvil\ExcelConverter;

abstract class File {

    protected $filePath = "";
    protected $fileResource = null;

    /**
     * File constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath ;
    }

    /**
     * @param string $descriptor
     */
    public function open($descriptor = "r")
    {
        $this->fileResource = fopen($this->filePath, $descriptor) ;
    }

    /**
     *
     */
    public function close()
    {
        if(is_resource($this->fileResource)) {
            fclose($this->fileResource) ;
        }
        $this->fileResource = null ;
    }

    public function rmdir($src) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $src . '/' . $file;
                if ( is_dir($full) ) {
                    $this->rmdir($full);
                }
                else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->close() ;
    }


}