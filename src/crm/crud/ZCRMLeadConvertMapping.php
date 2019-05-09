<?php
namespace zcrmsdk\crm\crud;

class ZCRMLeadConvertMapping
{
    
    /**
     * converted record name
     *
     * @var string
     */
    private $name;
    
    /**
     * converted record id
     *
     * @var string
     */
    private $id;
    
    /**
     * fields convertible
     *
     * @var array instances of ZCRMLeadConvertMappingField class
     */
    private $fields = array();
    
    /**
     * construtor to set the record name and record id
     *
     * @param string $name record name
     * @param string $id redord id
     */
    private function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }
    
    /**
     * method to get the lead convert mapping instance
     *
     * @param string $name
     * @param string $id
     * @return ZCRMLeadConvertMapping instance of ZCRMLeadConvertMapping class
     */
    public static function getInstance($name, $id)
    {
        return new ZCRMLeadConvertMapping($name, $id);
    }
    
    /**
     * method to get the name of the converted record
     *
     * @return String converted record name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the name of the converted record
     *
     * @param String $name converted record name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the converted record id
     *
     * @return string the converted record id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the converted record id
     *
     * @param string $id the converted record id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * methods to get the convertible fields of the record
     *
     * @return array array of ZCRMLeadConvertMappingField class instances
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * methods to set the convertible fields of the record
     *
     * @param ZCRMLeadConvertMappingField $fieldIns instance of ZCRMLeadConvertMappingField class
     */
    public function addFields($fieldIns)
    {
        array_push($this->fields, $fieldIns);
    }
}