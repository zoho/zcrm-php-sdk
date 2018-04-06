<?php

namespace ZCRM\crud;

class ZCRMProfileCategory {
    private $name;
    private $module;
    private $displayLabel;
    private $permissionIds = array();

    private function __construct($name) {
        $this->name = $name;
    }

    public static function getInstance($name) {
        return new ZCRMProfileCategory($name);
    }


    /**
     * name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * name
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * module
     * @return string
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * module
     * @param string $module
     */
    public function setModule($module) {
        $this->module = $module;
    }

    /**
     * displayLabel
     * @return string
     */
    public function getDisplayLabel() {
        return $this->displayLabel;
    }

    /**
     * displayLabel
     * @param string $displayLabel
     */
    public function setDisplayLabel($displayLabel) {
        $this->displayLabel = $displayLabel;
    }

    /**
     * permissionIds
     * @return array
     */
    public function getPermissionIds() {
        return $this->permissionIds;
    }

    /**
     * permissionIds
     * @param array $permissionIds
     */
    public function setPermissionIds($permissionIds) {
        $this->permissionIds = $permissionIds;
    }

}

?>