<?php
require_once realpath(dirname(__FILE__)."/../common/ZohoOAuthUtil.php");
require_once realpath(dirname(__FILE__)."/../common/ZohoOAuthConstants.php");
require_once realpath(dirname(__FILE__)."/../common/ZohoOAuthParams.php");
require_once realpath(dirname(__FILE__)."/../clientapp/ZohoOAuthPersistenceHandler.php");
require_once realpath(dirname(__FILE__)."/../clientapp/ZohoOAuthPersistenceByFile.php");
require_once realpath(dirname(__FILE__)."/../common/OAuthLogger.php");
require_once 'ZohoOAuthClient.php';

class ZohoOAuth
{

	private static $configProperties =array();
	
	public static function initializeWithOutInputStream($configuration)
	{
	    self::initialize(false,$configuration);
	}
	
	public static function initialize($configFilePointer,$configuration)
	{
	    try
	    {
	        if($configuration == null)
	        {
	            $configPath=realpath(dirname(__FILE__)."/../../../../resources/oauth_configuration.properties");
	            $filePointer=fopen($configPath,"r");
	            self::$configProperties = ZohoOAuthUtil::getFileContentAsMap($filePointer);
	            if($configFilePointer!=false)
	            {
	                $properties=ZohoOAuthUtil::getFileContentAsMap($configFilePointer);
	                foreach($properties as $key=>$value)
	                {
	                    self::$configProperties[$key]=$value;
	                }
	            }
	        }
			else
			{
				self::setConfigValues($configuration);
			}
				if(!array_key_exists(ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH,self::$configProperties) || self::$configProperties[ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH] == "")
				{
					if(!array_key_exists(ZohoOAuthConstants::DATABASE_PORT,self::$configProperties))
					{
						self::$configProperties[ZohoOAuthConstants::DATABASE_PORT] = "3306";
					}
					if(!array_key_exists(ZohoOAuthConstants::DATABASE_USERNAME,self::$configProperties))
					{
						self::$configProperties[ZohoOAuthConstants::DATABASE_USERNAME] = "root";
					}
					if(!array_key_exists(ZohoOAuthConstants::DATABASE_PASSWORD,self::$configProperties))
					{
						self::$configProperties[ZohoOAuthConstants::DATABASE_PASSWORD] = "";
					}
				}
	            $oAuthParams=new ZohoOAuthParams();
	            
	            $oAuthParams->setAccessType(self::getConfigValue(ZohoOAuthConstants::ACCESS_TYPE));
	            $oAuthParams->setClientId(self::getConfigValue(ZohoOAuthConstants::CLIENT_ID));
	            $oAuthParams->setClientSecret(self::getConfigValue(ZohoOAuthConstants::CLIENT_SECRET));
	            $oAuthParams->setRedirectURL(self::getConfigValue(ZohoOAuthConstants::REDIRECT_URL));
	            ZohoOAuthClient::getInstance($oAuthParams);
	    }
	    catch (IOException $ioe)
	    {
	        OAuthLogger::warn("Exception while initializing Zoho OAuth Client.. ". ioe);
	        throw ioe;
	    }
	}
	
	private static function setConfigValues($configuration)
	{
	    $config_keys = array(ZohoOAuthConstants::CLIENT_ID,ZohoOAuthConstants::CLIENT_SECRET,ZohoOAuthConstants::REDIRECT_URL,ZohoOAuthConstants::ACCESS_TYPE
			,ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS,ZohoOAuthConstants::IAM_URL,ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH,ZohoOAuthConstants::DATABASE_PORT
			,ZohoOAuthConstants::DATABASE_PASSWORD,ZohoOAuthConstants::DATABASE_USERNAME);
	    
	    if(!array_key_exists(ZohoOAuthConstants::ACCESS_TYPE,$configuration) || $configuration[ZohoOAuthConstants::ACCESS_TYPE] == "")
	    {
	        self::$configProperties[ZohoOAuthConstants::ACCESS_TYPE] = "offline";
	    }
	    if(!array_key_exists(ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS,$configuration) || $configuration[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS] == "")
	    {
	        self::$configProperties[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS] ="ZohoOAuthPersistenceHandler";
	    }
	    if(!array_key_exists(ZohoOAuthConstants::IAM_URL,$configuration) || $configuration[ZohoOAuthConstants::IAM_URL] == "")
	    {
	        self::$configProperties[ZohoOAuthConstants::IAM_URL] = "https://accounts.zoho.com";
	    }
	    
	    foreach($config_keys as $key)
	    {
	        if(array_key_exists($key,$configuration))
	            self::$configProperties[$key] = $configuration[$key];
	    }
	}
	public static function getConfigValue($key)
	{
		return self::$configProperties[$key];
	}
	
	public static function getAllConfigs()
	{
		return self::$configProperties;
	}
	
	public static function getIAMUrl()
	{
		return self::getConfigValue(ZohoOAuthConstants::IAM_URL);
	}
	
	public static function getGrantURL()
	{
		return self::getIAMUrl()."/oauth/v2/auth";
	}
	
	public static function getTokenURL()
	{
		return self::getIAMUrl()."/oauth/v2/token";
	}
	
	public static function getRefreshTokenURL()
	{
		return self::getIAMUrl()."/oauth/v2/token";
	}
	
	public static function getRevokeTokenURL()
	{
		return self::getIAMUrl()."/oauth/v2/token/revoke";
	}
	
	public static function getUserInfoURL()
	{
		return self::getIAMUrl()."/oauth/user/info";
	}
	
	public static function getClientID()
	{
		return self::getConfigValue(ZohoOAuthConstants::CLIENT_ID);
	}
	
	public static function getClientSecret()
	{
		return self::getConfigValue(ZohoOAuthConstants::CLIENT_SECRET);
	}
	
	public static function getRedirectURL()
	{
		return self::getConfigValue(ZohoOAuthConstants::REDIRECT_URL);
	}
	
	public static function getAccessType()
	{
		return self::getConfigValue(ZohoOAuthConstants::ACCESS_TYPE);
	}
	
	public static function getPersistenceHandlerInstance()
	{
		try
		{
			return ZohoOAuth::getConfigValue("token_persistence_path")!=""?new ZohoOAuthPersistenceByFile():new ZohoOAuthPersistenceHandler();
		}
		catch (Exception $ex)
		{
			throw new ZohoOAuthException($ex);
		}
	}
	
	public static function getClientInstance()
	{
		if(ZohoOAuthClient::getInstanceWithOutParam() == null)
		{
			throw new ZohoOAuthException("ZohoOAuth.initializeWithOutInputStream() must be called before this.");
		}
		return ZohoOAuthClient::getInstanceWithOutParam();
	}
	
}
?>