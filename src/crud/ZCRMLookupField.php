<?php

namespace ZCRM\crud;

class ZCRMLookupField {
    private $apiName = null;
    private $displayLabel = null;
    private $module = null;
    private $id = null;

    private function __construct($apiName) {
        $this->apiName = $apiName;
    }

    public static function getInstance($apiName) {
        return new ZCRMLookupField($apiName);
    }

    public function setModule($module) {
        $this->module = $module;
    }

    public function getModule() {
        return $this->module;
    }

    public function setDisplayLabel($displayLabel) {
        $this->displayLabel = $displayLabel;
    }

    public function getDisplayLabel() {
        return $this->displayLabel;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}

?>