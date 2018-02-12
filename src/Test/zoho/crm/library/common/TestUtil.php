<?php
require_once realpath(dirname(__FILE__)."/../api/MetaDataAPIHandlerTest.php");

class TestUtil
{
	
	public static $sampleDate=null;
	public static $sampleDateTimeISO=null;
	public static $dataTypeVsValue=array("integer"=>456789,"text"=>"SampleData","double"=>100435,"phone"=>"9999000000",
	 		"email"=>"sumanth.chilka+automation@zohocorp.com",
	 		"website"=>"www.zohocorp.com",
	 		"bigint"=>"9876543210123456",
			"boolean"=>true
	);
	public static $nonSupportiveModules=array("Approvals","Activities","CustomModule5001","CustomModule5002","CustomModule5003","CustomModule5004","CustomModule5005","CustomModule5006","CustomModule5007","CustomModule5008");
	 
	public static function getDateTimeISO()
	{
	 	date_default_timezone_set("Asia/Kolkata");
	 	$timeInMillis=microtime(true);
	 	$timeInMillis=$timeInMillis+8000000;
	 	$timeInMillis= round($timeInMillis);
	 	$dateTime = date('Y-m-d H:i:s', $timeInMillis);
	 	$dateTime=date(DATE_ISO8601, strtotime($dateTime));
	 	$sub1=substr($dateTime,0,22);
	 	$sub2=substr($dateTime,22,23);
	 	return ($sub1.":".$sub2);
	}
	public static function getDate()
	{
		date_default_timezone_set("Asia/Kolkata");
		$timeInMillis=microtime(true);
		$timeInMillis=$timeInMillis+8000000;
		$timeInMillis= round($timeInMillis);
		
		return date('Y-m-d', $timeInMillis);
	}
	
	public static function moveModulePositions($isToFront,$moduleNames,$moduleList)
	{
		foreach ($moduleNames as $moduleName)
		{
			$moduleAPIName=MetaDataAPIHandlerTest::$moduleNameVsApiName[$moduleName];
			unset($moduleList[$moduleAPIName]);
			if($isToFront)
			{
				$moduleList=array($moduleAPIName=>$moduleName)+$moduleList;
			}
			else {
				$moduleList=$moduleList+array($moduleAPIName=>$moduleName);
			}
		}
		return $moduleList;
	}
	
	public static function isActivityModule($moduleName)
	{
		return in_array($moduleName, array("Tasks","Calls","Events"));
	}
}
?>