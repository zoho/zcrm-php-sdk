<?php
namespace zcrmsdk\crm\setup\org;
use zcrmsdk\crm\api\handler\OrganizationAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\api\response\BulkAPIResponse;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\api\handler\VariableGroupAPIHandler;
use zcrmsdk\crm\api\handler\VariableAPIHandler;
/**
 * Purpose of this method is to call the Organization level APIs like users, profiles, roles, ..etc
 *
 * @author sumanth-3058
 *
 */
class ZCRMOrganization
{
    
    /**
     * company name
     *
     * @var string
     */
    private $company_name;
    
    /**
     * alias of the organization
     *
     * @var string
     */
    private $alias;
    
    /**
     * organization record id
     *
     * @var string
     */
    private $orgId;
    
    /**
     * primary zoho id
     *
     * @var string
     */
    private $primary_zuid;
    
    /**
     * zoho group id
     *
     * @var string
     */
    private $zgid;
    
    /**
     * primary email
     *
     * @var string
     */
    private $primary_email;
    
    /**
     * website of the organization
     *
     * @var string
     */
    private $website;
    
    /**
     * mobile number
     *
     * @var string
     */
    private $mobile;
    
    /**
     * phone number
     *
     * @var string
     */
    private $phone;
    
    /**
     * employee count
     *
     * @var int
     */
    private $employee_count;
    
    /**
     * description of the organization
     *
     * @var string
     */
    private $description;
    
    /**
     * time zone of the locality
     *
     * @var string
     */
    private $time_zone;
    
    /**
     * iso code of the organization
     *
     * @var string
     */
    private $iso_code;
    
    /**
     * currency locale
     *
     * @var string
     */
    private $currency_locale;
    
    /**
     * currency symbol
     *
     * @var string
     */
    private $currency_symbol;
    
    /**
     * street name of the organizaton
     *
     * @var string
     */
    private $street;
    
    /**
     * state of the organization
     *
     * @var string
     */
    private $state;
    
    /**
     * city of the organization
     *
     * @var string
     */
    private $city;
    
    /**
     * country of the organization
     *
     * @var string
     */
    private $country;
    
    /**
     * zipCode of the organization
     *
     * @var string
     */
    private $zipCode;
    
    /**
     * country_code of the organization
     *
     * @var string
     */
    private $country_code;
    
    /**
     * fax number of the organization
     *
     * @var string
     */
    private $fax;
    
    /**
     * organization multi-currency status
     *
     * @var string
     */
    private $mc_status;
    
    /**
     * organization google apps enabled
     *
     * @var boolean
     */
    private $gapps_enabled;
    
    /**
     * paid expiry
     *
     * @var string
     */
    private $paid_expiry;
    
    /**
     * trial type
     *
     * @var string
     */
    private $trial_type;
    
    /**
     * expiry of trial
     *
     * @var string
     */
    private $trial_expiry;
    
    /**
     * paid account
     *
     * @var boolean
     */
    private $paid;
    
    /**
     * paid type
     *
     * @var string
     */
    private $paid_type;
    
    /**
     * constructor to set the organization name and organization record id
     *
     * @param string $orgName organization name
     * @param string $orgId organization record id
     */
    private function __construct($orgName, $orgId)
    {
        $this->orgId = $orgId;
        $this->company_name = $orgName;
    }
    
    /**
     * method to get the instance of the organization
     *
     * @param string $orgName organization name
     * @param string $orgId organization record id
     * @return ZCRMOrganization instance of ZCRMOrganization Class
     */
    public static function getInstance($orgName = null, $orgId = null)
    {
        return new ZCRMOrganization($orgName, $orgId);
    }
    
    /**
     * method to set the fax number of the organization
     *
     * @param string $fax fax number
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }
    
    /**
     * method to get the fax number of the organization
     *
     * @return string fax number
     */
    public function getFax()
    {
        return $this->fax;
    }
    
    /**
     * method to get the company_name
     *
     * @return String the company_name
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }
    
    /**
     * method to set the company_name
     *
     * @param String $company_name the company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }
    
    /**
     * method to get the alias of the organization
     *
     * @return String the alias of the organization
     */
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * method to set the alias of the organization
     *
     * @param String $alias the alias of the organization
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
    
    /**
     * method to get the organization record Id
     *
     * @return string the organization record Id
     */
    public function getOrgId()
    {
        return $this->orgId;
    }
    
    /**
     * method to set the organization record Id
     *
     * @param string $orgId the organization record Id
     */
    public function setOrgId($orgId)
    {
        $this->orgId = $orgId;
    }
    
