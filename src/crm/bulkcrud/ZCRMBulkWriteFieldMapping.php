<?php
namespace zcrmsdk\crm\bulkcrud;

class ZCRMBulkWriteFieldMapping
{
    /**
     * field api name
     * @var string
     */
    private $api_name = null;
    
    /**
     * field value index
     * @var int
     */
    private $index = null;
    
    /**
     * unique field name or record id
     * @var string
     */
    private $find_by = null;
    
    /**
     * field value format
     * @var string
     */
    private $format = null;
    
    /** 
     * field default value
     * @var map<string,object>
     */
    private $default_value = array();
    
    /**
     * constructor to set the field API name and field index
     * @param string $api_name
     * @param int $index
     */
    private function __construct($api_name, $index)
    {
        $this->api_name = $api_name;
        $this->index = $index;
    }
   
    /**
     * Method to get the instance of the ZCRMBulkWriteFieldMapping class
     * @param string $api_name
     * @param int $index
     * @return ZCRMBulkWriteFieldMapping - class instance
     */
    public static function getInstance($api_name = null, $index = null)
    {
        return new ZCRMBulkWriteFieldMapping($api_name, $index);
    }
    
    /**
     * Method to set the API name of the field present in Zoho module object that you want to import.
     * @param string $api_name
     */
    public function setFieldAPIName($api_name)
    {
        $this->api_name = $api_name;
    }
    
    /**
     * Method to get the field API name of the field you want to import from the module.
     * @return string
     */
    public function getFieldAPIName()
    {
        return $this->api_name;
    }
    
    /**
     * Method to set the column index of the field you want to map to the CRM field.
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }
    
    /**
     * Method to get the column index of the field you have mapped to the CRM module.
     * @return number
     */
    public function getIndex()
    {
        return $this->index;
    }
    
    /**
     * Method to set the API name of the unique field or primary field(record ID) in the module.
     * @param string $find_by
     */
    public function setFindBy($find_by)
    {
        $this->find_by = $find_by;
    }
    
    /**
     * Method to get the API name of the unique field or primary field(record ID) in the module.
     * @return string
     */
    public function getFindBy()
    {
        return $this->find_by;
    }
    
    /**
     * Method to set the format of field value 
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
    
    /**
     * Method to get the format of field value 
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    /**
     * Method to set the default value with which the system replaces any partial or empty file column in the CSV file.
     * @param string $key
     * @param object $value
     */
    public function setDefaultValue($key, $value)
    {
        $this->default_value[$key] = $value;
    }
    
    /**
     * Method to get the default value with which the system replaces any partial or empty file column in the CSV file.
     * @return map<string,object>
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }
}
?>