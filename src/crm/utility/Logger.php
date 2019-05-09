<?php
namespace zcrmsdk\crm\utility;

class Logger
{
    
    public static function writeToFile($msg)
    {
        set_include_path(ZCRMConfigUtil::getConfigValue('applicationLogFilePath'));
        $path = get_include_path();
        if (!ZCRMConfigUtil::getConfigValue('applicationLogFilePath')) {
            $path=dirname(__FILE__) ."/../../..";
        }
        $filePointer = fopen($path . "/ZCRMClientLibrary.log", "a");
        if (! $filePointer) {
            return;
        }
        fwrite($filePointer, sprintf("%s %s\n", date("Y-m-d H:i:s"), $msg));
        fclose($filePointer);
    }
    
    public static function warn($msg)
    {
        self::writeToFile("WARNING: $msg");
    }
    
    public static function info($msg)
    {
        self::writeToFile("INFO: $msg");
    }
    
    public static function severe($msg)
    {
        self::writeToFile("SEVERE: $msg");
    }
    
    public static function err($msg)
    {
        self::writeToFile("ERROR: $msg");
    }
    
    public static function debug($msg)
    {
        self::writeToFile("DEBUG: $msg");
    }
}