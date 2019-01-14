<?php
require_once realpath(dirname(__FILE__).'/../../api/handler/MetaDataAPIHandler.php');
require_once realpath(dirname(__FILE__).'/../../common/ZCRMConfigUtil.php');
require_once realpath(dirname(__FILE__).'/../../setup/metadata/ZCRMOrganization.php');

class ZCRMRestClient
{
	
	private function __construct()
	{
		
	}
	/**
	 * method to get the instance of the rest client
	 * @return ZCRMRestClient insance of the ZCRMRestClient class
	 */
	public static function getInstance()
	{
		return new ZCRMRestClient();
	}
	/**
	 * method to initialize the configurationsto the rest client 
	 * @param array $configuration array of configurations. default is null
	 */
	public static function initialize($configuration=null)
	{
	    ZCRMConfigUtil::initialize(true,$configuration);
	}
	/**
	 * method to get all the modules of the restclient
	 * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
	 */
	public function getAllModules()
	{
		return MetaDataAPIHandler::getInstance()->getAllModules();
	}
	/**
	 * method to get the module of the rest client
	 * @param string $moduleName api name of the module
	 * @return APIResponse instance of the APIResponse class containing the api response
	 */
	public function getModule($moduleName)
	{
		return MetaDataAPIHandler::getInstance()->getModule($moduleName);
	}
	/**
	 * method to get the organization of the rest client 
	 * @return ZCRMOrganization instance of the ZCRMOrganization class
	 */
	public function getOrganizationInstance()
	{
		return ZCRMOrganization::getInstance();
	}
	/**
	 *  method to get the module of the rest client
	 * @param string $moduleAPIName module api name
	 * @return ZCRMModule instance of the ZCRMModule class
	 */
	public function getModuleInstance($moduleAPIName)
	{
		return ZCRMModule::getInstance($moduleAPIName);
	}
	/**
	 * method to get the record of the client
	 * @param string $moduleAPIName module api name
	 * @param string $entityId record id
	 * @return ZCRMRecord instance of the ZCRMRecord class
	 */
	public function getRecordInstance($moduleAPIName,$entityId)
	{
		return ZCRMRecord::getInstance($moduleAPIName, $entityId);
	}
	/**
	 * method to get the current user of the rest client
	 * @return APIResponse instance of the APIResponse class containing the  api response
	 */
	public function getCurrentUser()
	{
		return OrganizationAPIHandler::getInstance()->getCurrentUser();
	}
	/**
	 * method to get the current user email id 
	 * @return string currrent user email id
	 */
	public static function getCurrentUserEmailID()
	{
		return isset($_SERVER[APIConstants::USER_EMAIL_ID])?$_SERVER[APIConstants::USER_EMAIL_ID]:null;
	}
	/**
	 * method to get the organization details of the rest client
	 * @return APIResponse instance of the APIResponse class containing the api response
	 */
	public static function getOrganizationDetails()
	{
		return OrganizationAPIHandler::getInstance()->getOrganizationDetails(); 
	}
}
?>