    /**
     * method to get the primary zoho id of the organization
     *
     * @return string primary zoho id of the organization
     */
    public function getPrimaryZuid()
    {
        return $this->primary_zuid;
    }
    
    /**
     * method to set the primary zoho id of the organization
     *
     * @param string $primary_zuid primary zoho id of the organization
     */
    public function setPrimaryZuid($primary_zuid)
    {
        $this->primary_zuid = $primary_zuid;
    }
    
    /**
     * method to get the zoho group id of the organization
     *
     * @return string zoho group id of the organization
     */
    public function getZgid()
    {
        return $this->zgid;
    }
    
    /**
     * method to set the zoho group id of the organization
     *
     * @param string $zgid zoho group id of the organization
     */
    public function setZgid($zgid)
    {
        $this->zgid = $zgid;
    }
    
    /**
     * method to get the primary email of the organization
     *
     * @return String the primary email of the organization
     */
    public function getPrimaryEmail()
    {
        return $this->primary_email;
    }
    
    /**
     * method to set the primary email of the organization
     *
     * @param String $primary_email the primary email of the organization
     */
    public function setPrimaryEmail($primary_email)
    {
        $this->primary_email = $primary_email;
    }
    
    /**
     * method to get the website of the organization
     *
     * @return String the website of the organization
     */
    public function getWebsite()
    {
        return $this->website;
    }
    
    /**
     * method to set the website of the organization
     *
     * @param String $website the website of the organization
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }
    
    /**
     * method to get the mobile number of the organization
     *
     * @return string the mobile number of the organization
     */
    public function getMobile()
    {
        return $this->mobile;
    }
    
    /**
     * method to set the mobile number of the organization
     *
     * @param string $mobile the mobile number of the organization
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }
    
    /**
     * method to get the phone number of the organization
     *
     * @return string the phone number of the organization
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * method to set the phone number of the organization
     *
     * @param string $phone the phone number of the organization
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    
    /**
     * method to get the employee count of the organization
     *
     * @return int the employee count of the organization
     */
    public function getEmployeeCount()
    {
        return $this->employee_count;
    }
    
    /**
     * method to set the employee count of the organization
     *
     * @param int $employee_count the employee count of the organization
     */
    public function setEmployeeCount($employee_count)
    {
        $this->employee_count = $employee_count;
    }
    
    /**
     * method to get the description of the organization
     *
     * @return String the description of the organization
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * method to set the description of the organization
     *
     * @param String $description the description of the organization
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * method to get the time zone of the organization's locality
     *
     * @return String the time zone of the organization's locality
     */
    public function getTimeZone()
    {
        return $this->time_zone;
    }
    
    /**
     * method to set the time zone of the organization's locality
     *
     * @param String $time_zone the time zone of the organization's locality
     */
    public function setTimeZone($time_zone)
    {
        $this->time_zone = $time_zone;
    }
    
    /**
     * method to get the iso code of the organization
     *
     * @return String the iso code of the organization
     */
    public function getIsoCode()
    {
        return $this->iso_code;
    }
    
    /**
     * method to set the iso code of the organization
     *
     * @param String $iso_code the iso code of the organization
     */
    public function setIsoCode($iso_code)
    {
        $this->iso_code = $iso_code;
    }
    
    /**
     * method to get the currency locale of the organization
     *
     * @return String the currency locale of the organization
     */
    public function getCurrencyLocale()
    {
        return $this->currency_locale;
    }
    
    /**
     * method to set the currency locale of the organization
     *
     * @param String $currency_locale the currency locale of the organization
     */
    public function setCurrencyLocale($currency_locale)
    {
        $this->currency_locale = $currency_locale;
    }
    
    /**
     * method to get the currency symbol of the organization
     *
     * @return String the currency symbol of the organization
     */
    public function getCurrencySymbol()
    {
        return $this->currency_symbol;
    }
    
    /**
     * method to set the currency symbol of the organization
     *
     * @param String $currency_symbol the currency symbol of the organization
     */
    public function setCurrencySymbol($currency_symbol)
    {
        $this->currency_symbol = $currency_symbol;
    }
    
    /**
     * method to get the streetname of the organization
     *
     * @return String streetname of the organization
     */
    public function getStreet()
    {
        return $this->street;
    }
    
