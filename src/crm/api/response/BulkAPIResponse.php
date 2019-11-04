<?php
namespace zcrmsdk\crm\api\response;

use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\utility\APIConstants;

class BulkAPIResponse extends CommonAPIResponse
{
    
    /**
     * the bulk data
     *
     * @var array
     */
    private $bulkData = null;
    
    /**
     * response status of the api
     *
     * @var string
     */
    private $status = null;
    
    /**
     * the response information
     *
     * @var ResponseInfo
     */
    private $info = null;
    
    /**
     * bulk entities response
     *
     * @var array array of EntityResponse instances
     */
    private $bulkEntitiesResponse = null;
    
    /**
     * constructor to set the http response and http status code
     *
     * @param string $httpResponse the http response
     * @param int $httpStatusCode  http status code
     */
    public function __construct($httpResponse, $httpStatusCode)
    {
        parent::__construct($httpResponse, $httpStatusCode);
        $this->setInfo();
    }
    
    /**
     *
     * {@inheritdoc}
     * @see CommonAPIResponse::handleForFaultyResponses()
     */
    public function handleForFaultyResponses()
    {
        $statusCode = self::getHttpStatusCode();
        if (in_array($statusCode, APIExceptionHandler::getFaultyResponseCodes())) {
            if ($statusCode == APIConstants::RESPONSECODE_NO_CONTENT) {
                $exception = new ZCRMException("No Content", $statusCode);
                $exception->setExceptionCode("NO CONTENT");
                throw $exception;
            }
            else if ($statusCode == APIConstants::RESPONSECODE_NOT_MODIFIED) {
                $exception = new ZCRMException("Not Modified", $statusCode);
                $exception->setExceptionCode("NOT MODIFIED");
                throw $exception;
            }
            else {
                $responseJSON = $this->getResponseJSON();
                $exception = new ZCRMException($responseJSON[APIConstants::MESSAGE], $statusCode);
                $exception->setExceptionCode($responseJSON[APIConstants::CODE]);
                $exception->setExceptionDetails($responseJSON[APIConstants::DETAILS]);
                throw $exception;
            }
        }
    }
    
    /**
     *
     * {@inheritdoc}
     * @see CommonAPIResponse::processResponseData()
     */
    public function processResponseData()//status of the response
    {
        $this->bulkEntitiesResponse = array();
        $bulkResponseJSON = $this->getResponseJSON();
        if (array_key_exists(APIConstants::DATA, $bulkResponseJSON)) {
            $recordsArray = $bulkResponseJSON[APIConstants::DATA];
            foreach ($recordsArray as $record) {
                if ($record != null && array_key_exists(APIConstants::STATUS, $record)) {
                    array_push($this->bulkEntitiesResponse, new EntityResponse($record));
                }
            }
        }
        if (array_key_exists(APIConstants::TAGS, $bulkResponseJSON)) {
            $TagsArray = $bulkResponseJSON[APIConstants::TAGS];
            foreach ($TagsArray as $Tags) {
                if ($Tags != null && array_key_exists(APIConstants::STATUS, $Tags)) {
                    array_push($this->bulkEntitiesResponse, new EntityResponse($Tags));
                }
            }
        }
        if (array_key_exists(APIConstants::TAXES, $bulkResponseJSON)) {
            
            $orgTaxesArray= $bulkResponseJSON[APIConstants::TAXES];
            foreach ($orgTaxesArray as $orgTax) {
                if ($orgTax != null && array_key_exists(APIConstants::STATUS, $orgTax)) {
                    array_push($this->bulkEntitiesResponse, new EntityResponse($orgTax));
                }
            }
        }
        if (array_key_exists(APIConstants::VARIABLES, $bulkResponseJSON)) {
            
            $variables= $bulkResponseJSON[APIConstants::VARIABLES];
            foreach ($variables as $variable) {
                if ($variable != null && array_key_exists(APIConstants::STATUS, $variable)) {
                    array_push($this->bulkEntitiesResponse, new EntityResponse($variable));
                }
            }
        }
    }
    
    /**
     * method to get the bulk data
     *
     * @return array array of data instances
     */
    public function getData()
    {
        return $this->bulkData;
    }
    
    /**
     * method to set the bulk data
     *
     * @param array $bulkData  array of data instances
     */
    public function setData($bulkData)
    {
        $this->bulkData = $bulkData;
    }
    
    /**
     * method to Get the response status
     *
     * @return String the response status
     */
    public function getStatus()
    {
        
        return $this->status;
    }
    
    /**
     * method to Set the response status
     *
     * @param String $status  the response status
     */
    public function setStatus($status)
    {
        
        $this->status = $status;
    }
    
    /**
     * method to get the response information
     *
     * @return ResponseInfo instance of the ResponseInfo class
     */
    public function getInfo()
    {
        return $this->info;
    }
    
    /**
     * method to set the response information
     *
     * @param ResponseInfo $info  instance of the ResponseInfo class
     */
    public function setInfo()
    {
        if (array_key_exists(APIConstants::INFO, $this->getResponseJSON())) {
            $this->info = new ResponseInfo($this->getResponseJSON()[APIConstants::INFO]);
        }
    }
    
    /**
     * method to get the bulk entity responses
     *
     * @return array array of the instances of EntityResponse class
     */
    public function getEntityResponses()
    {
        return $this->bulkEntitiesResponse;
    }
}