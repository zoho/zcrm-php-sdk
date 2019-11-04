<?php
namespace zcrmsdk\crm\setup\users;

class ZCRMUser
{
    
    /**
     * user id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * user name
     *
     * @var string
     */
    private $name = null;
    
    /**
     * signature of the user
     *
     * @var string
     */
    private $signature = null;
    
    /**
     * country name of the user
     *
     * @var string
     */
    private $country = null;
    
    /**
     * method to get the role of the user
     *
     * @var ZCRMRole
     */
    private $role = null;
    
    /**
     * user customize info
     *
     * @var ZCRMUserCustomizeInfo
     */
    private $customizeInfo = null;
    
    /**
     * city name of the user
     *
     * @var string
     */
    private $city = null;
    
    /**
     * name format of the user
     *
     * @var string
     */
    private $nameFormat = null;
    
    /**
     * language of the user
     *
     * @var string
     */
    private $language = null;
    
    /**
     * locale of the user
     *
     * @var string
     */
    private $locale = null;
    
    /**
     * personal account
     *
     * @var boolean
     */
    private $isPersonalAccount = null;
    
    /**
     * default tab group
     *
     * @var string
     */
    private $defaultTabGroup = null;
    
    /**
     * street name of the user
     *
     * @var string
     */
    private $street = null;
    
    /**
     * alias of the user
     *
     * @var string
     */
    private $alias = null;
    
    /**
     * user theme
     *
     * @var ZCRMUserTheme
     */
    private $theme = null;
    
    /**
     * statename of the user
     *
     * @var string
     */
    private $state = null;
    
    /**
     * country locale of the user
     *
     * @var string
     */
    private $countryLocale = null;
    
    /**
     * fax of the user
     *
     * @var string
     */
    private $fax = null;
    
    /**
     * firstname of the user
     *
     * @var string
     */
    private $firstName = null;
    
    /**
     * email of the user
     *
     * @var string
     */
    private $email = null;
    
    /**
     * zip of the user
     *
     * @var string
     */
    private $zip = null;
    
    /**
     * decimal separator
     *
     * @var string
     */
    private $decimalSeparator = null;
    
    /**
     * website of the user
     *
     * @var string
     */
    private $website = null;
    
    /**
     * time format of the user
     *
     * @var string
     */
    private $timeFormat = null;
    
    /**
     * user profile
     *
     * @var ZCRMProfile
     */
    private $profile = null;
    
    /**
     * mobile number of the user
     *
     * @var String
     */
    private $mobile = null;
    
    /**
     * last name of the user
     *
     * @var string
     */
    private $lastName = null;
    
    /**
     * time zone of the user
     *
     * @var string
     */
    private $timeZone = null;
    
    /**
     * zoho user id
     *
     * @var string
     */
    private $zuid = null;
    
    /**
     * confirm user
     *
     * @var Boolean
     */
    private $isConfirm = null;
    
    /**
     * user full name
     *
     * @var string
     */
    private $fullName = null;
    
    /**
     * phone number of the user
     *
     * @var String
     */
    private $phone = null;
    
    /**
     * date of birth of the user
     *
     * @var string
     */
    private $dob = null;
    
    /**
     * date format of the user
     *
     * @var string
     */
    private $dateFormat = null;
    
    /**
     * user status
     *
     * @var string
     */
    private $status = null;
    
    /**
     * creator user
     *
     * @var ZCRMUser
     */
    private $createdBy = null;
    
    /**
     * modifier user
     *
     * @var ZCRMUser
     */
    private $modifiedBy = null;
    
    /**
     * territories of the user
     *
     * @var array
     */
    private $territories = null;
    
    /**
     * user who the current user reports
     *
     * @var ZCRMUser
     */
    private $reportingTo = null;
    
    /**
     * user online
     *
     * @var boolean
     */
    private $isOnline = null;
    
    /**
     * currency of the user
     *
     * @var string
     */
    private $currency = null;
    
    /**
     * creation time of the user
     *
     * @var string
     */
    private $createdTime = null;
    
    /**
     * modification time of the user
     *
     * @var string
     */
    private $modifiedTime = null;
    
    /**
     * key value pair of the field name and the value
     *
     * @var array
     */
    private $fieldNameVsValue = array();
    
