<?php

namespace ZCRM\users;

class ZCRMRole {
    private $name = null;
    private $id = null;
    private $reportingTo = null;
    private $label = null;
    private $isAdmin = null;

    private function __construct($roleId, $roleName) {
        $this->id = $roleId;
        $this->name = $roleName;
    }

    public static function getInstance($roleId, $roleName) {
        return new ZCRMRole($roleId, $roleName);
    }


    /**
     * get the Name of the Role name
     * @return String
     */
    public function getName() {
        return $this->name;
    }

    /**
     * set the Name of the Role name
     * @param String role name $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * get the Id of the Role
     * @return Long
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the Id of the Role
     * @param Long $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * get the Reporting to role
     * @return ZCRMUser
     */
    public function getReportingTo() {
        return $this->reportingTo;
    }

    /**
     * Set the Reporting to role
     * @param ZCRMUser $reportingTo
     */
    public function setReportingTo($reportingTo) {
        $this->reportingTo = $reportingTo;
    }

    /**
     * get the Role label
     * @return String
     */
    public function getDisplayLabel() {
        return $this->label;
    }

    /**
     * Set the Role label
     * @param String $label
     */
    public function setDisplayLabel($label) {
        $this->label = $label;
    }

    /**
     * Know whether the role is Admin role or not
     * @return boolean
     */
    public function isAdminRole() {
        return $this->isAdmin;
    }

    /**
     * Set the role as Admin role
     * @param boolean $isAdmin
     */
    public function setAdminRole($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

}

?>