    /**
     * method to set the streetname of the organization
     *
     * @param String $street streetname of the organization
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }
    
    /**
     * method to get the state name of the organization
     *
     * @return String the state name of the organization
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * method to set the state name of the organization
     *
     * @param String $state the state name of the organization
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * method to get the city name of the organization
     *
     * @return String the city name of the organization
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * method to set the city name of the organization
     *
     * @param String $city the city name of the organization
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    /**
     * method to get the country name of the organization
     *
     * @return String the country name of the organization
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * method to set the country name of the organization
     *
     * @param String $country the country name of the organization
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
    
    /**
     * method to get the Zip Code of the organization
     *
     * @param String $zipCode the ZipCode of the organization
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    /**
     * method to set the Zip Code of the organization
     *
     * @param String $zipCode the Zip Code of the organization
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
    
    /**
     * method to get the Country Code of the organization
     *
     * @param String $country_code the Country Code of the organization
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }
    
    /**
     * method to set the Country Code of the organization
     *
     * @param String $country_code the Country Code of the organization
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;
    }
    
    /**
     * method to get the multi-currency status of the organization
     *
     * @return string the multi-currency status of the organization
     */
    public function getMcStatus()
    {
        return $this->mc_status;
    }
    
    /**
     * method to set the multi-currency status of the organization
     *
     * @param string $mc_status the multi-currency status of the organization
     */
    public function setMcStatus($mc_status)
    {
        $this->mc_status = $mc_status;
        return $this;
    }
    
    /**
     * method to check whether the google apps is enabled
     *
     * @return Boolean true if google apps is enabled otherwise false
     */
    public function isGappsEnabled()
    {
        return $this->gapps_enabled;
    }
    
    /**
     * method to enable the google apps of the organiation
     *
     * @param Boolean $gapps_enabled true to enable the google apps otherwise false
     */
    public function setGappsEnabled($gapps_enabled)
    {
        $this->gapps_enabled = $gapps_enabled;
    }
    
    /**
     * method to get the paid expiry of the organization
     *
     * @return String the paid expiry of the organization
     */
    public function getPaidExpiry()
    {
        return $this->paid_expiry;
    }
    
    /**
     * method to set the paid expiry of the organization
     *
     * @param String $paid_expiry the paid expiry of the organization
     */
    public function setPaidExpiry($paid_expiry)
    {
        $this->paid_expiry = $paid_expiry;
    }
    
    /**
     * method to get the trial type of the organization
     *
     * @return String the trial type of the organization
     */
    public function getTrialType()
    {
        return $this->trial_type;
    }
    
    /**
     * method to set the trial type of the organization
     *
     * @param String $trial_type the trial type of the organization
     */
    public function setTrialType($trial_type)
    {
        $this->trial_type = $trial_type;
    }
    
    /**
     * method to get the trial expiry of the organization
     *
     * @return String the trial expiry of the organization
     */
    public function getTrialExpiry()
    {
        return $this->trial_expiry;
    }
    
    /**
     * method to set the trial expiry of the organization
     *
     * @param String $trial_expiry the trial expiry of the organization
     */
    public function setTrialExpiry($trial_expiry)
    {
        $this->trial_expiry = $trial_expiry;
    }
    
    /**
     * method to check whether the accound is paid
     *
     * @return Boolean true if paid account otherwise false
     */
    public function isPaidAccount()
    {
        return $this->paid;
    }
    
    /**
     * method to set the account as paid account
     *
     * @param Boolean $paid true to enable the paid account otherwise false
     */
    public function setPaidAccount($paid)
    {
        $this->paid = $paid;
    }
    
    /**
     * method to get the account paid type
     *
     * @return String the account paid type
     */
    public function getPaidType()
    {
        return $this->paid_type;
    }
    
    /**
     * method to set the account paid type
     *
     * @param String $paid_type the account paid type
     */
    public function setPaidType($paid_type)
    {
        $this->paid_type = $paid_type;
    }
    
