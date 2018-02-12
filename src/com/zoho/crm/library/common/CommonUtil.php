<?php
require_once realpath(dirname(__FILE__)."/../exception/Logger.php");
class CommonUtil
{
	public static function getFileContentAsMap($fileHandler)
	{
		$reponseMap=array();
		try{
			while(!feof($fileHandler))
			{
				$line=fgets($fileHandler);
				$lineAfterSplit=explode("=",$line);
				if(strpos($lineAfterSplit[0],"#")===false)
				{
					$reponseMap[$lineAfterSplit[0]]=$lineAfterSplit[1];
				}
			}
			fclose($fileHandler);
		}
		catch (Exception $ex)
		{
			Logger::warn("Exception occured while converting file content as map (file::ZohoOAuthUtil.php)");
		}
		return $reponseMap;
	}
	
	public static function getEmptyJSONObject()
	{
		return new ArrayObject();
	}
}
?>