<?php

namespace ZCRM\crud;

use ZCRM\api\handler\EntityAPIHandler;
use ZCRM\api\handler\MassEntityAPIHandler;

class ZCRMModule {
    private $convertable = null;
    private $creatable = null;
    private $editable = null;
    private $deletable = null;
    private $webLink = null;
    private $singularLabel = null;
    private $pluralLabel = null;
    private $modifiedBy = null;
    private $modifiedTime = null;
    private $viewable = null;
    private $apiSupported = null;
    private $customModule = null;
    private $scoringSupported = null;
    private $id = null;
    private $moduleName = null;
    private $businessCardFieldLimit = null;
    private $apiName = null;
    private $businessCardFields = array();
    private $profiles = array();
    private $displayFieldName = null;
    private $displayFieldId = null;
    private $relatedList = null;
    private $layouts = null;
    private $fields = null;
    private $relatedListProperties = null;
    private $properties = null;
    private $perPage = null;
    private $searchLayoutFields = null;
    private $defaultTerritoryName = null;
    private $defaultTerritoryId = null;
    private $defaultCustomViewId = null;
    private $customView = null;
    private $globalSearchSupported;
    private $sequenceNumber;

    private function __construct($apiName) {
        $this->apiName = $apiName;
    }

    public static function getInstance($apiName) {
        return new ZCRMModule($apiName);
    }

    public function isCreatable() {
        return $this->creatable;
    }

    public function setCreatable($creatable) {
        $this->creatable = $creatable;
    }

    public function isConvertable() {
        return $this->convertable;
    }

    public function setConvertable($convertable) {
        $this->convertable = $convertable;
    }

    public function isEditable() {
        return $this->editable;
    }

    public function setEditable($editable) {
        $this->editable = $editable;
    }

    public function isDeletable() {
        return $this->deletable;
    }

    public function setDeletable($deletable) {
        $this->deletable = $deletable;
    }

    public function getWebLink() {
        return $this->webLink;
    }

    public function setWebLink($webLink) {
        $this->webLink = $webLink;
    }

    public function getSingularLabel() {
        return $this->singularLabel;
    }

    public function setSingularLabel($singularLabel) {
        $this->singularLabel = $singularLabel;
    }

    public function getPluralLabel() {
        return $this->pluralLabel;
    }

    public function setPluralLabel($pluralLabel) {
        $this->pluralLabel = $pluralLabel;
    }

    public function getModifiedBy() {
        return $this->modifiedBy;
    }

