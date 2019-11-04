<?php
namespace zcrmsdk\crm\api\response;

use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\utility\APIConstants;

class APIResponse extends CommonAPIResponse
{
    
    /**
     * data of the api response
     *
     * @var object
     */
    private $data = null;
    
    /**
     * response status of the api
     *
     * @var string
     */
    private $status = null;
    
    /**
     * constructor to set the http response , http code and apiname
     *
     * @param string $httpResponse the http response
     * @param int $httpStatusCode status code of the response
     * @param string $apiName module api name
     */
    public function __construct($httpResponse, $httpStatusCode, $apiName = null)
    {
        parent::__construct($httpResponse, $httpStatusCode, $apiName);
    }
    
    /**
     * method to set the data of the class object
     *
     * @param object $data data to be set for the object
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * method to get the data of the class object
     *
     * @return object data of the object
     */
    public function getData()
    {
        return $this->data;
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
     * @param String $status the response status
     */
    public function setStatus($status)
    {
        
        $this->status = $status;
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
                $exception = new ZCRMException(APIConstants::INVALID_DATA . "-" . APIConstants::INVALID_ID_MSG, $statusCode);
                $exception->setExceptionCode("No Content");
                throw $exception;
            } else {
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
    public function processResponseData()
    {
        $responseJSON = $this->getResponseJSON();
        if ($responseJSON == null) {
            return;
        }
        if (array_key_exists(APIConstants::DATA, $responseJSON)) {
            $responseJSON = $responseJSON[APIConstants::DATA][0];
        }
        if (array_key_exists(APIConstants::TAGS, $responseJSON)) {
            $responseJSON = $responseJSON[APIConstants::TAGS][0];
        } else if (array_key_exists(APIConstants::USERS, $responseJSON)) {
            $responseJSON = $responseJSON[APIConstants::USERS][0];
        } else if (array_key_exists(APIConstants::MODULES, $responseJSON)) {
            $responseJSON = $responseJSON[APIConstants::MODULES];
        } else if (array_key_exists(APIConstants::CUSTOM_VIEWS, $responseJSON)) {
            $responseJSON = $responseJSON[APIConstants::CUSTOM_VIEWS];
        }else if (array_key_exists(APIConstants::TAXES, $responseJSON)) {
            $responseJSON = $responseJSON[APIConstants::TAXES][0];
        }
        else if (array_key_exists("variables", $responseJSON)) {
            $responseJSON = $responseJSON['variables'][0];
        }
        if (isset($responseJSON[APIConstants::STATUS]) && $responseJSON[APIConstants::STATUS] == APIConstants::STATUS_ERROR) {
            $exception = new ZCRMException($responseJSON[APIConstants::MESSAGE], self::getHttpStatusCode());
            $exception->setExceptionCode($responseJSON[APIConstants::CODE]);
            $exception->setExceptionDetails($responseJSON[APIConstants::DETAILS]);
            throw $exception;
        } elseif (isset($responseJSON[APIConstants::STATUS]) && $responseJSON[APIConstants::STATUS] == APIConstants::STATUS_SUCCESS) {
            self::setCode($responseJSON[APIConstants::CODE]);
            self::setStatus($responseJSON[APIConstants::STATUS]);
            self::setMessage($responseJSON[APIConstants::MESSAGE]);
            self::setDetails($responseJSON[APIConstants::DETAILS]);
        }
    }
}