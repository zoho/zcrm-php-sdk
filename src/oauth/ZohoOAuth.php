<?php
namespace zcrmsdk\oauth;

use Exception;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use zcrmsdk\oauth\persistence\ZohoOAuthPersistenceByFile;
use zcrmsdk\oauth\persistence\ZohoOAuthPersistenceHandler;
use zcrmsdk\oauth\utility\ZohoOAuthConstants;
use zcrmsdk\oauth\utility\ZohoOAuthParams;

class ZohoOAuth
{
    
    private static $configProperties = array();
    
    public static function initialize($configuration)
    {
        self::setConfigValues($configuration);
        if (! array_key_exists(ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH, self::$configProperties) || self::$configProperties[ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH] == "") {
            if (! array_key_exists(ZohoOAuthConstants::DATABASE_PORT, self::$configProperties)) {
                self::$configProperties[ZohoOAuthConstants::DATABASE_PORT] = "3306";
            }
            if (! array_key_exists(ZohoOAuthConstants::DATABASE_USERNAME, self::$configProperties)) {
                self::$configProperties[ZohoOAuthConstants::DATABASE_USERNAME] = "root";
            }
            if (! array_key_exists(ZohoOAuthConstants::DATABASE_PASSWORD, self::$configProperties)) {
                self::$configProperties[ZohoOAuthConstants::DATABASE_PASSWORD] = "";
            }
            if (! array_key_exists(ZohoOAuthConstants::DATABASE_NAME, self::$configProperties)) {
                self::$configProperties[ZohoOAuthConstants::DATABASE_NAME] = "zohooauth";
            }
            if (! array_key_exists(ZohoOAuthConstants::HOST_ADDRESS, self::$configProperties)) {
                self::$configProperties[ZohoOAuthConstants::HOST_ADDRESS] = "localhost";
            }
        }
        $oAuthParams = new ZohoOAuthParams();
        $oAuthParams->setAccessType(self::getConfigValue(ZohoOAuthConstants::ACCESS_TYPE));
        $oAuthParams->setClientId(self::getConfigValue(ZohoOAuthConstants::CLIENT_ID));
        $oAuthParams->setClientSecret(self::getConfigValue(ZohoOAuthConstants::CLIENT_SECRET));
        $oAuthParams->setRedirectURL(self::getConfigValue(ZohoOAuthConstants::REDIRECT_URL));
        ZohoOAuthClient::getInstance($oAuthParams);
    }
    
    private static function setConfigValues($configuration)
    {
        $config_keys = array(
            ZohoOAuthConstants::CLIENT_ID,
            ZohoOAuthConstants::CLIENT_SECRET,
            ZohoOAuthConstants::REDIRECT_URL,
            ZohoOAuthConstants::ACCESS_TYPE,
            ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS,
            ZohoOAuthConstants::IAM_URL,
            ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH,
            ZohoOAuthConstants::DATABASE_PORT,
            ZohoOAuthConstants::DATABASE_PASSWORD,
            ZohoOAuthConstants::DATABASE_USERNAME,
            ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS_NAME,
            ZohoOAuthConstants::HOST_ADDRESS
        );
        
        if (! array_key_exists(ZohoOAuthConstants::ACCESS_TYPE, $configuration) || $configuration[ZohoOAuthConstants::ACCESS_TYPE] == "") {
            self::$configProperties[ZohoOAuthConstants::ACCESS_TYPE] = "offline";
        }
        if (! array_key_exists(ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS, $configuration) || $configuration[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS] == "") {
            self::$configProperties[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS] = "ZohoOAuthPersistenceHandler";
        }
        if (! array_key_exists(ZohoOAuthConstants::IAM_URL, $configuration) || $configuration[ZohoOAuthConstants::IAM_URL] == "") {
            self::$configProperties[ZohoOAuthConstants::IAM_URL] = "https://accounts.zoho.com";
        }
        
        foreach ($config_keys as $key) {
            if (array_key_exists($key, $configuration))
                self::$configProperties[$key] = $configuration[$key];
        }
    }
    
    public static function getConfigValue($key)
    {
        return isset(self::$configProperties[$key])?self::$configProperties[$key]:"";
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
        return self::getIAMUrl() . "/oauth/v2/auth";
    }
    
    public static function getTokenURL()
    {
        return self::getIAMUrl() . "/oauth/v2/token";
    }
    
    public static function getRefreshTokenURL()
    {
        return self::getIAMUrl() . "/oauth/v2/token";
    }
    
    public static function getRevokeTokenURL()
    {
        return self::getIAMUrl() . "/oauth/v2/token/revoke";
    }
    
    public static function getUserInfoURL()
    {
        return self::getIAMUrl() . "/oauth/user/info";
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
        try {
            if(ZohoOAuth::getConfigValue("token_persistence_path")!=""){
                return new ZohoOAuthPersistenceByFile() ;
            }
            else if(self::$configProperties[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS] == "ZohoOAuthPersistenceHandler"){
                return new ZohoOAuthPersistenceHandler();
            }
            else{
                require_once  realpath(self::$configProperties[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS]);
                $str=self::$configProperties[ZohoOAuthConstants::PERSISTENCE_HANDLER_CLASS_NAME];
                return new $str();
            }
        } catch (Exception $ex) {
            throw new ZohoOAuthException($ex);
        }
    }
    
    public static function getClientInstance()
    {
        if (ZohoOAuthClient::getInstanceWithOutParam() == null) {
            throw new ZohoOAuthException("ZCRMRestClient::initialize(\$configMap) must be called before this.");
            
        }
        return ZohoOAuthClient::getInstanceWithOutParam();
    }
}