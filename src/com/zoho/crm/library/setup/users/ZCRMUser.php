<?php
class ZCRMUser
{
	private $id=null;
	private $name=null;
	private $signature=null;
	private $country=null;
	private $role=null;
	private $customizeInfo=null;
	private $city=null;
	private $nameFormat=null;
	private $language=null;
	private $locale=null;
	private $isPersonalAccount=null;
	private $defaultTabGroup=null;
	private $street=null;
	private $alias=null;
	private $theme=null;
	private $state=null;
	private $countryLocale=null;
	private $fax=null;
	private $firstName=null;
	private $email=null;
	private $zip=null;
	private $decimalSeparator=null;
	private $website=null;
	private $timeFormat=null;
	private $profile=null;
	private $mobile=null;
	private $lastName=null;
	private $timeZone=null;
	private $zuid=null;
	private $isConfirm=null;
	private $fullName=null;
	private $phone=null;
	private $dob=null;
	private $dateFormat=null;
	private $status=null;
	private $createdBy=null;
	private $modifiedBy=null;
	private $territories=null;
	private $reportingTo=null;
	private $isOnline=null;
	private $currency=null;
	private $createdTime=null;
	private $modifiedTime=null;
	private $fieldNameVsValue=array();
	public static $defaultKeys=array("Currency","Modified_Time","created_time","territories","reporting_to","Isonline","created_by","Modified_By","country","id","name","role","customize_info","city","signature","name_format","language","locale","personal_account","default_tab_group","alias","street","theme","state","country_locale","fax","first_name","email","zip","decimal_separator","website","time_format","profile","mobile","last_name","time_zone","zuid","confirm","full_name","phone","dob","date_format","status");
	
	
	private function __construct($id,$name)
	{
		$this->id=$id;
		$this->name=$name;
	}
	
	public static function getInstance($id,$name)
	{
		return new ZCRMUser($id,$name);
	}

	/**
	 * Method to get the field value by api name
	 * @return String
	 */
	public function getFieldValue($apiName){
		return $this->fieldNameVsValue[$apiName];
	}
	
	/**
	 * Method to set the field value for api name
	 * @param $apiName,$value
	 */
	public function setFieldValue($apiName,$value){
		$this->fieldNameVsValue[$apiName] = $value;
	}
	
	public function getData()
	{
		return $this->fieldNameVsValue;
	}
	
    /**
     * id
     * @return Long
     */
    public function getId(){
        return $this->id;
    }

    /**
     * id
     * @param Long $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * name
     * @return String
     */
    public function getName(){
        return $this->name;
    }

    /**
     * name
     * @param String $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * signature
     * @return String
     */
    public function getSignature(){
        return $this->signature;
    }

    /**
     * signature
     * @param String $signature
     */
    public function setSignature($signature){
        $this->signature = $signature;
    }

    /**
     * country
     * @return String
     */
    public function getCountry(){
        return $this->country;
    }

    /**
     * country
     * @param String $country
     */
    public function setCountry($country){
        $this->country = $country;
    }

    /**
     * role
     * @return String
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * role
     * @param String $role
     */
    public function setRole($role){
        $this->role = $role;
    }

    /**
     * customizeInfo
     * @return ZCRMUserCustomizeInfo
     */
    public function getCustomizeInfo(){
        return $this->customizeInfo;
    }

    /**
     * customizeInfo
     * @param ZCRMUserCustomizeInfo $customizeInfo
     */
    public function setCustomizeInfo($customizeInfo){
        $this->customizeInfo = $customizeInfo;
    }

    /**
     * city
     * @return String
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * city
     * @param String $city
     */
    public function setCity($city){
        $this->city = $city;
    }

    /**
     * nameFormat
     * @return String
     */
    public function getNameFormat(){
        return $this->nameFormat;
    }

    /**
     * nameFormat
     * @param String $nameFormat
     */
    public function setNameFormat($nameFormat){
        $this->nameFormat = $nameFormat;
    }

    /**
     * language
     * @return String
     */
    public function getLanguage(){
        return $this->language;
    }

    /**
     * language
     * @param String $language
     */
    public function setLanguage($language){
        $this->language = $language;
    }

    /**
     * locale
     * @return String
     */
    public function getLocale(){
        return $this->locale;
    }

