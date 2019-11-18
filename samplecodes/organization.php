
<?php

require_once __DIR__ . '/../vendor/autoload.php';
use zcrmsdk\crm\setup\org\ZCRMOrganization;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\setup\users\ZCRMProfile;
use zcrmsdk\crm\setup\users\ZCRMRole;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\crud\ZCRMOrgTax;


class Org
{

    public function __construct()
    {
        $configuration = [];
        ZCRMRestClient::initialize($configuration);
    }

    public function getUser()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $responseIns = $orgIns->getUser("{user_id}"); // to get the user
        $userInstance = $responseIns->getData(); // to get the user data in form ZCRMUser instance

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
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function getAllUsers()
    {
        $orgIns = ZCRMOrganization::getInstance(); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllUsers($param_map,$header_map); // to get all the user
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllActiveUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllActiveUsers($param_map,$header_map); // to get all the active users
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllDeactiveUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllDeactiveUsers($param_map,$header_map); // to get all the deactivated users
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllConfirmedUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllConfirmedUsers($param_map,$header_map); // to get all the confirmer users
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllNotConfirmedUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllNotConfirmedUsers($param_map,$header_map); // to get all the unconfirmed users
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllDeletedUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllDeletedUsers($param_map,$header_map); // to get all the deleted users
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllActiveConfirmedUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllActiveConfirmedUsers($param_map,$header_map); // to get all the active and confirmed users
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllAdminUsers()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllAdminUsers($param_map,$header_map); // to get all the administrators
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getAllActiveConfirmedAdmins()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $orgIns->getAllActiveConfirmedAdmins($param_map,$header_map); // to get all the confirmed administrators
        $userInstances = $response->getData(); // to get the array of users in form of ZCRMUser instances
        foreach ($userInstances as $userInstance) {
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

    public function getCurrentUser()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        
        $response = $orgIns->getCurrentUser(); // to get the current user
        $userInstance = $response->getData(); // to get the user in form of ZCRMUser instance
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

    public function deleteUser()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $orgIns->deleteUser("{user_id}"); // to delete the user
    }

    public function createUser()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $user = ZCRMUser::getInstance(NULL, NULL); // to get the user instance
        $user->setLastName("subject"); // to set the last name of the user
        $user->setFirstName("test"); // to set the first name of the user
        $user->setEmail("test1@gmail.com"); // to set the email id of the user
        $role = ZCRMRole::getInstance("{role_id}", "{role_name}"); // to get the role
        $user->setRole($role); // to get the role of the user
        $profile = ZCRMProfile::getInstance("{profile_id}", "{profile_name}"); // to get the profile
        $user->setProfile($profile); // to set the profile of the user
        $responseIns = $orgIns->createUser($user); // to create the user
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function updateUser()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $user = ZCRMUser::getInstance("{user_id}", "{user_name}"); // to get the user
        $user->setId("{user_id}"); // to set the id of the user
        $user->setFax("321432423423"); // to set the fax number of the user
        $user->setMobile("4234234232"); // to set the mobile number of the user
        $user->setPhone("2342342342"); // to set the phone number of the user
        $user->setStreet("sddsfdsfd"); // to set the street name of the user
        $user->setAlias("test"); // to set the alias of the user
        $user->setWebsite("www.zoho.com"); // to set the website of the user
        $user->setCity("chennai"); // to set the city of the user
        $user->setCountry("India"); // to set the country of the user
        $user->setState("Tamil nadu"); // to set the state of the user
        $user->setZip("6000010"); // to set the zip code of the user
        $responseIns = $orgIns->updateUser($user); // to update the user
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function getorgtaxes()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $orgTaxes = $orgIns->getOrganizationTaxes()->getData();
        foreach ($orgTaxes as $orgTax) {
            echo $orgTax->getId() . "\n";
            echo $orgTax->getName() . "\n";
            echo $orgTax->getDisplayName() . "\n";
            echo $orgTax->getValue() . "\n";
        }
    }

