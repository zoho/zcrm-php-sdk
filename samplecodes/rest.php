<?php
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
require_once __DIR__ . '/../vendor/autoload.php';

class RestC
{
    
    public function __construct()
    {
        $configuration = [];
        ZCRMRestClient::initialize($configuration);
    }
    
    public function getAllModules()
    {
        $rest = ZCRMRestClient::getInstance(); // to get the rest client
        $modules = $rest->getAllModules()->getData(); // to get the the modules in form of ZCRMModule instances array
        foreach ($modules as $module) {
            echo $module->getModuleName(); // to get the name of the module
            echo $module->getSingularLabel(); // to get the singular label of the module
            echo $module->getPluralLabel(); // to get the plural label of the module
            echo $module->getBusinessCardFieldLimit(); // to get the business card field limit of the module
            echo $module->getAPIName(); // to get the api name of the module
            echo $module->isCreatable(); // to check wther the module is creatable
            echo $module->isConvertable(); // to check wther the module is Convertable
            echo $module->isEditable(); // to check wther the module is editable
            echo $module->isDeletable(); // to check wther the module is deletable
            echo $module->getWebLink(); // to get the weblink
            $user = $module->getModifiedBy(); // to get the user who modified the module in form of ZCRMUser instance
            if ($user != null) {
                $user->getId(); // to get the user id
                $user->getName(); // to get the user name
            }
            echo $module->getModifiedTime(); // to get the modified time of the module in iso 8601 format
            echo $module->isViewable(); // to check whether the module is viewable
            echo $module->isApiSupported(); // to check whether the module is api supported
            echo $module->isCustomModule(); // to check whether it is a custom module
            echo $module->isScoringSupported(); // to check whether the scoring is supported
            echo $module->getId(); // to get the module id
            $BusinessCardFields = $module->getBusinessCardFields(); // to get the business card fields of the module
            foreach ($BusinessCardFields as $BusinessCardField) {
                echo $BusinessCardField;
            }
            $profiles = $module->getAllProfiles(); // to get the profiles of the module in form of ZCRMProfile array instances
            foreach ($profiles as $profile) {
                echo $profile->getId(); // to get the profile id
                echo $profile->getName(); // to get the profile name
            }
            echo $module->isGlobalSearchSupported(); // to check whether the module is global search supported
            echo $module->getSequenceNumber(); // to get the sequence number of the module
        }
    }
    
