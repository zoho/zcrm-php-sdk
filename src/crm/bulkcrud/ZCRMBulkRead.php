<?php
namespace zcrmsdk\crm\bulkcrud;

use zcrmsdk\crm\bulkapi\handler\BulkReadAPIHandler;
use zcrmsdk\crm\bulkapi\handler\BulkAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\bulkapi\response\BulkResponse;
use zcrmsdk\crm\api\response\FileAPIResponse;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\exception\ZCRMException;

class ZCRMBulkRead
{
    /**
     * bulk read job id
     * @var string
     */
    private $jobId = null;
    
    /**
     * bulk read operation
     * @var string
     */
    private $operation = null;
    
    /**
     * status of bulk read
     * @var string
     */
    private $state = null;
    
    /**
     * result of the bulk read
     * @var ZCRMBulkResult
     */
    private $result = null;
    
    /**
     * query of the bulk read
     * @var ZCRMBulkQuery
     */
    private $query = null;
    
    /**
     * callback of the bulk read
     * @var ZCRMBulkCallBack
     */
    private $callback = null;
    
    /**
     * the user who created the record
     * @var ZCRMUser
     */
    private $createdBy = null;
    
    /**
     * created time of the record
     * @var string
     */
    private $createdTime = null;
    
    /**
     * api name of the module
     * @var string
     */
    private $moduleAPIName = null;
    
    /** when you want to export the events as an ICS file 
     * @var string
    */
    private $file_type = null;

    /**
     * constructor to set the module API name and job id
     * @param string $moduleAPIName
     * @param string $jobId
     */
    private function __construct($moduleAPIName, $jobId)
    {
        $this->moduleAPIName = $moduleAPIName;
        $this->jobId = $jobId;
    }
    
    /**
     * Method to get the instance of the ZCRMBulkRead class
     * @param string $moduleAPIName
     * @param string $jobId
     * @return ZCRMBulkRead - class instance
     */
    public static function getInstance($moduleAPIName = null, $jobId = null)
    {
        return new ZCRMBulkRead($moduleAPIName, $jobId);
    }
    
    /**
     * Method to set the API Name of the module to be read.
     * @param String $moduleApiName
     */
    public function setModuleAPIName($moduleAPIName)
    {
        $this->moduleAPIName = $moduleAPIName;
    }
    
    /**
     * Method to get the API Name of the module to be read.
     * @return String api name of the module
     */
    public function getModuleAPIName()
    {
        return $this->moduleAPIName;
    }
    
    /**
     * Method to set the unique identifier of the bulk read job.
     * @param String $jobId job id of the record
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    }
    
    /**
     * Method to get the unique identifier of the bulk read job.
     * @return String job id of the bulk read job
     */
    public function getJobId()
    {
        return $this->jobId;
    }
    
    /**
     * Method to set the creator of that bulk read job
     * @param ZCRMUser $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Method to get the creator of that bulk read job
     * @return ZCRMUser
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Method to set the creation time of the bulk read job
     * @param String $createdTime creation time in ISO 8601 format
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
    
    /**
     * Method to get the creation time of the bulk read job
     * @return String creation time in ISO 8601 format
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }
    
    /**
     * Method to set the current status of the bulk read job
     * @param String $state state of the record
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * Method to get the current status of the bulk read job
     * @return String
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Method to set the type of action the API completed.
     * @param String $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }
    
    /**
     * Method to get the type of action the API completed.
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }
    
    /**
     * Method to set callback details to the bulk read job.
     * @param ZCRMBulkCallBack $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }
    
    /**
     * Method to get callback details of the bulk read job.
     * @return ZCRMBulkCallBack - class instance
     */
    public function getCallback()
    {
        return $this->callback;
    }
    
    /**
     * Method to set result details to the bulk read job. 
     * @param ZCRMBulkResult $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
    
    /**
     * Method to get result details to the bulk read job. 
     * @return ZCRMBulkResult - class instance
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * Method to set query details to the bulk read job.
     * @param ZCRMBulkQuery $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }
    
    /**
     * Method to get query details to the bulk read job.
     * @return ZCRMBulkQuery
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Method to set file_type value for this key as "ics" to export all records in the Events module as an ICS file.
     * @param String $file_type
     */
    public function setFileType($file_type)
    {
        $this->file_type = $file_type;
    }
    
    /**
     * Method to get file_type value for this key as "ics" to export all records in the Events module as an ICS file.
     * @return string
     */
    public function getFileType()
    {
        return $this->file_type;
    }
    
    /**
     * Method to create a bulk read job to export records.
     * @return APIResponse - APIResponse instance of the APIResponse class which holds the API response.
     */
    public function createBulkReadJob()
    {
        return BulkReadAPIHandler::getInstance($this)->createBulkReadJob();
    }
    
    /**
     * Method to get the details of a bulk read job performed previously.
     * @return APIResponse - APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getBulkReadJobDetails()
    {
        return BulkReadAPIHandler::getInstance($this)->getBulkReadJobDetails();
    }
    
    /**
     * Method download the bulk read job as a CSV file.
     * @return FileAPIResponse - FileAPIResponse instance of the FileAPIResponse class which holds the response.
     */
    public function downloadBulkReadResult()
    {
        return BulkReadAPIHandler::getInstance($this)->downloadBulkReadResult();
    }
    
    /**
     * Method to get download the result of the bulk read job and get CSV file as ZCRMRecord instance.
     * @param string $filePath - file path to store the downloaded file.
     * @return BulkResponse - BulkResponse instance of the BulkResponse class which holds the response.
     */
    public function downloadANDGetRecords($filePath)
    {
        if ($filePath == null)
        {
            throw new ZCRMException("File Path must not be null for download and get records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        return BulkAPIHandler::getInstance($this, ZCRMBulkWrite::getInstance())->processZip($filePath, true, null, APIConstants::READ, null, false);
    }
    
    /**
     * Method to get CSV file as ZCRMRecord instance.
     * @param string $filePath - file path of the downloaded file.
     * @param string $fileName - file name of the downloaded file.
     * @return BulkResponse - BulkResponse instance of the BulkResponse class which holds the response.
     */
    public function getRecords($filePath, $fileName)
    {
        if ($fileName == null)
        {
            throw new ZCRMException("File Name must not be null for get records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        if ($filePath == null)
        {
            throw new ZCRMException("File Path must not be null for get records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        return BulkAPIHandler::getInstance($this, ZCRMBulkWrite::getInstance())->processZip($filePath, false, $fileName, APIConstants::READ, null, false);
    }
}