    /**
     * public variables of the user
     *
     * @var array
     */
    public static $defaultKeys = array(
        "Currency",
        "Modified_Time",
        "created_time",
        "territories",
        "reporting_to",
        "Isonline",
        "created_by",
        "Modified_By",
        "country",
        "id",
        "name",
        "role",
        "customize_info",
        "city",
        "signature",
        "name_format",
        "language",
        "locale",
        "personal_account",
        "default_tab_group",
        "alias",
        "street",
        "theme",
        "state",
        "country_locale",
        "fax",
        "first_name",
        "email",
        "zip",
        "decimal_separator",
        "website",
        "time_format",
        "profile",
        "mobile",
        "last_name",
        "time_zone",
        "zuid",
        "confirm",
        "full_name",
        "phone",
        "dob",
        "date_format",
        "status"
    );
    
    /**
     * constructor to assign the user id and user name of the user
     *
     * @param string $id user id
     * @param string $name username
     */
    private function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
    /**
     * method to get the instance of the user
     *
     * @param string $id user id
     * @param string $name user name
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public static function getInstance($id = null, $name = null)
    {
        return new ZCRMUser($id, $name);
    }
    
    /**
     * Method to get the field value by api name
     *
     * @param string $apiName api name of the field
     * @return string the value of the field
     */
    public function getFieldValue($apiName)
    {
        return $this->fieldNameVsValue[$apiName];
    }
    
    /**
     * Method to set the field value for field api name
     *
     * @param string $apiName field api name
     * @param string $value field value
     */
    public function setFieldValue($apiName, $value)
    {
        $this->fieldNameVsValue[$apiName] = $value;
    }
    
    /**
     * method to get the values of the fields of the user
     *
     * @return array array of field name(key) and value (value)
     */
    public function getData()
    {
        return $this->fieldNameVsValue;
    }
    
    /**
     * method to get the user id
     *
     * @return string the user id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the user id
     *
     * @param string $id the user id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the user name
     *
     * @return String the user name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the user name
     *
     * @param String $name the user name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the user signature
     *
     * @return String the user signature
     */
    public function getSignature()
    {
        return $this->signature;
    }
    
    /**
     * method to set the user signature
     *
     * @param String $signature the user signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }
    
    /**
     * method to get the country name of the user
     *
     * @return String the country name of the user
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * method to set the country name of the user
     *
     * @param String $country the country name of the user
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
    
    /**
     * method to get the role of the user
     *
     * @return ZCRMRole the instance of the ZCRMRole class
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * method to set the role of the user
     *
     * @param ZCRMRole $role the instance of the ZCRMRole class
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
    
    /**
     * method to get the customize information of the user
     *
     * @return ZCRMUserCustomizeInfo instance of the ZCRMUserCustomizeInfo class
     */
    public function getCustomizeInfo()
    {
        return $this->customizeInfo;
    }
    
    /**
     * method to set the customize information of the user
     *
     * @param ZCRMUserCustomizeInfo $customizeInfo instance of the ZCRMUserCustomizeInfo class
     */
    public function setCustomizeInfo($customizeInfo)
    {
        $this->customizeInfo = $customizeInfo;
    }
    
    /**
     * method to get the city name of the user
     *
     * @return String the city name of the user
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * method to set the city name of the user
     *
     * @param String $city the city name of the user
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    /**
     * method to get the name format of the user
     *
     * @return String the name format of the user
     */
    public function getNameFormat()
    {
        return $this->nameFormat;
    }
    
    /**
     * method tosget the name format of the user
     *
     * @param String $nameFormat the name format of the user
     */
    public function setNameFormat($nameFormat)
    {
        $this->nameFormat = $nameFormat;
    }
    
    /**
     * method to get the language of the user
     *
     * @return String the language of the user
     */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
     * method to set the language of the user
     *
     * @param String $language the language of the user
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
    
    /**
     * method to get the locale of the user
     *
     * @return String the locale of the user
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * method to set the locale of the user
     *
     * @param String $locale locale of the user
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    
    /**
     * method to check whether the peronal account
     *
     * @return boolean true if the personal account otherwise false
     */
    public function isPersonalAccount()
    {
        return $this->isPersonalAccount;
    }
    
