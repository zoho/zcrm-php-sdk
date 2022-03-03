<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\api\handler\EntityAPIHandler;
use zcrmsdk\crm\api\handler\MassEntityAPIHandler;
use zcrmsdk\crm\api\handler\ModuleAPIHandler;
use zcrmsdk\crm\api\handler\TagAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\api\response\BulkAPIResponse;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMUser;

class ZCRMModule
{
    
    /**
     *
     * convertable module
     *
     * @var boolean
     */
    private $convertable = null;
    
    /**
     * creatable module
     *
     * @var boolean
     */
    private $creatable = null;
    
    /**
     * editable module
     *
     * @var boolean
     */
    private $editable = null;
    
    /**
     * deletable module
     *
     * @var boolean
     */
    private $deletable = null;
    
    /**
     * weblink of the webtab
     *
     * @var string
     */
    private $webLink = null;
    
    /**
     * singular label name of the module
     *
     * @var string
     */
    private $singularLabel = null;
    
    /**
     * plural label name of the module
     *
     * @var string
     */
    private $pluralLabel = null;
    
    /**
     * the user who modified the module
     *
     * @var ZCRMUser
     */
    private $modifiedBy = null;
    
    /**
     * modification time of the moduel
     *
     * @var String
     */
    private $modifiedTime = null;
    
    /**
     * viewable module
     *
     * @var boolean
     */
    private $viewable = null;
    
    /**
     * api supported module
     *
     * @var boolean
     */
    private $apiSupported = null;
    
    /**
     * custom module
     *
     * @var boolean
     */
    private $customModule = null;
    
    /**
     * scoring supported module
     *
     * @var boolean
     */
    private $scoringSupported = null;
    
    /**
     * module id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * module display name
     *
     * @var string
     */
    private $moduleName = null;
    
    /**
     * business card field limit
     *
     * @var int
     */
    private $businessCardFieldLimit = null;
    
    /**
     * module api name
     *
     * @var string
     */
    private $apiName = null;
    
    /**
     * api names of the fields supported
     *
     * @var array
     */
    private $businessCardFields = array();
    
    /**
     * profiles for the module
     *
     * @var array ZCRMProfile instances array
     */
    private $profiles = array();
    
    /**
     * display field name of the module
     *
     * @var string
     */
    private $displayFieldName = null;
    
    /**
     * id of the display field of the module
     *
     * @var string
     */
    private $displayFieldId = null;
    
    /**
     * related list of the module
     *
     * @var ZCRMModuleRelatedList
     */
    private $relatedList = null;
    
    /**
     * layout of the module
     *
     * @var ZCRMLayout
     */
    private $layouts = null;
    
    /**
     * field api names
     *
     * @var array
     */
    private $fields = null;
    
    /**
     * related list properties of the module
     *
     * @var ZCRMRelatedListProperties
     */
    private $relatedListProperties = null;
    
    /**
     * poroperties of the module
     *
     * @var array
     */
    private $properties = null;
    
    /**
     * records per page
     *
     * @var int
     */
    private $perPage = null;
    
    /**
     * search layout fields
     *
     * @var array
     */
    private $searchLayoutFields = null;
    
    /**
     * default territory name
     *
     * @var string
     */
    private $defaultTerritoryName = null;
    
    /**
     * default territory id
     *
     * @var string
     */
    private $defaultTerritoryId = null;
    
    /**
     * default custom view id
     *
     * @var string
     */
    private $defaultCustomViewId = null;
    
    /**
     * custom view of the module
     *
     * @var ZCRMCustomView
     */
    private $customView = null;
    
    /**
     * global search supported
     *
     * @var boolean
     */
    private $globalSearchSupported;
    
    /**
     * sequence number of the module
     *
     * @var int
     */
    private $sequenceNumber;
    
