<?php
require_once 'CommonUtil.php';
require_once realpath(dirname(__FILE__)."/../../../oauth/client/ZohoOAuth.php");

class ZCRMConfigUtil
{
	private static $configProperties=array();
	
	public static function getInstance()
	{
		return new ZCRMConfigUtil();
	}
	public static function initialize($configPath, $initializeOAuth = true)
    {
        $configFile = realpath(rtrim($configPath, '/\\') . DIRECTORY_SEPARATOR . 'configuration.properties');
        $filePointer = fopen($configFile, "r");

        if (!$filePointer) {
            return;
        }

        self::$configProperties = CommonUtil::getFileContentAsMap($filePointer);

        if ($initializeOAuth) {
            ZohoOAuth::initializeWithOutInputStream($configPath);
        }
    }
	
	public static function loadConfigProperties($fileHandler)
	{
		$configMap=CommonUtil::getFileContentAsMap($fileHandler);
		foreach($configMap as $key=>$value)
		{
			self::$configProperties[$key]=$value;
		}
	}
	
	public static function getConfigValue($key)
	{
		return isset(self::$configProperties[$key])?self::$configProperties[$key]:'';
	}
	
	public static function setConfigValue($key,$value)
	{
		self::$configProperties[$key]=$value;
	}
	
	public static function getAPIBaseUrl()
	{
		return self::getConfigValue("apiBaseUrl");
	}
	
	public static function getAPIVersion()
	{
		return self::getConfigValue("apiVersion");
	}
	public static function getAccessToken()
	{
		$currentUserEmail= ZCRMRestClient::getCurrentUserEmailID();
		
		if ($currentUserEmail == null && self::getConfigValue("currentUserEmail") == null)
		{
			throw new ZCRMException("Current user should either be set in ZCRMRestClient or in configuration.properties file");
		}
		else if ($currentUserEmail == null)
		{
			$currentUserEmail = self::getConfigValue("currentUserEmail");
		}
		$oAuthCliIns = ZohoOAuth::getClientInstance();
		return $oAuthCliIns->getAccessToken($currentUserEmail);
	}
	
	public static function getAllConfigs()
	{
		return self::$configProperties;
	}
}
?>