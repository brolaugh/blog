<?php

class FTP
{

    public static $externalHostName = "";
    private static $host = "127.0.0.1";
    private static $username = "";
    private static $password = "";
    private $conn_id;
    public function __construct()
    {
        $this->conn_id = ftp_connect(self::$host);
        $login_result = ftp_login($this->conn_id, self::$username, self::$password);

    }
    public function uploadImage($image){
        $imageType = exif_imagetype($image);
        $imageName = $this->generateFileName();
        if($imageType == 1){
            $imageName.=".gif";
        }elseif ($imageType == 2){
            $imageName.=".jpeg";
        } elseif ($imageType == 3){
            $imageName.=".png";
        }else{
            return false;
        }
        ftp_chdir($this->conn_id, "images");

        if(ftp_fput($this->conn_id, $imageName, $image, FTP_BINARY)){
            return self::$externalHostName . "images/" . $imageName;
        }else{
            return false;
        }
    }
    private function generateFileName(){

        $CHARS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
        $output = "";
        for($i = 0; $i < 5; $i++){
            $output.=$CHARS[mt_rand(0, strlen($CHARS))];
        }

        return $output;
    }

}