    /**
     * constructor to set the module api name
     *
     * @param string $apiName
     */
    private function __construct($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * method to get the instance of module
     *
     * @param string $apiName the module api name
     * @return ZCRMModule instance of ZCRMModule class
     */
    public static function getInstance($apiName)
    {
        return new ZCRMModule($apiName);
    }
    
    /**
     * method to check whether the module is creatable
     *
     * @return boolean true if module is creatable otherwise false
     */
    public function isCreatable()
    {
        return $this->creatable;
    }
    
    /**
     * method to set the module as creatable
     *
     * @param boolean $creatable true to set the module creatable otherwise false
     */
    public function setCreatable($creatable)
    {
        $this->creatable = $creatable;
    }
    
    /**
     * method to check whether the module is convertable
     *
     * @return boolean true if module is convertable otherwise false
     */
    public function isConvertable()
    {
        return $this->convertable;
    }
    
    /**
     * method to set the module as convertable
     *
     * @param boolean $convertable true to set the module convertable otherwise false
     */
    public function setConvertable($convertable)
    {
        $this->convertable = $convertable;
    }
    
    /**
     * method to check whether the module is Editable
     *
     * @return boolean true if module is Editable otherwise false
     */
    public function isEditable()
    {
        return $this->editable;
    }
    
    /**
     * method to set the module as Editable
     *
     * @param boolean $editable editable true to set the module Editable otherwise false
     */
    public function setEditable($editable)
    {
        $this->editable = $editable;
    }
    
    /**
     * method to check whether the module is Deletable
     *
     * @return boolean true if module is Deletable otherwise false
     */
    public function isDeletable()
    {
        return $this->deletable;
    }
    
    /**
     * method to set the module as deletable
     *
     * @param boolean $deletable true to set the module deletable otherwise false
     */
    public function setDeletable($deletable)
    {
        $this->deletable = $deletable;
    }
    
    /**
     * method to get the weblink of the webtab
     *
     * @return string the weblink of the webtab
     */
    public function getWebLink()
    {
        return $this->webLink;
    }
    
    /**
     * ethod to get the weblink of the webtab
     *
     * @param string $webLink the weblink of the webtab
     */
    public function setWebLink($webLink)
    {
        $this->webLink = $webLink;
    }
    
    /**
     * method to get the singular label of the module
     *
     * @return string singular label singular label of the module
     */
    public function getSingularLabel()
    {
        return $this->singularLabel;
    }
    
    /**
     * method to set the singular label of the module
     *
     * @param string $singularLabel singular label of the module
     */
    public function setSingularLabel($singularLabel)
    {
        $this->singularLabel = $singularLabel;
    }
    
    /**
     * method to get the Plural Label of the module
     *
     * @return string PluralLabel Plural Label of the module
     */
    public function getPluralLabel()
    {
        return $this->pluralLabel;
    }
    
    /**
     * method to set the plural Label of the module
     *
     * @param string $pluralLabel Plural Label of the module
     */
    public function setPluralLabel($pluralLabel)
    {
        $this->pluralLabel = $pluralLabel;
    }
    
    /**
     * Method to get the user who modified the module
     *
     * @return ZCRMUser user who modified the module
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * Method to set the user who modified the module
     *
     * @param ZCRMUser $modifiedBy user who modified the module
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
    
    /**
     * Method to get the modification time of the module
     *
     * @return String the modification time in ISO 8601 format
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    
    /**
     * Method to set the modification time of the module
     *
     * @param String $modifiedTime modification time in ISO 8601 format
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    }
    
    /**
     * method to check whether the module is Viewable
     *
     * @return boolean true if the module is Viewable otherwise false
     */
    public function isViewable()
    {
        return $this->viewable;
    }
    
    /**
     * method to set the module as viewable
     *
     * @param boolean $viewable true to set the module as viewable otherwise false
     */
    public function setViewable($viewable)
    {
        $this->viewable = $viewable;
    }
    
    /**
     * method to check whether the module is ApiSupported
     *
     * @return boolean true if the module is ApiSupported otherwise false
     */
    public function isApiSupported()
    {
        return $this->apiSupported;
    }
    
    /**
     * method to set the module as apiSupported
     *
     * @param boolean $apiSupported true to set the module as apiSupported otherwise false
     */
    public function setApiSupported($apiSupported)
    {
        $this->apiSupported = $apiSupported;
    }
    
    /**
     * method to check whether the module is CustomModule
     *
     * @return boolean true if the module is CustomModule otherwise false
     */
    public function isCustomModule()
    {
        return $this->customModule;
    }
    
    /**
     * method to set the module as customModule
     *
     * @param boolean $customModule true to set the module as customModule otherwise false
     */
    public function setCustomModule($customModule)
    {
        $this->customModule = $customModule;
    }
    
    /**
     * method to check whether the module is ScoringSupported
     *
     * @return boolean true if the module is ScoringSupported otherwise false
     */
    public function isScoringSupported()
    {
        return $this->scoringSupported;
    }
    
    /**
     * method to set the module as scoringSupported
     *
     * @param boolean $scoringSupported true to set the module as scoringSupported otherwise false
     */
    public function setScoringSupported($scoringSupported)
    {
        $this->scoringSupported = $scoringSupported;
    }
    
    /**
     * method to get the module id
     *
     * @return string the module id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the module id
     *
     * @param string $id the module id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the module name
     *
     * @return string the module name
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }
    
    /**
     * method to set the module name
     *
     * @param string $moduleName the module name
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }
    
    /**
     * method to get the business card field limit
     *
     * @return int business card field limit
     */
    public function getBusinessCardFieldLimit()
    {
        return $this->businessCardFieldLimit;
    }
    
    /**
     * method to set the business card field limit
     *
     * @param int $businessCardFieldLimit business card field limit
     */
    public function setBusinessCardFieldLimit($businessCardFieldLimit)
    {
        $this->businessCardFieldLimit = $businessCardFieldLimit;
    }
    
    /**
     * method to set the business card fields
     *
     * @param array $businessCardFields the business card fields
     */
    public function setBusinessCardFields($businessCardFields)
    {
        $this->businessCardFields = $businessCardFields;
    }
    
    /**
     * method to get the business card fields
     *
     * @return array the business card fields
     */
    public function getBusinessCardFields()
    {
        return $this->businessCardFields;
    }
    
    /**
     * method to set the module api name
     *
     * @param string $apiName the module api name
     */
    public function setAPIName($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * method to get the module api name
     *
     * @return string the module api name
     */
    public function getAPIName()
    {
        return $this->apiName;
    }
    
    /**
     * method to get the profiles of modules
     *
     * @param array $profiles array of instances of ZCRMProfile instances
     */
    public function setAllProfiles($profiles)
    {
        $this->profiles = $profiles;
    }
    
    /**
     * method to set the profiles of modules
     *
     * @return array array of instances of ZCRMProfile instances
     */
    public function getAllProfiles()
    {
        return $this->profiles;
    }
    
    /**
     * method to set the display field of the module
     *
     * @param string $name field api name
     */
    public function setDisplayFieldName($name)
    {
        $this->displayFieldName = $name;
    }
    
    /**
     * method to get the display field of the module
     *
     * @return string field api name
     */
    public function getDisplayFieldName()
    {
        return $this->displayFieldName;
    }
    
    /**
     * method to set the id of the display field the module
     *
     * @param string $id id of the the display field
     */
    public function setDisplayFieldId($id)
    {
        $this->displayFieldId = $id;
    }
    
    /**
     * method to set the id of the display field the module
     *
     * @return string id of the the display field
     */
    public function getDisplayFieldId()
    {
        return $this->displayFieldId;
    }
    
    /**
     * method to get the related list of the module
     *
     * @return ZCRMModuleRelatedList instance of ZCRMModuleRelatedList
     */
    public function getRelatedLists()
    {
        return $this->relatedList;
    }
    
    /**
     * method to set the related list of the module
     *
     * @param ZCRMModuleRelatedList $relatedList instance of ZCRMModuleRelatedList
     */
    public function setRelatedLists($relatedList)
    {
        $this->relatedList = $relatedList;
    }
    
    /**
     * method to set the module layout
     *
     * @param ZCRMLayout $layouts instance of ZCRMLayout
     */
    public function setLayouts($layouts)
    {
        $this->layouts = $layouts;
    }
    
    /**
     * metho to get the module layout
     *
     * @return ZCRMLayout instance of ZCRMLayout
     */
    public function getLayouts()
    {
        return $this->layouts;
    }
    
    /**
     * method to set the field of the module
     *
     * @param array $fields array of ZCRMField instances
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * method to get the field of the module
     *
     * @return array array of ZCRMField instances
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * method to set the related list properties of the module
     *
     * @param ZCRMRelatedListProperties $relatedListProp instance of ZCRMRelatedListProperties class
     */
    public function setRelatedListProperties($relatedListProp)
    {
        $this->relatedListProperties = $relatedListProp;
    }
    
    /**
     * method to get the related list properties of the module
     *
     * @return ZCRMRelatedListProperties instance of ZCRMRelatedListProperties class
     */
    public function getRelatedListProperties()
    {
        return $this->relatedListProperties;
    }
    
    /**
     * method to get the properties of the module
     *
     * @return array Properties of the module
     */
    public function getProperties()
    {
        return $this->properties;
    }
    
    /**
     * method to set the properties of the module
     *
     * @param array $properties Properties of the module
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }
    
    /**
     * method to Get the value for the number of records shown in module list view
     *
     * @return int number of records shown in module list view
     */
    public function getPerPage()
    {
        return $this->perPage;
    }
    
    /**
     * method to Set the value for the number of records to be shown in module list view
     *
     * @param int $perPage the number of records to be shown in module list view
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }
    
    /**
     * method to Get the module search layout fields
     *
     * @return Array the module search layout fields
     */
    public function getSearchLayoutFields()
    {
        return $this->searchLayoutFields;
    }
    
    /**
     * method to Set the module search layout fields
     *
     * @param Array $searchLayoutFields the module search layout fields
     */
    public function setSearchLayoutFields($searchLayoutFields)
    {
        $this->searchLayoutFields = $searchLayoutFields;
    }
    
    /**
     * method to Get the module's default Territory Name
     *
     * @return String module's default Territory Name
     */
    public function getDefaultTerritoryName()
    {
        return $this->defaultTerritoryName;
    }
    
    /**
     * method to Set the module's default Territory Name
     *
     * @param String $defaultTerritoryName the module's default Territory Name
     */
    public function setDefaultTerritoryName($defaultTerritoryName)
    {
        $this->defaultTerritoryName = $defaultTerritoryName;
    }
    
    /**
     * method to Get the module's default Territory Id
     *
     * @return string module's default Territory Id
     */
    public function getDefaultTerritoryId()
    {
        return $this->defaultTerritoryId;
    }
    
    /**
     * method to Set the module's default Territory Id
     *
     * @param string $defaultTerritoryId module's default Territory Id
     */
    public function setDefaultTerritoryId($defaultTerritoryId)
    {
        $this->defaultTerritoryId = $defaultTerritoryId;
    }
    
    /**
     * method to Set the Module Default custom view
     *
     * @param ZCRMCustomView $customView instance of ZCRMCustomView
     */
    public function setDefaultCustomView($customView)
    {
        $this->customView = $customView;
    }
    
    /**
     * method to Get the Module Default custom view
     *
     * @return ZCRMCustomView instance of ZCRMCustomView
     */
    public function getDefaultCustomView()
    {
        return $this->customView;
    }
    
    /**
     * method to check whether module is global Search Supported
     *
     * @return boolean true if the module is global search supported otherwise false
     */
    public function isGlobalSearchSupported()
    {
        return $this->globalSearchSupported;
    }
    
    /**
     * method to set module as global Search Supported
     *
     * @param boolean $globalSearchSupported true to set the module as global search supported otherwise false
     */
    public function setGlobalSearchSupported($globalSearchSupported)
    {
        $this->globalSearchSupported = $globalSearchSupported;
    }
    
    /**
     * method to get the sequence number of the module
     *
     * @return int the sequence number of the module
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }
    
    /**
     * method to set the sequence number of the module
     *
     * @param int $sequenceNumber the sequence number of the module
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;
    }
    
    /**
     * method to get the the specified field of the module.
     *
     * @param string $fieldId id of the field
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getFieldDetails($fieldId)
    {
        return ModuleAPIHandler::getInstance($this)->getFieldDetails($fieldId);
    }
    
    /**
     * method to get the list of fields of the module.
     *
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getAllFields()
    {
        return ModuleAPIHandler::getInstance($this)->getAllFields();
    }
    
    /**
     * method to get all the layouts of the module
     *
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getAllLayouts()
    {
        return ModuleAPIHandler::getInstance($this)->getAllLayouts();
    }
    
    /**
     * method to get the layout details
     *
     * @param string $layoutId layout id
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getLayoutDetails($layoutId)
    {
        return ModuleAPIHandler::getInstance($this)->getLayoutDetails($layoutId);
    }
    
    /**
     * method to Return the custom views of the module.
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getAllCustomViews($param_map = array())
    {
        return ModuleAPIHandler::getInstance($this)->getAllCustomViews($param_map);
    }
    
    /**
     * method to Return the custom view details of the module.
     *
     * @param string $customViewId id of the custom view
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getCustomView($customViewId)
    {
        return ModuleAPIHandler::getInstance($this)->getCustomView($customViewId);
    }
    
    /**
     * Method to update module settings
     *
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function updateModuleSettings()
    {
        return ModuleAPIHandler::getInstance($this)->updateModuleSettings();
    }
    
    /**
     * Method to update custom views settings
     *
     * @param ZCRMCustomView $customViewInstance instance of ZCRMCustomView
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function updateCustomView($customViewInstance)
    {
        return ModuleAPIHandler::getInstance($this)->updateCustomView($customViewInstance);
    }
    
    /**
     * Method to get related lists of a module.
     *
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the Bulk api Response
     */
    public function getAllRelatedLists()
    {
        return ModuleAPIHandler::getInstance($this)->getAllRelatedLists();
    }
    
    /**
     * Method to get the specified related list
     *
     * @param string $relatedListId related list's id
     * @return APIResponse instance of the APIResponse class containing the api Response
     */
    public function getRelatedListDetails($relatedListId)
    {
        return ModuleAPIHandler::getInstance($this)->getRelatedListDetails($relatedListId);
    }
    
    /**
     * method to get the default custom id
     *
     * @return string default custom id
     */
    public function getDefaultCustomViewId()
    {
        return $this->defaultCustomViewId;
    }
    
    /**
     * method to set the default custom id
     *
     * @param string $defaultCustomViewId custom view id
     */
    public function setDefaultCustomViewId($defaultCustomViewId)
    {
        $this->defaultCustomViewId = $defaultCustomViewId;
    }
    
    /**
     * method to get the record of the module
     *
     * @param string $entityId record id
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getRecord($entityId,$param_map=array(),$header_map=array())
    {
        $record = ZCRMRecord::getInstance($this->apiName, $entityId);
        return EntityAPIHandler::getInstance($record)->getRecord($param_map,$header_map);
    }
    
    /**
     * method to get records of the custom view
     *
     ** @param Array  $param_map key-value pair containing parameter names and the value
     * @param Array  $header_map key-value pair containing header names and the value
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getRecords($param_map=array(), $header_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->getRecords($param_map,$header_map);
    }
    
    /**
     * method to search records of the module by searchword
     *
     * @param string $searchWord word to be searched
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function searchRecordsByWord($searchWord, $param_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->searchRecords($param_map,"word",$searchWord);
    }
    
    /**
     * method to search records of the module by phone
     *
     * @param int $phone phone number to be searched
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function searchRecordsByPhone($phone, $param_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->searchRecords($param_map,"phone",$phone);
    }
    
    /**
     * method to search records of the module by email id
     *
     * @param string $email email id to be searched
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function searchRecordsByEmail($email, $param_map=array())
    {
        
        return MassEntityAPIHandler::getInstance($this)->searchRecords($param_map,"email",$email);
    }
    
    /**
     * method to search records of the module by criteria
     *
     * @param string $criteria criteria of search
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function searchRecordsByCriteria($criteria, $param_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->searchRecords($param_map,"criteria",$criteria);
    }
    
    /**
     * method to the field of records in module
     *
     * @param array $entityIds array of instances of ZCRMRecord class
     * @param string $fieldApiName field api name of the field
     * @param string $value updated value
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function massUpdateRecords($entityIds, $fieldApiName, $value)
    {
        return MassEntityAPIHandler::getInstance($this)->massUpdateRecords($entityIds, $fieldApiName, $value);
    }
    
    /**
     * method to update the records in the module
     *
     * @param array $records array of instances of ZCRMRecord class
     * @param string $trigger array of triggers
     * @param string $lar_id lead assignment rule id
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function updateRecords($records, $trigger = null,$process = null)
    {
        return MassEntityAPIHandler::getInstance($this)->updateRecords($records, $trigger,$process);
    }
    
    /**
     * method to create the records in the module
     *
     * @param array $records array of instances of ZCRMRecord class
     * @param string $trigger array of triggers
     * @param string $lar_id lead assignment rule id
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function createRecords($records, $trigger = null,$lar_id = null,$process = null)
    {
        return MassEntityAPIHandler::getInstance($this)->createRecords($records, $trigger,$lar_id,$process);
    }
    
    /**
     * method to upsert the records of the module
     *
     * @param array $records array of instances of ZCRMRecord class
     * @param string $trigger array of triggers
     * @param string $lar_id lead assignment rule id
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function upsertRecords($records, $trigger = null,$lar_id = null,$duplicate_check_fields=null,$process = null)
    {
        return MassEntityAPIHandler::getInstance($this)->upsertRecords($records, $trigger,$lar_id,$duplicate_check_fields,$process);
    }
    
    /**
     * method to delete the records of the module
     *
     * @param array $entityIds array of record ids of the records in the module
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function deleteRecords($entityIds)
    {
        return MassEntityAPIHandler::getInstance($this)->deleteRecords($entityIds);
    }
    
    /**
     * method to get the deleted records of the module
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getAllDeletedRecords($param_map=array(),$header_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->getAllDeletedRecords($param_map,$header_map);
    }
    
    /**
     * method to get the records in recyle bin of the module
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getRecycleBinRecords($param_map=array(),$header_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->getRecycleBinRecords($param_map,$header_map);
    }
    
    /**
     * method to get the permanently deleted records of the module
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getPermanentlyDeletedRecords($param_map=array(),$header_map=array())
    {
        return MassEntityAPIHandler::getInstance($this)->getPermanentlyDeletedRecords($param_map,$header_map);
    }
    
    /**
     * method to get the tags of the module
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @throws ZCRMException ifthe module api name is invalid
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getTags()
    {
        if ($this->apiName == null || $this->apiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for getTags operation");
        }
        return TagAPIHandler::getInstance($this)->getTags();
    }
    
    /**
     * method to get the tag count of the module
     *
     * @param string $tagid tag id of the tag
     * @throws ZCRMException if the tag id and the module api name is invalid
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getTagCount($tagid)
    {
        if ($this->apiName == null || $this->apiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for getTagCount operation");
        }
        if ($tagid == null || $tagid == 0) {
            throw new ZCRMException("Tag ID MUST NOT be null/empty for getTagCount operation");
        }
        return TagAPIHandler::getInstance($this)->getTagCount($tagid);
    }
    
    /**
     * method to create the tags of the module
     *
     * @param array $tags array of ZCRMTag instances
     * @throws ZCRMException if the tag object array or the module api name is invalid
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function createTags($tags)
    {
        if ($this->apiName == null || $this->apiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for createTags operation");
        }
        if (sizeof($tags) <= 0) {
            throw new ZCRMException("Tag object list MUST NOT be null/empty for createTags operation");
        }
        return TagAPIHandler::getInstance($this)->createTags($tags);
    }
    
    /**
     * method to update the tags of the module
     *
     * @param array $tags array of ZCRMTag instances
     * @throws ZCRMException if the tag object array or the module api name is invalid
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function updateTags($tags)
    {
        if ($this->apiName == null || $this->apiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for updateTags operation");
        }
        if (sizeof($tags) <= 0) {
            throw new ZCRMException("Tag object list MUST NOT be null/empty for updateTags operation");
        }
        return TagAPIHandler::getInstance($this)->updateTags($tags);
    }
    
    /**
     * method to add tags to the record of the module
     *
     * @param array $recordIds array of record ids of the records in the module
     * @param array $tagNames array of tag names
     * @throws ZCRMException if the module api name or tag name list or record ID list is invalid
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function addTagsToRecords($recordIds, $tagNames)
    {
        if ($this->apiName == null || $this->apiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for Add Tags to Multiple records operation");
        }
        if (sizeof($tagNames) <= 0) {
            throw new ZCRMException("Tag Name list MUST NOT be null/empty for Add Tags to Multiple records operation");
        }
        if (sizeof($recordIds) <= 0) {
            throw new ZCRMException("Record ID list MUST NOT be null/empty for Add Tags to Multiple records operation");
        }
        return TagAPIHandler::getInstance($this)->addTagsToRecords($recordIds, $tagNames);
    }
    
    /**
     * method to remove the the tags the the records of the module
     *
     * @param array $recordIds array of record ids of the records in the module
     * @param array $tagNames array of tag names
     * @throws ZCRMException if the module api name or tag name list or record ID list is invalid
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function removeTagsFromRecords($recordIds, $tagNames)
    {
        if ($this->apiName == null || $this->apiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for Remove Tags from Multiple records operation");
        }
        if (sizeof($tagNames) <= 0) {
            throw new ZCRMException("Tag Name list MUST NOT be null/empty for Remove Tags from Multiple records operation");
        }
        if (sizeof($recordIds) <= 0) {
            throw new ZCRMException("Record ID list MUST NOT be null/empty for Remove Tags from Multiple records operation");
        }
        return TagAPIHandler::getInstance($this)->removeTagsFromRecords($recordIds, $tagNames);
    }
}