<?php
namespace zcrmsdk\crm\bulkcrud;

class ZCRMBulkQuery
{
    /**
     * module api name
     * @var string
     */
    private $module = null;
    
    /**
     * custom view id
     * @var string 
     */
    private $cvId = null;
    
    /**
     * array of field api names
     * @var array
     */
    private $fields = array();
    
    /**
     * number of page
     * @var int
     */
    private $page = null;
    
    /**
     * ZCRMBulkCriteria - instance
     * @var ZCRMBulkCriteria
     */
    private $criteria = null;
    
    private $criteriaPattern = null;
    
    private $criteriaCondition = null;
    
    /**
     * empty constructor
     */
    function __construct(){}
    
    /**
     * Method to get instance of ZCRMBulkQuery class
     * @return ZCRMBulkQuery - instance
     */
    public static function getInstance()
    {
        return new ZCRMBulkQuery();
    }
    
    /**
     * Method to set index of the record to be obtained (default is 1).
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }
    
    /**
     * Method to get index of the record to be obtained.
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * Method to set the API Name of the fields to be fetched.
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * Method to get the API Name of the fields to be fetched.
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * Method to set the API Name of the module to be read.
     * @param string $module
     */
    public function setModuleAPIName($module)
    {
        $this->module = $module;
    }
    
    /**
     *  Method to get the API Name of the module to be read.
     * @return string
     */
    public function getModuleAPIName()
    {
        return $this->module;
    }
    
    /**
     * Method to set the unique ID of the custom view whose records you want to export.
     * @param string $cvid
     */
    public function setCvId($cvid)
    {
        $this->cvId = $cvid;
    }
    
    /**
     * Method to get the unique ID of the custom view whose records you want to export.
     * @return string
     */
    public function getCvId()
    {
        return $this->cvId;
    }
    
    /**
     * Method to set filter the records to be exported.
     * @param ZCRMBulkCriteria $criteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * Method to get filter details the records to be exported.
     * @return ZCRMBulkCriteria - instance
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
    
    public function setCriteriaCondition($criteriaConditiona)
    {
        $this->criteriaCondition = $criteriaConditiona;
    }
    
    public function getCriteriaCondition()
    {
        return $this->criteriaCondition;
    }
    
    public function setCriteriaPattern($criteriaPattern)
    {
        $this->criteriaPattern = $criteriaPattern;
    }
    
    public function getCriteriaPattern()
    {
        return $this->criteriaPattern;
    }
}
