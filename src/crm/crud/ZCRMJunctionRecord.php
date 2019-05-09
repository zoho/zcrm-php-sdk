<?php
namespace zcrmsdk\crm\crud;

class ZCRMJunctionRecord
{
    
    /**
     * junction record id
     *
     * @var string
     */
    private $id;
    
    /**
     * module api name of the record
     *
     * @var string
     */
    private $apiName;
    
    /**
     * related data between the modules
     *
     * @var array
     */
    private $relatedDetails = array();
    
    /**
     * constructor to set the api name and id of the junction record
     *
     * @param string $apiName module api name of the junction record
     * @param string $id junction record id
     */
    private function __construct($apiName, $id)
    {
        $this->apiName = $apiName;
        $this->id = $id;
    }
    
    /**
     * methdo to get the instance of the junction record
     *
     * @param string $apiName module api name of the junction record
     * @param string $id junction record id
     * @return ZCRMJunctionRecord instance of ZCRMJunctionRecord class
     */
    public static function getInstance($apiName, $id)
    {
        return new ZCRMJunctionRecord($apiName, $id);
    }
    
    /**
     * method to get the ID of the junction record
     *
     * @return string junction record id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to the module API name of the junction record
     *
     * @return String module api name
     */
    public function getApiName()
    {
        return $this->apiName;
    }
    
    /**
     * method to get related details between the modules
     *
     * @return Array key-value pairs, key is the field api name, value is the field value
     *
     */
    public function getRelatedDetails()
    {
        return $this->relatedDetails;
    }
    
    /**
     * method to set the related details between the modules
     *
     * @param string $fieldApiName field api name
     * @param string $value value of the field
     */
    public function setRelatedData($fieldApiName, $value)
    {
        $this->relatedDetails[$fieldApiName] = $value;
    }
}