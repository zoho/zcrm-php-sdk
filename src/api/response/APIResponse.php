<?php

namespace ZCRM\api\response;

use ZCRM\common\APIConstants;
use ZCRM\exception\APIExceptionHandler;
use ZCRM\exception\ZCRMException;

class APIResponse extends CommonAPIResponse {

    private $data = NULL;

    private $status = NULL;

    public function __construct($httpResponse, $httpStatusCode, $apiName = NULL) {
        parent::__construct($httpResponse, $httpStatusCode, $apiName);
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    /**
     * Get the response status
     *
     * @return String
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set the response status
     *
     * @param String $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @throws ZCRMException
     */
    public function handleForFaultyResponses() {

        $statusCode = self::getHttpStatusCode();

        if (in_array($statusCode, APIExceptionHandler::getFaultyResponseCodes())) {
            if ($statusCode == APIConstants::RESPONSECODE_NO_CONTENT) {
                $exception = new ZCRMException(APIConstants::INVALID_DATA . "-" . APIConstants::INVALID_ID_MSG, $statusCode);
                $exception->setExceptionCode("No Content");
                throw $exception;
            } else {
                $json = $this->getResponseJSON();
                $exception = new ZCRMException($json['message'], $statusCode);
                $exception->setExceptionCode($json['code']);
                $exception->setExceptionDetails($json['details']);
                throw $exception;
            }
        }

    }

    public function processResponseData() {

        $json = $this->getResponseJSON();
        if ($json == NULL) {
            return;
        }
        if (array_key_exists("data", $json)) {
            $json = $json['data'][0];
        } else {
            if (array_key_exists("users", $json)) {
                $json = $json['users'][0];
            } else {
                if (array_key_exists("modules", $json)) {
                    $json = $json['modules'];
                }
            }
        }


        /*
         * $exception not appropriate or just not working correctly for trivial responses issues
         *
                if (isset($responseJSON['status']) && $responseJSON['status'] == APIConstants::STATUS_ERROR) {
                  $exception = new ZCRMException($responseJSON['message'], self::getHttpStatusCode());
                  $exception->setExceptionCode($responseJSON['code']);
                  $exception->setExceptionDetails($responseJSON['details']);
                  throw $exception;
                }
                elseif (isset($responseJSON['status']) && $responseJSON['status'] == APIConstants::STATUS_SUCCESS) {
                  self::setCode($responseJSON['code']);
                  self::setStatus($responseJSON['status']);
                  self::setMessage($responseJSON['message']);
                  self::setDetails($responseJSON['details']);
                }
        */

        if (isset($json['code'])) {
            self::setCode($json['code']);
        }
        if (isset($json['status'])) {
            self::setStatus($json['status']);
        }
        if (isset($json['message'])) {
            self::setMessage($json['message']);
        }
        if (isset($json['details'])) {
            self::setDetails($json['details']);
        }

    }

}

?>