<?php
namespace zcrmsdk\crm\bulkcrud;

use zcrmsdk\crm\bulkapi\handler\BulkWriteAPIHandler;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\bulkapi\handler\BulkAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\bulkapi\response\BulkResponse;
use zcrmsdk\crm\api\response\FileAPIResponse;
use zcrmsdk\crm\exception\ZCRMException;

class ZCRMBulkWrite
{
    /**
     * bulk write job id
     * @var string
     */
    private $jobId = null;
    
    /**
     * charset of the uploaded file
     * @var string
     */
    private $character_encoding = null;
    
    /**
     * bulk write operation
     * @var string
     */
    private $operation = null;
    
    /**
     * bulk write call back 
     * @var ZCRMBulkCallBack
     */
    private $callback = null;
    
    /**
     * the user who created the bulk write job
     * @var ZCRMUser
     */
    private $created_by = null;
    
    /**
     * creation time of the bulk write job
     * @var string
     */
    private $created_time = null;
    
    /**
     * status of the bulk write job
     * @var string
     */
    private $status = null;
    
    /**
     * bulk read resource
     * @var array of ZCRMBulkWriteResource instance 
     */
    private $resources = array();
    
    /**
     * bulk read result
     * @var ZCRMBulkResult
     */
    private $result;
    
    /**
     * constructor to set the operation type, job_id and module API name
     * @param string $operation
     * @param string $jobId
     * @param string $moduleAPIName
     */
    private function __construct($operation, $jobId, $moduleAPIName)
    {
        $this->operation = $operation;
        $this->jobId = $jobId;
        $this->moduleAPIName = $moduleAPIName;
    }
    
    /**
     * Method to get the instance of the ZCRMBulkWrite class
     * @param string $operation
     * @param string $jobId
     * @param string $moduleAPIName
     * @return ZCRMBulkWrite - class instance
     */
    public static function getInstance($operation = null, $jobId = null, $moduleAPIName = null)
    {
        return new ZCRMBulkWrite($operation, $jobId, $moduleAPIName);
    }
    
    /**
     * Method to set the module API name
     * @param string $moduleAPIName
     */
    public function setModuleAPIName($moduleAPIName)
    {
        $this->moduleAPIName = $moduleAPIName;
    }
    
    /**
     * Method to get the module API name
     * @return string
     */
    public function getModuleAPIName()
    {
        return $this->moduleAPIName;
    }
    
    /**
     * Method to set the unique identifier of the bulk write job
     * @param string $jobId
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    }
    
    /**
     * Method to get the unique identifier of the bulk write job
     * @return string
     */
    public function getJobId()
    {
        return $this->jobId;
    }
    
    /**
     * Method to set the the charset of the uploaded file.
     * @param string $character_encoding
     */
    public function setCharacterEncoding($character_encoding)
    {
        $this->character_encoding = $character_encoding;
    }
    
    /**
     * Method to get the character encoding for the bulk write job.
     * @return string
     */
    public function getCharacterEncoding()
    {
        return $this->character_encoding;
    }
    
    /**
     * Method to set the type of operation you want to perform on the bulk write job(values are[insert, update,upsert]).
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }
    
    /**
     * Method to get the type of bulk write operation performed. 
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }
    
    /**
     * Method to set a valid URL which should allow HTTP POST method.
     * @param ZCRMBulkCallBack $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }
    
    /**
     * Method to get the callback method and URL.
     * @return ZCRMBulkCallBack
     */
    public function getCallback()
    {
        return $this->callback;
    }
    
    /**
     * Method to set the creator of that bulk write job
     * @param ZCRMUser $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }
    
    /**
     * Method to get the creator of that bulk write job
     * @return ZCRMUser
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    
    /**
     * Method to set the creation time of the record
     * @param string $created_time creation time in ISO 8601 format
     */
    public function setCreatedTime($created_time)
    {
        $this->created_time = $created_time;
    }
    
    /**
     * Method to get the creation time of the record
     * @return string creation time in ISO 8601 format
     */
    public function getCreatedTime()
    {
        return $this->created_time;
    }
    
    /**
     * Method to set the current status of the bulk write job.
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Method to get the current status of the bulk write job.
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Method to set the ZCRMBulkWriteResource object
     * @param ZCRMBulkWriteResource $resource
     */
    public function setResource($resource)
    {
        array_push($this->resources, $resource);
    }
    
