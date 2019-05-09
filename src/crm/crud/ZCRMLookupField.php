<?php
namespace zcrmsdk\crm\crud;

class ZCRMLookupField
{
    
    /**
     * api name of the lookup field
     *
     * @var string
     */
    private $apiName = null;
    
    /**
     * display name of the lookup field
     *
     * @var string
     */
    private $displayLabel = null;
    
    /**
     * module api name
     *
     * @var string
     */
    private $module = null;
    
    /**
     * lookup field id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * constructor to set the lookup field api name
     *
     * @param string $apiName lookup field api name
     */
    private function __construct($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * method to get the lookup field instance
     *
     * @param string $apiName api name of the lookup field
     * @return ZCRMLookupField instance of ZCRMLookupField Class
     */
    public static function getInstance($apiName)
    {
        return new ZCRMLookupField($apiName);
    }
    
    /**
     * method to set the module name of the lookup field
     *
     * @param string $module module name
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
    
    /**
     * method to get the module name of the lookup field
     *
     * @return string module name
     */
    public function getModule()
    {
        return $this->module;
    }
    
    /**
     * method to set the display label of the lookup field
     *
     * @param string $displayLabel display label of the lookup field
     */
    public function setDisplayLabel($displayLabel)
    {
        $this->displayLabel = $displayLabel;
    }
    
    /**
     * method to get the display label of the lookup field
     *
     * @return string display label of the lookup field
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }
    
    /**
     * method to set the lookup field id
     *
     * @param string $id lookup field id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to set the lookup field id
     *
     * @return string lookup field id
     */
    public function getId()
    {
        return $this->id;
    }
}