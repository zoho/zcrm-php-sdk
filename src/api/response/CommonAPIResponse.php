<?php

namespace ZCRM\api\response;

use ZCRM\exception\APIExceptionHandler;
use ZCRM\common\APIConstants;

class CommonAPIResponse {
    private $httpStatusCode = null;
    private $responseJSON = null;
    private $responseHeaders = null;
    private $code = null;
    private $message = null;
    private $details = null;
    private $response = null;
    private $apiName = null;

    public function __construct($response, $httpStatusCode, $apiName = null) {
        $this->apiName = $apiName;
        $this->response = $response;
        $this->httpStatusCode = $httpStatusCode;
        $this->setResponseJSON();
        $this->processResponse();
    }

    public function processResponse() {
        if (in_array($this->httpStatusCode, APIExceptionHandler::getFaultyResponseCodes())) {
            $this->handleForFaultyResponses();
        } else if ($this->httpStatusCode == APIConstants::RESPONSECODE_ACCEPTED || $this->httpStatusCode == APIConstants::RESPONSECODE_OK || $this->httpStatusCode == APIConstants::RESPONSECODE_CREATED) {
            $this->processResponseData();
        }
    }

    public function handleForFaultyResponses() {
        return;
    }

    public function processResponseData() {
        return;
    }

    public function setResponseJSON() {
        if ($this->httpStatusCode == APIConstants::RESPONSECODE_NO_CONTENT || $this->httpStatusCode == APIConstants::RESPONSECODE_NOT_MODIFIED) {
            $this->responseJSON = array();
            $this->responseHeaders = array();
            return;
        }
        list($headers, $content) = explode("\r\n\r\n", $this->response, 2);
        $headerArray = (explode("\r\n", $headers, 50));
        $headerMap = array();
        foreach ($headerArray as $key) {
            if (strpos($key, ":") != false) {
                $firstHalf = substr($key, 0, strpos($key, ":"));
                $secondHalf = substr($key, strpos($key, ":") + 1);
                $headerMap[$firstHalf] = trim($secondHalf);
            }
        }
        $jsonResponse = json_decode($content, true);
        if ($jsonResponse == null && $this->httpStatusCode != APIConstants::RESPONSECODE_NO_CONTENT) {
            list($headers, $content) = explode("\r\n\r\n", $content, 2);
            $jsonResponse = json_decode($content, true);
        }
        $this->responseJSON = $jsonResponse;
        $this->responseHeaders = $headerMap;
    }

    public function setHttpStatusCode($statusCode) {
        $this->httpStatusCode = $statusCode;
    }

    public function getHttpStatusCode() {
        return $this->httpStatusCode;
    }

    public function getResponseJSON() {
        return $this->responseJSON;
    }

    public function setResponseHeaders($responseHeader) {
        $this->responseHeaders = $responseHeader;
    }

    public function getResponseHeaders() {
        return $this->responseHeaders;
    }

    public function getExpiryTimeOfAccessToken() {
        return $this->responseHeaders[APIConstants::ACCESS_TOKEN_EXPIRY];
    }

    public function getAPILimitForCurrentWindow() {
        return $this->responseHeaders[APIConstants::CURR_WINDOW_API_LIMIT];
    }

    public function getRemainingAPICountForCurrentWindow() {
        return $this->responseHeaders[APIConstants::CURR_WINDOW_REMAINING_API_COUNT];
    }

    public function getCurrentWindowResetTimeInMillis() {
        return $this->responseHeaders[APIConstants::CURR_WINDOW_RESET];
    }

    public function getRemainingAPICountForTheDay() {
        return $this->responseHeaders[APIConstants::API_COUNT_REMAINING_FOR_THE_DAY];
    }

    public function getAPILimitForTheDay() {
        return $this->responseHeaders[APIConstants::API_LIMIT_FOR_THE_DAY];
    }

    /**
     * Get the response code like SUCCESS,INVALID_DATA,..etc
     * @return String
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Get the response code like SUCCESS,INVALID_DATA,..etc
     * @param String $code
     */
    public function setCode($code) {
        $this->code = $code;
    }


    /**
     * Get the response message
     * @return String
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Set the response message
     * @param String $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * Get the extra details of response (if any)
     * @return Array
     */
    public function getDetails() {
        return $this->details;
    }

    /**
     * Set the extra details for response (if any)
     * @param Array $details
     */
    public function setDetails($details) {
        $this->details = $details;
    }

    public function getResponse() {
        return $this->response;
    }

    public function setResponse($response) {
        $this->response = $response;
    }

    public function getAPIName() {
        return $this->apiName;
    }
}

?>