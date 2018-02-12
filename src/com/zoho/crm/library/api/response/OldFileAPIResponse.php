<?php
require_once 'APIResponse.php';
require_once '../../common/APIConstants.php';

class OldFileAPIResponse extends APIResponse
{
	public function __construct($httpResponse,$httpStatusCode)
	{
		parent::__construct($httpResponse,$httpStatusCode,"downloadFile");
	}
	
	public function getFileName()
	{
		$contentDisp=$this->getResponseHeaders()['Content-Disposition'];
		$fileName=substr($contentDisp,strrpos($contentDisp,"'")+1,strlen($contentDisp));
		return $fileName;
	}
	
	public function setResponseJSON()
	{
		$httpStatusCode=$this->getHttpStatusCode();
		if($httpStatusCode==APIConstants::RESPONSECODE_NO_CONTENT )
		{
			parent::setResponseJSON(array());
			parent::setResponseHeaders(array());
			return;
		}
		list($headers, $content) = explode("\r\n\r\n",$this->getResponse(),2);
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
			parent::setResponseJSON(json_decode($content,true));
		}
		else 
		{
			parent::setResponse($content);
			parent::setResponseJSON(array());
		}
		$this->setResponseHeaders($headerMap);
	}
	
	public function getFileContent()
	{
		try{
			return $this->getResponse();
		}
		catch(ZCRMException $e)
		{
			throw $e;
		}
	}
}
?>