<?php

namespace ZCRM\api\response;

use ZCRM\common\APIConstants;
use ZCRM\exception\ZCRMException;
use ZCRM\exception\APIExceptionHandler;

class BulkAPIResponse extends CommonAPIResponse {
    private $bulkData = null;
    private $status = null;
    private $info = null;
    private $bulkEntitiesResponse = null;

    public function __construct($httpResponse, $httpStatusCode) {
        parent::__construct($httpResponse, $httpStatusCode);
        $this->setInfo();
    }

    /**
     * @throws ZCRMException
     */
    public function handleForFaultyResponses() {
        $statusCode = self::getHttpStatusCode();
        if (in_array($statusCode, APIExceptionHandler::getFaultyResponseCodes())) {
            if ($statusCode == APIConstants::RESPONSECODE_NO_CONTENT) {
                $exception = new ZCRMException("No Content", $statusCode);
                $exception->setExceptionCode("NO CONTENT");
                throw $exception;
            } else {
                $responseJSON = $this->getResponseJSON();
                $exception = new ZCRMException($responseJSON['message'], $statusCode);
                $exception->setExceptionCode($responseJSON['code']);
                $exception->setExceptionDetails($responseJSON['details']);
                throw $exception;
            }
        }
    }

    public function processResponseData() {
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
    }

    /**
     * bulkData
     * @return unkown
     */
    public function getData() {
        return $this->bulkData;
    }

    /**
     * bulkData
     * @param unkown $bulkData
     */
    public function setData($bulkData) {
        $this->bulkData = $bulkData;
    }

    /**
     * status
     * @return String
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * status
     * @param String $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * info
     * @return Instance of ResponseInfo
     */
    public function getInfo() {
        return $this->info;
    }

    /**
     * info
     * @param Instance of ResponseInfo $info
     */
    public function setInfo() {
        if (array_key_exists(APIConstants::INFO, $this->getResponseJSON())) {
            $this->info = new ResponseInfo($this->getResponseJSON()[APIConstants::INFO]);
        }
    }

    /**
     * bulkEntitiesResponse
     * @return Array of EntityResponse
     */
    public function getEntityResponses() {
        return $this->bulkEntitiesResponse;
    }


}

?>