    /**
     * Method to get array ZCRMBulkWriteResource instance
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }
    
    /**
     * Method to set ZCRMBulkResult object
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
    
    /**
     * Method to get ZCRMBulkResult class instance
     * @return ZCRMBulkResult
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * Method to upload a CSV file in ZIP format for bulk write API.
     * @param string $filePath - uploaded zip file path
     * @param string $headers - uploaded file request headers
     * @return APIResponse - APIResponse instance of the APIResponse class which holds the API response.
     */
    public function uploadFile($filePath, $headers)
    {
        return BulkWriteAPIHandler::getInstance($this)->uploadFile($filePath, $headers);
    }
    
    /**
     * Method to create a bulk write job.
     * @return APIResponse - APIResponse instance of the APIResponse class which holds the API response.
     */
    public function createBulkWriteJob()
    {
        return BulkWriteAPIHandler::getInstance($this)->createBulkWriteJob();
    }
    
    /**
     * Method to get the details of a bulk write job performed previously.
     * @return APIResponse - APIResponse instance of the APIResponse class which holds the API response.
     */
    public function getBulkWriteJobDetails()
    {
        return BulkWriteAPIHandler::getInstance($this)->getBulkWriteJobDetails();
    }
    
    /**
     * Method to download the result of the bulk write job as a CSV file.
     * @param string $downloadedFileURL - the download URL from which you can download the result(CSV file) of the bulk write job.
     * @return FileAPIResponse - FileAPIResponse instance of the FileAPIResponse class which holds the response.
     */
    public function downloadBulkWriteResult($downloadedFileURL)
    {
        return BulkWriteAPIHandler::getInstance($this)->downloadBulkWriteResult($downloadedFileURL);
    }
    
    /**
     * Method to get download the result of the bulk write job and get CSV file as ZCRMRecord instance.
     * @param string $filePath - file path to store the downloaded file.
     * @param string $downloadFileURL - the download URL from which you can download the result(CSV file) of the bulk write job.
     * @return BulkResponse - BulkResponse instance of the BulkResponse class which holds the response.
     */
    public function downloadANDGetRecords($filePath, $downloadFileURL)
    {
        if ($downloadFileURL == null)
        {
            throw new ZCRMException("Download File URL must not be null for download and get records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        if ($filePath == null)
        {
            throw new ZCRMException("File Path must not be null for download and get records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        return BulkAPIHandler::getInstance(ZCRMBulkRead::getInstance(), $this)->processZip($filePath, true, null, APIConstants::WRITE, $downloadFileURL, false);
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
        return BulkAPIHandler::getInstance(ZCRMBulkRead::getInstance(), $this)->processZip($filePath, false, $fileName, APIConstants::WRITE, null, false);
    }
    
    /**
     * Method to get download the result of the bulk write job and get CSV file as failed ZCRMRecord instance.
     * @param string $filePath - file path to store the downloaded file.
     * @param string $downloadFileURL - the download URL from which you can download the result(CSV file) of the bulk write job.
     * @return BulkResponse - BulkResponse instance of the BulkResponse class which holds the response.
     */
    public function downloadANDGetFailedRecords($filePath, $downloadFileURL)
    {
        if ($downloadFileURL == null)
        {
            throw new ZCRMException("Download File URL must not be null for download and get failed records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        if ($filePath == null)
        {
            throw new ZCRMException("File Path must not be null for download and get failed records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        return BulkAPIHandler::getInstance(ZCRMBulkRead::getInstance(), $this)->processZip($filePath, true, null, APIConstants::WRITE, $downloadFileURL, true);
    }
    
    /**
     * Method to get CSV file as failed ZCRMRecord instance.
     * @param string $filePath - file path of the downloaded file.
     * @param string $fileName - file name of the downloaded file.
     * @return BulkResponse - BulkResponse instance of the BulkResponse class which holds the response.
     */
    public function getFailedRecords($filePath, $fileName)
    {
        if ($fileName == null)
        {
            throw new ZCRMException("File Name must not be null for get failed records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        if ($filePath == null)
        {
            throw new ZCRMException("File Path must not be null for get failed records operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        return BulkAPIHandler::getInstance(ZCRMBulkRead::getInstance(), $this)->processZip($filePath, false, $fileName, APIConstants::WRITE, null, true);
    }
}
?>