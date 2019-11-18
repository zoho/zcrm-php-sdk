<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\api\response\BulkAPIResponse;

class ZCRMCustomView
{
    
    /**
     * api name of the module
     *
     * @var String api name of the module
     */
    private $moduleAPIName = null;
    
    /**
     * display name of the view
     *
     * @var string
     */
    private $displayValue = null;
    
    /**
     * default view
     *
     * @var boolean
     */
    private $default = null;
    
    /**
     * custom view id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * custom view name
     *
     * @var String
     */
    private $name = null;
    
    /**
     * custom view system name
     *
     * @var string
     */
    private $systemName = null;
    
    /**
     * field api name
     *
     * @var String
     */
    private $sortBy = null;
    
    /**
     * category of the custom view
     *
     * @var ZCRMCustomViewCategory
     */
    private $category = null;
    
    /**
     * fields of the custom view
     *
     * @var array
     */
    private $fields = array();
    
    /**
     * the favourite
     *
     * @var boolean
     */
    private $favorite = null;
    
    /**
     * the order of sorting of records in the view
     *
     * @var String
     */
    private $sortOrder = null;
    
    /**
     * criteria pattern of the view
     *
     * @var String
     */
    private $criteriaPattern = null;
    
    /**
     * record selection criteria
     *
     * @var ZCRMCustomViewCriteria
     */
    private $criteria = null;
    /**
     * criteria condition
     *
     * @var string
     */
    private $criteriaCondition = null;
    /**
     * category list of the view
     *
     * @var array array instances of ZCRMCustomViewCategory
     */
    private $categoriesList = array();
    
    /**
     * offline status of the view
     *
     * @var boolean
     */
    private $offLine = null;
    
    /**
     * constructor to set the module API name and custom view id
     *
     * @param String $moduleAPIName module API name
     * @param string $id  module API name
     */
    public function __construct($moduleAPIName, $id)
    {
        $this->moduleAPIName = $moduleAPIName;
        $this->id = $id;
    }
    
    /**
     * Method to get the instance of the ZCRMCustomView class
     *
     * @param String $moduleAPIName module API name
     * @param string $id module API name
     * @return ZCRMCustomView instance of ZCRMCustomView class
     */
    public static function getInstance($moduleAPIName , $id)
    {
        return new ZCRMCustomView( $moduleAPIName,$id);
    }
    
    /**
     * Method to get the display Name of the custom View
     *
     * @return string display name of the custom view
     */
    public function getDisplayValue()
    {
        return $this->displayValue;
    }
    
    /**
     * Method to set the display Name of the custom View
     *
     * @param string $displayValue display name of the custom view
     */
    public function setDisplayValue($displayValue)
    {
        $this->displayValue = $displayValue;
    }
    
    /**
     * Method to know whether the custom view is default or not
     *
     * @return Boolean value true if default otherwise false
     */
    public function isDefault()
    {
        return $this->default;
    }
    
    /**
     * Method to set the custom view as default or not
     *
     * @param boolean $default  true if default otherwise false
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }
    
    /**
     * method to get the customview id
     *
     * @return string custom view id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to get the customview id
     *
     * @param string $id custom view id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Method to get the customview Name
     *
     * @return string customview name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Method to set the customview Name
     *
     * @param string $name customview name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Method to get the system name of the custom view
     *
     * @return string system name of custom view
     */
    public function getSystemName()
    {
        return $this->systemName;
    }
    
    /**
     * Method to set the customview system Name
     *
     * @param string $systemName system name of the custom view
     */
    public function setSystemName($systemName)
    {
        $this->systemName = $systemName;
    }
    
    /**
     * Method to get the customview Sorted By field Name
     *
     * @return string field api name
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }
    
    /**
     * Method to set the customview Sorted By field Name
     *
     * @param string $sortBy field api name
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }
    
    /**
     * Method to get the customview Category
     *
     * @return string custom view category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Method to set the customview Category
     *
     * @param string $category custom view category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    /**
     * Method to get the customview Fields
     *
     * @return array array of field api name of the fields in custom view
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * Method to set the customview Fields
     *
     * @param array $fields array of field api name
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * Method to check whether the custom view is favourite one or not
     *
     * @return int favourite value
     */
    public function isFavorite()
    {
        return $this->favorite;
    }
    
    /**
     * Method to set the custom view as favourite one or not
     *
     * @param int $favorite favourite value
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;
    }
    
    /**
     * Method to get the custom view records sort order
     *
     * @return String sortorder (ascending if "asc" or descending if "desc")
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    
    /**
     * Method to set the custom view sort order type
     *
     * @param String $sortOrder sorts the custom view records in ascending-"asc" or descending-"desc" order
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
    
    /**
     * Method to get the custom view criteria pattern
     *
     * @return string CriteriaPattern criteria pattern
     */
    public function getCriteriaPattern()
    {
        return $this->criteriaPattern;
    }
    
    /**
     * Method to set the custom view criteria pattern
     *
     * @param String $criteriaPattern Criteria pattern
     */
    public function setCriteriaPattern($criteriaPattern)
    {
        $this->criteriaPattern = $criteriaPattern;
    }
    
    /**
     * Method to get the criteria of the custom view
     *
     * @return array array of instances of ZCRMCustomViewCriteria
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
    
    /**
     * Method to set the criteria of the custom view
     *
     * @param array $criteria array of instance of ZCRMCustomViewCriteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    
    public function getCriteriaCondition()
    {
        return $this->criteriaCondition;
    }
    
    public function setCriteriaCondition($criteriaCondition)
    {
        $this->criteriaCondition = $criteriaCondition;
    }
    
    /**
     * Method to get the module api name of the custom view
     *
     * @return String module api name
     */
    public function getModuleAPIName()
    {
        return $this->moduleAPIName;
    }
    /**
     * Method to get the module api name of the custom view
     *
     * @param String $moduleapiname  module api name
     */
    public function setModuleAPIName($moduleapiname)
    {
        $this->moduleAPIName=$moduleapiname;
    }
    /**
     * Method to get the custom view records
     *
     * @param Array  $param_map key-value pair containing parameter names and the value
     * @param Array  $header_map key-value pair containing header names and the value
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getRecords($param_map=array(),$header_map=array())
    {
        $param_map['cvid']=$this->id;
        return ZCRMModule::getInstance($this->moduleAPIName)->getRecords($param_map,$header_map);
    }
    
    /**
     * method to get the categories List of the custom view
     *
     * @return array array instances of the ZCRMCustomViewCategory
     */
    public function getCategoriesList()
    {
        return $this->categoriesList;
    }
    
    /**
     * Method to set the category list of the custom view
     *
     * @param array $categoriesList  array instances of ZCRMCustomViewCategory
     */
    public function setCategoriesList($categoriesList)
    {
        $this->categoriesList = $categoriesList;
    }
    
    /**
     * Method to set the offline status of the custom view
     *
     * @param boolean $off_line true to set offline
     */
    public function setOffLine($off_line)
    {
        $this->offLine = (boolean) $off_line;
    }
    
    /**
     * Method to check whether the custom view is offline or not
     *
     * @return boolean offline value (true if offline )
     */
    public function isOffLine()
    {
        return $this->offLine;
    }
}