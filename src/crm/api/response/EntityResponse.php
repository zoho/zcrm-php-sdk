<?php
namespace zcrmsdk\crm\api\response;

use zcrmsdk\crm\utility\APIConstants;

class EntityResponse
{
    
    /**
     * status of the response
     *
     * @var string
     */
    private $status = null;
    
    /**
     * the response message
     *
     * @var string
     */
    private $message = null;
    
    /**
     * the response code like SUCCESS,INVALID_DATA,..etc
     *
     * @var string
     */
    private $code = null;
    
    /**
     * response json object
     *
     * @var object
     */
    private $responseJSON = null;
    
    /**
     * data of the response
     *
     * @var array
     */
    private $data = null;
    
    /**
     * upsert details like action,duplicate field
     *
     * @var array
     */
    private $upsertDetails = array();
    
    /**
     * details of the response
     *
     * @var array
     */
    private $details = null;
    
    /**
     * constructor to set the entity response
     *
     * @param object $entityResponseJSON  the entity response
     */
    public function __construct($entityResponseJSON)
    {
        $this->responseJSON = $entityResponseJSON;
        $this->status = $entityResponseJSON[APIConstants::STATUS];
        $this->message = $entityResponseJSON[APIConstants::MESSAGE];
        $this->code = $entityResponseJSON[APIConstants::CODE];
        if (array_key_exists(APIConstants::ACTION, $entityResponseJSON)) {
            $this->upsertDetails[APIConstants::ACTION] = $entityResponseJSON[APIConstants::ACTION];
        }
        if (array_key_exists(APIConstants::DUPLICATE_FIELD, $entityResponseJSON)) {
            $this->upsertDetails[APIConstants::DUPLICATE_FIELD] = $entityResponseJSON[APIConstants::DUPLICATE_FIELD];
        }
        if (array_key_exists("details", $entityResponseJSON)) {
            $this->details = $entityResponseJSON["details"];
        }
    }
    
    /**
     * method to Get the response status like error or success
     *
     * @return String the response status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * method to Set the response status like error or success
     *
     * @param String $status the response status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * method to get the response message
     *
     * @return String the response message
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * method to get the response message
     *
     * @param String $message the response message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * method to Get the response code like SUCCESS,INVALID_DATA,..etc
     *
     * @return String the response code like SUCCESS,INVALID_DATA,..etc
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * method to set the response code like SUCCESS,INVALID_DATA,..etc
     *
     * @param String $code
     *            the response code like SUCCESS,INVALID_DATA,..etc
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    
    /**
     * method to get the json object
     *
     * @return object the json object
     */
    public function getResponseJSON()
    {
        return $this->responseJSON;
    }
    
    /**
     * method to get the data of the response
     *
     * @return array array of the data
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * method to set the data of the response
     *
     * @param array $data  array of the data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * method to get the upsert details like action,duplicate field
     *
     * @return array array containg the upsert details like action,duplicate field
     */
    public function getUpsertDetails()
    {
        return $this->upsertDetails;
    }
    
    /**
     * method to set the details
     *
     * @param Array $details array containing the details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }
    
    /**
     * method to get the details
     *
     * @return Array array containing the details
     */
    public function getDetails()
    {
        return $this->details;
    }
}