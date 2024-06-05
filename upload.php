<?php

class Upload {
    public $file = null ; 
    const MAX_FS = 1024 * 1024 ; // 1MB

    // $fb: filebox name   $folder: application upload folder
    public function __construct($fb, $folder)
    {
        if ( !empty($_FILES[$fb]["tmp_name"])) {
           extract($_FILES[$fb]) ; // $name, $tmp_name, $size, $error ...
           $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION)) ;
           $imgExt = ["png", "jpg", "jpeg"] ; // white list
           if ( !in_array($ext, $imgExt)) {
            throw new Exception("Not an image file") ; 
           } else if ( $size > self::MAX_FS ) {
             throw new Exception("Too big image file") ;
           } else {
              $this->file = sha1($tmp_name . $name . $size . uniqid()) . ".$ext";
              move_uploaded_file($tmp_name, $folder . "/" . $this->file) ;
           }
        } else {
            throw new Exception("No file or invalid file selected") ;
        }
    }
}