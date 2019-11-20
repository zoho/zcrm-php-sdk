<?php
namespace zcrmsdk\crm\bulkapi\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\api\handler\APIHandler;
use zcrmsdk\crm\bulkcrud\ZCRMBulkCallBack;
use zcrmsdk\crm\bulkcrud\ZCRMBulkResult;
use zcrmsdk\crm\bulkcrud\ZCRMBulkWriteFieldMapping;
use zcrmsdk\crm\bulkcrud\ZCRMBulkWriteFileStatus;
use zcrmsdk\crm\bulkcrud\ZCRMBulkWriteResource;
use zcrmsdk\crm\crud\ZCRMAttachment;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\utility\ZCRMConfigUtil;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;

class BulkWriteAPIHandler extends APIHandler
{
    protected $record = null;
    
    private function __construct($zcrmbulkread)
    {
        $this->record = $zcrmbulkread;
    }
    
    public static function getInstance($zcrmbulkread)
    {
        return new BulkWriteAPIHandler($zcrmbulkread);
    }
    
    public function uploadFile($filePath, $headers)
    {
        try
        {
            if ($filePath == null)
            {
                throw new ZCRMException("File path must not be null for file upload operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            if (sizeof($headers) <= 0)
            {
                throw new ZCRMException("Headers must not be null for file upload operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = ZCRMConfigUtil::getFileUploadURL() . "/crm/" . ZCRMConfigUtil::getAPIVersion() . "/". APIConstants::UPLOAD;
            if ($headers != null)
            {
                foreach ($headers as $key => $value)
                {
                    $this->addHeader($key, " " . $value); //header value with space in starting position
                }
            }
            $responseInstance = APIRequest::getInstance($this)->uploadFile($filePath);
            $responseJson = $responseInstance->getResponseJSON();
            $detailsJSON = isset($responseJson[APIConstants::DETAILS]) ? $responseJson[APIConstants::DETAILS] : array();
            $responseInstance->setData(self::getZCRMAttachmentObject($detailsJSON));
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function createBulkWriteJob()
    {
        try
        {
            if ($this->record->getJobId() != null)
            {
                throw new ZCRMException("JOB ID must be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = APIConstants::WRITE;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = json_encode(self::getZCRMBulkWriteAsJSON());
            $this->isBulk = true;
            
            //fire request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $reponseDetails = $responseInstance->getResponseJSON()[APIConstants::DETAILS];
            self::setBulkWriteRecordProperties($reponseDetails);
            $responseInstance->setData($this->record);
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getBulkWriteJobDetails()
    {
        try
        {
            if ($this->record->getJobId() == null)
            {
                throw new ZCRMException("JOB ID must not be null for get operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = APIConstants::WRITE . "/" . $this->record->getJobId();
            $this->addHeader("Content-Type", "application/json");
            $this->isBulk = true;
            
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $reponseDetails = $responseInstance->getResponseJSON();
            self::setBulkWriteRecordProperties($reponseDetails);
            $responseInstance->setData($this->record);
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function downloadBulkWriteResult($downloadURL)
    {
        if ($downloadURL == null)
        {
            throw new ZCRMException("Download File URL must not be null for download operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
        $this->urlPath = $downloadURL;
        return APIRequest::getInstance($this)->downloadFile();
    }
    
    private function getZCRMAttachmentObject($attachmentJson)
    {
        $attachment = ZCRMAttachment::getInstance(null, isset($attachmentJson['file_id']) ? ($attachmentJson['file_id']) : "0");
        if(isset($attachmentJson['created_time']))
        {
            $attachment->setCreatedTime($attachmentJson["created_time"]);
        }
        return $attachment;
    }
    
    private function getZCRMBulkWriteAsJSON()
    {
        $recordJSON = array();
        if ($this->record->getCharacterEncoding() != null)
        {
            $recordJSON["character_encoding"] = $this->record->getCharacterEncoding();
        }
        if($this->record->getOperation() != null)
        {
            $recordJSON["operation"] = $this->record->getOperation();
        }
        if($this->record->getCallback() != null)
        {
            $callback = $this->record->getCallback();
            $callBackJSON = array();
            if($callback->getUrl() != null)
            {
                $callBackJSON["url"] = $callback->getUrl();
            }
            if ($callback->getMethod() != null)
            {
                $callBackJSON["method"] = $callback->getMethod();
            }
            $recordJSON["callback"] = $callBackJSON;
        }
        if ($this->record->getResources() != null && sizeof($this->record->getResources()) > 0)
        {
            $recordJSON["resource"] = self::getZCRMBulkWriteResourceAsJSONArray();
        }
        return $recordJSON;
    }
    
    private function getZCRMBulkWriteResourceAsJSONArray()
    {
        $resource = array();
        foreach ($this->record->getResources() as $resourceObj)
        {
            array_push($resource, self::getZCRMBulkWriteResourceAsJSONObject($resourceObj));
        }
        return $resource;
    }
    
    private function getZCRMBulkWriteResourceAsJSONObject(ZCRMBulkWriteResource $resourceObj)
    {
        $resourceJSON = array();
        if ($resourceObj->getType() != null)
        {
            $resourceJSON["type"] = $resourceObj->getType();
        }
        if ($resourceObj->getModuleAPIName() != null)
        {
            $resourceJSON["module"] = $resourceObj->getModuleAPIName();
        }
        if ($resourceObj->getFileId() != null)
        {
            $resourceJSON["file_id"] = $resourceObj->getFileId();
        }
        if ("true" == $resourceObj->getIgnoreEmpty() || "false" == $resourceObj->getIgnoreEmpty())
        {
            $resourceJSON["ignore_empty"] = $resourceObj->getIgnoreEmpty();
        }
        if ($resourceObj->getFindBy() != null)
        {
            $resourceJSON["find_by"] = $resourceObj->getFindBy();
        }
        if ($resourceObj->getFieldMapping() != null && sizeof($resourceObj->getFieldMapping()) > 0)
        {
            $resourceJSON["field_mappings"] = self::getZCRMBulkWriteFieldMappingAsJSONArray($resourceObj->getFieldMapping());
        }
        return $resourceJSON;
    }
    
    private function getZCRMBulkWriteFieldMappingAsJSONArray($fieldMapping)
    {
        $fieldMappingArray = array();
        foreach ($fieldMapping as $fieldMappingObj)
        {
            array_push($fieldMappingArray,self::getZCRMBulkWriteFieldMappingJSONObject($fieldMappingObj));
        }
        return $fieldMappingArray;
    }
    
    private function getZCRMBulkWriteFieldMappingJSONObject(ZCRMBulkWriteFieldMapping $fieldMappingObj)
    {
        $fieldMappingJSON = array();
        if ($fieldMappingObj->getFieldAPIName() != null)
        {
            $fieldMappingJSON["api_name"] = $fieldMappingObj->getFieldAPIName();
        }
        if ($fieldMappingObj->getIndex() >= 0 && $fieldMappingObj->getIndex() != null)
        {
            $fieldMappingJSON["index"] = $fieldMappingObj->getIndex();
        }
        if ($fieldMappingObj->getDefaultValue() != null && sizeof($fieldMappingObj->getDefaultValue()) > 0)
        {
            $fieldMappingJSON["default_value"] = $fieldMappingObj->getDefaultValue();
        }
        if ($fieldMappingObj->getFindBy() != null)
        {
            $fieldMappingJSON["find_by"] = $fieldMappingObj->getFindBy();
        }
        if ($fieldMappingObj->getFormat() != null)
        {
            $fieldMappingJSON["format"] = $fieldMappingObj->getFormat();
        }
        return $fieldMappingJSON;
    }
    
    private function setBulkWriteRecordProperties($recordDetails)
    {
        foreach ($recordDetails as $key => $value)
        {
            if ("id" == $key && $value != null)
            {
                $this->record->setJobId($value);
            }
            else if ("created_by" == $key && $value != null)
            {
                $createdBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setCreatedBy($createdBy);
            }
            else if("created_time" == $key && $value != null)
            {
                $this->record->setCreatedTime($value);
            }
            else if("status" == $key && $value != null)
            {
                $this->record->setStatus($value);
            }
            else if("character_encoding" == $key && $value != null)
            {
                $this->record->setCharacterEncoding($value);
            }
            else if("resource" == $key && $value != null)
            {
                self::setZCRMBulkWriteResourceObject($value);
            }
            else if("result" == $key && $value != null)
            {
                $result = ZCRMBulkResult::getInstance();
                if(isset($value["download_url"]))
                {
                    $result->setDownloadUrl($value["download_url"]);
                }
                $this->record->setResult($result);
            }
            else if("operation" == $key && $value != null)
            {
                $this->record->setOperation($value);
            }
            else if("callback" == $key && $value != null)
            {
                $callback = ZCRMBulkCallBack::getInstance();
                if(isset($value["url"]))
                {
                    $callback->setUrl($value["url"]);
                }
                if(isset($value["method"]))
                {
                    $callback->setMethod($value["method"]);
                }
                $this->record->setCallback($callback);
            }
        }
    }
    
    private function setZCRMBulkWriteResourceObject($resource)
    {
        foreach($resource as $resourceJSON)
        {
            $resourceObj = ZCRMBulkWriteResource::getInstance();
            if(isset($resourceJSON["status"]) && $resourceJSON["status"] != null)
            {
                $resourceObj->setStatus($resourceJSON["status"]);
            }
            if(isset($resourceJSON["message"]) && $resourceJSON["message"] != null)
            {
                $resourceObj->setMessage($resourceJSON["message"]);
            }
            if(isset($resourceJSON["type"]) && $resourceJSON["type"] != null)
            {
                $resourceObj->setType($resourceJSON["type"]);
            }
            if(isset($resourceJSON["module"]) && $resourceJSON["module"] != null)
            {
                $resourceObj->setModuleAPIName($resourceJSON["module"]);
            }
            if(isset($resourceJSON["field_mappings"]) && $resourceJSON["field_mappings"] != null)
            {
                foreach ($resourceJSON["field_mappings"] as $fieldMappingJSON)
                {
                    $resourceObj->setFieldMapping(self::setZCRMBulkWriteFieldMappingObject($fieldMappingJSON));
                }
            }
            if(isset($resourceJSON["file"]) && $resourceJSON["file"] != null)
            {
                $resourceObj->setFileStatus(self::setZCRMBulkWriteFileObject($resourceJSON["file"]));
            }
            if (isset($resourceJSON["ignore_empty"]) && $resourceJSON["ignore_empty"] != null)
            {
                $resourceObj->setIgnoreEmpty($resourceJSON["ignore_empty"]);
            }
            if (isset($resourceJSON["find_by"]) && $resourceJSON["find_by"] != null)
            {
                $resourceObj->setFindBy($resourceJSON["find_by"]);
            }
            $this->record->setResource($resourceObj);
        }
    }
    
    private function setZCRMBulkWriteFieldMappingObject($fieldMappingJSON)
    {
        $fieldMappingObj = ZCRMBulkWriteFieldMapping::getInstance();
        if(isset($fieldMappingJSON["api_name"]) && $fieldMappingJSON["api_name"] != null)
        {
            $fieldMappingObj->setFieldAPIName($fieldMappingJSON["api_name"]);
        }
        if(isset($fieldMappingJSON["index"]) && ($fieldMappingJSON["index"] != null || $fieldMappingJSON["index"] == 0))
        {
            $fieldMappingObj->setIndex($fieldMappingJSON["index"]);
        }
        if(isset($fieldMappingJSON["find_by"]) && $fieldMappingJSON["find_by"] != null)
        {
            $fieldMappingObj->setFindBy($fieldMappingJSON["find_by"]);
        }
        if(isset($fieldMappingJSON["format"]) && $fieldMappingJSON["format"] != null)
        {
            $fieldMappingObj->setFormat($fieldMappingJSON["format"]);
        }
        if(isset($fieldMappingJSON["default_value"]) && $fieldMappingJSON["default_value"] != null)
        {
            foreach ($fieldMappingJSON["default_value"] as $fieldName => $fieldValue)
            {
                $fieldMappingObj->setDefaultValue($fieldName,$fieldValue);
            }
        }
        return $fieldMappingObj;
    }
    
    private function setZCRMBulkWriteFileObject($fileJSON)
    {
        $fileObj = ZCRMBulkWriteFileStatus::getInstance();
        if(isset($fileJSON["status"]) && $fileJSON["status"] != null)
        {
            $fileObj->setStatus($fileJSON["status"]);
        }
        if(isset($fileJSON["name"]) && $fileJSON["name"] != null)
        {
            $fileObj->setFileName($fileJSON["name"]);
        }
        if(isset($fileJSON["added_count"]) && ($fileJSON["added_count"] != null || $fileJSON["added_count"] == 0))
        {
            $fileObj->setAddedCount($fileJSON["added_count"]);
        }
        if(isset($fileJSON["skipped_count"]) && ($fileJSON["skipped_count"] != null || $fileJSON["skipped_count"] == 0))
        {
            $fileObj->setSkippedCount($fileJSON["skipped_count"]);
        }
        if(isset($fileJSON["updated_count"]) && ($fileJSON["updated_count"] != null || $fileJSON["updated_count"] == 0))
        {
            $fileObj->setUpdatedCount($fileJSON["updated_count"]);
        }
        if(isset($fileJSON["total_count"]) && ($fileJSON["total_count"] != null || $fileJSON["total_count"] == 0))
        {
            $fileObj->setTotalCount($fileJSON["total_count"]);
        }
        return $fileObj;
    }
}