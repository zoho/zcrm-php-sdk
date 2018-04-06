<?php

namespace ZCRM\crud;

class ZCRMJunctionRecord {
    private $id;
    private $apiName;
    private $relatedDetails = array();

    private function __construct($apiName, $id) {
        $this->apiName = $apiName;
        $this->id = $id;
    }

    public static function getInstance($apiName, $id) {
        return new ZCRMJunctionRecord($apiName, $id);
    }


    /**
     * id
     * @return Long
     * get the ID of the junction record
     */
    public function getId() {
        return $this->id;
    }

    /**
     * apiName
     * @return String
     * get the API name of the junction record
     */
    public function getApiName() {
        return $this->apiName;
    }

    /**
     * relatedDetails
     * @return Mapping Array
     * returns the related data between the modules
     */
    public function getRelatedDetails() {
        return $this->relatedDetails;
    }

    /**
     * relatedDetails
     * @param Mapping Array $relatedDetails
     * set the related data between the modules (for adding the relation)
     */
    public function setRelatedData($fieldApiName, $value) {
        $this->relatedDetails[$fieldApiName] = $value;
    }

}

?>