    /**
     * method to set the personal account of the user
     *
     * @param boolean $isPersonalAccount true to set the personal account otherwise false
     */
    public function setPersonalAccount($isPersonalAccount)
    {
        $this->isPersonalAccount = $isPersonalAccount;
    }
    
    /**
     * method to get the default Tab Group
     *
     * @return String the default Tab Group
     */
    public function getDefaultTabGroup()
    {
        return $this->defaultTabGroup;
    }
    
    /**
     * method to set the default Tab Group
     *
     * @param String $defaultTabGroup the default Tab Group
     */
    public function setDefaultTabGroup($defaultTabGroup)
    {
        $this->defaultTabGroup = $defaultTabGroup;
    }
    
    /**
     * method to get the street name of the user
     *
     * @return String the street name of the user
     */
    public function getStreet()
    {
        return $this->street;
    }
    
    /**
     * method to set the street name of the user
     *
     * @param String $street the street name of the user
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }
    
    /**
     * method to get the alias of the user
     *
     * @return String alias of the user
     */
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * method to set the alias of the user
     *
     * @param String $alias alias of the user
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
    
    /**
     * method to get the theme of the user
     *
     * @return ZCRMUserTheme instance of ZCRMUserTheme class
     */
    public function getTheme()
    {
        return $this->theme;
    }
    
    /**
     * method to set the theme of the user
     *
     * @param ZCRMUserTheme $theme instance of ZCRMUserTheme class
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }
    
    /**
     * method to get the state name of the user
     *
     * @return String the state name of the user
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * method to set the state name of the user
     *
     * @param String $state the state name of the user
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * method to get the country Locale of the user
     *
     * @return String the country Locale of the user
     */
    public function getCountryLocale()
    {
        return $this->countryLocale;
    }
    
    /**
     * method to set the country Locale of the user
     *
     * @param String $countryLocale the country Locale of the user
     */
    public function setCountryLocale($countryLocale)
    {
        $this->countryLocale = $countryLocale;
    }
    
    /**
     * method to get the fax of the user
     *
     * @return String the fax of the user
     */
    public function getFax()
    {
        return $this->fax;
    }
    
    /**
     * method to set the fax of the user
     *
     * @param String $fax the fax of the user
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }
    
    /**
     * method to get the first name of the user
     *
     * @return String first name of the user
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * method to set the first name of the user
     *
     * @param String $firstName first name of the user
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * method to get the email of the user
     *
     * @return String the email of the user
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * method to set the email of the user
     *
     * @param String $email the email of the user
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * method to get the zip of the user
     *
     * @return String the zip of the user
     */
    public function getZip()
    {
        return $this->zip;
    }
    
    /**
     * method to set the zip of the user
     *
     * @param String $zip the zip of the user
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }
    
    /**
     * method to get the decimal separator
     *
     * @return String the decimal separator
     */
    public function getDecimalSeparator()
    {
        return $this->decimalSeparator;
    }
    
    /**
     * method to set the decimal separator
     *
     * @param String $decimalSeparator the decimal separator
     */
    public function setDecimalSeparator($decimalSeparator)
    {
        $this->decimalSeparator = $decimalSeparator;
    }
    
    /**
     * method to get the website of the user
     *
     * @return String the website of the user
     */
    public function getWebsite()
    {
        return $this->website;
    }
    
    /**
     * method to set the website of the user
     *
     * @param String $website website of the user
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }
    
    /**
     * method to get the time format of the user
     *
     * @return String the time format of the user
     */
    public function getTimeFormat()
    {
        return $this->timeFormat;
    }
    
    /**
     * method to set the time format of the user
     *
     * @param String $timeFormat time format of the user
     */
    public function setTimeFormat($timeFormat)
    {
        $this->timeFormat = $timeFormat;
    }
    
    /**
     * method to get the profile of the user
     *
     * @return ZCRMProfile ZCRMProfile class instance
     */
    public function getProfile()
    {
        return $this->profile;
    }
    
    /**
     * method to set the profile of the user
     *
     * @param ZCRMProfile $profile ZCRMProfile class instance
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }
    
    /**
     * method to get the mobile number of the user
     *
     * @return String the mobile number of the user
     */
    public function getMobile()
    {
        return $this->mobile;
    }
    
