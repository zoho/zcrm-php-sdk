<?php

namespace ZCRM;

use ZCRM\api\handler\MetaDataAPIHandler;
use ZCRM\api\handler\OrganizationAPIHandler;
use ZCRM\common\APIConstants;
use ZCRM\common\ZCRMConfigUtil;
use ZCRM\crud\ZCRMRecord;
use ZCRM\crud\ZCRMModule;


class ZCRMRestClient {

    private function __construct() {

    }

    /**
     * @return ZCRMRestClient
     */
    public static function getInstance() {
        return new ZCRMRestClient();
    }

    /**
     * apiBaseUrl=www.zohoapis.com
     * apiVersion=v2
     * sandbox=false
     * applicationLogFilePath=
     * currentUserEmail=
     */
    public static function initialize($config) {
        ZCRMConfigUtil::initialize($config);
    }

    /**
     * @return mixed
     */
    public function getAllModules() {
        return MetaDataAPIHandler::getInstance()->getAllModules();
    }

    /**
     * @param $moduleName
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
     * @return ZCRMModule
     */
    public function getModuleInstance($moduleAPIName) {
        return ZCRMModule::getInstance($moduleAPIName);
    }

    /**
     * @param $moduleAPIName
     * @param $entityId
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
        return isset($_SERVER[APIConstants::USER_EMAIL_ID]) ? $_SERVER[APIConstants::USER_EMAIL_ID] : null;
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