<?php

namespace ZCRM\crud;

class ZCRMLayout {
    private $id = null;
    private $name = null;
    private $createdTime = null;
    private $modifiedTime = null;
    private $visible = null;
    private $modifiedBy = null;
    private $accessibleProfiles = null;
    private $createdBy = null;
    private $sections = null;
    private $status = null;
    private $convertMapping = array();


    private function __construct($id) {
        $this->id = $id;
    }

    public static function getInstance($id) {
        return new ZCRMLayout($id);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }

    public function getCreatedTime() {
        return $this->createdTime;
    }

    public function setModifiedTime($modifiedTime) {
        $this->modifiedTime = $modifiedTime;
    }

    public function getModifiedTime() {
        return $this->modifiedTime;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }

    public function isVisible() {
        return $this->visible;
    }

    public function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }

    public function getModifiedBy() {
        return $this->modifiedBy;
    }

    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    public function getCreatedBy() {
        return $this->createdBy;
    }

    public function setAccessibleProfiles($profiles) {
        $this->accessibleProfiles = $profiles;
    }

    public function getAccessibleProfiles() {
        return $this->accessibleProfiles;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setSections($sections) {
        $this->sections = $sections;
    }

    public function getSections() {
        return $this->sections;
    }

    /**
     * convertMapping
     * @return array
     */
    public function getConvertMapping() {
        return $this->convertMapping;
    }

    /**
     * convertMapping
     * @param $module , $convertMap
     */
    public function addConvertMapping($module, $convertMap) {
        $this->convertMapping[$module] = $convertMap;
    }

}

?>