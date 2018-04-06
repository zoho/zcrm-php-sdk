<?php

namespace ZCRM\crud;

class ZCRMCustomView {
    private $moduleAPIName = null;
    private $displayValue = null;
    private $default = null;
    private $id = null;
    private $name = null;
    private $systemName = null;
    private $sortBy = null;
    private $category = null;
    private $fields = array();
    private $favorite = null;
    private $sortOrder = null;
    private $criteriaPattern = null;
    private $criteria = null;
    private $categoriesList = array();
    private $offLine = null;

    public function __construct($moduleAPIName, $id) {
        $this->moduleAPIName = $moduleAPIName;
        $this->id = $id;
    }

    public static function getInstance($moduleAPIName = null, $id) {
        return new ZCRMCustomView($moduleAPIName, $id);
    }


    /**
     * Get the display Name of the customView
     * @return unkown
     */
    public function getDisplayValue() {
        return $this->displayValue;
    }

    /**
     * Set the display Name of the customView
     * @param unkown $displayValue
     */
    public function setDisplayValue($displayValue) {
        $this->displayValue = $displayValue;
    }

    /**
     * Method to know whether the custom view is default one or not
     * @return Boolean value
     */
    public function isDefault() {
        return $this->default;
    }

    /**
     * Method to set the custom view as default
     * @param unkown $default
     */
    public function setDefault($default) {
        $this->default = $default;
    }

    /**
     * Get the customview Id
     * @return customViewId
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the customview Id
     * @param  $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Method to get the customview Name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Method to set the customview Name
     * @param  $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Method to get the customview system Name
     * @return System name
     */
    public function getSystemName() {
        return $this->systemName;
    }

    /**
     * Method to set the customview system Name
     * @param  $systemName
     */
    public function setSystemName($systemName) {
        $this->systemName = $systemName;
    }

    /**
     * Method to get the customview SortBy field Name
     * @return sortBy field
     */
    public function getSortBy() {
        return $this->sortBy;
    }

    /**
     * Method to set the customview SortBy field Name
     * @param  $sortBy
     */
    public function setSortBy($sortBy) {
        $this->sortBy = $sortBy;
    }

    /**
     * Method to get the customview Category
     * @return Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Method to set the customview Category
     * @param $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }

    /**
     * Method to get the customview Fields
     * @return custom view fields
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * Method to set the customview Fields
     * @param $fields
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }

    /**
     * Method to check whether the custom view is default one or not
     * @return favorite
     */
    public function isFavorite() {
        return $this->favorite;
    }

    /**
     * Method to set the custom view as default one or not
     * @param $favorite
     */
    public function setFavorite($favorite) {
        $this->favorite = $favorite;
    }

    /**
     * Method to get the custom view sort order
     * @return sortOrder
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Method to set the custom view sort order type
     * @param $sortOrder
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

    /**
     * Method to get the custom view criteria pattern
     * @return CriteriaPattern
     */
    public function getCriteriaPattern() {
        return $this->criteriaPattern;
    }

    /**
     * Method to set the custom view criteria pattern
     * @param  $criteriaPattern
     */
    public function setCriteriaPattern($criteriaPattern) {
        $this->criteriaPattern = $criteriaPattern;
    }

    /**
     * Method to get the custom view criteria
     * @return Criteria
     */
    public function getCriteria() {
        return $this->criteria;
    }

    /**
     * Method to set the custom view criteria
     * @param  $criteria
     */
    public function setCriteria($criteria) {
        $this->criteria = $criteria;
    }


    /**
     * moduleAPIName
     * @return String
     */
    public function getModuleAPIName() {
        return $this->moduleAPIName;
    }

    public function getRecords(String $sortByField = null, String $sortOrder = null, $startIndex = 1, $endIndex = 200) {
        return ZCRMModule::getInstance($apiName)->getRecords($this->id, $sortByField, $sortOrder, $startIndex, $endIndex);
    }


    /**
     * categoriesList
     * @return unkown
     */
    public function getCategoriesList() {
        return $this->categoriesList;
    }

    /**
     * categoriesList
     * @param unkown $categoriesList
     */
    public function setCategoriesList($categoriesList) {
        $this->categoriesList = $categoriesList;
    }


    public function setOffLine($off_line) {
        $this->offLine = (boolean)$off_line;
    }

    public function isOffLine() {
        return $this->offLine;
    }

}

?>