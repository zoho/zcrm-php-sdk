<?php

namespace ZCRM;

use ZCRM\api\handler\MetaDataAPIHandler;
use ZCRM\common\ZCRMConfigUtils;

//use ZCRM\ZCRMOrganization;
//require_once realpath(dirname(__FILE__) . '/../../api/handler/MetaDataAPIHandler.php');
//require_once realpath(dirname(__FILE__) . '/../../common/ZCRMConfigUtil.php');
//require_once realpath(dirname(__FILE__) . '/../../setup/metadata/ZCRMOrganization.php');

class ZCRMRestClient {

    private function __construct() {

    }

    public static function getInstance() {
        return new ZCRMRestClient();
    }

    public static function initialize() {
        ZCRMConfigUtil::initialize(true);
    }

    public function getAllModules() {
        return MetaDataAPIHandler::getInstance()->getAllModules();
    }

    public function getModule($moduleName) {
        return MetaDataAPIHandler::getInstance()->getModule($moduleName);
    }

    public function getOrganizationInstance() {
        return ZCRMOrganization::getInstance();
    }

    public function getModuleInstance($moduleAPIName) {
        return ZCRMModule::getInstance($moduleAPIName);
    }

    public function getRecordInstance($moduleAPIName, $entityId) {
        return ZCRMRecord::getInstance($moduleAPIName, $entityId);
    }

    public function getCurrentUser() {
        return OrganizationAPIHandler::getInstance()->getCurrentUser();
    }

    public static function getCurrentUserEmailID() {
        return isset($_SERVER[APIConstants::USER_EMAIL_ID]) ? $_SERVER[APIConstants::USER_EMAIL_ID] : null;
    }

    public static function getOrganizationDetails() {
        return OrganizationAPIHandler::getInstance()->getOrganizationDetails();
    }
}

?>