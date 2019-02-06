<?php

namespace ZCRM\crud;

class ZCRMRelatedListProperties {
    private $sortBy = null;
    private $sortOrder = null;
    private $fields = null;

    private function __construct() {

    }

    public static function getInstance() {
        return new ZCRMRelatedListProperties();
    }

    /**
     * sortBy
     * @return mixed Unknown
     */
    public function getSortBy() {
        return $this->sortBy;
    }

    /**
     * sortBy
     * @param mixed $sortBy Unknown
     * @return ZCRMRelatedListProperties
     */
    public function setSortBy($sortBy) {
        $this->sortBy = $sortBy;
    }

    /**
     * sortOrder
     * @return mixed Unknown
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * sortOrder
     * @param mixed $sortOrder Unknown
     * @return ZCRMRelatedListProperties
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

    /**
     * fields
     * @return mixed Unknown
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * fields
     * @param mixed $fields Unknown
     * @return ZCRMRelatedListProperties
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }

}

?>
