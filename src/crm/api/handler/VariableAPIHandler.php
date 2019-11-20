<?php
namespace zcrmsdk\crm\api\handler;
use zcrmsdk\crm\crud\ZCRMVariable;
use zcrmsdk\crm\crud\ZCRMVariableGroup;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\api\handler\APIHandler;
use zcrmsdk\crm\utility\APIConstants;

class VariableAPIHandler extends APIHandler
{
    private $variables=null;

    public static function getInstance()
    {
        return  new VariableAPIHandler();
    }
    public function getVariables()
    {
        try{
            $this->urlPath="settings/variables";
            $this->requestMethod=APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type","application/json");
            $this->apiKey="variables";
            $response=APIRequest::getInstance($this)->getBulkApiResponse();
            $responseJson=$response->getResponseJson();
            $data=$responseJson["variables"];
            $dataList=array();
            foreach($data as $jsonData)
            {
                $variablesIns=ZCRMVariable::getInstance();
                self::getVariablesResAsObj($jsonData,$variablesIns);
                array_push($dataList,$variablesIns);
            }
            $response->setData($dataList);
            return  $response;
        }
        catch(ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    private function getVariablesResAsObj($jsonData,$entityInstance)
    {
        foreach($jsonData as $key=>$value)
        {

            if("id"==$key)
            {
                $entityInstance->setId($value);
            }
            else if("name"==$key)
            {
                $entityInstance->setName($value);
            }
            else if("api_name"==$key)
            {
                $entityInstance->setApiName($value);
            }
            else if("type"==$key)
            {
                $entityInstance->setType($value);
            }
            else if("value"==$key)
            {
                $entityInstance->setValue($value);
            }
            if("variable_group"==$key)
            {
                $ZCRMVariableGroupIns=ZCRMVariableGroup::getInstance();
                $ZCRMVariableGroupIns->setId($value['id']);
                $ZCRMVariableGroupIns->setApiName($value['api_name']);
                $entityInstance->setVariableGroup($ZCRMVariableGroupIns);
            }
            if("description"==$key)
            {
                $entityInstance->setDescription($value);
            }
        }
    }
    
    public function getVariable($group)
    {
        try{
            $this->urlPath="settings/variables/".$this->variables->getId();
            $this->requestMethod=APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type","application/json");
            if($group!=null)
            {
                $this->addParam("group",$group);
            }
            $this->apiKey="variables";
            $response=APIRequest::getInstance($this)->getApiResponse();
            $responseJson=$response->getResponseJson();
            $data=$responseJson["variables"];
            $jsonData=$data[0];
            $variablesIns=ZCRMVariable::getInstance();
            self::getVariableResAsObj($jsonData,$variablesIns);
            $response->setData($variablesIns);
            return  $response;
        }
        catch(ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    private function getVariableResAsObj($jsonData,$entityInstance)
    {
        foreach($jsonData as $key=>$value)
        {

            if("id"==$key)
            {
                $entityInstance->setId($value);
            }
            else if("name"==$key)
            {
                $entityInstance->setName($value);
            }
            else if("api_name"==$key)
            {
                $entityInstance->setApiName($value);
            }
            else if("type"==$key)
            {
                $entityInstance->setType($value);
            }
            else if("value"==$key)
            {
                $entityInstance->setValue($value);
            }
            if("variable_group"==$key)
            {
                $ZCRMVariableGroupIns=ZCRMVariableGroup::getInstance();
                $ZCRMVariableGroupIns->setId($value['id']);
                $ZCRMVariableGroupIns->setApiName($value['api_name']);
                $entityInstance->setVariableGroup($ZCRMVariableGroupIns);
            }
            if("description"==$key)
            {
                $entityInstance->setDescription($value);
            }
        }
    }
    
    public function createVariables($variable)
    {
        try{
            $this->urlPath="settings/variables";
            $this->requestMethod=APIConstants::REQUEST_METHOD_POST;
            $this->addHeader("Content-Type","application/json");
            $this->apiKey="variables";
            $requestBody=array();
            $dataList=array();
            foreach($variable as $eachVariable)
            {
                $dataObject=self::convertObjectToJson($eachVariable);
                array_push($dataList,$dataObject);
            }
            $requestBody['variables']=$dataList;
            $this->requestBody=$requestBody;
            $response=APIRequest::getInstance($this)->getBulkApiResponse();
            return  $response;
        }
        catch(ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    private function convertObjectToJson($entityInstance)
    {
        $variablesJson=array();
        if($entityInstance->getId()!=null)
        {
            $variablesJson["id"]=$entityInstance->getId();
        }
        if($entityInstance->getName()!=null)
        {
            $variablesJson["name"]="".$entityInstance->getName();
        }
        if($entityInstance->getApiName()!=null)
        {
            $variablesJson["api_name"]="".$entityInstance->getApiName();
        }
        if($entityInstance->getType()!=null)
        {
            $variablesJson["type"]="".$entityInstance->getType();
        }
        if($entityInstance->getValue()!=null)
        {
            $variablesJson["value"]="".$entityInstance->getValue();
        }
        if($entityInstance->getVariableGroup()!=null)
        {
            $variableGroupJson=array();
            $variableGroup=$entityInstance->getVariableGroup();
            if($variableGroup->getId()!=null)
            {
                $variableGroupJson["id"]=$variableGroup->getId();
            }
            if($variableGroup->getApiName()!=null)
            {
                $variableGroupJson["api_name"]="".$variableGroup->getApiName();
            }
            $variablesJson["variable_group"]=$variableGroupJson;
        }
        if($entityInstance->getDescription()!=null)
        {
            $variablesJson["description"]="".$entityInstance->getDescription();
        }
        return  $variablesJson;
    }
    
    public function updateVariables($variable)
    {
        try{
            $this->urlPath="settings/variables";
            $this->requestMethod=APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type","application/json");
            $this->apiKey="variables";
            $requestBody=array();
            $dataList=array();
            foreach($variable as $eachVariable)
            {
                $dataObject=self::convertObjectToJson($eachVariable);
                array_push($dataList,$dataObject);
            }
            $requestBody['variables']=$dataList;
            $this->requestBody=$requestBody;
            $response=APIRequest::getInstance($this)->getBulkApiResponse();
            return  $response;
        }
        catch(ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function updateVariable()
    {
        try{
            $this->urlPath="settings/variables/".$this->variables->getId();
            $this->requestMethod=APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type","application/json");
            $this->apiKey="variables";
            $requestBody=array();
            $dataList=array();
            $dataObject=self::convertObjectToJson($this->variables);
            array_push($dataList,$dataObject);
            $requestBody['variables']=$dataList;
            $requestBody=json_encode($requestBody);
            $this->requestBody=$requestBody;
            $response=APIRequest::getInstance($this)->getApiResponse();
            return  $response;
        }
        catch(ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deleteVariable()
    {
        try{
            $this->urlPath="settings/variables/".$this->variables->getId();
            $this->requestMethod=APIConstants::REQUEST_METHOD_DELETE;
            $this->addHeader("Content-Type","application/json");
            $this->apiKey="variables";
            $requestBody=array();
            $dataList=array();
            $dataObject=self::convertObjectToJson($this->variables);
            array_push($dataList,$dataObject);
            $requestBody['variables']=$dataList;
            $requestBody=json_encode($requestBody);
            $this->requestBody=$requestBody;
            $response=APIRequest::getInstance($this)->getApiResponse();
            return  $response;
        }
        catch(ZCRMException $exception)
        {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function setVariables($variables)
    {
        $this->variables=$variables;
    }
}