    /**
     * locale
     * @param String $locale
     */
    public function setLocale($locale){
        $this->locale = $locale;
    }

    /**
     * isPersonalAccount
     * @return boolean
     */
    public function isPersonalAccount(){
        return $this->isPersonalAccount;
    }

    /**
     * isPersonalAccount
     * @param boolean $isPersonalAccount
     */
    public function setPersonalAccount($isPersonalAccount){
        $this->isPersonalAccount = $isPersonalAccount;
    }

    /**
     * defaultTabGroup
     * @return String
     */
    public function getDefaultTabGroup(){
        return $this->defaultTabGroup;
    }

    /**
     * defaultTabGroup
     * @param String $defaultTabGroup
     */
    public function setDefaultTabGroup($defaultTabGroup){
        $this->defaultTabGroup = $defaultTabGroup;
    }

    /**
     * street
     * @return String
     */
    public function getStreet(){
        return $this->street;
    }

    /**
     * street
     * @param String $street
     */
    public function setStreet($street){
        $this->street = $street;
    }

    /**
     * alias
     * @return String
     */
    public function getAlias(){
        return $this->alias;
    }

    /**
     * alias
     * @param String $alias
     */
    public function setAlias($alias){
        $this->alias = $alias;
    }

    /**
     * theme
     * @return ZCRMUserTheme
     */
    public function getTheme(){
        return $this->theme;
    }

    /**
     * theme
     * @param ZCRMUserTheme $theme
     */
    public function setTheme($theme){
        $this->theme = $theme;
    }

    /**
     * state
     * @return String
     */
    public function getState(){
        return $this->state;
    }

    /**
     * state
     * @param String $state
     */
    public function setState($state){
        $this->state = $state;
    }

    /**
     * countryLocale
     * @return String
     */
    public function getCountryLocale(){
        return $this->countryLocale;
    }

    /**
     * countryLocale
     * @param String $countryLocale
     */
    public function setCountryLocale($countryLocale){
        $this->countryLocale = $countryLocale;
    }

    /**
     * fax
     * @return String
     */
    public function getFax(){
        return $this->fax;
    }

    /**
     * fax
     * @param String $fax
     */
    public function setFax($fax){
        $this->fax = $fax;
    }

    /**
     * firstName
     * @return String
     */
    public function getFirstName(){
        return $this->firstName;
    }

    /**
     * firstName
     * @param String $firstName
     */
    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    /**
     * email
     * @return String
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * email
     * @param String $email
     */
    public function setEmail($email){
        $this->email = $email;
    }

    /**
     * zip
     * @return String
     */
    public function getZip(){
        return $this->zip;
    }

    /**
     * zip
     * @param String $zip
     */
    public function setZip($zip){
        $this->zip = $zip;
    }

    /**
     * decimalSeparator
     * @return String
     */
    public function getDecimalSeparator(){
        return $this->decimalSeparator;
    }

    /**
     * decimalSeparator
     * @param String $decimalSeparator
     */
    public function setDecimalSeparator($decimalSeparator){
        $this->decimalSeparator = $decimalSeparator;
    }

    /**
     * website
     * @return String
     */
    public function getWebsite(){
        return $this->website;
    }

    /**
     * website
     * @param String $website
     */
    public function setWebsite($website){
        $this->website = $website;
    }

    /**
     * timeFormat
     * @return String
     */
    public function getTimeFormat(){
        return $this->timeFormat;
    }

    /**
     * timeFormat
     * @param String $timeFormat
     */
    public function setTimeFormat($timeFormat){
        $this->timeFormat = $timeFormat;
    }

    /**
     * profile
     * @return ZCRMProfile
     */
    public function getProfile(){
        return $this->profile;
    }

    /**
     * profile
     * @param ZCRMProfile $profile
     */
    public function setProfile($profile){
        $this->profile = $profile;
    }

    /**
     * mobile
     * @return Long
     */
    public function getMobile(){
        return $this->mobile;
    }

    /**
     * mobile
     * @param Long $mobile
     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }

    /**
     * lastName
     * @return String
     */
    public function getLastName(){
        return $this->lastName;
    }

