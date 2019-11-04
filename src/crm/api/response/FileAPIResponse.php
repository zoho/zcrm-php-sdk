<?php
namespace zcrmsdk\crm\api\response;

use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\exception\APIExceptionHandler;

class FileAPIResponse
{
    
    /**
     * response
     *
     * @var string
     */
    private $response = null;
    
    /**
     * Json response
     *
     * @var array array of json object
     */
    private $responseJSON = null;
    
    /**
     * http status code
     *
     * @var string
     */
    private $httpStatusCode = null;
    
    /**
     * response headers
     *
     * @var array
     */
    private $responseHeaders = null;
    
    /**
     * code
     *
     * @var string
     */
    private $code = null;
    
    /**
     * message
     *
     * @var string
     */
    private $message = null;
    
    /**
     * details
     *
     * @var array
     */
    private $details = null;
    
    /**
     * response status
     *
     * @var string
     */
    private $status = null;
    
    /**
     * method to set the content of the file
     *
     * @param string $httpResponse http response
     * @param int $httpStatusCode status code
     * @throws ZCRMException exception is thrown if the response is faulty
     * @return FileAPIResponse instance of the FileAPIResponse class containing the file api response
     */
    public function setFileContent($httpResponse, $httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
        if ($httpStatusCode == APIConstants::RESPONSECODE_NO_CONTENT) {
            $this->responseJSON = array();
            $this->responseHeaders = array();
            $exception = new ZCRMException(APIConstants::INVALID_ID_MSG, $httpStatusCode);
            $exception->setExceptionCode("No Content");
            throw $exception;
        }
        list ($headers, $content) = explode("\r\n\r\n", $httpResponse, 2);
        $headerArray = (explode("\r\n", $headers, 50));
        $headerMap = array();
        foreach ($headerArray as $key) {
            if (strpos($key, ":") != false) {
                $splitArray = explode(":", $key);
                $headerMap[$splitArray[0]] = $splitArray[1];
            }
        }
        if (in_array($httpStatusCode, APIExceptionHandler::getFaultyResponseCodes())) {
            $content = json_decode($content, true);
            $this->responseJSON = $content;
            $exception = new ZCRMException($content['message'], $httpStatusCode);
            $exception->setExceptionCode($content['code']);
            $exception->setExceptionDetails($content['details']);
            throw $exception;
        } else if ($httpStatusCode == APIConstants::RESPONSECODE_OK) {
            $this->response = $content;
            $this->responseJSON = array();
            $this->status = APIConstants::STATUS_SUCCESS;
        }
        $this->responseHeaders = $headerMap;
        return $this;
    }
    
    /**
     * method to get the name of the file
     *
     * @return string the name of the file
     */
    public function getFileName()
    {
        $contentDisp = self::getResponseHeaders()['Content-Disposition'];
        if($contentDisp == null)
        {
            $contentDisp = self::getResponseHeaders()['Content-disposition'];
        }
        $fileName = substr($contentDisp, strrpos($contentDisp, "'") + 1, strlen($contentDisp));
        if(strpos($fileName, "=")!== false)
        {
            $fileName = substr($fileName, strrpos($fileName, "=") + 1, strlen($fileName));
            $fileName = str_replace(array('\'', '"'), '', $fileName);
            
        }
        return $fileName;
    }
    
    /**
     * method to get the content of the file
     *
     * @return string content of the file
     */
    public function getFileContent()
    {
        return $this->response;
    }
    
    /**
     * method to get the response
     *
     * @return String the response
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * method to set the response
     *
     * @param String $response  the reponse to be set
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
    
    /**
     * method to get the json response object
     *
     * @return Array array of the Json response objects
     */
    public function getResponseJSON()
    {
        return $this->responseJSON;
    }
    
    /**
     * method to set the json response objects
     *
     * @param Array $responseJSON array of the Json response objects
     */
    public function setResponseJSON($responseJSON)
    {
        $this->responseJSON = $responseJSON;
    }
    
    /**
     * method to get the http Status Code
     *
     * @return String the http Status Code
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
    
    /**
     * method to set the http Status Code
     *
     * @param String $httpStatusCode the http Status Code
     */
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }
    
    /**
     * method to get the response headers
     *
     * @return Array array containing the response headers
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }
    
    /**
     * method to set the response headers
     *
     * @param Array $responseHeaders array containing the response headers
     */
    public function setResponseHeaders($responseHeaders)
    {
        $this->responseHeaders = $responseHeaders;
    }
    
    /**
     * method to get the code
     *
     * @return String the code
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * method to set the code
     *
     * @param String $code the code to be set
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    
    /**
     * method to get the message
     *
     * @return String the message
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * method to set the message
     *
     * @param String $message the message
     */
    public function setMessage($message)
    {
        $this->message = $message;
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
     * method to get the status
     *
     * @return string the status
     */
    public function getStatus()
    {
        return $this->status;
    }
}