    public function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }

    public function getModifiedTime() {
        return $this->modifiedTime;
    }

    public function setModifiedTime($modifiedTime) {
        $this->modifiedTime = $modifiedTime;
    }

    public function isViewable() {
        return $this->viewable;
    }

    public function setViewable($viewable) {
        $this->viewable = $viewable;
    }

    public function isApiSupported() {
        return $this->apiSupported;
    }

    public function setApiSupported($apiSupported) {
        $this->apiSupported = $apiSupported;
    }

    public function isCustomModule() {
        return $this->customModule;
    }

    public function setCustomModule($customModule) {
        $this->customModule = $customModule;
    }

    public function isScoringSupported() {
        return $this->scoringSupported;
    }

    public function setScoringSupported($scoringSupported) {
        $this->scoringSupported = $scoringSupported;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getModuleName() {
        return $this->moduleName;
    }

    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
    }

    public function getBusinessCardFieldLimit() {
        return $this->businessCardFieldLimit;
    }

    public function setBusinessCardFieldLimit($businessCardFieldLimit) {
        $this->businessCardFieldLimit = $businessCardFieldLimit;
    }

    public function setBusinessCardFields($businessCardFields) {
        $this->businessCardFields = $businessCardFields;
    }

    public function getBusinessCardFields() {
        return $this->businessCardFields;
    }

    public function setAPIName($apiName) {
        $this->apiName = $apiName;
    }

    public function getAPIName() {
        return $this->apiName;
    }

    public function setAllProfiles($profiles) {
        $this->profiles = $profiles;
    }

    public function getAllProfiles() {
        return $this->profiles;
    }

    public function setDisplayFieldName($name) {
        $this->displayFieldName = $name;
    }

    public function getDisplayFieldName() {
        return $this->displayFieldName;
    }

    public function setDisplayFieldId($id) {
        $this->displayFieldId = $id;
    }

    public function getDisplayFieldId() {
        return $this->displayFieldId;
    }


    /**
     * relatedList
     * @return ZCRMModuleRelatedList instance
     */
    public function getRelatedLists() {
        return $this->relatedList;
    }

    /**
     * relatedList
     * @param ZCRMModuleRelatedList instance $relatedList
     * @return
     */
    public function setRelatedLists($relatedList) {
        $this->relatedList = $relatedList;
    }

    public function setLayouts($layouts) {
        $this->layouts = $layouts;
    }

    public function getLayouts() {
        return $this->layouts;
    }

    public function setFields($fields) {
        $this->fields = $fields;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setRelatedListProperties($relatedListProp) {
        $this->relatedListProperties = $relatedListProp;
    }

    public function getRelatedListProperties() {
        return $this->relatedListProperties;
    }


    /**
     * properties
     * @return Module Properties
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * properties
     * @param unkown $properties
     */
    public function setProperties($properties) {
        $this->properties = $properties;
    }


    /**
     * Get the value for the number of records has to shown in module list view
     * @return Number
     */
    public function getPerPage() {
        return $this->perPage;
    }

    /**
     * Set the value for the number of records has to shown in module list view
     * @param Number $perPage
     */
    public function setPerPage($perPage) {
        $this->perPage = $perPage;
    }

    /**
     * Get the module search layout fields
     * @return Array
     */
    public function getSearchLayoutFields() {
        return $this->searchLayoutFields;
    }

    /**
     * Set the module search layout fields
     * @param Array $searchLayoutFields
     */
    public function setSearchLayoutFields($searchLayoutFields) {
        $this->searchLayoutFields = $searchLayoutFields;
    }

    /**
     * Get the module's defaultTerritoryName
     * @return String
     */
    public function getDefaultTerritoryName() {
        return $this->defaultTerritoryName;
    }

    /**
     * Set the module's defaultTerritoryName
     * @param String $defaultTerritoryName
     */
    public function setDefaultTerritoryName($defaultTerritoryName) {
        $this->defaultTerritoryName = $defaultTerritoryName;
    }

    /**
     * Get the module's defaultTerritoryId
     * @return Long
     */
    public function getDefaultTerritoryId() {
        return $this->defaultTerritoryId;
    }

    /**
     * Set the module's defaultTerritoryId
     * @param Long $defaultTerritoryId
     */
    public function setDefaultTerritoryId($defaultTerritoryId) {
        $this->defaultTerritoryId = $defaultTerritoryId;
    }

    /**
     * Set the Module Default custom view
     */
    public function setDefaultCustomView($customView) {
        $this->customView = $customView;
    }

    /**
     * Get the Module Default custom view
     */
    public function getDefaultCustomView() {
        return $this->customView;
    }

    /**
     * globalSearchSupported
     * @return boolean
     */
    public function isGlobalSearchSupported() {
        return $this->globalSearchSupported;
    }

    /**
     * globalSearchSupported
     * @param boolean $globalSearchSupported
     */
    public function setGlobalSearchSupported($globalSearchSupported) {
        $this->globalSearchSupported = $globalSearchSupported;
    }

    /**
     * sequenceNumber
     * @return integer
     */
    public function getSequenceNumber() {
        return $this->sequenceNumber;
    }

    /**
     * sequenceNumber
     * @param integer $sequenceNumber
     */
    public function setSequenceNumber($sequenceNumber) {
        $this->sequenceNumber = $sequenceNumber;
    }


    /**
     * Returns the specified field of the module.
     * @return ZCRMFields of the module
     */
    public function getFieldDetails($fieldId) {
        return ModuleAPIHandler::getInstance($this)->getFieldDetails($fieldId);
    }

    /**
     * Returns list of ZCRMFields of the module.
     * @return list of ZCRMFields of the module
     */
    public function getAllFields() {
        return ModuleAPIHandler::getInstance($this)->getAllFields();
    }

    /**
     * Returns all the layouts of the module
     * @return all ZCRMLayouts of the module
     */
    public function getAllLayouts() {
        return ModuleAPIHandler::getInstance($this)->getAllLayouts();
    }

    /**
     * Returns layout with the given layoutId of the module(APIResponse).
     * @param layoutId Id of the layout to be returned
     * @return layout with the given layoutId of the module
     */
    public function getLayoutDetails($layoutId) {
        return ModuleAPIHandler::getInstance($this)->getLayoutDetails($layoutId);
    }

    /**
     * Returns the custom views of the module.
     * @return array of instances of custom views of the module
     */
    public function getAllCustomViews() {
        return ModuleAPIHandler::getInstance($this)->getAllCustomViews();
    }

    /**
     * Returns the custom view details of the module.
     * @return instance of custom views of the module
     */
    public function getCustomView($customViewId) {
        return ModuleAPIHandler::getInstance($this)->getCustomView($customViewId);
    }

    /**
     * Method to update module settings.
     * @return response of the API
     */
    public function updateModuleSettings() {
        return ModuleAPIHandler::getInstance($this)->updateModuleSettings();
    }

    /**
     * Method to update custom views settings.
     * @return response of the API
     */
    public function updateCustomView($customViewInstance) {
        return ModuleAPIHandler::getInstance($this)->updateCustomView($customViewInstance);
    }

    /**
     * Method to get related lists of a module.
     * @return Array of related list instances
     */
    public function getAllRelatedLists() {
        return ModuleAPIHandler::getInstance($this)->getAllRelatedLists();
    }

    /**
     * Method to get the specified related list
     * @return ZCRMModuleRelatedList instance
     */
    public function getRelatedListDetails($relatedListId) {
        return ModuleAPIHandler::getInstance($this)->getRelatedListDetails($relatedListId);
    }


    /**
     * Get module's defaultCustomViewId
     * @return Long
     */
    public function getDefaultCustomViewId() {
        return $this->defaultCustomViewId;
    }

    /**
     * Set module's defaultCustomViewId
     * @param Long $defaultCustomViewId
     */
    public function setDefaultCustomViewId($defaultCustomViewId) {
        $this->defaultCustomViewId = $defaultCustomViewId;
    }

    public function getRecord($entityId) {
        $record = ZCRMRecord::getInstance($this->apiName, $entityId);
        return EntityAPIHandler::getInstance($record)->getRecord();
    }

    public function getRecords($cvId = null, $sortByField = null, $sortOrder = null, $startIndex = 1, $endIndex = 200) {
        return MassEntityAPIHandler::getInstance($this)->getRecords($cvId, $sortByField, $sortOrder, $startIndex, $endIndex);
    }

    public function searchRecords($searchWord, $page = 1, $perPage = 200) {
        return MassEntityAPIHandler::getInstance($this)->searchRecords($searchWord, $page, $perPage);
    }

    public function massUpdateRecords($entityIds, $fieldApiName, $value) {
        return MassEntityAPIHandler::getInstance($this)->massUpdateRecords($entityIds, $fieldApiName, $value);
    }

    public function updateRecords($records) {
        return MassEntityAPIHandler::getInstance($this)->updateRecords($records);
    }

    public function createRecords($records) {
        return MassEntityAPIHandler::getInstance($this)->createRecords($records);
    }

    public function upsertRecords($records) {
        return MassEntityAPIHandler::getInstance($this)->upsertRecords($records);
    }

    public function deleteRecords($entityIds) {
        return MassEntityAPIHandler::getInstance($this)->deleteRecords($entityIds);
    }

    public function getAllDeletedRecords() {
        return MassEntityAPIHandler::getInstance($this)->getAllDeletedRecords();
    }

    public function getRecycleBinRecords() {
        return MassEntityAPIHandler::getInstance($this)->getRecycleBinRecords();
    }

    public function getPermanentlyDeletedRecords() {
        return MassEntityAPIHandler::getInstance($this)->getPermanentlyDeletedRecords();
    }
}

?>