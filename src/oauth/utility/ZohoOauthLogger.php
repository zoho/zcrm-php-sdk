<?php
namespace zcrmsdk\oauth\utility;

class ZohoOAuthLogger implements ZohoOAuthLoggerInterface
{

    public function writeToFile($msg)
    {
        $filePointer = fopen(dirname(__FILE__) . "/OAuth.log", "a");
        fwrite($filePointer, sprintf("%s %s\n", date("Y-m-d H:i:s"), $msg));
        fclose($filePointer);
    }

    public function warn($msg)
    {
        self::writeToFile("WARNING: $msg");
    }

    public function info($msg)
    {
        self::writeToFile("INFO: $msg");
    }

    public function severe($msg)
    {
        self::writeToFile("SEVERE: $msg");
    }

    public function err($msg)
    {
        self::writeToFile("ERROR: $msg");
    }

    public function debug($msg)
    {
        self::writeToFile("DEBUG: $msg");
    }
}
