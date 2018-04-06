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
     * @return unkown
     */
    public function getSortBy() {
        return $this->sortBy;
    }

    /**
     * sortBy
     * @param unkown $sortBy
     * @return ZCRMRelatedListProperties
     */
    public function setSortBy($sortBy) {
        $this->sortBy = $sortBy;
    }

    /**
     * sortOrder
     * @return unkown
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * sortOrder
     * @param unkown $sortOrder
     * @return ZCRMRelatedListProperties
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

    /**
     * fields
     * @return unkown
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * fields
     * @param unkown $fields
     * @return ZCRMRelatedListProperties
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }

}

?>