    /**
     * method to get the user of the organization
     *
     * @param string $userId user id
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getUser($userId)
    {
        return OrganizationAPIHandler::getInstance()->getUser($userId);
    }
    
    /**
     * method to get the users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllUsers($param_map,$header_map);
    }
    
    /**
     * method to get the active users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllActiveUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllActiveUsers($param_map,$header_map);
    }
    
    /**
     * method to get the deactived users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllDeactiveUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllDeactiveUsers($param_map,$header_map);
    }
    
    /**
     * method to get the confirmed users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllConfirmedUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllConfirmedUsers($param_map,$header_map);
    }
    
    /**
     * method to get the unconfirmed users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllNotConfirmedUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllNotConfirmedUsers($param_map,$header_map);
    }
    
    /**
     * method to get the deleted users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllDeletedUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllDeletedUsers($param_map,$header_map);
    }
    
    /**
     * method to get the active confirmed users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllActiveConfirmedUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllActiveConfirmedUsers($param_map,$header_map);
    }
    
    /**
     * method to get the admin users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllAdminUsers($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllAdminUsers($param_map,$header_map);
    }
    
    /**
     * method to get the confirmed active admin users of the organization
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllActiveConfirmedAdmins($param_map=array(),$header_map=array())
    {
        return OrganizationAPIHandler::getInstance()->getAllActiveConfirmedAdmins($param_map,$header_map);
    }
    
    /**
     * method to get the current users of the organization
     *
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getCurrentUser()
    {
        return OrganizationAPIHandler::getInstance()->getCurrentUser();
    }
    
    /**
     * method to get the profiles of the organization
     *
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllProfiles()
    {
        return OrganizationAPIHandler::getInstance()->getAllProfiles();
    }
    
    /**
     * method to get the profile id of the organization
     *
     * @param string $profileId the profile id of the organization
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getProfile($profileId)
    {
        return OrganizationAPIHandler::getInstance()->getProfile($profileId);
    }
    
    /**
     * method to get the roles of the organization
     *
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAllRoles()
    {
        return OrganizationAPIHandler::getInstance()->getAllRoles();
    }
    
    /**
     * method to get the role of the organization
     *
     * @param string $roleId the role id of the organization
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getRole($roleId)
    {
        return OrganizationAPIHandler::getInstance()->getRole($roleId);
    }
    
    /**
     * method to create the user of the organization
     *
     * @param ZCRMUser $userInstance instance of the ZCRMUser class
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function createUser($userInstance)
    {
        return OrganizationAPIHandler::getInstance()->createUser($userInstance);
    }
    
    /**
     * method to update the user of the organization
     *
     * @param ZCRMUser $userInstance instance of the ZCRMUser class
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function updateUser($userInstance)
    {
        return OrganizationAPIHandler::getInstance()->updateUser($userInstance);
    }
    /**
     * method to search user by criteria
     * @param string $criteria criteria to search with
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the api response
     */
    public function searchUsersByCriteria($criteria,$param_map=array()){
        return OrganizationAPIHandler::getInstance()->searchUsersByCriteria($criteria,$param_map);
    }
    /**
     * method to delete the user of the organization
     *
     * @param string $userIdid of the user
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function deleteUser($userId)
    {
        return OrganizationAPIHandler::getInstance()->deleteUser($userId);
    }
    /**
     * method to get the organization tax details
     * @param string $orgTaxId org tax id
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function getOrganizationTax($orgTaxId)
    {
        return OrganizationAPIHandler::getInstance()->getOrganizationTax($orgTaxId);
    }
    /**
     * method to get the organization tax details
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getOrganizationTaxes()
    {
        return OrganizationAPIHandler::getInstance()->getOrganizationTaxes();
    }
    /**
     * method to create organization taxes
     * @param array $orgTaxInstances array of ZCRMOrgTax instances
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function createOrganizationTaxes($orgTaxInstances)
    {
        return OrganizationAPIHandler::getInstance()->createOrganizationTaxes($orgTaxInstances);
    }
    /**
     *method to update organization taxes
     * @param array $orgTaxInstances array of ZCRMOrgTax instances
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function updateOrganizationTaxes($orgTaxInstances)
    {
        return OrganizationAPIHandler::getInstance()->updateOrganizationTaxes($orgTaxInstances);
    }
    /**
     *method to delete organization taxes
     * @param array $orgTaxIds array of org tax ids
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function deleteOrganizationTaxes($orgTaxIds)
    {
        return OrganizationAPIHandler::getInstance()->deleteOrganizationTaxes($orgTaxIds);
    }
    /**
     *method to delete organization tax
     * @param string $orgTaxIds org tax id
     * @return APIResponse   instance of the APIResponse   class containing the  api response
     */
    public function deleteOrganizationTax($orgTaxId)
    {
        return OrganizationAPIHandler::getInstance()->deleteOrganizationTax($orgTaxId);
    }
    public function getVariableGroups()
    {
        $instance = VariableGroupAPIHandler::getInstance();
        return $instance->getVariableGroups();
    }
    public function getVariables()
    {
        $instance = VariableAPIHandler::getInstance();
        return $instance->getVariables();
    }
    public function createVariables($variable)
    {
        $instance = VariableAPIHandler::getInstance();
        return $instance->createVariables($variable);
    }
    public function updateVariables($variable)
    {
        $instance = VariableAPIHandler::getInstance();
        return $instance->updateVariables($variable);
    }
    public function getNotes($param_map=array(),$header_map=array()){
        return OrganizationAPIHandler::getInstance()->getNotes($param_map,$header_map);
    }
    public function createNotes($noteInstances){
        return OrganizationAPIHandler::getInstance()->createNotes($noteInstances);
    }
    public function deleteNotes($noteIds){
        return OrganizationAPIHandler::getInstance()->deleteNotes($noteIds);
    }
    
}