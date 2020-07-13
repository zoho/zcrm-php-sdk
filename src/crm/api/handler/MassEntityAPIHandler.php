<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMTrashRecord;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

class MassEntityAPIHandler extends APIHandler
{
    
    private $module = null;
    
    public function __construct($moduleInstance)
    {
        $this->module = $moduleInstance;
    }
    
    public static function getInstance($moduleInstance)
    {
        return new MassEntityAPIHandler($moduleInstance);
    }
    
    public function createRecords($records, $trigger,$lar_id,$process)
    {
        if (sizeof($records) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlPath = $this->module->getAPIName();
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type", "application/json");
            $requestBodyObj = array();
            $dataArray = array();
            foreach ($records as $record) {
                if ($record->getEntityId() == null) {
                    array_push($dataArray, EntityAPIHandler::getInstance($record)->getZCRMRecordAsJSON());
                } else {
                    throw new ZCRMException("Entity ID MUST be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
                }
            }
            $requestBodyObj["data"] = $dataArray;
            if ($trigger !== null && is_array($trigger)) {
                $requestBodyObj["trigger"] = $trigger;
            }
            if ($lar_id !== null) {
                $requestBodyObj["lar_id"] = $lar_id;
            }
            if($process !== null && is_array($process) ){
                $requestBodyObj["process"] =$process;
            }
            
            $this->requestBody = $requestBodyObj;
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            $createdRecords = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityResIns = $responses[$i];
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus()) {
                    $responseData = $entityResIns->getResponseJSON();
                    $recordDetails = $responseData["details"];
                    $newRecord = $records[$i];
                    EntityAPIHandler::getInstance($newRecord)->setRecordProperties($recordDetails);
                    array_push($createdRecords, $newRecord);
                    $entityResIns->setData($newRecord);
                } else {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($createdRecords);
            return $bulkAPIResponse;
        } catch (ZCRMException $e) {
            throw $e;
        }
    }
    
    public function upsertRecords($records, $trigger,$lar_id,$duplicate_check_fields,$process)
    {
        if (sizeof($records) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlPath = $this->module->getAPIName() . "/upsert";
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type", "application/json");
            if($duplicate_check_fields!=null)
            $this->addParam("duplicate_check_fields", implode(",", $duplicate_check_fields)); // converts array to string with specified seperator
            $requestBodyObj = array();
            $dataArray = array();
            foreach ($records as $record)
            {
                $recordJSON=EntityAPIHandler::getInstance($record)->getZCRMRecordAsJSON();
                if($record->getEntityId()!=null)
                {
                    $recordJSON['id']=$record->getEntityId();
                }
                array_push($dataArray,$recordJSON);
            }
            $requestBodyObj["data"] = $dataArray;
            if ($trigger !== null && is_array($trigger)) {
                $requestBodyObj["trigger"] = $trigger;
            }
            if ($lar_id !== null) {
                $requestBodyObj["lar_id"] = $lar_id;
            }
            if($process !== null && is_array($process) ){
                $requestBodyObj["process"] =$process;
            }
            $this->requestBody = $requestBodyObj;
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            $upsertRecords = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityResIns = $responses[$i];
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus()) {
                    $responseData = $entityResIns->getResponseJSON();
                    $recordDetails = $responseData["details"];
                    $newRecord = $records[$i];
                    EntityAPIHandler::getInstance($newRecord)->setRecordProperties($recordDetails);
                    array_push($upsertRecords, $newRecord);
                    $entityResIns->setData($newRecord);
                } else {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($upsertRecords);
            return $bulkAPIResponse;
        } catch (ZCRMException $e) {
            throw $e;
        }
    }
    
    public function updateRecords($records, $trigger,$process)
    {
        if (sizeof($records) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlPath = $this->module->getAPIName();
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $requestBodyObj = array();
            $dataArray = array();
            foreach ($records as $record) {
                $recordJSON = EntityAPIHandler::getInstance($record)->getZCRMRecordAsJSON();
                if ($record->getEntityId() != null) {
                    $recordJSON['id'] = $record->getEntityId();
                }
                array_push($dataArray, $recordJSON);
            }
            $requestBodyObj["data"] = $dataArray;
            if ($trigger !== null && is_array($trigger)) {
                $requestBodyObj["trigger"] = $trigger;
            }
            if($process !== null && is_array($process) ){
                $requestBodyObj["process"] =$process;
            }
            
            $this->requestBody = $requestBodyObj;
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            $upsertRecords = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityResIns = $responses[$i];
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus()) {
                    $responseData = $entityResIns->getResponseJSON();
                    $recordDetails = $responseData["details"];
                    $newRecord = $records[$i];
                    EntityAPIHandler::getInstance($newRecord)->setRecordProperties($recordDetails);
                    array_push($upsertRecords, $newRecord);
                    $entityResIns->setData($newRecord);
                } else {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($upsertRecords);
            return $bulkAPIResponse;
        } catch (ZCRMException $e) {
            throw $e;
        }
    }
    
    public function deleteRecords($entityIds)
    {
        if (sizeof($entityIds) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlPath = $this->module->getAPIName();
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("ids", implode(",", $entityIds)); // converts array to string with specified seperator
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responses = $bulkAPIResponse->getEntityResponses();
            
            foreach ($responses as $entityResIns) {
                $responseData = $entityResIns->getResponseJSON();
                $responseJSON = $responseData["details"];
                $record = ZCRMRecord::getInstance($this->module->getAPIName(), $responseJSON["id"]);
                $entityResIns->setData($record);
            }
            return $bulkAPIResponse;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getAllDeletedRecords($param_map,$header_map)
    {
        return self::getDeletedRecords($param_map,$header_map,"all");
    }
    
    public function getRecycleBinRecords($param_map,$header_map)
    {
        return self::getDeletedRecords($param_map,$header_map,"recycle");
    }
    
    public function getPermanentlyDeletedRecords($param_map,$header_map)
    {
        return self::getDeletedRecords($param_map,$header_map,"permanent");
    }
    
    private function getDeletedRecords($param_map,$header_map,$type)
    {
        try {
            $this->urlPath = $this->module->getAPIName() . "/deleted";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            foreach($param_map as $key=>$value){
                if($value!=null)$this->addParam($key,$value);
            }
            foreach($header_map as $key=>$value){
                if($value!=null)$this->addHeader($key,$value);
            }
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("type", $type);
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $trashRecords = $responseJSON["data"];
            $trashRecordList = array();
            foreach ($trashRecords as $trashRecord) {
                $trashRecordInstance = ZCRMTrashRecord::getInstance($trashRecord['type'], $trashRecord['id']);
                self::setTrashRecordProperties($trashRecordInstance, $trashRecord);
                array_push($trashRecordList, $trashRecordInstance);
            }
            
            $responseInstance->setData($trashRecordList);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function setTrashRecordProperties($trashRecordInstance, $recordProperties)
    {
        if ($recordProperties['display_name'] != null) {
            $trashRecordInstance->setDisplayName($recordProperties['display_name']);
        }
        if ($recordProperties['created_by'] != null) {
            $createdBy = $recordProperties['created_by'];
            $createdBy_User = ZCRMUser::getInstance($createdBy['id'], $createdBy['name']);
            $trashRecordInstance->setCreatedBy($createdBy_User);
        }
        if ($recordProperties['deleted_by'] != null) {
            $deletedBy = $recordProperties['deleted_by'];
            $deletedBy_User = ZCRMUser::getInstance($deletedBy['id'], $deletedBy['name']);
            $trashRecordInstance->setDeletedBy($deletedBy_User);
        }
        $trashRecordInstance->setDeletedTime($recordProperties['deleted_time']);
    }
    
    public function getRecords($param_map,$header_map)
    {
        try {
            $this->urlPath = $this->module->getAPIName();
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            foreach ($param_map as $key => $value) {
                if($value!==null)$this->addParam($key, $value);
            }
            foreach ($header_map as $key => $value) {
                if($value!==null)$this->addHeader($key, $value);
            }
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $records = $responseJSON["data"];
            $recordsList = array();
            foreach ($records as $record) {
                $recordInstance = ZCRMRecord::getInstance($this->module->getAPIName(), $record["id"]);
                EntityAPIHandler::getInstance($recordInstance)->setRecordProperties($record);
                array_push($recordsList, $recordInstance);
            }
            
            $responseInstance->setData($recordsList);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function searchRecords($param_map,$type,$search_value)
    {
        try {
            $this->urlPath = $this->module->getAPIName() . "/search";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $exclusion_array = ["word","phone","email","criteria"];
            foreach($exclusion_array as $exclusion){
                if(array_key_exists($exclusion, $param_map)){
                    unset($param_map[$exclusion]);
                }
            }
            foreach ($param_map as $key => $value) {
                if($value!==null)$this->addParam($key, $value);
            }
            $this->addParam($type, $search_value);
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $records = $responseJSON["data"];
            $recordsList = array();
            foreach ($records as $record) {
                $recordInstance = ZCRMRecord::getInstance($this->module->getAPIName(), $record["id"]);
                EntityAPIHandler::getInstance($recordInstance)->setRecordProperties($record);
                array_push($recordsList, $recordInstance);
            }
            
            $responseInstance->setData($recordsList);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function massUpdateRecords($idList, $apiName, $value)
    {
        if (sizeof($idList) > 100) {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $inputJSON = self::constructJSONForMassUpdate($idList, $apiName, $value);
            $this->urlPath = $this->module->getAPIName();
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $inputJSON;
            $this->apiKey = 'data';
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            
            $updatedRecords = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityResIns = $responses[$i];
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus()) {
                    $responseData = $entityResIns->getResponseJSON();
                    $recordJSON = $responseData["details"];
                    
                    $updatedRecord = ZCRMRecord::getInstance($this->module->getAPIName(), $recordJSON["id"]);
                    EntityAPIHandler::getInstance($updatedRecord)->setRecordProperties($recordJSON);
                    array_push($updatedRecords, $updatedRecord);
                    $entityResIns->setData($updatedRecord);
                } else {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($updatedRecords);
            
            return $bulkAPIResponse;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function constructJSONForMassUpdate($idList, $apiName, $value)
    {
        $massUpdateArray = array();
        foreach ($idList as $id) {
            $updateJson = array();
            $updateJson["id"] = "" . $id;
            $updateJson[$apiName] = $value;
            array_push($massUpdateArray, $updateJson);
        }
        
        return array(
            "data" => $massUpdateArray
        );
    }
}