<?php

namespace ZCRM\common;

use ZCRM\oauth\client\ZohoOAuth;
use ZCRM\exception\ZCRMException;

class ZCRMConfigUtil {

    private static $configProperties = array();

    public static function getInstance() {
        return new ZCRMConfigUtil();
    }

    /**
     * @param $initializeOAuth
     *
     */
    public static function initialize($config) {

        // $path = realpath(dirname(__FILE__) . "/../../../../../resources/configuration.properties");
        // $fileHandler = fopen($path, "r");
        //if (!$fileHandler) {
        //    return;
        //}
        //self::$configProperties = CommonUtil::getFileContentAsMap($fileHandler);

        self::$configProperties = $config;

        ZohoOAuth::initializeWithOutInputStream();

    }

    public static function loadConfigProperties($fileHandler) {
        $configMap = CommonUtil::getFileContentAsMap($fileHandler);
        foreach ($configMap as $key => $value) {
            self::$configProperties[$key] = $value;
        }
    }

    public static function getConfigValue($key) {
        return isset(self::$configProperties[$key]) ? self::$configProperties[$key] : '';
    }

    public static function setConfigValue($key, $value) {
        self::$configProperties[$key] = $value;
    }

    public static function getAPIBaseUrl() {
        return self::getConfigValue("apiBaseUrl");
    }

    public static function getAPIVersion() {
        return self::getConfigValue("apiVersion");
    }

    /**
     * @return mixed
     * @throws ZCRMException
     */
    public static function getAccessToken() {
        $currentUserEmail = ZCRMRestClient::getCurrentUserEmailID();

        if ($currentUserEmail == null && self::getConfigValue("currentUserEmail") == null) {
            throw new ZCRMException("Current user should either be set in ZCRMRestClient or in configuration.properties file");
        } else if ($currentUserEmail == null) {
            $currentUserEmail = self::getConfigValue("currentUserEmail");
        }
        $oAuthCliIns = ZohoOAuth::getClientInstance();
        return $oAuthCliIns->getAccessToken($currentUserEmail);
    }

    public static function getAllConfigs() {
        return self::$configProperties;
    }
}

?>