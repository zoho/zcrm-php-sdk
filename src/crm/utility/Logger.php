<?php
namespace zcrmsdk\crm\utility;

class Logger
{
    
    public static function writeToFile($msg)
    {
        $path = trim(ZCRMConfigUtil::getConfigValue(APIConstants::APPLICATION_LOGFILE_PATH));
        if (!ZCRMConfigUtil::getConfigValue(APIConstants::APPLICATION_LOGFILE_PATH)) {
            $dir_path = __DIR__;
            if(strpos($dir_path, "vendor")!==false){
                $path = substr($dir_path,0, strpos($dir_path, "vendor")-1);
            }
            else{
                $path = substr($dir_path,0, strpos($dir_path, "src")-1);
            }
        }
        $filePointer = fopen($path . APIConstants::APPLICATION_LOGFILE_NAME, "a");
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