<?php
namespace zcrmsdk\crm\bulkcrud;

class ZCRMBulkWriteResource
{
    /**
     * resource status
     * @var string
     */
    private $status = null;
    
    /**
     * resource error message
     * @var string
     */
    private $message = null;
    
    /**
     * resource type
     * @var string
     */
    private $type = null;
    
    /**
     * resource module api name
     * @var string
     */
    private $module = null;
    
    /**
     * uploaded file id
     * @var string
     */
    private $fileId = null;
    
    /**
     * ignore empty value
     * @var boolean
     */
    private $ignore_empty;
    
    /**
     * resource find by
     * @var string
     */
    private $findBy;
    
    /**
     * 
     * @var Array of ZCRMBulkWriteFieldMapping instance
     */
    private $field_mappings = array();
    
    /**
     * file details
     * @var ZCRMBulkWriteFileStatus instance
     */
    private $fileStatus = null;
    
    /**
     * constructor to set the module name and file id
     * @param string $moduleAPIName
     * @param string $fileId
     */
    private function  __construct($moduleAPIName, $fileId)
    {
        $this->module = $moduleAPIName;
        $this->fileId = $fileId;
    }
   
    /**
     * Method to get the instance of the ZCRMBulkWriteResource class
     * @param string $moduleAPIName
     * @param string $file_id
     * @return ZCRMBulkWriteResource - class instance
     */
    public static function getInstance($moduleAPIName = null, $file_id = null)
    {
        return new ZCRMBulkWriteResource($moduleAPIName, $file_id);
    }
    
    /**
     * Method to set status of the bulk write job for that module.
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Method to get status of the bulk write job for that module
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Method to set type of the module that you want to import. The value is data.
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * Method to get type of the module that you want to import. The value is data.
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Method to set the API name of the module that is imported.
     * @param string $module
     */
    public function setModuleAPIName($module)
    {
        $this->module = $module;
    }
    
    /**
     * Method to get the API name of the module that is imported.
     * @return string
     */
    public function getModuleAPIName()
    {
        return $this->module;
    }
    
    /**
     * Method to get the file_id obtained from file upload API.
     * @return string
     */
    public function getFileId()
    {
        return $this->fileId;
    }
    
    /**
     * Method to set the file_id obtained from file upload API.
     * @param string $fileId
     */
    public function setFileId($fileId)
    {
        $this->fileId = $fileId;
    }
    
    /**
     * Method to set True - Ignores the empty values. False or empty - with empty values . The default value is false.
     * @param boolean $ignore_empty
     */
    public function setIgnoreEmpty($ignore_empty)
    {
        $this->ignore_empty = $ignore_empty;
    }
    
    /**
     * Method to get True/False.
     * @return boolean
     */
    public function getIgnoreEmpty()
    {
        return $this->ignore_empty;
    }
    
    /**
     * Method to set the API name of a unique field or ID of a record. 
     * @param string $findBy
     */
    public function setFindBy($findBy)
    {
        $this->findBy = $findBy;
    }
    
    /**
     * Method to get the API name of a unique field or ID of a record. 
     * @return string
     */
    public function getFindBy()
    {
        return $this->findBy;
    }
    
    /**
     * Method to set ZCRMBulkWriteFieldMapping instance
     * @param array $field_mappings
     */
    public function setFieldMapping($field_mappings)
    {
        array_push($this->field_mappings,$field_mappings);
    }
    
    /**
     * Method to get the field_mappings properties table for information on field_mappings object.
     * @return array
     */
    public function getFieldMapping()
    {
        return $this->field_mappings;
    }
    
    /**
     * Method to set ZCRMBulkWriteFile instance
     * @param ZCRMBulkWriteFileStatus $file
     */
    public function setFileStatus($file)
    {
        $this->fileStatus = $file;
    }
    
    /**
     * Method to get the file properties table for information on file object
     * @return ZCRMBulkWriteFileStatus
     */
    public function getFileStatus()
    {
        return $this->fileStatus;
    }
    
    /**
     * Method to set resource error message
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * Method to get resource error message
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