    /**
     * method to set the mobile number of the user
     *
     * @param String $mobile the mobile number of the user
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }
    
    /**
     * method to get the last name of the user
     *
     * @return String the last name of the user
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * method to set the last name of the user
     *
     * @param String $lastName the last name of the user
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    
    /**
     * method to get the time zone of the user
     *
     * @return String the time zone of the user
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }
    
    /**
     * method to set the time zone of the user
     *
     * @param String $timeZone the time zone of the user
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    
    /**
     * method to get the zoho user id of the user
     *
     * @return string the zoho user id of the user
     */
    public function getZuid()
    {
        return $this->zuid;
    }
    
    /**
     * method to set the zoho user id of the user
     *
     * @param string $zuid the zoho user id of the user
     */
    public function setZuid($zuid)
    {
        $this->zuid = $zuid;
    }
    
    /**
     * method to check whether user is a confirm user
     *
     * @return boolean true if the user is a confirm user otherwise false
     */
    public function isConfirm()
    {
        return $this->isConfirm;
    }
    
    /**
     * method to set the user as confirm user
     *
     * @param boolean $isConfirm true to set as confirm user otherwise false
     */
    public function setConfirm($isConfirm)
    {
        $this->isConfirm = $isConfirm;
    }
    
    /**
     * method to get the full name of the user
     *
     * @return String the full name of the user
     */
    public function getFullName()
    {
        return $this->fullName;
    }
    
    /**
     * method to set the full name of the user
     *
     * @param String $fullName the full name of the user
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }
    
    /**
     * method to get the phone number of the user
     *
     * @return String the phone number of the user
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * method to set the phone number of the user
     *
     * @param String $phone the phone number of the user
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    
    /**
     * method to get the date of birth of the user
     *
     * @return String date of birth of the user
     */
    public function getDob()
    {
        return $this->dob;
    }
    
    /**
     * method to set the date of birth of the user
     *
     * @param String $dob date of birth of the user
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }
    
    /**
     * method to get the date format of the user
     *
     * @return String the date format of the user
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }
    
    /**
     * method to set the date format of the user
     *
     * @param String $dateFormat the date format of the user
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }
    
    /**
     * method to get the user status
     *
     * @return String the user status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * method to set the user status
     *
     * @param String $status the user status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * method to get the user who created the user
     *
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * method to set the user who created the user
     *
     * @param ZCRMUser $createdBy instance of the ZCRMUser class
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * method to get the user who modified the user
     *
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * method to set the user who modified the user
     *
     * @param ZCRMUser $modifiedBy instance of the ZCRMUser class
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }
    
    /**
     * method to get the territories of the user
     *
     * @return array array of the territories of the user
     */
    public function getTerritories()
    {
        return $this->territories;
    }
    
    /**
     * method to set the territories of the user
     *
     * @param Array $territories array of the territories of the user
     */
    public function setTerritories($territories)
    {
        $this->territories = $territories;
    }
    
    /**
     * method to get the reporting To user
     *
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public function getReportingTo()
    {
        return $this->reportingTo;
    }
    
    /**
     * method to set the reporting To user
     *
     * @param ZCRMUser $reportingTo instance of the ZCRMUser class
     */
    public function setReportingTo($reportingTo)
    {
        $this->reportingTo = $reportingTo;
    }
    
    /**
     * method to check whether the user is online
     *
     * @return Boolean true if the user is online otherwise false
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }
    
    /**
     * method to set the user online
     *
     * @param Boolean $isOnline true to set the user online otherwise false
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;
    }
    
    /**
     * method to get the currency of the user
     *
     * @return string currency of the user
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    
    /**
     * method to set currency of the user
     *
     * @param string $currency currency of the user
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    
    /**
     * method to get the creation time of the user
     *
     * @return String the creation time of the user in iso 8601 format
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }
    
    /**
     * method to set the creation time of the user
     *
     * @param String $createdTime the creation time of the user in iso 8601 format
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
    
    /**
     * method to get the modification time of the user
     *
     * @return String the modification time of the user in iso 8601 format
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    
    /**
     * method to set the modification time of the user
     *
     * @param String $modifiedTime the modification time of the user in iso 8601 format
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    }
}