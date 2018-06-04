<?php

namespace ZCRM;

use ZCRM\api\handler\MetaDataAPIHandler;
use ZCRM\api\handler\OrganizationAPIHandler;
use ZCRM\common\APIConstants;
use ZCRM\common\ZCRMConfigUtil;
use ZCRM\crud\ZCRMRecord;
use ZCRM\crud\ZCRMModule;


class ZCRMRestClient {


  public function __construct() {
  }
  /**
   * @param $config
   * Init direct with yml file or array
   *        or
   * pre-parse config as a default and then init w/ updated array
   * will allow config to be managed by end users app
   */
  public static function initialize($config) {
    ZCRMConfigUtil::initialize($config);
  }
  public static function parseConfig($config_path) {
    return ZCRMConfigUtil::parseConfig($config_path);
  }

  /**
   * @return mixed
   */
  public function getAllModules() {
    return MetaDataAPIHandler::getInstance()->getAllModules();
  }

  /**
   * @param $moduleName
   *
   * @return mixed
   */
  public function getModule($moduleName) {
    return MetaDataAPIHandler::getInstance()->getModule($moduleName);
  }

  /**
   * @return ZCRMOrganization
   */
  public function getOrganizationInstance() {
    return ZCRMOrganization::getInstance();
  }

  /**
   * @param $moduleAPIName
   *
   * @return ZCRMModule
   */
  public function getModuleInstance($moduleAPIName) {
    return ZCRMModule::getInstance($moduleAPIName);
  }

  /**
   * @param $moduleAPIName
   * @param $entityId
   *
   * @return ZCRMRecord
   */
  public function getRecordInstance($moduleAPIName, $entityId) {
    return ZCRMRecord::getInstance($moduleAPIName, $entityId);
  }

  /**
   * @return mixed
   */
  public function getCurrentUser() {
    return OrganizationAPIHandler::getInstance()->getCurrentUser();
  }

  /**
   * @return null
   */
  public static function getCurrentUserEmailID() {
    return isset($_SERVER[APIConstants::USER_EMAIL_ID]) ? $_SERVER[APIConstants::USER_EMAIL_ID] : NULL;
  }

  /**
   * @return mixed
   * @throws exception\ZCRMException
   */
  public static function getOrganizationDetails() {
    return OrganizationAPIHandler::getInstance()->getOrganizationDetails();
  }
}

?>
