<?php
require_once realpath(dirname(__FILE__)."/../api/response/APIResponse.php");
require_once realpath(dirname(__FILE__)."/../common/APIConstants.php");
/**
 * Purpose of this class is to trigger API call and fetch the response
 * @author sumanth-3058
 *
 */
class ZohoHTTPConnector
{
	private $url=null;
	private $requestParams = array();
	private $requestHeaders = array();
	private $requestParamCount=0;
	private $requestBody;
	private $requestType=APIConstants::REQUEST_METHOD_GET;
	private $userAgent="ZohoCRM PHP SDK";
	private $apiKey=null;
	private $isBulkRequest=false;
	
	private function __construct()
	{
		
	}
	
	public static function getInstance()
	{
		return new ZohoHTTPConnector();
	}
	
	public function fireRequest()
	{
		$curl_pointer=curl_init();
		if(self::getRequestParamsMap())
		{
			$url=self::getUrl()."?".self::getUrlParamsAsString(self::getRequestParamsMap());
			curl_setopt($curl_pointer,CURLOPT_URL,$url);
		}
		else 
		{
			curl_setopt($curl_pointer,CURLOPT_URL,self::getUrl());
		}
		curl_setopt($curl_pointer,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl_pointer,CURLOPT_HEADER,1);
		curl_setopt($curl_pointer,CURLOPT_USERAGENT,$this->userAgent);
		curl_setopt($curl_pointer,CURLOPT_HTTPHEADER,self::getRequestHeadersAsArray());
		curl_setopt($curl_pointer,CURLOPT_CUSTOMREQUEST,APIConstants::REQUEST_METHOD_GET);
		
		if ($this->requestType===APIConstants::REQUEST_METHOD_POST)
		{
			curl_setopt($curl_pointer,CURLOPT_CUSTOMREQUEST,APIConstants::REQUEST_METHOD_POST);
			curl_setopt($curl_pointer,CURLOPT_POST,true);
			curl_setopt($curl_pointer,CURLOPT_POSTFIELDS,$this->isBulkRequest?json_encode(self::getRequestBody()):self::getRequestBody());
		}
		else if ($this->requestType===APIConstants::REQUEST_METHOD_PUT)
		{
			curl_setopt($curl_pointer,CURLOPT_CUSTOMREQUEST,APIConstants::REQUEST_METHOD_PUT);
			curl_setopt($curl_pointer,CURLOPT_POSTFIELDS,$this->isBulkRequest?json_encode(self::getRequestBody()):self::getRequestBody());
		}
		else if ($this->requestType===APIConstants::REQUEST_METHOD_DELETE)
		{
			curl_setopt($curl_pointer,CURLOPT_CUSTOMREQUEST,APIConstants::REQUEST_METHOD_DELETE);
		}
		$result=curl_exec($curl_pointer);
		$responseInfo=curl_getinfo($curl_pointer);
		curl_close($curl_pointer);
		
		return array($result,$responseInfo);
	}
	
	public function downloadFile()
	{
		$curl_pointer=curl_init();
		curl_setopt($curl_pointer,CURLOPT_URL,self::getUrl());
		curl_setopt($curl_pointer,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl_pointer,CURLOPT_HEADER,1);
		curl_setopt($curl_pointer,CURLOPT_USERAGENT,$this->userAgent);
		curl_setopt($curl_pointer,CURLOPT_HTTPHEADER,self::getRequestHeadersAsArray());
		//curl_setopt($curl_pointer,CURLOPT_SSLVERSION,3);
		$result=curl_exec($curl_pointer);
		$responseInfo=curl_getinfo($curl_pointer);
		curl_close($curl_pointer);
		return array($result,$responseInfo);
	}
	
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
	}
	public function addParam($key,$value) {
		if($this->requestParams[$key]==null)
		{
			$this->requestParams[$key]=array($value);
		}else{
			$valArray=$this->requestParams[$key];
			array_push($valArray,$value);
			$this->requestParams[$key]=$valArray;
		}
	}
	public function addHeader($key,$value) {
		if($this->requestHeaders[$key]==null)
		{
			$this->requestHeaders[$key]=array($value);
		}else{
			$valArray=$this->requestHeaders[$key];
			array_push($valArray,$value);
			$this->requestHeaders[$key]=$valArray;
		}
	}
	
	public function getUrlParamsAsString($urlParams)
	{
		$params_as_string="";
		foreach($urlParams as $key=>$valueArray)
		{
			foreach ($valueArray as $value)
			{
				$params_as_string=$params_as_string.$key."=".urlencode($value)."&";
				$this->requestParamCount++;
			}
		}
		$params_as_string=rtrim($params_as_string,"&");
		$params_as_string=str_replace(PHP_EOL, '', $params_as_string);
		
		return $params_as_string;
	}
	
	public function setRequestHeadersMap($headers)
	{
		$this->requestHeaders=$headers;
	}
	public function getRequestHeadersMap()
	{
		return $this->requestHeaders;
	}
	
	public function setRequestParamsMap($params)
	{
		$this->requestParams=$params;
	}
	public function getRequestParamsMap()
	{
		return $this->requestParams;
	}
	
	public function setRequestBody($reqBody)
	{
		$this->requestBody=$reqBody;
	}
	public function getRequestBody()
	{
		return $this->requestBody;
	}
	
	public function setRequestType($reqType)
	{
		$this->requestType=$reqType;
	}
	public function getRequestType()
	{
		return $this->requestType;
	}
	
	public function getRequestHeadersAsArray()
	{
		$headersArray=array();
		$headersMap=self::getRequestHeadersMap();
		foreach ($headersMap as $key => $value)
		{
			$headersArray[]=$key.":".$value;
		}
		
		return $headersArray;
	}

    /**
     * Get the API Key used in the input json data(like 'modules', 'data','layouts',..etc)
     * @return String
     */
    public function getApiKey(){
        return $this->apiKey;
    }

    /**
     * Set the API Key used in the input json data(like 'modules', 'data','layouts',..etc)
     * @param String $apiKey
     */
    public function setApiKey($apiKey){
        $this->apiKey = $apiKey;
    }


    /**
     * isBulkRequest
     * @return unkown
     */
    public function isBulkRequest(){
        return $this->isBulkRequest;
    }

    /**
     * isBulkRequest
     * @param unkown $isBulkRequest
     */
    public function setBulkRequest($isBulkRequest){
        $this->isBulkRequest = $isBulkRequest;
    }

}
?>
