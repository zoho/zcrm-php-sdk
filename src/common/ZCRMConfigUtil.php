<?php

namespace ZCRM\common;

use ZCRM\oauth\client\ZohoOAuth;
use ZCRM\exception\ZCRMException;
use Symfony\Component\Yaml\Yaml;
use ZCRM\ZCRMRestClient;

class ZCRMConfigUtil {

  private static $config = [];

  private static $configProperties = [];
  private static $instance;

  public static function getInstance() {

    if (!self::$instance) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  /**
   * @param $config
   * Path to config.yml file
   */
  public static function initialize($config) {

    self::getInstance();
    if (is_array($config)) {
      self::$config = $config;
    }
    elseif (is_file($config)) {
      self::$config = self::parseConfig($config);
    }
    self::$configProperties = self::$config['api'];
    ZohoOAuth::initialize(self::$config);
  }
  
  public static function parseConfig($config_path) {
    return Yaml::parseFile($config_path);
  }
  
  /**
   * @param $fileHandler
   */
  public static function loadConfigProperties($fileHandler) {
    $configMap = CommonUtil::getFileContentAsMap($fileHandler);
    foreach ($configMap as $key => $value) {
      self::$configProperties[$key] = $value;
    }
  }

  /**
   * @param $key
   *
   * @return mixed|string
   */
  public static function getConfigValue($key) {
    return isset(self::$configProperties[$key]) ? self::$configProperties[$key] : '';
  }

  /**
   * @param $key
   * @param $value
   */
  public static function setConfigValue($key, $value) {
    self::$configProperties[$key] = $value;
  }

  /**
   * @return mixed|string
   */
  public static function getAPIBaseUrl() {
    return self::getConfigValue("apiBaseUrl");
  }

  /**
   * @return mixed|string
   */
  public static function getAPIVersion() {
    return self::getConfigValue("apiVersion");
  }

  /**
   * @return mixed
   * @throws ZCRMException
   */
  public static function getAccessToken() {

    $currentUserEmail = ZCRMRestClient::getCurrentUserEmailID();

    if ($currentUserEmail == NULL && self::getConfigValue("currentUserEmail") == NULL) {
      throw new ZCRMException("Current user should either be set in ZCRMRestClient or in configuration.properties file");
    }
    else {
      if ($currentUserEmail == NULL) {
        $currentUserEmail = self::getConfigValue("currentUserEmail");
      }
    }
    $oAuthCliIns = ZohoOAuth::getClientInstance();
    return $oAuthCliIns->getAccessToken($currentUserEmail);
  }

  /**
   * @return array
   */
  public static function getAllConfigs() {
    return self::$configProperties;
  }

}

?>
