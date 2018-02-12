<?php
require_once realpath(dirname(__FILE__)."/../../common/APIConstants.php");
require_once realpath(dirname(__FILE__)."/../../exception/ZCRMException.php");

class FileAPIResponse
{
	private $response=null;
	private $responseJSON=null;
	private $httpStatusCode=null;
	private $responseHeaders=null;
	private $code=null;
	private $message=null;
	private $details=null;
	private $status=null;
	
	public function setFileContent($httpResponse,$httpStatusCode)
	{
		$this->httpStatusCode=$httpStatusCode;
		if($httpStatusCode==APIConstants::RESPONSECODE_NO_CONTENT)
		{
			$this->responseJSON=array();
			$this->responseHeaders=array();
			$exception=new ZCRMException(APIConstants::INVALID_ID_MSG,$httpStatusCode);
			$exception->setExceptionCode("No Content");
			throw $exception;
		}
		list($headers, $content) = explode("\r\n\r\n",$httpResponse,2);
		$headerArray=(explode("\r\n",$headers,50));
		$headerMap=array();
		foreach ($headerArray as $key)
		{
			if(strpos($key,":")!=false)
			{
				$splitArray=explode(":",$key);
				$headerMap[$splitArray[0]]=$splitArray[1];
			}
		}
		if(in_array($httpStatusCode,APIExceptionHandler::getFaultyResponseCodes()))
		{
			$content=json_decode($content,true);
			$this->responseJSON=$content;
			$exception=new ZCRMException($content['message'],$httpStatusCode);
			$exception->setExceptionCode($content['code']);
			$exception->setExceptionDetails($content['details']);
			throw $exception;
		}
		else if($httpStatusCode==APIConstants::RESPONSECODE_OK)
		{
			$this->response=$content;
			$this->responseJSON=array();
			$this->status=APIConstants::STATUS_SUCCESS;
		}
		$this->responseHeaders=$headerMap;
		return $this;
	}
	
	public function getFileName()
	{
		$contentDisp=self::getResponseHeaders()['Content-Disposition'];
		$fileName=substr($contentDisp,strrpos($contentDisp,"'")+1,strlen($contentDisp));
		return $fileName;
	}
	
	public function getFileContent()
	{
		return $this->response;
	}

    /**
     * response
     * @return String
     */
    public function getResponse(){
        return $this->response;
    }

    /**
     * response
     * @param String $response
     */
    public function setResponse($response){
        $this->response = $response;
    }

    /**
     * responseJSON
     * @return Array
     */
    public function getResponseJSON(){
        return $this->responseJSON;
    }

    /**
     * responseJSON
     * @param Array $responseJSON
     */
    public function setResponseJSON($responseJSON){
        $this->responseJSON = $responseJSON;
    }

    /**
     * httpStatusCode
     * @return String
     */
    public function getHttpStatusCode(){
        return $this->httpStatusCode;
    }

    /**
     * httpStatusCode
     * @param String $httpStatusCode
     */
    public function setHttpStatusCode($httpStatusCode){
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * responseHeaders
     * @return Array
     */
    public function getResponseHeaders(){
        return $this->responseHeaders;
    }

    /**
     * responseHeaders
     * @param Array $responseHeaders
     */
    public function setResponseHeaders($responseHeaders){
        $this->responseHeaders = $responseHeaders;
    }

    /**
     * code
     * @return String
     */
    public function getCode(){
        return $this->code;
    }

    /**
     * code
     * @param String $code
     * @return NewFileAPIResponse
     */
    public function setCode($code){
        $this->code = $code;
    }

    /**
     * message
     * @return String
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     * message
     * @param String $message
     */
    public function setMessage($message){
        $this->message = $message;
    }

    /**
     * details
     * @return Array
     */
    public function getDetails(){
        return $this->details;
    }

    /**
     * details
     * @param Array $details
     * @return NewFileAPIResponse
     */
    public function setDetails($details){
        $this->details = $details;
    }
    
    public function getStatus()
    {
    	return $this->status;
    }

}
?>