    public function getorgtax()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}");// to get the organization instance
        $orgTax = $orgIns->getOrganizationTax( "{orgTax_id}")->getData();
        echo $orgTax->getId() . "\n";
        echo $orgTax->getName() . "\n";
        echo $orgTax->getDisplayName() . "\n";
        echo $orgTax->getValue() . "\n";
    }

    public function createorgtaxes()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}");// to get the organization instance
        $orgTax = ZCRMOrgTax::getInstance("{orgTax_name}", NULL);
        $orgTax->setValue("3");
        $orgTaxInstances = array();
        array_push($orgTaxInstances, $orgTax);
        $responseIns = $orgIns->createOrganizationTaxes($orgTaxInstances);
        foreach ($responseIns->getEntityResponses() as $responseIn) {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIn->getStatus(); // To get response status
            echo "Message:" . $responseIn->getMessage(); // To get response message
            echo "Code:" . $responseIn->getCode(); // To get status code
            echo "Details:" . json_encode($responseIn->getDetails());
        }
    }

    public function updateorgtaxes()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $orgTax = ZCRMOrgTax::getInstance("{orgTax_name}","{orgTax_id}");
        $orgTax->setValue("3");
        $orgTaxInstances = array();
        array_push($orgTaxInstances, $orgTax);
        $responseIns = $orgIns->updateOrganizationTaxes($orgTaxInstances);
        foreach ($responseIns->getEntityResponses() as $responseIn) {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIn->getStatus(); // To get response status
            echo "Message:" . $responseIn->getMessage(); // To get response message
            echo "Code:" . $responseIn->getCode(); // To get status code
            echo "Details:" . json_encode($responseIn->getDetails());
        }
    }

    public function deleteorgtax()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $responseIn = $orgIns->deleteOrganizationTax("{orgTax_id}");
        echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIn->getStatus(); // To get response status
        echo "Message:" . $responseIn->getMessage(); // To get response message
        echo "Code:" . $responseIn->getCode(); // To get status code
        echo "Details:" . json_encode($responseIn->getDetails());
    }

    public function deleteorgtaxes()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}");// to get the organization instance
        $orgTaxids = array(
            "{orgTax_id}","{orgTax_id}","{orgTax_id}"
        );
        $responseIns = $orgIns->deleteOrganizationTaxes($orgTaxids);
        foreach ($responseIns->getEntityResponses() as $responseIn) {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIn->getStatus(); // To get response status
            echo "Message:" . $responseIn->getMessage(); // To get response message
            echo "Code:" . $responseIn->getCode(); // To get status code
            echo "Details:" . json_encode($responseIn->getDetails());
        }
    }

    public function getAllProfiles()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $response = $orgIns->getAllProfiles(); // to get the profiles
        $profiles = $response->getData(); // to get the profiles in form of array of ZCRMProfile
        foreach ($profiles as $profile) {
            echo $profile->getId(); // to get the id of the profile
            echo $profile->getName(); // to get the name of the profile
            echo $profile->isDefaultProfile(); // to check whether the profile is default
            echo $profile->getCreatedTime(); // to get the created time of the profile
            echo $profile->getModifiedTime(); // to get the modified time of the profile
            $userInstance = $profile->getModifiedBy(); // to get the user who modified the profile
            if ($userInstance != NULL) {
                echo $userInstance->getId(); // to get the user id
                echo $userInstance->getName(); // to get the user name
            }
            echo $profile->getDescription(); // to get the profile description
            $userInstance = $profile->getCreatedBy(); // to get the user who created the profile
            if ($userInstance != NULL) {
                echo $userInstance->getId(); // to get the profile id
                echo $userInstance->getName(); // to get the profile name
            }
            echo $profile->getCategory(); // to get the category of the profile
            $permissions = $profile->getPermissionList(); // to get the permissions of the profile
            foreach ($permissions as $permission) {
                echo $permission->getDisplayLabel(); // to get the display labnel of the permission
                echo $permission->getModule(); // to get the module name of the permission
                echo $permission->getId(); // to get the id of the permission
                echo $permission->getName(); // to get the name of the permission
                echo $permission->isEnabled(); // to check whether the permission is enabled
            }
            $sections = $profile->getSectionsList(); // to get the section list of the profile
            foreach ($sections as $section) {
                echo $section->getName(); // to get the name of the section
                $profilecategories = $section->getCategories(); // to get the categories of the profile sections
                foreach ($profilecategories as $profilecategory) {
                    echo $profilecategory->getName(); // to get the name of the category
                    echo $profilecategory->getModule(); // to get the module name to which the category belongs
                    echo $profilecategory->getDisplayLabel(); // to get the display label of the category
                    $permissionIds = $profilecategory->getPermissionIds(); // to get the permission ids of the profile section categories
                    foreach ($permissionIds as $permissionId) {
                        echo $permissionId; // to get the permission id
                    }
                }
            }
        }
    }

    public function getProfile()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $response = $orgIns->getProfile("{profile_id}"); // to get the profile
        $profile = $response->getData(); // to get the profile in form of the ZCRMProfile instance
        echo $profile->getId(); // to get the id of the profile
        echo $profile->getName(); // to get the name of the profile
        echo $profile->isDefaultProfile(); // to check whether the profile is default
        echo $profile->getCreatedTime(); // to get the created time of the profile
        echo $profile->getModifiedTime(); // to get the modified time of the profile
        $userInstance = $profile->getModifiedBy(); // to get the user who modified the profile
        if ($userInstance != NULL) {
            echo $userInstance->getId(); // to get the user id
            echo $userInstance->getName(); // to get the user name
        }
        echo $profile->getDescription(); // to get the profile description
        $userInstance = $profile->getCreatedBy(); // to get the user who created the profile
        if ($userInstance != NULL) {
            echo $userInstance->getId(); // to get the profile id
            echo $userInstance->getName(); // to get the profile name
        }
        echo $profile->getCategory(); // to get the category of the profile
        $permissions = $profile->getPermissionList(); // to get the permissions of the profile
        foreach ($permissions as $permission) {
            echo $permission->getDisplayLabel(); // to get the display labnel of the permission
            echo $permission->getModule(); // to get the module name of the permission
            echo $permission->getId(); // to get the id of the permission
            echo $permission->getName(); // to get the name of the permission
            echo $permission->isEnabled(); // to check whether the permission is enabled
        }
        $sections = $profile->getSectionsList(); // to get the section list of the profile
        foreach ($sections as $section) {
            echo $section->getName(); // to get the name of the section
            $profilecategories = $section->getCategories(); // to get the categories of the profile sections
            foreach ($profilecategories as $profilecategory) {
                echo $profilecategory->getName(); // to get the name of the category
                echo $profilecategory->getModule(); // to get the module name to which the category belongs
                echo $profilecategory->getDisplayLabel(); // to get the display label of the category
                $permissionIds = $profilecategory->getPermissionIds(); // to get the permission ids of the profile section categories
                foreach ($permissionIds as $permissionId) {
                    echo $permissionId; // to get the permission id
                }
            }
        }
    }

    public function getAllRoles()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $response = $orgIns->getAllRoles(); // to get the roles of the organization
        $roles = $response->getData(); // to get the roles in form of array of ZCRMRole instances
        foreach ($roles as $role) {
            echo $role->getName(); // to get the role name
            echo $role->getId(); // to get the role id
            $reportingrole = $role->getReportingTo(); // to get the role id and name to whom user of this role will report to
            if ($reportingrole != null) {
                echo $reportingrole->getId();
                echo $reportingrole->getName();
            }
            echo $role->getDisplayLabel(); // to get the display label of the role
            echo $role->isAdminRole(); // to check whether it is the administrator role
        }
    }

    public function getRole()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $response = $orgIns->getRole("{role_id}"); // to get the role of the organization
        $role = $response->getData(); // to get the role in form ZCRMRole instance
        echo $role->getName(); // to get the role name
        echo $role->getId(); // to get the role id
        $reportingrole = $role->getReportingTo(); // to get the role id and name to whom user of this role will report to
        if ($reportingrole != null) {
            echo $reportingrole->getId();
            echo $reportingrole->getName();
        }
        echo $role->getDisplayLabel(); // to get the display label of the role
        echo $role->isAdminRole(); // to check whether it is the administrator role
    }

    public function searchUsersByCriteria()
    {
        $orgIns = ZCRMOrganization::getInstance("{org_name}", "{org_id}"); // to get the organization instance
        $param_map=array("page"=>"1","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $userInstances = $orgIns->searchUsersByCriteria("{criteria}", $param_map)->getData(); // to get the users of the organization based on criteria 
        foreach ($userInstances as $userInstance) {
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
}

$ob1 = new Org();
$ob1->searchUsersByCriteria();
?>