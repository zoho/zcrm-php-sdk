<?php
namespace zcrmsdk\crm\setup\restclient;

use zcrmsdk\crm\api\handler\MetaDataAPIHandler;
use zcrmsdk\crm\api\handler\OrganizationAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\api\response\BulkAPIResponse;
use zcrmsdk\crm\bulkcrud\ZCRMBulkRead;
use zcrmsdk\crm\bulkcrud\ZCRMBulkWrite;
use zcrmsdk\crm\utility\ZCRMConfigUtil;
use zcrmsdk\crm\setup\org\ZCRMOrganization;
use zcrmsdk\crm\crud\ZCRMModule;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMCustomView;

class ZCRMRestClient
{
    
    private function __construct()
    {}
    private static $CurrentUserEmailID;
    /**
     * method to get the instance of the rest client
     *
     * @return ZCRMRestClient insance of the ZCRMRestClient class
     */
    public static function getInstance()
    {
        return new ZCRMRestClient();
    }
    public static function setCurrentUserEmailId($UserEmailId)
    {
        self::$CurrentUserEmailID=$UserEmailId;
    }
    /**
     * method to initialize the configurationsto the rest client
     *
     * @param array $configuration array of configurations.
     */
    public static function initialize($configuration)
    {
        ZCRMConfigUtil::initialize($configuration);
    }
    /**
     * method to get all the modules of the restclient
     *
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllModules()
    {
        return MetaDataAPIHandler::getInstance()->getAllModules();
    }
    
    /**
     * method to get the module of the rest client
     *
     * @param string $moduleName api name of the module
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getModule($moduleName)
    {
        return MetaDataAPIHandler::getInstance()->getModule($moduleName);
    }
    
    /**
     * method to get the organization of the rest client
     *
     * @return ZCRMOrganization instance of the ZCRMOrganization class
     */
    public function getOrganizationInstance()
    {
        return ZCRMOrganization::getInstance();
    }
    /**
     * method to get the Custom view of the organisation
     *
     * @return ZCRMCustomView instance of the ZCRMCustomView class
     */
    public function getCustomViewInstance($moduleAPIName,$id)
    {
        return ZCRMCustomView::getInstance($moduleAPIName,$id );
    }
    
    /**
     * method to get the module of the rest client
     *
     * @param string $moduleAPIName module api name
     * @return ZCRMModule instance of the ZCRMModule class
     */
    public function getModuleInstance($moduleAPIName)
    {
        return ZCRMModule::getInstance($moduleAPIName);
    }
    
    /**
     * method to get the record of the client
     *
     * @param string $moduleAPIName module api name
     * @param string $entityId record id
     * @return ZCRMRecord instance of the ZCRMRecord class
     */
    public function getRecordInstance($moduleAPIName, $entityId)
    {
        return ZCRMRecord::getInstance($moduleAPIName, $entityId);
    }
    
    /**
     * method to get the current user of the rest client
     *
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getCurrentUser()
    {
        return OrganizationAPIHandler::getInstance()->getCurrentUser();
    }
    
    /**
     * method to get the current user email id
     *
     * @return string currrent user email id
     */
    public  static function getCurrentUserEmailID()
    {
        return self::$CurrentUserEmailID;
    }
    
    /**
     * method to get the organization details of the rest client
     *
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public static function getOrganizationDetails()
    {
        return OrganizationAPIHandler::getInstance()->getOrganizationDetails();
    }

    /**
     * Method to get the bulk read instance
     * @param string $moduleName
     * @param string $jobId
     * @return ZCRMBulkRead - class instance
     */
    public function getBulkReadInstance($moduleName = null, $jobId = null)
    {
        return ZCRMBulkRead::getInstance($moduleName, $jobId);
    }
    
    /**
     * Method to get the bulk write instance
     * @param string $operation - bulk write operation (insert or update)
     * @param string $jobId - bulk write job id
     * @param string $moduleAPIName - bulk write module api name
     * @return ZCRMBulkWrite - class instance
     */
    public function getBulkWriteInstance($operation = null, $jobId = null, $moduleAPIName = null)
    {
        return ZCRMBulkWrite::getInstance($operation, $jobId, $moduleAPIName);
    }
}