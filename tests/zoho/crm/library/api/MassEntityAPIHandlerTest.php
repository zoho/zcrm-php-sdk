<?php
require_once realpath(dirname(__FILE__)."/../../../../../com/zoho/crm/library/api/handler/MassEntityAPIHandler.php");
require_once 'MetaDataAPIHandlerTest.php';
require_once realpath(dirname(__FILE__)."/../common/TestUtil.php");

class MassEntityAPIHandlerTest
{
	public static $filePointer=null;
	public static $productId=null;
	public static $firstParnetId=null;
	public static $firstParnetModule=null;
	public static $moduleApiNameVsEntityIds=array();
	private static $createLimit=5;
	public static function test($fp)
	{
		self::$filePointer=$fp;
		self::testCreateRecords();
		self::testUpsertRecords();
		self::testUpdateRecords();
		self::testGetRecords();
		self::testDeleteRecords();
		self::testGetDeletedRecords();
	}
	public function testCreateRecords()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			throw new ZCRMException("No Modules fetched..");
		}
		
		$moduleList=TestUtil::moveModulePositions(true,array("Products"),MetaDataAPIHandlerTest::$moduleList);
		foreach ($moduleList as $apiName=>$moduleName)
		{
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				if(in_array($moduleName, TestUtil::$nonSupportiveModules))
				{
					continue;
				}
				else if($moduleName=='Attachments' || $moduleName=='Notes')
				{
					continue;
				}
				self::setRecordFieldsAndValidate($apiName,$startTime,$endTime,"create");
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleName.')','create',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testUpdateRecords()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			throw new ZCRMException("No Modules fetched..");
		}
		try{
			foreach (MetaDataAPIHandlerTest::$moduleList as $apiName=>$moduleName)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					if(in_array($moduleName, TestUtil::$nonSupportiveModules))
					{
						continue;
					}
					else if($moduleName=='Attachments' || $moduleName=='Notes')
					{
						continue;
					}
					self::updateRecordFieldsAndValidate($apiName,$startTime,$endTime);
				}catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord','update',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
				}
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleName.')','update',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function testUpsertRecords()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			throw new ZCRMException("No Modules fetched..");
		}
	
		$moduleList=MetaDataAPIHandlerTest::$moduleList;
		foreach ($moduleList as $apiName=>$moduleName)
		{
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				if(in_array($moduleName, TestUtil::$nonSupportiveModules) || TestUtil::isActivityModule($moduleName))
				{
					continue;
				}
				else if($moduleName=='Attachments' || $moduleName=='Notes')
				{
					continue;
				}
				self::setRecordFieldsAndValidate($apiName,$startTime,$endTime,"upsert");
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleName.')','upsertRecords',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetRecords()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			throw new ZCRMException("No Modules fetched..");
		}
		try{
			foreach (MetaDataAPIHandlerTest::$moduleList as $apiName=>$moduleName)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					if(in_array($moduleName, TestUtil::$nonSupportiveModules))
					{
						continue;
					}
					Main::incrementTotalCount();
					self::validateGetRecordsResponse($apiName,$moduleName,$startTime,$endTime);
				}catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.')','testGetRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
				}
					
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.')','testGetRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function testDeleteRecords()
	{

		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			throw new ZCRMException("No Modules fetched..");
		}
		try{
			$moduleList=TestUtil::moveModulePositions(true,array("Attachments","Notes"),MetaDataAPIHandlerTest::$moduleList);
			$moduleList=TestUtil::moveModulePositions(false,array("Products"),$moduleList);
			foreach ($moduleList as $apiName=>$moduleName)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					if(in_array($moduleName, TestUtil::$nonSupportiveModules))
					{
						continue;
					}
					if($moduleName=='Attachments' || $moduleName=='Notes')
					{
						continue;
					}
					Main::incrementTotalCount();
					self::validateDeleteRecordsResponse($apiName,$startTime,$endTime);
				}catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.')','testDeleteRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
				}
					
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.')','testDeleteRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function testGetDeletedRecords()
	{
	
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			throw new ZCRMException("No Modules fetched..");
		}
		try{
			foreach (MetaDataAPIHandlerTest::$moduleList as $apiName=>$moduleName)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					if(in_array($moduleName, TestUtil::$nonSupportiveModules))
					{
						continue;
					}
					if($moduleName=='Attachments' || $moduleName=='Notes')
					{
						continue;
					}
					self::validateGetDeletedRecordsResponse($apiName,$startTime,$endTime);
				}catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.')','testGetDeletedRecords',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
				}
					
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.')','testGetDeletedRecords',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateGetDeletedRecordsResponse($apiName,$startTime,$endTime)
	{
		$types=array("all","recycle","permanent");
		foreach ($types as $type)
		{
			try {
				Main::incrementTotalCount();
				$startTime=microtime(true)*1000;
				$moduleIns=ZCRMModule::getInstance($apiName);
				$bulkResponseIns=null;
				$methodName="getAllDeletedRecords()";
				if($type=='all')
				{
					$bulkResponseIns=$moduleIns->getAllDeletedRecords();
				}
				elseif ($type=='recycle')
				{
					$bulkResponseIns=$moduleIns->getRecycleBinRecords();
					$methodName="getRecycleBinRecords()";
				}
				elseif ($type=='permanent')
				{
					$bulkResponseIns=$moduleIns->getPermanentlyDeletedRecords();
					$methodName="getPermanentlyDeletedRecords()";
				}
				$endTime=microtime(true)*1000;
				$trashRecords=$bulkResponseIns->getData();
				if($bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK && $bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_NO_CONTENT)
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.")",'validateGetDeletedRecordsResponse',"Deleted Records GET Failed",$bulkResponseIns->getMessage(),'failure',($endTime-$startTime));
					continue;
				}
				$deletedIdList=array();
				foreach ($trashRecords as $trashRecord)
				{
					if($trashRecord->getEntityId()==null || $trashRecord->getType()==null || $trashRecord->getDeletedTime()==null)
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.")",'validateGetDeletedRecordsResponse',"Trash Record data is not set properly","id=".$trashRecord->getEntityId().",type=".$trashRecord->getType().",deleted_time=".$trashRecord->getDeletedTime(),'failure',($endTime-$startTime));
						continue;
					}
					if($type!='all' && $type!=$trashRecord->getType())
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.")",'validateGetDeletedRecordsResponse',"Trash Record Type mismatched","requested_type=".$type.",fetched_type=".$trashRecord->getType(),'failure',($endTime-$startTime));
						continue;
					}
					array_push($deletedIdList,$trashRecord->getEntityId());
				}
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$apiName.")",$methodName,"Deleted Records fetched successfully","ID List:".json_encode($deletedIdList),'success',($endTime-$startTime));
				unset($deletedIdList);
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				if($e->getCode()==APIConstants::RESPONSECODE_NO_CONTENT && $e->getMessage()=='No Content')
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$apiName.")",$methodName,"Deleted Records fetched successfully","No Records Exist",'success',($endTime-$startTime));
					continue;
				}
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$apiName.")",'validateGetDeletedRecordsResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function validateDeleteRecordsResponse($moduleAPIName,$startTime,$endTime)
	{
		try{
			if(self::$moduleApiNameVsEntityIds[$moduleAPIName]==null)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordResponse',"Unable to process","Record creation failed so get can't be done",'failure',($endTime-$startTime));
			}
			$startTime=microtime(true)*1000;
			$moduleIns=ZCRMModule::getInstance($moduleAPIName);
			$bulkResponseIns=$moduleIns->deleteRecords(self::$moduleApiNameVsEntityIds[$moduleAPIName]);
			$endTime=microtime(true)*1000;
			$entityResponses=$bulkResponseIns->getEntityResponses();
			if($bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK && $bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_ACCEPTED)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateDeleteRecordsResponse',"Record deletion Failed1".$bulkResponseIns->getHttpStatusCode(),$bulkResponseIns->getMessage(),'failure',($endTime-$startTime));
				return;
			}
			$deletedIdList=array();
			foreach ($entityResponses as $entityResponseIns)
			{
				if(!(APIConstants::STATUS_SUCCESS==$entityResponseIns->getStatus() && "record deleted"==$entityResponseIns->getMessage() && $entityResponseIns->getCode()==APIConstants::CODE_SUCCESS && $entityResponseIns->getStatus()==APIConstants::STATUS_SUCCESS && $entityResponseIns->getDetails()['id']!=null) && "record not deletable"!=$entityResponseIns->getMessage())
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateDeleteRecordsResponse',"Record deletion Failed2",json_encode($entityResponseIns->getResponseJSON()),'failure',($endTime-$startTime));
				}
				array_push($deletedIdList,$entityResponseIns->getData()->getEntityId());
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleAPIName.")",'deleteRecords()',"Records deleted Successfully","ID List:".json_encode($deletedIdList),'success',($endTime-$startTime));
			unset($deletedIdList);
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateDeleteRecordResponse',$e->getMessage().",id:".self::$moduleApiNameVsEntityIds[$moduleAPIName],$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateGetRecordsResponse($moduleAPIName,$moduleName,$startTime,$endTime)
	{
		try {
			$moduleIns=ZCRMModule::getInstance($moduleAPIName);
			$bulkResponseIns=$moduleIns->getRecords();
			$endTime=microtime(true)*1000;
			$fetchCount=-1;
			if($moduleName=="Notes" || $moduleName=='Attachments')
			{
				if($bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK && $bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_NO_CONTENT)
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordsResponse',"Record Get failed",$bulkResponseIns->getMessage(),'failure',($endTime-$startTime));
					return;
				}
				$records=$bulkResponseIns->getData();
				$fetchCount=sizeof($records);
			}
			else 
			{
				if($bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK )
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordsResponse',"Record Get failed",$bulkResponseIns->getMessage(),'failure',($endTime-$startTime));
					return;
				}
				$records=$bulkResponseIns->getData();
				$getCount=sizeof($records);
				$insertCount=sizeof(self::$moduleApiNameVsEntityIds[$moduleAPIName]);
				if($getCount<$insertCount)
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordsResponse',"Record Get failed","Insert and Get records count mismatched;;insertCount=".$insertCount.",getCount=".$getCount,'failure',($endTime-$startTime));
					return;
				}
				foreach ($records as $zcrmRecord)
				{
					if($zcrmRecord->getData()==null || $zcrmRecord->getCreatedBy()==null || $zcrmRecord->getOwner()==null || $zcrmRecord->getCreatedTime()==null)
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordsResponse',"Record Get failed","Records data is not fetched properly",'failure',($endTime-$startTime));
						return;
					}
				}
				$fetchCount=$getCount;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleAPIName.")",'getRecords()',"Bulk Records fetched successfully","Fetch Count::".$fetchCount,'success',($endTime-$startTime));
			unset($fetchedIds);
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function updateRecordFieldsAndValidate($moduleAPIName,$startTime,$endTime)
	{
		try
		{
			$moduleFields=MetaDataAPIHandlerTest::$moduleVsFieldMap[$moduleAPIName];
			$layoutIds = array_keys( MetaDataAPIHandlerTest::$moduleVsLayoutMap[$moduleAPIName]);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleAPIName];
			foreach ($layoutIds as $layoutId)
			{
				Main::incrementTotalCount();
				if(self::$moduleApiNameVsEntityIds[$moduleAPIName]==null)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'updateRecordFieldsAndValidate',"Unable to process","Record creation failed so update can't be done",'failure',($endTime-$startTime));
				}
				$layoutFields=MetaDataAPIHandlerTest::$moduleVsLayoutMap[$moduleAPIName][$layoutId];
				$fieldAPINameForUpdate=null;
				foreach ($moduleFields as $fieldAPIName=>$fieldDetails)
				{
					$inputData=array();
					if(!in_array($fieldAPIName, $layoutFields))
					{
						continue;
					}
					$fieldLabel=$fieldDetails['field_label'];
					$dataType=$fieldDetails['data_type'];
					if($dataType=='text')
					{
						$fieldAPINameForUpdate=$fieldAPIName;
						break;
					}
				}
				$isValid=self::validateUpdateResponse($fieldAPINameForUpdate,"Updated Text",$moduleAPIName, $startTime, $endTime);
				if($isValid)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),"ZCRMModule(".$moduleAPIName.")",'updateRecords()',"Records Updated Successfully","EntityId List::".json_encode(self::$moduleApiNameVsEntityIds[$moduleAPIName]),'success',($endTime-$startTime));
				}
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'updateRecordFields',$e->getMessage().",id=".self::$moduleApiNameVsEntityIds[$moduleAPIName],$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateUpdateResponse($fieldAPIName,$fieldValue,$moduleAPIName,$startTime,$endTime)
	{
		try{
			$moduleIns=ZCRMModule::getInstance($moduleAPIName);
			$bulkResponseIns=$moduleIns->updateRecords(self::$moduleApiNameVsEntityIds[$moduleAPIName], $fieldAPIName,$fieldValue);
			$endTime=microtime(true)*1000;
			$updatedRecords=$bulkResponseIns->getData();
			$entityResponses=$bulkResponseIns->getEntityResponses();
			foreach ($entityResponses as $entityResponseIns)
			{
				if(APIConstants::STATUS_SUCCESS!=$entityResponseIns->getStatus() || "record updated"!=$entityResponseIns->getMessage() || $entityResponseIns->getCode()!=APIConstants::CODE_SUCCESS || $entityResponseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $entityResponseIns->getDetails()['id']==null)
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateUpdateResponse',"Record update Failed",json_encode($entityResponseIns->getResponseJSON()),'failure',($endTime-$startTime));
				}
			}
			if($bulkResponseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK)
			{
				return false;
			}
			
			return true;
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateUpdateResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function setRecordFieldsAndValidate($moduleAPIName,$startTime,$endTime,$method)
	{
		try{
			$moduleFields=MetaDataAPIHandlerTest::$moduleVsFieldMap[$moduleAPIName];
			$layoutIds = array_keys( MetaDataAPIHandlerTest::$moduleVsLayoutMap[$moduleAPIName]);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleAPIName];
			foreach ($layoutIds as $layoutId)
			{
				$recordsArray=array();
				Main::incrementTotalCount();
				$moduleTextField=null;
				$productDetailsAPIName=null;
				for($index=0;$index<self::$createLimit;$index++)
				{
					$zcrmrecord=ZCRMRecord::getInstance($moduleAPIName, null);
					$layoutFields=MetaDataAPIHandlerTest::$moduleVsLayoutMap[$moduleAPIName][$layoutId];
					foreach ($moduleFields as $fieldAPIName=>$fieldDetails)
					{
						$inputData=array();
						if(!in_array($fieldAPIName, $layoutFields))
						{
							continue;
						}
						if($fieldAPIName=='Layout')
						{
							$zcrmrecord->setFieldValue("Layout",$layoutId);
							continue;
						}
						$fieldLabel=$fieldDetails['field_label'];
						$dataType=$fieldDetails['data_type'];
						if($dataType=='lookup' || ($fieldLabel=='Repeat' && $moduleName=='Events'))
						{
							continue;
						}
						elseif($dataType=='picklist')
						{
							$pickListValues=$fieldDetails['pick_list_values'];
							if(sizeof($pickListValues)>1)
							{
								$zcrmrecord->setFieldValue($fieldAPIName,$pickListValues[1]->getDisplayValue());
							}
							else
							{
								$zcrmrecord->setFieldValue($fieldAPIName,$pickListValues[0]->getDisplayValue());
							}
						}
						elseif($dataType=='currency')
						{
							$length=$fieldDetails['length']+0;
							$currencyVal="";
							for($i=0;$i<$length;$i++)
							{
							$currencyVal=$currencyVal.($i+1)%10;
							}
							$currencyVal=str_replace(".", "", $currencyVal);
							$currencyVal=str_replace("e+", "", $currencyVal);
									$zcrmrecord->setFieldValue($fieldAPIName,$currencyVal);
						}
						elseif($dataType=='double')
						{
							$val=TestUtil::$dataTypeVsValue[$dataType];
							$length=$fieldDetails['length']+0;
							if($length<strlen($val))
							{
								$val=substr($val, 0,$length);
							}
							$zcrmrecord->setFieldValue($fieldAPIName,$val+0);
						}
						elseif ($dataType=='text')
						{
							$val=$fieldLabel.round(microtime(true)*1000);
							$zcrmrecord->setFieldValue($fieldAPIName,$val);
							if($moduleTextField==null && $fieldLabel!='Product Details')
							{
								$moduleTextField=$fieldAPIName;
							}
						}
						elseif($dataType=='datetime')
						{
							$dateTime=TestUtil::getDateTimeISO();
							$zcrmrecord->setFieldValue($fieldAPIName,$dateTime);
						}
						elseif($dataType=='email')
						{
							$value="sumanth.chilka+auto".round(microtime(true)*1000)."@zohocorp.com";
							$zcrmrecord->setFieldValue($fieldAPIName,$value);
						}
						else
						{
							$length=$fieldDetails['length']+0;
							$value=isset(TestUtil::$dataTypeVsValue[$dataType])?TestUtil::$dataTypeVsValue[$dataType]:null;
							if($length<strlen($value))
							{
								$value=substr($value, 0,$length);
							}
							$zcrmrecord->setFieldValue($fieldAPIName,$value);
						}
								
						if($moduleName=='PriceBooks' && $fieldLabel=='Pricing Details')
						{
							$pricingDetails=array("from_range"=>1,"to_range"=>100,"discount"=>5);
							$zcrmrecord->setFieldValue($fieldAPIName,array($pricingDetails));
						}
						elseif($fieldLabel=='Product Details' && ($moduleName=='Quotes' || $moduleName=='SalesOrders' || $moduleName=='PurchaseOrders'|| $moduleName=='Invoices'))
						{
							$productObj=array("id"=>self::$productId);
							$productDetailsObj=array("product"=>$productObj,"quantity"=>150);
							$zcrmrecord->setFieldValue($fieldAPIName,array($productDetailsObj));
							$productDetailsAPIName=$fieldAPIName;
						}
						elseif($fieldLabel=='Call Duration' && $moduleName=='Calls')
						{
							$zcrmrecord->setFieldValue($fieldAPIName,"10");
						}
						elseif($fieldLabel=='Participants' && $moduleName=='Events')
						{
							$participantObj=array("type"=>"user","participant"=>OrganizationAPIHandlerTest::$userIdList[0]);
							$zcrmrecord->setFieldValue($fieldAPIName,array($participantObj));
						}
					}
					array_push($recordsArray, $zcrmrecord);
					unset($zcrmrecord);
				}
				if($method=="upsert")
				{
					$zcrmrecord=ZCRMRecord::getInstance($moduleAPIName, self::$moduleApiNameVsEntityIds[$moduleAPIName][0]);
					if($moduleName=='Quotes' || $moduleName=='SalesOrders' || $moduleName=='PurchaseOrders'|| $moduleName=='Invoices')
					{
						$productObj=array("id"=>self::$productId);
						$productDetailsObj=array("product"=>$productObj,"quantity"=>150);
						$zcrmrecord->setFieldValue($productDetailsAPIName,array($productDetailsObj));
					}
					$zcrmrecord->setFieldValue($moduleTextField, "Upsert_Text");
					array_push($recordsArray, $zcrmrecord);
					$successIds=self::validateUpsertResponse($recordsArray, $moduleAPIName, $startTime, $endTime,$zcrmrecord->getEntityId());
					if($successIds!=null && sizeof($successIds)>0)
					{
						$endTime=$endTime==0?microtime(true)*1000:$endTime;
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleAPIName.")",'upsertRecords',"Records upsert completed Successfully","Entity Id List::".json_encode($successIds),'success',($endTime-$startTime));
					}
				}
				else 
				{
					$isValid=self::validateCreateResponse($recordsArray, $moduleAPIName, $startTime, $endTime);
					if($isValid)
					{
						$endTime=$endTime==0?microtime(true)*1000:$endTime;
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleAPIName.")",'createRecords',"Records Created Successfully","Entity Id List::".json_encode(self::$moduleApiNameVsEntityIds[$moduleAPIName]),'success',($endTime-$startTime));
					}
				}
				unset($recordsArray);
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'setRecordFields',$e->getMessage().",id=".self::$moduleApiNameVsEntityIds[$moduleAPIName],$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateCreateResponse($recordsArray,$moduleAPIName,$startTime,$endTime)
	{
		try{
			$moduleIns=ZCRMModule::getInstance($moduleAPIName);
			$bulkResponseIns=$moduleIns->createRecords($recordsArray);
			$endTime=microtime(true)*1000;
			$createdRecords=$bulkResponseIns->getData();
			$entityResponses=$bulkResponseIns->getEntityResponses();
			$creationSuccess=true;
			foreach ($entityResponses as $entityResponseIns)
			{
				if(APIConstants::STATUS_SUCCESS!=$entityResponseIns->getStatus() || "record added"!=$entityResponseIns->getMessage() || $entityResponseIns->getCode()!=APIConstants::CODE_SUCCESS || $entityResponseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $entityResponseIns->getDetails()['id']==null)
				{
					$creationSuccess=false;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateCreateResponse',"Record Creation Failed",json_encode($entityResponseIns->getResponseJSON()),'failure',($endTime-$startTime));
					continue;
				}
			}
			$successIds=array();
			foreach ($createdRecords as $record)
			{
				array_push($successIds,$record->getEntityId());
			}
			if(MetaDataAPIHandlerTest::$moduleList[$moduleAPIName]=='Products')
			{
				self::$productId=$successIds[0];
			}
			self::$moduleApiNameVsEntityIds[$moduleAPIName]=$successIds;
			return $creationSuccess;
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateCreateResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function validateUpsertResponse($recordsArray,$moduleAPIName,$startTime,$endTime,$updateEntityId)
	{
		try{
			$startTime=microtime(true)*1000;
			$moduleIns=ZCRMModule::getInstance($moduleAPIName);
			$bulkResponseIns=$moduleIns->upsertRecords($recordsArray);
			$endTime=microtime(true)*1000;
			$upsertRecords=$bulkResponseIns->getData();
			$entityResponses=$bulkResponseIns->getEntityResponses();
			foreach ($entityResponses as $entityResponseIns)
			{
				if(APIConstants::STATUS_SUCCESS!=$entityResponseIns->getStatus() || ("record added"!=$entityResponseIns->getMessage() && "record updated"!=$entityResponseIns->getMessage()) || $entityResponseIns->getCode()!=APIConstants::CODE_SUCCESS || $entityResponseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $entityResponseIns->getDetails()['id']==null)
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateUpsertResponse',"Record Upsert Failed1",json_encode($entityResponseIns->getResponseJSON()),'failure',($endTime-$startTime));
					continue;
				}
			}
			$successIds=array();
			foreach ($upsertRecords as $record)
			{
				array_push($successIds,$record->getEntityId());
			}
			return $successIds;
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'MassEntityAPIHandlerTest('.$moduleAPIName.")",'validateUpsertResponse',$e->getExceptionCode(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return null;
		}
	}
	
}
?>