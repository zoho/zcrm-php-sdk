<?php

namespace ZCRM\common;

use ZCRM\oauth\client\ZohoOAuth;
use ZCRM\exception\ZCRMException;
use Symfony\Component\Yaml\Yaml;
use ZCRM\ZCRMRestClient;

class ZCRMConfigUtil {

  private static $config = array();
  private static $configProperties = array();

  public static function getInstance() {
    return new ZCRMConfigUtil();
  }

  /**
   * @param $config_path
   * Path to config.yml file
   */
  public static function initialize($config_path) {

    self::$config = Yaml::parseFile($config_path);
    self::$configProperties = self::$config['api'];

    ZohoOAuth::initialize(self::$config);

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

    if ($currentUserEmail == null && self::getConfigValue("currentUserEmail") == null) {
      throw new ZCRMException("Current user should either be set in ZCRMRestClient or in configuration.properties file");
    } else if ($currentUserEmail == null) {
      $currentUserEmail = self::getConfigValue("currentUserEmail");
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
