<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMTag;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

class TagAPIHandler extends APIHandler
{
    
    protected $module = null;
    
    private function __construct($zcrmmodule)
    {
        $this->module = $zcrmmodule;
    }
    
    public static function getInstance($zcrmmodule = null)
    {
        return new TagAPIHandler($zcrmmodule);
    }
    
    public function getTags()
    {
        try
        {
            $this->urlPath = "settings/tags";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            
            $responseJSON = $responseInstance->getResponseJSON();
            $tags = $responseJSON[APIConstants::TAGS];
            $tagsList = array();
            foreach ($tags as $tag)
            {
                $tagInstance = ZCRMTag::getInstance($tag["id"]);
                self::setTagProperties($tagInstance, $tag);
                array_push($tagsList, $tagInstance);
            }
            $responseInstance->setData($tagsList);
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getTagCount($tagId)
    {
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = "settings/tags/" . $tagId . "/actions/records_count";
            $this->addParam("module", $this->module->getAPIName());
            
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $tagDetails = $responseInstance->getResponseJSON();
            $tagInstance = ZCRMTag::getInstance($tagId);
            self::setTagProperties($tagInstance, $tagDetails);
            $responseInstance->setData($tagInstance);
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function createTags($tags)
    {
        if (sizeof($tags) > 50)
        {
            throw new ZCRMException(APIConstants::API_MAX_TAGS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try
        {
            $this->urlPath = "settings/tags";
            $this->addParam("module", $this->module->getAPIName());
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type", "application/json");
            $requestBodyObj = array();
            $dataArray = array();
            foreach ($tags as $tag)
            {
                if ($tag->getId() != null)
                {
                    throw new ZCRMException("Tag ID MUST be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
                    
                }
                array_push($dataArray, self::getZCRMTagAsJSON($tag));
            }
            $requestBodyObj[APIConstants::TAGS] = $dataArray;
            $this->requestBody = $requestBodyObj;
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            
            $createdTags = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++)
            {
                $entityResIns = $responses[$i];
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus())
                {
                    $responseData = $entityResIns->getResponseJSON();
                    $tagDetails = $responseData[APIConstants::DETAILS];
                    $newTag = $tags[$i];
                    self::setTagProperties($newTag, $tagDetails);
                    array_push($createdTags, $newTag);
                    $entityResIns->setData($newTag);
                }
                else
                {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($createdTags);
            return $bulkAPIResponse;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function updateTags($tags)
    {
        if (sizeof($tags) > 50)
        {
            throw new ZCRMException(APIConstants::API_MAX_TAGS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try
        {
            $this->urlPath = "settings/tags";
            $this->addParam("module", $this->module->getAPIName());
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $requestBodyObj = array();
            $dataArray = array();
            foreach ($tags as $tag)
            {
                array_push($dataArray, self::getZCRMTagAsJSON($tag));
            }
            $requestBodyObj[APIConstants::TAGS] = $dataArray;
            $this->requestBody = $requestBodyObj;
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            
            $updatedTags = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++)
            {
                $entityResIns = $responses[$i];
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus())
                {
                    $responseData = $entityResIns->getResponseJSON();
                    $tagDetails = $responseData[APIConstants::DETAILS];
                    $updateTag = $tags[$i];
                    self::setTagProperties($updateTag, $tagDetails);
                    array_push($updatedTags, $updateTag);
                    $entityResIns->setData($updateTag);
                }
                else
                {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($updatedTags);
            return $bulkAPIResponse;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function delete($tagId)
    {
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->urlPath = "settings/tags/" . $tagId;
            $this->addHeader("Content-Type", "application/json");
            
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function merge($tagId, $mergeId)
    {
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = "settings/tags/" . $mergeId . "/actions/merge";
            $this->addHeader("Content-Type", "application/json");
            $tagJSON = array();
            $tagJSON["conflict_id"] = "" . $tagId;
            array_filter($tagJSON);
            $this->requestBody = json_encode(array_filter(array(
                "tags" => array(
                    $tagJSON
                )
            )));
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseDataArray = $responseInstance->getResponseJSON()[APIConstants::TAGS];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData[APIConstants::DETAILS];
            $tag = ZCRMTag::getInstance($reponseDetails['id']);
            self::setTagProperties($tag, $reponseDetails);
            $responseInstance->setData($tag);
            return $responseInstance;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function update($tag)
    {
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->urlPath = "settings/tags/" . $tag->getId();
            $this->addParam("module", $tag->getModuleAPIName());
            $this->addHeader("Content-Type", "application/json");
            $tagJSON = array();
            $tagJSON["name"] = "" . $tag->getName();
            array_filter($tagJSON);
            $this->requestBody = json_encode(array_filter(array(
                "tags" => array(
                    $tagJSON
                )
            )));
            
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $responseDataArray = $responseInstance->getResponseJSON()[APIConstants::TAGS];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData[APIConstants::DETAILS];
            self::setTagProperties($tag, $reponseDetails);
            $responseInstance->setData($tag);
            return $responseInstance;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function addTags($record, $tagNames)
    {
        if (sizeof($tagNames) > 10)
        {
            throw new ZCRMException(APIConstants::API_MAX_RECORD_TAGS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try 
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $record->getModuleApiName() . "/" . $record->getEntityId() . "/actions/add_tags";
            $this->addParam("tag_names", implode(',', $tagNames));
            
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $responseDataArray = $responseInstance->getResponseJSON()[APIConstants::DATA];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData[APIConstants::DETAILS];
            $addRecordIns = $record;
            EntityAPIHandler::getInstance($addRecordIns)->setRecordProperties($reponseDetails);
//             $addRecordIns->setTagNames($reponseDetails['tags']);
            $responseInstance->setData($addRecordIns);
            return $responseInstance;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function removeTags($record, $tagNames)
    {
        if (sizeof($tagNames) > 10)
        {
            throw new ZCRMException(APIConstants::API_MAX_RECORD_TAGS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $record->getModuleApiName() . "/" . $record->getEntityId() . "/actions/remove_tags";
            $this->addParam("tag_names", implode(',', $tagNames));
            
            // Fire Request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $responseDataArray = $responseInstance->getResponseJSON()[APIConstants::DATA];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData[APIConstants::DETAILS];
            $removeRecordIns = $record;
            EntityAPIHandler::getInstance($removeRecordIns)->setRecordProperties($reponseDetails);
            $responseInstance->setData($removeRecordIns);
            return $responseInstance;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function addTagsToRecords($recordId, $tagNames)
    {
        if (sizeof($tagNames) > 10)
        {
            throw new ZCRMException(APIConstants::API_MAX_RECORD_TAGS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        if (sizeof($recordId) > 100)
        {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $this->module->getAPIName() . "/actions/add_tags";
            $this->addParam("ids", implode(',', $recordId));
            $this->addParam("tag_names", implode(',', $tagNames));
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            
            $recordList = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            foreach ($responses as $entityResIns)
            {
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus())
                {
                    $responseData = $entityResIns->getResponseJSON();
                    $recordDetails = $responseData[APIConstants::DETAILS];
                    $addRecordIns = ZCRMRecord::getInstance($this->module->getAPIName(), $recordDetails["id"]);
                    EntityAPIHandler::getInstance($addRecordIns)->setRecordProperties($recordDetails);
                    array_push($recordList, $addRecordIns);
                    $entityResIns->setData($addRecordIns);
                }
                else
                {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($recordList);
            return $bulkAPIResponse;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function removeTagsFromRecords($recordId, $tagNames)
    {
        if (sizeof($tagNames) > 10)
        {
            throw new ZCRMException(APIConstants::API_MAX_RECORD_TAGS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        if (sizeof($recordId) > 100)
        {
            throw new ZCRMException(APIConstants::API_MAX_RECORDS_MSG, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
        try
        {
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $this->module->getAPIName() . "/actions/remove_tags";
            $this->addParam("ids", implode(',', $recordId));
            $this->addParam("tag_names", implode(',', $tagNames));
            
            // Fire Request
            $bulkAPIResponse = APIRequest::getInstance($this)->getBulkAPIResponse();
            
            $recordList = array();
            $responses = $bulkAPIResponse->getEntityResponses();
            foreach ($responses as $entityResIns)
            {
                if (APIConstants::STATUS_SUCCESS === $entityResIns->getStatus())
                {
                    $responseData = $entityResIns->getResponseJSON();
                    $recordDetails = $responseData[APIConstants::DETAILS];
                    $removeRecordIns = ZCRMRecord::getInstance($this->module->getAPIName(), $recordDetails["id"]);
                    EntityAPIHandler::getInstance($removeRecordIns)->setRecordProperties($recordDetails);
                    array_push($recordList, $removeRecordIns);
                    $entityResIns->setData($removeRecordIns);
                }
                else
                {
                    $entityResIns->setData(null);
                }
            }
            $bulkAPIResponse->setData($recordList);
            return $bulkAPIResponse;
        }
        catch (ZCRMException $e)
        {
            throw $e;
        }
    }
    
    public function setTagProperties($tagInstance, $tagDetails)
    {
        foreach ($tagDetails as $key => $value)
        {
            if ("id" == $key)
            {
                $tagInstance->setId($value);
            }
            else if ("name" == $key)
            {
                $tagInstance->setName($value);
            }
            else if ("created_by" == $key)
            {
                $createdBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $tagInstance->setCreatedBy($createdBy);
            }
            else if ("modified_by" == $key)
            {
                $modifiedBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $tagInstance->setModifiedBy($modifiedBy);
            }
            else if ("created_time" == $key)
            {
                $tagInstance->setCreatedTime("" . $value);
            }
            else if ("modified_time" == $key)
            {
                $tagInstance->setModifiedTime("" . $value);
            }
            else if ("count" == $key)
            {
                $tagInstance->setCount($value);
            }
        }
    }
    
    public function getZCRMTagAsJSON($tag)
    {
        $recordJSON = array();
        if ($tag->getName() != null)
        {
            $recordJSON["name"] = "" . $tag->getName();
        }
        if ($tag->getId() != null)
        {
            $recordJSON["id"] = "" . $tag->getId();
        }
        return array_filter($recordJSON);
    }
}