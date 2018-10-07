<?php
class OAuthLogger
{
	public static function writeToFile($msg)
	{
        set_include_path(ZCRMConfigUtil::getConfigValue(APIConstants::APPLICATION_LOGFILE_PATH));
        $path=get_include_path();
        if($path{strlen($path)-1}!='\/')
        {
            $path=$path."/";
        }
        $path=str_replace("\n", "", $path);
        $filePointer=fopen($path."OAuth.log","a");
        if(!$filePointer)
        {
            return;
        }
        fwrite($filePointer,sprintf("%s %s\n",date("Y-m-d H:i:s"),$msg));
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
?>