    public function getModule()
    {
        $rest = ZCRMRestClient::getInstance(); // to get the rest client
        $module = $rest->getModule("{module_api_name}")->getData(); // to get the module in form of ZCRMModule instance
        echo $module->getModuleName(); // to get the name of the module
        echo $module->getSingularLabel(); // to get the singular label of the module
        echo $module->getPluralLabel(); // to get the plural label of the module
        echo $module->getBusinessCardFieldLimit(); // to get the business card field limit of the module
        echo $module->getAPIName(); // to get the api name of the module
        echo $module->isCreatable(); // to check wther the module is creatable
        echo $module->isConvertable(); // to check wther the module is Convertable
        echo $module->isEditable(); // to check wther the module is editable
        echo $module->isDeletable(); // to check wther the module is deletable
        echo $module->getWebLink(); // to get the weblink
        $user = $module->getModifiedBy(); // to get the user who modified the module in form of ZCRMUser instance
        if ($user != null) {
            $user->getId(); // to get the user id
            $user->getName(); // to get the user name
        }
        echo $module->getModifiedTime(); // to get the modified time of the module in iso 8601 format
        echo $module->isViewable(); // to check whether the module is viewable
        echo $module->isApiSupported(); // to check whether the module is api supported
        echo $module->isCustomModule(); // to check whether it is a custom module
        echo $module->isScoringSupported(); // to check whether the scoring is supported
        echo $module->getId(); // to get the module id
        $BusinessCardFields = $module->getBusinessCardFields(); // to get the business card fields of the module
        foreach ($BusinessCardFields as $BusinessCardField) {
            echo $BusinessCardField;
        }
        $profiles = $module->getAllProfiles(); // to get the profiles of the module in form of ZCRMProfile array instances
        foreach ($profiles as $profile) {
            echo $profile->getId(); // to get the profile id
            echo $profile->getName(); // to get the profile name
        }
        echo $module->getDisplayFieldName(); // to get the display field name
        echo $module->getDisplayFieldId(); // to get the display field id
        $relatedlists = $module->getRelatedLists(); // to get the related list of the module in form of ZCRMModuleRelatedList
        if ($relatedlists != null) {
            foreach ($relatedlists as $relatedlist) {
                echo $relatedlist->getApiName(); // to get the api name of the related list
                echo $relatedlist->getModule(); // to get the module api name of the related list
                echo $relatedlist->getDisplayLabel(); // to get the display labelof the related list
                echo $relatedlist->isVisible(); // to check whether the related list is visible
                echo $relatedlist->getName(); // to get the related list's name
                echo $relatedlist->getId(); // to get the related list's id
                echo $relatedlist->getHref(); // to get the related list's href
                echo $relatedlist->getType(); // to get the related lists's type
            }
        }
        $RelatedListProperties = $module->getRelatedListProperties(); // to get the related list properties in form of ZCRMRelatedListProperties instance array
        
        if ($RelatedListProperties != null) {
            echo $RelatedListProperties->getSortBy(); // to get the sort by field of the related list
            echo $RelatedListProperties->getSortOrder(); // to get the sort order of the related list
            $fields = $RelatedListProperties->getFields(); // to get the fields of the related list
            foreach ($fields as $field) {
                echo $field;
            }
        }
        $properties = $module->getProperties(); // to get the properties of the module
        if ($properties != null) {
            foreach ($properties as $property) {
                echo $property;
            }
        }
        echo $module->getPerPage(); // to get the records per page for the module
        $fields = $module->getSearchLayoutFields(); // to get the search layout fields
        if ($fields != null) {
            foreach ($fields as $field) {
                echo $field;
            }
        }
        echo $module->getDefaultTerritoryName(); // to get the default territory name
        echo $module->getDefaultTerritoryId(); // to get the default territory id
        $customview = $module->getDefaultCustomView(); // to get the default custom view of the module in form of ZCRMCustomView instance
        
        if ($customview != null) {
            echo $customview->getDisplayValue(); // to get the display value of the custom view
            echo $customview->isDefault(); // to check whether the custom view is default
            echo $customview->getId(); // to get the id of the custom view
            echo $customview->getName(); // to get the name of the custom view
            echo $customview->getSystemName(); // to get the system name
            echo $customview->getSortBy(); // to get the sort by field of the custom view
            
            $fields = $customview->getFields(); // to get the field names of the custom view
            foreach ($fields as $field) {
                echo $field;
            }
            echo $customview->isFavorite(); // to check whether the custom view is favourite
            echo $customview->getSortOrder(); // to get the sort order
            echo $customview->getCriteriaPattern(); // to get the criteria patter
            $criterias = $customview->getCriteria(); // to get the criterias in form of ZCRMCustomViewCriteria array
            foreach ($criterias as $criteria) {
                echo $criteria->getField(); // to get the field of the criteria
                echo $criteria->getValue(); // to get the value of the criteria
                echo $criteria->getComparator(); // to get the comparator of the criteria
            }
            echo $customview->getModuleAPIName(); // to get the api name of the module to whoich the custom view belongs to
            echo $customview->isOffLine(); // to check whther the custom view is offline
            $categories = $customview->getCategoriesList(); // to get the categories list as an array of ZCRMCustomViewCategory
            foreach ($categories as $category) {
                echo $category->getDisplayValue(); // to get the display value of the category
                echo $category->getActualValue(); // to get the actual value of the category
            }
        }
        echo $module->isGlobalSearchSupported(); // to check whether the module is global search supported
        echo $module->getSequenceNumber(); // to get the sequence number of the module
        echo $module->getDefaultCustomViewId(); // to get the default custom view id
    }
    
    public static function getRecordInstance()
    {
        $rest = ZCRMRestClient::getInstance(); // to get the rest client
        $record_Instance = $rest->getRecordInstance("{module_API_Name}", "record_id"); // to get dummy record object
        return $record_Instance;
    }
    
    public static function getModuleInstance()
    {
        $rest = ZCRMRestClient::getInstance(); // to get the rest client
        $module_Instance = $rest->getModuleInstance("{module_API_Name}"); // to get dummy module object
        return $module_Instance;
    }
    
    public static function getOrganizationInstance()
    {
        $rest = ZCRMRestClient::getInstance(); // to get the rest client
        $organization_Instance = $rest->getOrganizationInstance(); // to get dummy organization object
        return $organization_Instance;
    }
    
