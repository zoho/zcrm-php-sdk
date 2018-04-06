<?php

namespace ZCRM\crud;

class ZCRMLeadConvertMapping {
    private $name;
    private $id;
    private $fields = array();

    private function __construct($name, $id) {
        $this->name = $name;
        $this->id = $id + 0;
    }

    public static function getInstance($name, $id) {
        return new ZCRMLeadConvertMapping($name, $id);
    }

    /**
     * name
     * @return String
     */
    public function getName() {
        return $this->name;
    }

    /**
     * name
     * @param String $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * id
     * @return Long
     */
    public function getId() {
        return $this->id;
    }

    /**
     * id
     * @param Long $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * fields
     * @return array of ZCRMLeadConvertMappingField instances
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * fields
     * @param ZCRMLeadConvertMappingField_Instance
     */
    public function addFields($fieldIns) {
        array_push($this->fields, $fieldIns);
    }

}

?>