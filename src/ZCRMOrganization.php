<?php

namespace ZCRM;

use ZCRM\api\handler\OrganizationAPIHandler;

//require_once realpath(dirname(__FILE__) . '/../../api/handler/OrganizationAPIHandler.php');

/**
 * Purpose of this method is to call the Organization level APIs like users, profiles, roles, ..etc
 * @author sumanth-3058
 *
 */
class ZCRMOrganization {
    private $company_name;
    private $alias;

    private $orgId;
    private $primary_zuid;
    private $zgid;

    private $primary_email;
    private $website;
    private $mobile;
    private $phone;

    private $employee_count;
    private $description;

    private $time_zone;
    private $iso_code;
    private $currency_locale;
    private $currency_symbol;
    private $street;
    private $state;
    private $city;
    private $country;
    private $zipCode;
    private $country_code;
    private $fax;

    private $mc_status;
    private $gapps_enabled;

    private $paid_expiry;
    private $trial_type;
    private $trial_expiry;
    private $paid;
    private $paid_type;

    private function __construct($orgName, $orgId) {
        $this->orgId = $orgId;
        $this->company_name = $orgName;
    }

    public static function getInstance($orgName = null, $orgId = null) {
        return new ZCRMOrganization($orgName, $orgId);
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function getFax() {
        return $this->fax;
    }

    /**
     * company_name
     * @return String
     */
    public function getCompanyName() {
        return $this->company_name;
    }

    /**
     * company_name
     * @param String $company_name
     */
    public function setCompanyName($company_name) {
        $this->company_name = $company_name;
    }

    /**
     * alias
     * @return String
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * alias
     * @param String $alias
     */
    public function setAlias($alias) {
        $this->alias = $alias;
    }

    /**
     * orgId
     * @return Long
     */
    public function getOrgId() {
        return $this->orgId;
    }

    /**
     * orgId
     * @param Long $orgId
     */
    public function setOrgId($orgId) {
        $this->orgId = $orgId;
    }

    /**
     * primary_zuid
     * @return Long
     */
    public function getPrimaryZuid() {
        return $this->primary_zuid;
    }

    /**
     * primary_zuid
     * @param Long $primary_zuid
     */
    public function setPrimaryZuid($primary_zuid) {
        $this->primary_zuid = $primary_zuid;
    }

    /**
     * zgid
     * @return Long
     */
    public function getZgid() {
        return $this->zgid;
    }

    /**
     * zgid
     * @param Long $zgid
     */
    public function setZgid($zgid) {
        $this->zgid = $zgid;
    }

    /**
     * primary_email
     * @return String
     */
    public function getPrimaryEmail() {
        return $this->primary_email;
    }

    /**
     * primary_email
     * @param String $primary_email
     */
    public function setPrimaryEmail($primary_email) {
        $this->primary_email = $primary_email;
    }

    /**
     * website
     * @return String
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * website
     * @param String $website
     */
    public function setWebsite($website) {
        $this->website = $website;
    }

    /**
     * mobile
     * @return String
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * mobile
     * @param String $mobile
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    /**
     * phone
     * @return String
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * phone
     * @param String $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * employee_count
     * @return integer
     */
    public function getEmployeeCount() {
        return $this->employee_count;
    }

    /**
     * employee_count
     * @param integer $employee_count
     */
    public function setEmployeeCount($employee_count) {
        $this->employee_count = $employee_count;
    }

    /**
     * description
     * @return String
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * description
     * @param String $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * time_zone
     * @return String
     */
    public function getTimeZone() {
        return $this->time_zone;
    }

    /**
     * time_zone
     * @param String $time_zone
     */
    public function setTimeZone($time_zone) {
        $this->time_zone = $time_zone;
    }

    /**
     * iso_code
     * @return String
     */
    public function getIsoCode() {
        return $this->iso_code;
    }

    /**
     * iso_code
     * @param String $iso_code
     */
    public function setIsoCode($iso_code) {
        $this->iso_code = $iso_code;
    }

    /**
     * currency_locale
     * @return String
     */
    public function getCurrencyLocale() {
        return $this->currency_locale;
    }

    /**
     * currency_locale
     * @param String $currency_locale
     */
    public function setCurrencyLocale($currency_locale) {
        $this->currency_locale = $currency_locale;
    }

    /**
     * currency_symbol
     * @return String
     */
    public function getCurrencySymbol() {
        return $this->currency_symbol;
    }

    /**
     * currency_symbol
     * @param String $currency_symbol
     */
    public function setCurrencySymbol($currency_symbol) {
        $this->currency_symbol = $currency_symbol;
    }

    /**
     * street
     * @return String
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * street
     * @param String $street
     */
    public function setStreet($street) {
        $this->street = $street;
    }

    /**
     * state
     * @return String
     */
    public function getState() {
        return $this->state;
    }

    /**
     * state
     * @param String $state
     */
    public function setState($state) {
        $this->state = $state;
    }

    /**
     * city
     * @return String
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * city
     * @param String $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * country
     * @return String
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * country
     * @param String $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * zipCode
     * @return String
     */
    public function getZipCode() {
        return $this->zipCode;
    }

    /**
     * zipCode
     * @param String $zipCode
     */
    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    /**
     * country_code
     * @return String
     */
    public function getCountryCode() {
        return $this->country_code;
    }

    /**
     * country_code
     * @param String $country_code
     */
    public function setCountryCode($country_code) {
        $this->country_code = $country_code;
    }

    /**
     * mc_status
     * @return Boolean
     */
    public function getMcStatus() {
        return $this->mc_status;
    }

    /**
     * mc_status
     * @param Boolean $mc_status
     */
    public function setMcStatus($mc_status) {
        $this->mc_status = $mc_status;
        return $this;
    }

    /**
     * gapps_enabled
     * @return Boolean
     */
    public function isGappsEnabled() {
        return $this->gapps_enabled;
    }

    /**
     * gapps_enabled
     * @param Boolean $gapps_enabled
     */
    public function setGappsEnabled($gapps_enabled) {
        $this->gapps_enabled = $gapps_enabled;
    }

    /**
     * paid_expiry
     * @return String
     */
    public function getPaidExpiry() {
        return $this->paid_expiry;
    }

    /**
     * paid_expiry
     * @param String $paid_expiry
     */
    public function setPaidExpiry($paid_expiry) {
        $this->paid_expiry = $paid_expiry;
    }

    /**
     * trial_type
     * @return String
     */
    public function getTrialType() {
        return $this->trial_type;
    }

    /**
     * trial_type
     * @param String $trial_type
     */
    public function setTrialType($trial_type) {
        $this->trial_type = $trial_type;
    }

    /**
     * trial_expiry
     * @return String
     */
    public function getTrialExpiry() {
        return $this->trial_expiry;
    }

    /**
     * trial_expiry
     * @param String $trial_expiry
     */
    public function setTrialExpiry($trial_expiry) {
        $this->trial_expiry = $trial_expiry;
    }

    /**
     * paid
     * @return Boolean
     */
    public function isPaidAccount() {
        return $this->paid;
    }

    /**
     * paid
     * @param Boolean $paid
     */
    public function setPaidAccount($paid) {
        $this->paid = $paid;
    }

    /**
     * paid_type
     * @return String
     */
    public function getPaidType() {
        return $this->paid_type;
    }

    /**
     * paid_type
     * @param String $paid_type
     */
    public function setPaidType($paid_type) {
        $this->paid_type = $paid_type;
    }


    public function getUser($userId) {
        return OrganizationAPIHandler::getInstance()->getUser($userId);
    }

    public function getAllUsers() {
        return OrganizationAPIHandler::getInstance()->getAllUsers();
    }

    public function getAllActiveUsers() {
        return OrganizationAPIHandler::getInstance()->getAllActiveUsers();
    }

    public function getAllDeactiveUsers() {
        return OrganizationAPIHandler::getInstance()->getAllDeactiveUsers();
    }

    public function getAllConfirmedUsers() {
        return OrganizationAPIHandler::getInstance()->getAllConfirmedUsers();
    }

    public function getAllNotConfirmedUsers() {
        return OrganizationAPIHandler::getInstance()->getAllNotConfirmedUsers();
    }

    public function getAllDeletedUsers() {
        return OrganizationAPIHandler::getInstance()->getAllDeletedUsers();
    }

    public function getAllActiveConfirmedUsers() {
        return OrganizationAPIHandler::getInstance()->getAllActiveConfirmedUsers();
    }

    public function getAllAdminUsers() {
        return OrganizationAPIHandler::getInstance()->getAllAdminUsers();
    }

    public function getAllActiveConfirmedAdmins() {
        return OrganizationAPIHandler::getInstance()->getAllActiveConfirmedAdmins();
    }

    public function getCurrentUser() {
        return OrganizationAPIHandler::getInstance()->getCurrentUser();
    }

    public function getAllProfiles() {
        return OrganizationAPIHandler::getInstance()->getAllProfiles();
    }

    public function getProfile($profileId) {
        return OrganizationAPIHandler::getInstance()->getProfile($profileId);
    }

    public function getAllRoles() {
        return OrganizationAPIHandler::getInstance()->getAllRoles();
    }

    public function getRole($roleId) {
        return OrganizationAPIHandler::getInstance()->getRole($roleId);
    }

    public function createUser($userInstance) {
        return OrganizationAPIHandler::getInstance()->createUser($userInstance);
    }

    public function updateUser($userInstance) {
        return OrganizationAPIHandler::getInstance()->updateUser($userInstance);
    }

    public function deleteUser($userId) {
        return OrganizationAPIHandler::getInstance()->deleteUser($userId);
    }
}

?>