    public function getCurrentUser()
    {
        $rest = ZCRMRestClient::getInstance(); // to get the rest client
        $users = $rest->getCurrentUser()->getData(); // to get the users in form of ZCRMUser instances array
        foreach ($users as $userInstance) {
            echo $userInstance->getId(); // to get the user id
            echo $userInstance->getCountry(); // to get the country of the user
            $roleInstance = $userInstance->getRole(); // to get the role of the user in form of ZCRMRole instance
            echo $roleInstance->getId(); // to get the role id
            echo $roleInstance->getName(); // to get the role name
            $customizeInstance = $userInstance->getCustomizeInfo(); // to get the customization information of the user in for of the ZCRMUserCustomizeInfo form
            if ($customizeInstance != null) {
                echo $customizeInstance->getNotesDesc(); // to get the note description
                echo $customizeInstance->getUnpinRecentItem(); // to get the unpinned recent items
                echo $customizeInstance->isToShowRightPanel(); // to check whether the right panel is shown
                echo $customizeInstance->isBcView(); // to check whether the business card view is enabled
                echo $customizeInstance->isToShowHome(); // to check whether the home is shown
                echo $customizeInstance->isToShowDetailView(); // to check whether the detail view is shows
            }
            echo $userInstance->getCity(); // to get the city of the user
            echo $userInstance->getSignature(); // to get the signature of the user
            echo $userInstance->getNameFormat(); // to get the name format of the user
            echo $userInstance->getLanguage(); // to get the language of the user
            echo $userInstance->getLocale(); // to get the locale of the user
            echo $userInstance->isPersonalAccount(); // to check whther this is a personal account
            echo $userInstance->getDefaultTabGroup(); // to get the default tab group
            echo $userInstance->getAlias(); // to get the alias of the user
            echo $userInstance->getStreet(); // to get the street name of the user
            $themeInstance = $userInstance->getTheme(); // to get the theme of the user in form of the ZCRMUserTheme
            if ($themeInstance != null) {
                echo $themeInstance->getNormalTabFontColor(); // to get the normal tab font color
                echo $themeInstance->getNormalTabBackground(); // to get the normal tab background
                echo $themeInstance->getSelectedTabFontColor(); // to get the selected tab font color
                echo $themeInstance->getSelectedTabBackground(); // to get the selected tab background
            }
            echo $userInstance->getState(); // to get the state of the user
            echo $userInstance->getCountryLocale(); // to get the country locale of the user
            echo $userInstance->getFax(); // to get the fax number of the user
            echo $userInstance->getFirstName(); // to get the first name of the user
            echo $userInstance->getEmail(); // to get the email id of the user
            echo $userInstance->getZip(); // to get the zip code of the user
            echo $userInstance->getDecimalSeparator(); // to get the decimal separator
            echo $userInstance->getWebsite(); // to get the website of the user
            echo $userInstance->getTimeFormat(); // to get the time format of the user
            $profile = $userInstance->getProfile(); // to get the user's profile in form of ZCRMProfile
            echo $profile->getId(); // to get the profile id
            echo $profile->getName(); // to get the name of the profile
            echo $userInstance->getMobile(); // to get the mobile number of the user
            echo $userInstance->getLastName(); // to get the last name of the user
            echo $userInstance->getTimeZone(); // to get the time zone of the user
            echo $userInstance->getZuid(); // to get the zoho user id of the user
            echo $userInstance->isConfirm(); // to check whether it is a confirmed user
            echo $userInstance->getFullName(); // to get the full name of the user
            echo $userInstance->getPhone(); // to get the phone number of the user
            echo $userInstance->getDob(); // to get the date of birth of the user
            echo $userInstance->getDateFormat(); // to get the date format
            echo $userInstance->getStatus(); // to get the status of the user
        }
    }
    
    public static function getOrganizationDetails(){
        $rest=ZCRMRestClient::getInstance();//to get the rest client
        $orgIns=$rest->getOrganizationDetails()->getData();//to get the organization in form of ZCRMOrganization instance
        echo $orgIns->getCompanyName();//to get the company name of the organization
        echo $orgIns->getOrgId();//to get the organization id of the organization
        echo $orgIns->getCountryCode();//to get the country code of the organization
        echo $orgIns->getCountry();//to get the the country of the organization
        echo $orgIns->getCurrencyLocale();//to get the country locale of the organization
        echo $orgIns->getFax();//to get the fax number of the organization
        echo $orgIns->getAlias();//to get the alias  of the organization
        echo $orgIns->getDescription();//to get the description of the organization
        echo $orgIns->getStreet();//to get the street name of the organization
        echo $orgIns->getCity();//to get the city name  of the organization
        echo $orgIns->getState();//to get the state  of the organization
        echo $orgIns->getZgid();//to get the zoho group id of the organization
        echo $orgIns->getWebSite();//to get the website  of the organization
        echo $orgIns->getPrimaryEmail();//to get the primary email of the organization
        echo $orgIns->getPrimaryZuid();//to get the primary zoho user id of the organization
        echo $orgIns->getIsoCode();//to get the iso code of the organization
        echo $orgIns->getPhone();//to get the phone number of the organization
        echo $orgIns->getMobile();//to get the mobile number of the organization
        echo $orgIns->getEmployeeCount();//to get the employee count of the organization
        echo $orgIns->getCurrencySymbol();//to get the currency symbol of the organization
        echo $orgIns->getTimeZone();//to get the time zone of the organization
        echo $orgIns->getMcStatus();//to get the multicurrency status of the organization
        echo $orgIns->isGappsEnabled();//to check whether the google apps is enabled
        echo $orgIns->isPaidAccount();//to check whether the account is paid account
        echo $orgIns->getPaidExpiry();//to get the paid expiration
        echo $orgIns->getPaidType();//to get the paid type
        echo $orgIns->getTrialType();//to get the trial type
        echo $orgIns->getTrialExpiry();//to get the trial expiration
        echo $orgIns->getZipCode();//to get the zip code of the organization
    }
}
$obj = new RestC();//object of the class

$obj->getOrganizationDetails();//function call