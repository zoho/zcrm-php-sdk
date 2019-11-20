<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMOrgTax;
use zcrmsdk\crm\crud\ZCRMPermission;
use zcrmsdk\crm\crud\ZCRMProfileCategory;
use zcrmsdk\crm\crud\ZCRMProfileSection;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\org\ZCRMOrganization;
use zcrmsdk\crm\setup\users\ZCRMProfile;
use zcrmsdk\crm\setup\users\ZCRMRole;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\setup\users\ZCRMUserCustomizeInfo;
use zcrmsdk\crm\setup\users\ZCRMUserTheme;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMNote;


/**
 *
 * Purpose of this class is to fire User level APIs and construct the response
 *
 * @author sumanth-3058
 *
 */
class OrganizationAPIHandler extends APIHandler
{
    
    private function __construct()
    {}
    
    public static function getInstance()
    {
        return new OrganizationAPIHandler();
    }
    public function getNotes($param_map,$header_map){
        try {
            $this->urlPath = "Notes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            foreach($param_map as $key=>$value){
                if($value!=null)$this->addParam($key,$value);
            }
            foreach($header_map as $key=>$value){
                if($value!=null)$this->addHeader($key,$value);
            }
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $notesDetails = $responseJSON['data'];
            $noteInstancesArray = array();
            foreach ($notesDetails as $notesObj) {
                $record_Ins=ZCRMRecord::getInstance($notesObj["\$se_module"], $notesObj["Parent_Id"]["id"]);
                $noteIns=ZCRMNote::getInstance($record_Ins,$notesObj["id"]);
                array_push($noteInstancesArray,RelatedListAPIHandler::getInstance($record_Ins, "Notes")->getZCRMNote($notesObj,$noteIns));
            }
            $responseInstance->setData($noteInstancesArray);
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function createNotes($noteInstances){
        if (sizeof($noteInstances) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_NOTES_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $dataArray = array();
            foreach ($noteInstances as $noteInstance) {
                if ($noteInstance->getId() == null) {
                    $record_Ins=ZCRMRecord::getInstance($noteInstance->getParentModule(),$noteInstance->getParentId());
                    array_push($dataArray, RelatedListAPIHandler::getInstance($record_Ins,"Notes")->getZCRMNoteAsJSON($noteInstance));
                } else {
                    throw new ZCRMException(" ID MUST be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
                }
            }
            
            $requestBodyObj = array();
            $requestBodyObj["data"] = $dataArray;
            $this->urlPath = "Notes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $requestBodyObj;
            
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deleteNotes($noteIds){
        if (sizeof($noteIds) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_NOTES_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            
            $this->urlPath = "Notes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("ids", implode(",", $noteIds)); // converts array to string with specified seperator
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getOrganizationDetails()
    {
        try {
            $this->urlPath = "org";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $orgDetails = $responseJSON['org'][0];
            $responseInstance->setData(self::setOrganizationDetails($orgDetails));
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getOrganizationTaxes()
    {
        try {
            $this->urlPath = "org/taxes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $orgTaxes = $responseJSON['taxes'];
            $orgTaxInstancesArray = array();
            foreach ($orgTaxes as $orgTaxobj) {
                array_push($orgTaxInstancesArray, self::getZCRMorgTax($orgTaxobj));
            }
            $responseInstance->setData($orgTaxInstancesArray);
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getOrganizationTax($orgTaxId)
    {
        try {
            $this->urlPath = "org/taxes/".$orgTaxId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $orgTax = $responseJSON['taxes'][0];
            $responseInstance->setData(self::getZCRMorgTax($orgTax));
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function createOrganizationTaxes($orgTaxInstances)
    {
        if (sizeof($orgTaxInstances) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_ORGTAX_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $dataArray = array();
            foreach ($orgTaxInstances as $orgTaxInstance) {
                if ($orgTaxInstance->getId() == null) {
                    array_push($dataArray, self::constructJSONForZCRMOrgTax($orgTaxInstance));
                } else {
                    throw new ZCRMException(" ID MUST be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
                }
            }
            
            $requestBodyObj = array();
            $requestBodyObj["taxes"] = $dataArray;
            $this->urlPath = "org/taxes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $requestBodyObj;
            
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function updateOrganizationTaxes($orgTaxInstances)
    {
        if (sizeof($orgTaxInstances) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_ORGTAX_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $dataArray = array();
            foreach ($orgTaxInstances as $orgTaxInstance) {
                if ($orgTaxInstance->getId() != null) {
                    array_push($dataArray, self::constructJSONForZCRMOrgTax($orgTaxInstance));
                } else {
                    throw new ZCRMException(" ID MUST not be null for update operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
                }
            }
            $requestBodyObj = array();
            $requestBodyObj["taxes"] = $dataArray;
            $this->urlPath = "org/taxes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $requestBodyObj;
            
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deleteOrganizationTax($orgTaxId)
    {
        try {
            $this->urlPath = "org/taxes/".$orgTaxId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deleteOrganizationTaxes($orgTaxIds)
    {
        if (sizeof($orgTaxIds) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_ORGTAX_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            
            $this->urlPath = "org/taxes";
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("ids", implode(",", $orgTaxIds)); // converts array to string with specified seperator
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getZCRMorgTax($orgTaxDetails){
        $orgTaxInstance=ZCRMOrgTax::getInstance($orgTaxDetails['name'], $orgTaxDetails['id']);
        $orgTaxInstance->setValue($orgTaxDetails['display_label']);
        $orgTaxInstance->setDisplayName($orgTaxDetails['value']);
        return $orgTaxInstance;
    }
    
    public function setOrganizationDetails($orgDetails)
    {
        $orgInsatance = ZCRMOrganization::getInstance($orgDetails['company_name'], $orgDetails['id']);
        $orgInsatance->setAlias($orgDetails['alias']);
        $orgInsatance->setCity($orgDetails['city']);
        $orgInsatance->setCountry($orgDetails['country']);
        $orgInsatance->setCountryCode($orgDetails['country_code']);
        $orgInsatance->setCurrencyLocale($orgDetails['currency_locale']);
        $orgInsatance->setCurrencySymbol($orgDetails['currency_symbol']);
        $orgInsatance->setDescription($orgDetails['description']);
        $orgInsatance->setEmployeeCount($orgDetails['employee_count']);
        $orgInsatance->setFax($orgDetails['fax']);
        $orgInsatance->setGappsEnabled((boolean) $orgDetails['gapps_enabled']);
        $orgInsatance->setIsoCode($orgDetails['iso_code']);
        $orgInsatance->setMcStatus($orgDetails['mc_status']);
        $orgInsatance->setMobile($orgDetails['mobile']);
        
        $orgInsatance->setPhone($orgDetails['phone']);
        $orgInsatance->setPrimaryEmail($orgDetails['primary_email']);
        $orgInsatance->setPrimaryZuid($orgDetails['primary_zuid']);
        $orgInsatance->setState($orgDetails['state']);
        $orgInsatance->setStreet($orgDetails['street']);
        $orgInsatance->setTimeZone($orgDetails['time_zone']);
        $orgInsatance->setWebsite($orgDetails['website']);
        $orgInsatance->setZgid($orgDetails['zgid']);
        $orgInsatance->setZipCode($orgDetails['zip']);
        
        $license_details = $orgDetails['license_details'];
        if ($license_details != null) {
            $orgInsatance->setPaidAccount((boolean) $license_details['paid']);
            $orgInsatance->setPaidType($license_details['paid_type']);
            $orgInsatance->setPaidExpiry($license_details['paid_expiry']);
            $orgInsatance->setTrialExpiry($license_details['trial_expiry']);
            $orgInsatance->setTrialType($license_details['trial_type']);
        }
        
        return $orgInsatance;
    }
    
    public function getAllRoles()
    {
        try {
            $this->urlPath = "settings/roles";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $roles = $responseJSON['roles'];
            $roleInstanceArray = array();
            foreach ($roles as $role) {
                array_push($roleInstanceArray, self::getZCRMRole($role));
            }
            $responseInstance->setData($roleInstanceArray);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getRole($roleId)
    {
        try {
            $this->urlPath = "settings/roles/" . $roleId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $roles = $responseJSON['roles'];
            $responseInstance->setData(self::getZCRMRole($roles[0]));
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getZCRMRole($roleDetails)
    {
        $crmRoleInstance = ZCRMRole::getInstance($roleDetails['id'], $roleDetails['name']);
        $crmRoleInstance->setDisplayLabel($roleDetails['display_label']);
        $crmRoleInstance->setAdminRole((boolean) $roleDetails['admin_user']);
        if (isset($roleDetails['reporting_to'])) {
            $crmRoleInstance->setReportingTo(ZCRMRole::getInstance($roleDetails['reporting_to']['id'], $roleDetails['reporting_to']['name']));
        }
        return $crmRoleInstance;
    }
    
    public function createUser($userInstance)
    {
        try {
            $userJson = self::constructJSONForUser(array(
                $userInstance
            ));
            $this->urlPath = "users";
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $userJson;
            $this->apiKey = 'users';
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function updateUser($userInstance)
    {
        try {
            $userJson = self::constructJSONForUser(array(
                $userInstance
            ));
            $this->urlPath = "users/" . $userInstance->getId();
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $userJson;
            $this->apiKey = 'users';
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deleteUser($userId)
    {
        try {
            $this->urlPath = "users/" . $userId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->addHeader("Content-Type", "application/json");
            $this->apiKey = 'users';
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function constructJSONForZCRMOrgTax($orgTaxInstance)
    {
        $orgTaxJson = array();
        
        if ($orgTaxInstance->getId() != null) {
            $orgTaxJson['id'] = $orgTaxInstance->getId();
        }
        if ($orgTaxInstance->getName() != null) {
            $orgTaxJson['name'] = $orgTaxInstance->getName();
        }
        if ($orgTaxInstance->getDisplayName() != null) {
            $orgTaxJson['display_label'] = $orgTaxInstance->getDisplayName();
        }
        if ($orgTaxInstance->getValue() != null) {
            $orgTaxJson['value'] = $orgTaxInstance->getValue();
        }
        
        return $orgTaxJson;
    }
    
    public function constructJSONForUser($userInstanceArray)
    {
        $userArray = array();
        foreach ($userInstanceArray as $user) {
            $userInfoJson = array();
            $userRole = $user->getRole();
            if ($userRole != null) {
                $userInfoJson['role'] = $userRole->getId();
            }
            $userProfile = $user->getProfile();
            if ($userProfile != null) {
                $userInfoJson['profile'] = $userProfile->getId();
            }
            if ($user->getCountry() != null) {
                $userInfoJson['country'] = $user->getCountry();
            }
            if ($user->getName() != null) {
                $userInfoJson['name'] = $user->getName();
            }
            if ($user->getCity() != null) {
                $userInfoJson['city'] = $user->getCity();
            }
            if ($user->getSignature() != null) {
                $userInfoJson['signature'] = $user->getSignature();
            }
            if ($user->getNameFormat() != null) {
                $userInfoJson['name_format'] = $user->getNameFormat();
            }
            if ($user->getLanguage() != null) {
                $userInfoJson['language'] = $user->getLanguage();
            }
            if ($user->getLocale() != null) {
                $userInfoJson['locale'] = $user->getLocale();
            }
            if ($user->isPersonalAccount() != null) {
                $userInfoJson['personal_account'] = (boolean) $user->isPersonalAccount();
            }
            if ($user->getDefaultTabGroup() != null) {
                $userInfoJson['default_tab_group'] = $user->getDefaultTabGroup();
            }
            if ($user->getStreet() != null) {
                $userInfoJson['street'] = $user->getStreet();
            }
            if ($user->getAlias() != null) {
                $userInfoJson['alias'] = $user->getAlias();
            }
            if ($user->getState() != null) {
                $userInfoJson['state'] = $user->getState();
            }
            if ($user->getCountryLocale() != null) {
                $userInfoJson['country_locale'] = $user->getCountryLocale();
            }
            if ($user->getFax() != null) {
                $userInfoJson['fax'] = $user->getFax();
            }
            if ($user->getFirstName() != null) {
                $userInfoJson['first_name'] = $user->getFirstName();
            }
            if ($user->getEmail() != null) {
                $userInfoJson['email'] = $user->getEmail();
            }
            if ($user->getZip() != null) {
                $userInfoJson['zip'] = $user->getZip();
            }
            if ($user->getDecimalSeparator() != null) {
                $userInfoJson['decimal_separator'] = $user->getDecimalSeparator();
            }
            if ($user->getWebsite() != null) {
                $userInfoJson['website'] = $user->getWebsite();
            }
            if ($user->getTimeFormat() != null) {
                $userInfoJson['time_format'] = $user->getTimeFormat();
            }
            if ($user->getMobile() != null) {
                $userInfoJson['mobile'] = $user->getMobile();
            }
            if ($user->getLastName() != null) {
                $userInfoJson['last_name'] = $user->getLastName();
            }
            if ($user->getTimeZone() != null) {
                $userInfoJson['time_zone'] = $user->getTimeZone();
            }
            if ($user->getPhone() != null) {
                $userInfoJson['phone'] = $user->getPhone();
            }
            if ($user->getDob() != null) {
                $userInfoJson['dob'] = $user->getDob();
            }
            if ($user->getDateFormat() != null) {
                $userInfoJson['date_format'] = $user->getDateFormat();
            }
            if ($user->getStatus() != null) {
                $userInfoJson['status'] = $user->getStatus();
            }
            $customFields = $user->getData();
            foreach ($customFields as $key => $value) {
                $userInfoJson[$key] = $value;
            }
            array_push($userArray, $userInfoJson);
        }
        return json_encode(array(
            "users" => $userArray
        ));
    }
    
    public function getAllProfiles()
    {
        try {
            $this->urlPath = "settings/profiles";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $profiles = $responseJSON['profiles'];
            $profileInstanceArray = array();
            foreach ($profiles as $profile) {
                array_push($profileInstanceArray, self::getZCRMProfile($profile));
            }
            $responseInstance->setData($profileInstanceArray);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getProfile($profileId)
    {
        try {
            $this->urlPath = "settings/profiles/" . $profileId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $profiles = $responseJSON['profiles'];
            $responseInstance->setData(self::getZCRMProfile($profiles[0]));
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getZCRMProfile($profileDetails)
    {
        $profileInstance = ZCRMProfile::getInstance($profileDetails['id'], $profileDetails['name']);
        $profileInstance->setCreatedTime($profileDetails['created_time']);
        $profileInstance->setModifiedTime($profileDetails['modified_time']);
        $profileInstance->setDescription($profileDetails['description']);
        $profileInstance->setCategory($profileDetails['category']);
        if ($profileDetails['modified_by'] != null) {
            $profileInstance->setModifiedBy(ZCRMUser::getInstance($profileDetails['modified_by']['id'], $profileDetails['modified_by']['name']));
        }
        if ($profileDetails['created_by'] != null) {
            $profileInstance->setCreatedBy(ZCRMUser::getInstance($profileDetails['created_by']['id'], $profileDetails['created_by']['name']));
        }
        if (isset($profileDetails['permissions_details'])) {
            $permissions = $profileDetails['permissions_details'];
            foreach ($permissions as $permission) {
                $perIns = ZCRMPermission::getInstance($permission['name'], $permission['id']);
                $perIns->setDisplayLabel($permission['display_label']);
                $perIns->setModule($permission['module']);
                $perIns->setEnabled(boolval($permission['enabled']));
                $profileInstance->addPermission($perIns);
            }
        }
        if (isset($profileDetails['sections'])) {
            $sections = $profileDetails['sections'];
            foreach ($sections as $section) {
                $zcrmProfileSection = ZCRMProfileSection::getInstance($section['name']);
                if (isset($section['categories'])) {
                    $categories = $section['categories'];
                    foreach ($categories as $category) {
                        $categoryIns = ZCRMProfileCategory::getInstance($category['name']);
                        $categoryIns->setDisplayLabel($category['display_label']);
                        $categoryIns->setPermissionIds($category['permissions_details']);
                        if (isset($category['module'])) {
                            $categoryIns->setModule($category['module']);
                        }
                        $zcrmProfileSection->addCategory($categoryIns);
                    }
                }
                $profileInstance->addSection($zcrmProfileSection);
            }
        }
        return $profileInstance;
    }
    
    public function getUser($userId)
    {
        try {
            $this->urlPath = "users/" . $userId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $users = $responseJSON['users'];
            $responseInstance->setData(self::getZCRMUser($users[0]));
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getUsers($param_map,$header_map,$type)
    {
        try {
            $this->urlPath = "users";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            foreach($param_map as $key=>$value){
                if($value!=null)$this->addParam($key,$value);
            }
            foreach($header_map as $key=>$value){
                if($value!=null)$this->addHeader($key,$value);
            }
            if ($type != null) {
                $this->addParam('type', $type);
            }
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $users = $responseJSON['users'];
            $userInstanceArray = array();
            foreach ($users as $user) {
                array_push($userInstanceArray, self::getZCRMUser($user));
            }
            $responseInstance->setData($userInstanceArray);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function searchUsersByCriteria($criteria,$param_map)
    {
        try {
            $this->urlPath = "users/search";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            foreach($param_map as $key=>$value){
                if($value!=null)$this->addParam($key,$value);
            }
            $this->addParam('criteria',$criteria);
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $users = $responseJSON['users'];
            $userInstanceArray = array();
            foreach ($users as $user) {
                array_push($userInstanceArray, self::getZCRMUser($user));
            }
            $responseInstance->setData($userInstanceArray);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getAllUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'AllUsers');
    }
    
    public function getAllDeactiveUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'DeactiveUsers');
    }
    
    public function getAllActiveUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'ActiveUsers');
    }
    
    public function getAllConfirmedUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'ConfirmedUsers');
    }
    
    public function getAllNotConfirmedUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'NotConfirmedUsers');
    }
    
    public function getAllDeletedUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'DeletedUsers');
    }
    
    public function getAllActiveConfirmedUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'ActiveConfirmedUsers');
    }
    
    public function getAllAdminUsers($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'AdminUsers');
    }
    
    public function getAllActiveConfirmedAdmins($param_map,$header_map)
    {
        return self::getUsers($param_map,$header_map,'ActiveConfirmedAdmins');
    }
    
    public function getCurrentUser()
    {
        return self::getUsers(array(),array(),'CurrentUser');
    }
    
    public function getZCRMUser($userDetails)
    {
        $userInstance = ZCRMUser::getInstance($userDetails['id'], isset($userDetails['name']) ? $userDetails['name'] : null);
        $userInstance->setCountry(isset($userDetails['country']) ? $userDetails['country'] : null);
        $roleInstance = ZCRMRole::getInstance($userDetails['role']['id'], $userDetails['role']['name']);
        $userInstance->setRole($roleInstance);
        if (array_key_exists("customize_info", $userDetails)) {
            $userInstance->setCustomizeInfo(self::getZCRMUserCustomizeInfo($userDetails['customize_info']));
        }
        $userInstance->setCity($userDetails['city']);
        $userInstance->setSignature(isset($userDetails['signature']) ? $userDetails['signature'] : null);
        
        $userInstance->setNameFormat(isset($userDetails['name_format']) ? $userDetails['name_format'] : null);
        $userInstance->setLanguage($userDetails['language']);
        $userInstance->setLocale($userDetails['locale']);
        $userInstance->setPersonalAccount(isset($userDetails['personal_account']) ? $userDetails['personal_account'] : null);
        $userInstance->setDefaultTabGroup(isset($userDetails['default_tab_group']) ? $userDetails['default_tab_group'] : null);
        $userInstance->setAlias($userDetails['alias']);
        $userInstance->setStreet($userDetails['street']);
        if (array_key_exists("theme", $userDetails)) {
            $userInstance->setTheme(self::getZCRMUserTheme($userDetails['theme']));
        }
        $userInstance->setState($userDetails['state']);
        $userInstance->setCountryLocale($userDetails['country_locale']);
        $userInstance->setFax($userDetails['fax']);
        $userInstance->setFirstName($userDetails['first_name']);
        $userInstance->setEmail($userDetails['email']);
        $userInstance->setZip($userDetails['zip']);
        $userInstance->setDecimalSeparator(isset($userDetails['decimal_separator']) ? $userDetails['decimal_separator'] : null);
        $userInstance->setWebsite($userDetails['website']);
        $userInstance->setTimeFormat($userDetails['time_format']);
        $profile = ZCRMProfile::getInstance($userDetails['profile']['id'], $userDetails['profile']['name']);
        $userInstance->setProfile($profile);
        $userInstance->setMobile($userDetails['mobile']);
        $userInstance->setLastName($userDetails['last_name']);
        $userInstance->setTimeZone($userDetails['time_zone']);
        $userInstance->setZuid($userDetails['zuid']);
        $userInstance->setConfirm($userDetails['confirm']);
        $userInstance->setFullName($userDetails['full_name']);
        $userInstance->setPhone($userDetails['phone']);
        $userInstance->setDob($userDetails['dob']);
        $userInstance->setDateFormat($userDetails['date_format']);
        $userInstance->setStatus($userDetails['status']);
        $userInstance->setTerritories(isset($userDetails['territories']) ? $userDetails['territories'] : null);
        $userInstance->setReportingTo(isset($userDetails['reporting_to']) ? $userDetails['reporting_to'] : null);
        $userInstance->setCreatedBy($userDetails['created_by']);
        $userInstance->setModifiedBy($userDetails['Modified_By']);
        $userInstance->setIsOnline($userDetails['Isonline']);
        $userInstance->setCurrency(isset($userDetails['Currency']) ? $userDetails['Currency'] : null);
        $userInstance->setCreatedTime($userDetails['created_time']);
        $userInstance->setModifiedTime($userDetails['Modified_Time']);
        foreach ($userDetails as $key => $value) {
            if (! in_array($key, ZCRMUser::$defaultKeys)) {
                $userInstance->setFieldValue($key, $value);
            }
        }
        
        return $userInstance;
    }
    
    public function getZCRMUserCustomizeInfo($customizeInfo)
    {
        $customizeInfoInstance = ZCRMUserCustomizeInfo::getInstance();
        if ($customizeInfo['notes_desc'] != null) {
            $customizeInfoInstance->setNotesDesc($customizeInfo['notes_desc']);
        }
        if ($customizeInfo['show_right_panel'] != null) {
            $customizeInfoInstance->setIsToShowRightPanel((boolean) $customizeInfo['show_right_panel']);
        }
        if ($customizeInfo['bc_view'] != null) {
            $customizeInfoInstance->setBcView($customizeInfo['bc_view']);
        }
        if ($customizeInfo['show_home'] != null) {
            $customizeInfoInstance->setIsToShowHome((boolean) $customizeInfo['show_home']);
        }
        if ($customizeInfo['show_detail_view'] != null) {
            $customizeInfoInstance->setIsToShowDetailView((boolean) $customizeInfo['show_detail_view']);
        }
        if ($customizeInfo['unpin_recent_item'] != null) {
            $customizeInfoInstance->setUnpinRecentItem($customizeInfo['unpin_recent_item']);
        }
        return $customizeInfoInstance;
    }
    
    public function getZCRMUserTheme($themeDetails)
    {
        $themeInstance = ZCRMUserTheme::getInstance();
        $themeInstance->setNormalTabFontColor($themeDetails['normal_tab']['font_color']);
        $themeInstance->setNormalTabBackground($themeDetails['normal_tab']['background']);
        $themeInstance->setSelectedTabFontColor($themeDetails['selected_tab']['font_color']);
        $themeInstance->setSelectedTabBackground($themeDetails['selected_tab']['background']);
        
        return $themeInstance;
    }
}