<?php
namespace zcrmsdk\crm\bulkapi\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\api\handler\APIHandler;
use zcrmsdk\crm\bulkcrud\ZCRMBulkCallBack;
use zcrmsdk\crm\bulkcrud\ZCRMBulkCriteria;
use zcrmsdk\crm\bulkcrud\ZCRMBulkQuery;
use zcrmsdk\crm\bulkcrud\ZCRMBulkResult;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;

class BulkReadAPIHandler extends APIHandler
{
    protected $record = null;
    private $index = 1; 
    
    private function __construct($zcrmbulkread)
    {
        $this->record = $zcrmbulkread;
    }
    
    public static function getInstance($zcrmbulkread)
    {
        return new BulkReadAPIHandler($zcrmbulkread);
    }
    
    public function getBulkReadJobDetails()
    {
        try
        {
            if ($this->record->getJobId() == null)
            {
                throw new ZCRMException("JOB ID must not be null for get operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = APIConstants::READ . "/" . $this->record->getJobId();
            $this->addHeader("Content-Type", "application/json");
            $this->isBulk = true;
            
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $recordDetails = $responseInstance->getResponseJSON()[APIConstants::DATA];
            self::setBulkReadRecordProperties($recordDetails[0]);
            $responseInstance->setData($this->record);
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function createBulkReadJob()
    {
        try
        {
            if ($this->record->getJobId() != null)
            {
                throw new ZCRMException("JOB ID must be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = APIConstants::READ;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = json_encode(self::getZCRMBulkQueryAsJSON());
            $this->isBulk = true;
            //fire request
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $responseDataArray = $responseInstance->getResponseJSON()[APIConstants::DATA];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData[APIConstants::DETAILS];
            self::setBulkReadRecordProperties($reponseDetails);
            $responseInstance->setData($this->record);
            return $responseInstance;
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function downloadBulkReadResult()
    {
        try
        {
            if ($this->record->getJobId() == null)
            {
                throw new ZCRMException("JOB ID must not be null for get bulk read result operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = APIConstants::READ . "/" . $this->record->getJobId() . "/" . APIConstants::RESULT;
            $this->isBulk = true;
            return APIRequest::getInstance($this)->downloadFile();
        }
        catch (ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    private function setBulkReadRecordProperties($recordDetails)
    {
        foreach ($recordDetails as $key => $value)
        {
            if ("id" == $key && $value != null)
            {
                $this->record->setJobId($value);
            }
            else if ("operation" == $key && $value != null)
            {
                $this->record->setOperation($value);
            }
            else if("state" == $key && $value != null)
            {
                $this->record->setState($value);
            }
            else if("created_by" == $key && $value != null)
            {
                $createdBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setCreatedBy($createdBy);
            }
            else if ("created_time" == $key && $value != null)
            {
                $this->record->setCreatedTime($value);
            }
            else if("result" == $key && $value != null)
            {
                $this->record->setResult(self::setZCRMResultObject($value));
            }
            else if ("query" == $key && $value != null)
            {
                $this->record->setQuery(self::setZCRMBulkQueryObject($value));
            }
            else if ("callback" == $key && $value != null)
            {
                $this->record->setCallback(self::setZCRMBulkReadCallbackObject($value));
            }
            else if ("file_type" == $key && $value != null)
            {
                $this->record->setFileType($value);
            }
        }
    }
    
    private function setZCRMBulkQueryObject($queryValue)
    {
        $query = ZCRMBulkQuery::getInstance();
        foreach ($queryValue as $key => $value)
        {
            if("module" == $key && $value != null)
            {
                $this->record->setModuleAPIName($value);
                $query->setModuleAPIName($value);
            }
            else if("page" == $key && $value != null)
            {
                $query->setPage($value);
            }
            else if("cvid" == $key && $value != null)
            {
                $query->setCvId($value);
            }
            else if("fields" == $key && $value != null)
            {
                $query->setFields($value);
            }
            else if ("criteria" == $key && $value != null)
            {
                $this->index = 1;
                $criteriaInstance = self::setZCRMBulkCriteriaObject($value, $this->index);
                $query->setCriteria($criteriaInstance);
                $query->setCriteriaPattern($criteriaInstance->getPattern());
                $query->setCriteriaCondition($criteriaInstance->getCriteria());
            }
        }
        return $query;
    }
    
    private function setZCRMBulkCriteriaObject($criteriaJSON)
    {
        $recordCriteria = ZCRMBulkCriteria::getInstance();
        $recordCriteria->setAPIName(isset($criteriaJSON['api_name'])? $criteriaJSON['api_name'] : null);
        $recordCriteria->setComparator(isset($criteriaJSON['comparator'])? $criteriaJSON['comparator'] : null);
        if(isset($criteriaJSON['value']))
        {
            if(is_bool($criteriaJSON['value']))
            {
                $recordCriteria->setValue((bool)$criteriaJSON['value']);
            }
            else 
            {
                $recordCriteria->setValue($criteriaJSON['value']);
            }
            $recordCriteria->setIndex($this->index);
            $recordCriteria->setPattern((string)$this->index);
            $this->index = $this->index + 1;
            $recordCriteria->setCriteria("(".$criteriaJSON['api_name'].":".$criteriaJSON['comparator'].":".json_encode($recordCriteria->getValue()).")");
        }
        
        if (isset($criteriaJSON['group']))
        {
            $group_criteria = array();
            foreach ($criteriaJSON['group'] as $group)
            {
                array_push($group_criteria, self::setZCRMBulkCriteriaObject($group));
            }
            $recordCriteria->setGroup($group_criteria);
        }
        
        if(isset($criteriaJSON['group_operator']))
        {
            $criteriavalue = "(";
            $pattern = "(";
            $recordCriteria->setGroupOperator($criteriaJSON['group_operator']);
            $count = sizeof($group_criteria);
            $i = 0;
            foreach ($group_criteria as $criteriaObj)
            {
                $i++;
                $criteriavalue .= $criteriaObj->getCriteria();
                $pattern .= $criteriaObj->getPattern();
                if ($i < $count)
                {
                    $criteriavalue .= $recordCriteria->getGroupOperator();
                    $pattern .= $recordCriteria->getGroupOperator();
                }
            }
            $recordCriteria->setCriteria($criteriavalue . ")");
            $recordCriteria->setPattern($pattern . ")");

            
            // $recordCriteria->setCriteria("(".$group_criteria[0]->getCriteria().$recordCriteria->getGroupOperator().$group_criteria[1]->getCriteria().")");
            // $recordCriteria->setPattern("(".$group_criteria[0]->getPattern().$recordCriteria->getGroupOperator().$group_criteria[1]->getPattern().")");
        }
        return $recordCriteria;
    }
    
    private function getZCRMBulkQueryAsJSON()
    {
        $requestBodyObject = array();
        $recordJSON = array();
        if ($this->record->getModuleAPIName() != null)
        {
            $recordJSON["module"] = $this->record->getModuleAPIName();
        }
        if ($this->record->getQuery() != null)
        {
            $query = $this->record->getQuery();
            if($query->getFields() != null && sizeof($query->getFields()) > 0)
            {
                $recordJSON["fields"] = $query->getFields();
            }
            if ($query->getPage() > 0)
            {
                $recordJSON["page"] = $query->getPage();
            }
            if ($query->getCriteria() != null)
            {
                $recordJSON["criteria"] = self::getCriteriaAsJSONObject($query->getCriteria());
            }
            if ($query->getCvId() != 0)
            {
                $recordJSON["cvid"] = $query->getCvId();
            }
        }
        if($this->record->getCallback() != null)
        {
            $requestBodyObject[APIConstants::CALLBACK] = self::getCallBackAsJSONObject($this->record->getCallback());
        }
        if($this->record->getFileType() != null)
        {
            $requestBodyObject[APIConstants::FILETYPE] = $this->record->getFileType();
        }
        $requestBodyObject[APIConstants::QUERY] = $recordJSON;
        return $requestBodyObject;
    }
    
    private function getCriteriaAsJSONObject(ZCRMBulkCriteria $criteria)
    {
        $recordCriteria = array();
        if ($criteria->getAPIName() != null)
        {
            $recordCriteria["api_name"] = $criteria->getAPIName();
        }
        if ($criteria->getValue() != null || is_bool($criteria->getValue()))
        {
            $recordCriteria["value"] = $criteria->getValue();
        }
        if ($criteria->getGroupOperator() != null)
        {
            $recordCriteria["group_operator"] = $criteria->getGroupOperator();
        }
        if ($criteria->getComparator() != null)
        {
            $recordCriteria["comparator"] = $criteria->getComparator();
        }
        if ($criteria->getGroup() != null && sizeof($criteria->getGroup()) > 0 )
        {
            $recordData = array();
            foreach ($criteria->getGroup() as $group)
            {
                array_push($recordData , self::getCriteriaAsJSONObject($group));
            }
            $recordCriteria["group"] = $recordData;
        }
        return $recordCriteria;
    }
    
    private function getCallBackAsJSONObject(ZCRMBulkCallBack $callback)
    {
        $callbackJSON = array();
        if($callback->getUrl() != null)
        {
            $callbackJSON["url"] = $callback->getUrl();
        }
        if($callback->getMethod() != null)
        {
            $callbackJSON["method"] = $callback->getMethod();
        }
        return $callbackJSON;
    }
    
    private function setZCRMBulkReadCallbackObject($callbackJSON)
    {
        $callback = ZCRMBulkCallBack::getInstance();
        if(array_key_exists("url",$callbackJSON) && $callbackJSON["url"] != null)
        {
            $callback->setUrl($callbackJSON["url"]);
        }
        if(array_key_exists("method",$callbackJSON) && $callbackJSON["method"] != null)
        {
            $callback->setMethod($callbackJSON["method"]);
        }
        return $callback;
    }
    
    private function setZCRMResultObject($resultJSON)
    {
        $result = ZCRMBulkResult::getInstance();
        if (array_key_exists("download_url", $resultJSON) && $resultJSON["download_url"] != null)
        {
            $result->setDownloadUrl($resultJSON["download_url"]);
        }
        if (array_key_exists("page", $resultJSON))
        {
            $result->setPage($resultJSON["page"]+0);
        }
        if (array_key_exists("count", $resultJSON))
        {
            $result->setCount($resultJSON["count"]+0);
        }
        if (array_key_exists("per_page", $resultJSON))
        {
            $result->setPerPage($resultJSON["per_page"]+0);
        }
        if (array_key_exists("more_records", $resultJSON))
        {
            $result->setMoreRecords((bool)$resultJSON["more_records"]);
        }
        return $result;
    }
}
?>