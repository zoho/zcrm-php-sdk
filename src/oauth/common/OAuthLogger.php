<?php

namespace ZCRM\oauth\common;


class OAuthLogger {

    public static function writeToFile($msg) {

      if(isset($_ENV['ZOHO_OATH_LOG_PATH'])){
        //$filePointer = fopen(dirname(__FILE__) . "/../logger/OAuth.log", "a");
        $h = fopen($_ENV['ZOHO_OATH_LOG_PATH'], "a");
        fwrite($h, sprintf("%s %s\n", date("Y-m-d H:i:s"), $msg));
        fclose($h);
      }
    }

    public static function warn($msg) {
        self::writeToFile("WARNING: $msg");
    }

    public static function info($msg) {
        self::writeToFile("INFO: $msg");
    }

    public static function severe($msg) {
        self::writeToFile("SEVERE: $msg");
    }

    public static function err($msg) {
        self::writeToFile("ERROR: $msg");
    }

    public static function debug($msg) {
        self::writeToFile("DEBUG: $msg");
    }
}

?>