    /**
     * lastName
     * @param String $lastName
     */
    public function setLastName($lastName){
        $this->lastName = $lastName;
    }

    /**
     * timeZone
     * @return String
     */
    public function getTimeZone(){
        return $this->timeZone;
    }

    /**
     * timeZone
     * @param String $timeZone
     */
    public function setTimeZone($timeZone){
        $this->timeZone = $timeZone;
    }

    /**
     * zuid
     * @return Long
     */
    public function getZuid(){
        return $this->zuid;
    }

    /**
     * zuid
     * @param Long $zuid
     */
    public function setZuid($zuid){
        $this->zuid = $zuid;
    }

    /**
     * isConfirm
     * @return boolean
     */
    public function isConfirm(){
        return $this->isConfirm;
    }

    /**
     * isConfirm
     * @param boolean $isConfirm
     */
    public function setConfirm($isConfirm){
        $this->isConfirm = $isConfirm;
    }

    /**
     * fullName
     * @return String
     */
    public function getFullName(){
        return $this->fullName;
    }

    /**
     * fullName
     * @param String $fullName
     */
    public function setFullName($fullName){
        $this->fullName = $fullName;
    }

    /**
     * phone
     * @return Long
     */
    public function getPhone(){
        return $this->phone;
    }

    /**
     * phone
     * @param Long $phone
     */
    public function setPhone($phone){
        $this->phone = $phone;
    }

    /**
     * dob
     * @return String
     */
    public function getDob(){
        return $this->dob;
    }

    /**
     * dob
     * @param String $dob
     */
    public function setDob($dob){
        $this->dob = $dob;
    }

    /**
     * dateFormat
     * @return String
     */
    public function getDateFormat(){
        return $this->dateFormat;
    }

    /**
     * dateFormat
     * @param String $dateFormat
     */
    public function setDateFormat($dateFormat){
        $this->dateFormat = $dateFormat;
    }

    /**
     * status
     * @return String
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * status
     * @param String $status
     */
    public function setStatus($status){
        $this->status = $status;
    }


    /**
     * createdBy
     * @return Object
     */
    public function getCreatedBy(){
        return $this->createdBy;
    }

    /**
     * createdBy
     * @param Object $createdBy
     * @return ZCRMUser
     */
    public function setCreatedBy($createdBy){
        $this->createdBy = $createdBy;
    }

    /**
     * modifiedBy
     * @return Object
     */
    public function getModifiedBy(){
        return $this->modifiedBy;
    }

    /**
     * modifiedBy
     * @param Object $modifiedBy
     * @return ZCRMUser
     */
    public function setModifiedBy($modifiedBy){
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    /**
     * territories
     * @return Array
     */
    public function getTerritories(){
        return $this->territories;
    }

    /**
     * territories
     * @param Array $territories
     * @return ZCRMUser
     */
    public function setTerritories($territories){
        $this->territories = $territories;
    }

    /**
     * reportingTo
     * @return Object
     */
    public function getReportingTo(){
        return $this->reportingTo;
    }

    /**
     * reportingTo
     * @param Object $reportingTo
     * @return ZCRMUser
     */
    public function setReportingTo($reportingTo){
        $this->reportingTo = $reportingTo;
    }

    /**
     * isOnline
     * @return Boolean
     */
    public function getIsOnline(){
        return $this->isOnline;
    }

    /**
     * isOnline
     * @param Boolean $isOnline
     * @return ZCRMUser
     */
    public function setIsOnline($isOnline){
        $this->isOnline = $isOnline;
    }
    
    public function geCurrency(){
    	return $this->currency;
    }
    
    public function setCurrency($currency){
    	$this->currency = $currency;
    }
    /**
     * createdTime
     * @return String
     */
    public function getCreatedTime(){
    	return $this->createdTime;
    }
    
    /**
     * createdTime
     * @param String $createdTime
     */
    public function setCreatedTime($createdTime){
    	$this->createdTime = $createdTime;
    }
    
    /**
     * modifiedTime
     * @return String
     */
    public function getModifiedTime(){
    	return $this->modifiedTime;
    }
    
    /**
     * modifiedTime
     * @param String $modifiedTime
     */
    public function setModifiedTime($modifiedTime){
    	$this->modifiedTime = $modifiedTime;
    }
}
?>