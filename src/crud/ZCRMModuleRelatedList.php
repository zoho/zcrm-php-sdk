<?php

namespace ZCRM\crud;

class ZCRMModuleRelatedList {
    private $apiName = null;
    private $module = null;
    private $displayLabel = null;
    private $visible = null;
    private $name = null;
    private $id = null;
    private $href = null;
    private $type = null;

    private function __construct($apiName) {
        $this->apiName = $apiName;
    }

    public static function getInstance($apiName) {
        return new ZCRMModuleRelatedList($apiName);
    }

    public function setApiName($apiName) {
        $this->apiName = $apiName;
    }

    /**
     * apiName
     * @return APIName
     */
    public function getApiName() {
        return $this->apiName;
    }

    /**
     * module
     * @return module
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * module
     * @param $module
     * @return ZCRMModuleRelatedList
     */
    public function setModule($module) {
        $this->module = $module;
    }

    /**
     * displayLabel
     * @return mixed Unknown
     */
    public function getDisplayLabel() {
        return $this->displayLabel;
    }

    /**
     * displayLabel
     * @param mixed $displayLabel Unknown
     * @return ZCRMModuleRelatedList
     */
    public function setDisplayLabel($displayLabel) {
        $this->displayLabel = $displayLabel;
    }

    /**
     * visible
     * @return mixed Unknown
     */
    public function isVisible() {
        return $this->visible;
    }

    /**
     * visible
     * @param mixed $visible Unknown
     * @return ZCRMModuleRelatedList
     */
    public function setVisible($visible) {
        $this->visible = $visible;
    }

    /**
     * name
     * @return mixed Unknown
     */
    public function getName() {
        return $this->name;
    }

    /**
     * name
     * @param mixed $name Unknown
     * @return ZCRMModuleRelatedList
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * id
     * @return mixed Unknown
     */
    public function getId() {
        return $this->id;
    }

    /**
     * id
     * @param mixed $id Unknown
     * @return ZCRMModuleRelatedList
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * href
     * @return mixed Unknown
     */
    public function getHref() {
        return $this->href;
    }

    /**
     * href
     * @param mixed $href Unknown
     * @return ZCRMModuleRelatedList
     */
    public function setHref($href) {
        $this->href = $href;
    }

    /**
     * type
     * @return mixed Unknown
     */
    public function getType() {
        return $this->type;
    }

    /**
     * type
     * @param mixed $type Unknown
     * @return ZCRMModuleRelatedList
     */
    public function setType($type) {
        $this->type = $type;
    }

    public function setRelatedListProperties($relatedListDetails) {
        $this->setModule($relatedListDetails['module']);
        $this->setDisplaylabel($relatedListDetails['display_label']);
        $this->setId($relatedListDetails['id'] + 0);
        $this->setName($relatedListDetails['name']);
        $this->setType($relatedListDetails['type']);
        $this->setHref($relatedListDetails['href']);
        $this->setVisible(isset($relatedListDetails['visible']) ? (boolean)$relatedListDetails['visible'] : false);
        return $this;
    }

}

?>
