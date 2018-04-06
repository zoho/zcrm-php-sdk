<?php

namespace ZCRM\crud;

class ZCRMCustomViewCategory {
    private $displayValue = null;
    private $actualValue = null;

    private function __construct() {

    }

    public static function getInstance() {
        return new ZCRMCustomViewCategory();
    }

    /**
     * get the displayValue of the custom view category
     * @return String
     */
    public function getDisplayValue() {
        return $this->displayValue;
    }

    /**
     * set the displayValue for the custom view category
     * @param String $displayValue
     */
    public function setDisplayValue($displayValue) {
        $this->displayValue = $displayValue;
    }

    /**
     * get the actual Value of the custom view category
     * @return String
     */
    public function getActualValue() {
        return $this->actualValue;
    }

    /**
     * set the actual Value for the custom view category
     * @param String $actualValue
     */
    public function setActualValue($actualValue) {
        $this->actualValue = $actualValue;
    }

}

?>