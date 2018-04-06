<?php
require_once realpath(dirname(__FILE__)."/../../../../../com/zoho/crm/library/api/handler/EntityAPIHandler.php");
require_once realpath(dirname(__FILE__)."/../../../../../com/zoho/crm/library/crud/ZCRMJunctionRecord.php");
require_once 'MetaDataAPIHandlerTest.php';
require_once realpath(dirname(__FILE__)."/../common/TestUtil.php");

class EntityAPIHandlerTest
{
	public static $filePointer=null;
	public static $productId=null;
	public static $firstParnetId=null;
	public static $firstParnetModule=null;
	public static $moduleApiNameVsEntityId=array();
	public static function test($fp)
	{
		self::$filePointer=$fp;
		self::testCreateRecord();
		self::testUpdateRecord();
		self::testGetRecord();
		self::testAddRelation();
		self::testRemoveRelation();
		self::testDeleteRecord();
	}
	
	public function testAddRelation()
	{
		$productId=self::$moduleApiNameVsEntityId[MetaDataAPIHandlerTest::$moduleNameVsApiName["Products"]];
		$priceBookId=self::$moduleApiNameVsEntityId[MetaDataAPIHandlerTest::$moduleNameVsApiName["PriceBooks"]];
		$startTime=microtime(true)*1000;
		$endTime=0;
		try{
			Main::incrementTotalCount();
			$parentRecord=ZCRMRecord::getInstance("Products", $productId);
			$junctionRecord=ZCRMJunctionRecord::getInstance("Price_Books", $priceBookId);
			$junctionRecord->setRelatedData("list_price", 98);
			$responseIns=$parentRecord->addRelation($junctionRecord);
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || "relation added"!=$responseIns->getMessage() || $responseIns->getCode()!=APIConstants::CODE_SUCCESS || $responseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $responseIns->getDetails()['id']!=$junctionRecord->getId())
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord(Products,'.$productId.")",'addRelation(Price_Books,'.$priceBookId.")",$responseIns->getMessage(),$responseIns->getHttpStatusCode(),'failure',($endTime-$startTime));
				return;
			}
			
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord(Products,'.$productId.")",'addRelation(Price_Books,'.$priceBookId.")","Relation added successfully",$responseIns->getDetails()['id'],'success',($endTime-$startTime));
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord(Products,'.$productId.")",'addRelation(Price_Books,'.$priceBookId.")",$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	public function testRemoveRelation()
	{
		$productId=self::$moduleApiNameVsEntityId[MetaDataAPIHandlerTest::$moduleNameVsApiName["Products"]];
		$priceBookId=self::$moduleApiNameVsEntityId[MetaDataAPIHandlerTest::$moduleNameVsApiName["PriceBooks"]];
		$startTime=microtime(true)*1000;
		$endTime=0;
		try{
			Main::incrementTotalCount();
			$parentRecord=ZCRMRecord::getInstance("Products", $productId);
			$junctionRecord=ZCRMJunctionRecord::getInstance("Price_Books", $priceBookId);
			$responseIns=$parentRecord->removeRelation($junctionRecord);
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || "relation removed"!=$responseIns->getMessage() || $responseIns->getCode()!=APIConstants::CODE_SUCCESS || $responseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $responseIns->getDetails()['id']!=$junctionRecord->getId())
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord(Products,'.$productId.")",'removeRelation(Price_Books,'.$priceBookId.")",$responseIns->getMessage(),$responseIns->getHttpStatusCode(),'failure',($endTime-$startTime));
				return;
			}
				
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord(Products,'.$productId.")",'removeRelation(Price_Books,'.$priceBookId.")","Relation added successfully",$responseIns->getDetails()['id'],'success',($endTime-$startTime));
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord(Products,'.$productId.")",'removeRelation(Price_Books,'.$priceBookId.")",$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	public function testCreateRecord()
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
				if(self::$firstParnetModule==null)
				{
					self::$firstParnetModule=$apiName;
				}
				self::setRecordFieldsAndValidate($apiName,$startTime,$endTime);
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord','create',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			}
			
		}
	}
	
	public function testUpdateRecord()
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
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord','update',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function testGetRecord()
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
					if($moduleName=='Attachments')
					{
						self::downloadFile($apiName,$startTime, $endTime);
						continue;
					}
					$isValid=self::validateGetRecordResponse($apiName,$startTime,$endTime);
					if($isValid)
					{
						$endTime=$endTime==0?microtime(true)*1000:$endTime;
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$apiName.")",'getRecord('.self::$moduleApiNameVsEntityId[$apiName].')',"Record fetched Successfully","EntityId::".self::$moduleApiNameVsEntityId[$apiName],'success',($endTime-$startTime));
					}
					if($moduleName=="Notes")
					{
						self::getNotes($apiName,$startTime, $endTime);
					}
				}catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$apiName.')','testGetRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
				}
					
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$apiName.')','testGetRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function testDeleteRecord()
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
					Main::incrementTotalCount();
					if($moduleName=='Attachments')
					{
						self::deleteFile($apiName,$startTime, $endTime);
						continue;
					}
					else if($moduleName=='Notes')
					{
						self::deleteNote($apiName, $startTime, $endTime);
						continue;
					}
					$isValid=self::validateDeleteRecordResponse($apiName,$startTime,$endTime);
					if($isValid)
					{
						$endTime=$endTime==0?microtime(true)*1000:$endTime;
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),"ZCRMRecord(".$apiName.",".self::$moduleApiNameVsEntityId[$apiName].")",'delete()',"Record Deleted Successfully","EntityId::".self::$moduleApiNameVsEntityId[$apiName],'success',($endTime-$startTime));
					}
				}catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$apiName.')','testDeleteRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
				}
					
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$apiName.')','testDeleteRecord',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateDeleteRecordResponse($moduleAPIName,$startTime,$endTime)
	{
		try{
			if(self::$moduleApiNameVsEntityId[$moduleAPIName]==null)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordResponse',"Unable to process","Record creation failed so get can't be done",'failure',($endTime-$startTime));
			}
			$recordIns=ZCRMRecord::getInstance($moduleAPIName, self::$moduleApiNameVsEntityId[$moduleAPIName]);
			$responseIns=$recordIns->delete();
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $responseIns->getMessage()!='record deleted' || $responseIns->getCode()!=APIConstants::CODE_SUCCESS || $responseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $responseIns->getDetails()['id']!=$recordIns->getEntityId())
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateDeleteRecordResponse',"Record deletion failed,id=".$recordIns->getEntityId(),$responseIns->getCode(),'failure',($endTime-$startTime));
				return false;
			}
			return true;
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateDeleteRecordResponse',$e->getMessage().",id:".self::$moduleApiNameVsEntityId[$moduleAPIName],$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function validateGetRecordResponse($moduleAPIName,$startTime,$endTime)
	{
		try {
			$moduleIns=ZCRMModule::getInstance($moduleAPIName);
			if(self::$moduleApiNameVsEntityId[$moduleAPIName]==null)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateGetRecordResponse',"Unable to process","Record creation failed so get can't be done",'failure',($endTime-$startTime));
			}
			$responseIns=$moduleIns->getRecord(self::$moduleApiNameVsEntityId[$moduleAPIName]);
			$endTime=microtime(true)*1000;
			$zcrmRecord=$responseIns->getData();
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $zcrmRecord==null || $zcrmRecord->getData()==null || $zcrmRecord->getCreatedBy()==null || $zcrmRecord->getOwner()==null || $zcrmRecord->getCreatedTime()==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName."),".self::$moduleApiNameVsEntityId[$moduleAPIName],'validateGetRecordResponse',"Record Get failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			return true;
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName."),".self::$moduleApiNameVsEntityId[$moduleAPIName],'validateGetRecordResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function updateRecordFieldsAndValidate($moduleAPIName,$startTime,$endTime)
	{
		try
		{
			$moduleFields=MetaDataAPIHandlerTest::$moduleVsFieldMap[$moduleAPIName];
			$layoutIds = array_keys( MetaDataAPIHandlerTest::$moduleVsLayoutMap[$moduleAPIName]);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleAPIName];
			if($moduleName=='Attachments')
			{
				return 0;
			}
			else if($moduleName=='Notes')
			{
				self::updateNote($moduleAPIName, $startTime, $endTime);
				return 0;
			}
			foreach ($layoutIds as $layoutId)
			{
				Main::incrementTotalCount();
				if(self::$moduleApiNameVsEntityId[$moduleAPIName]==null)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'updateRecordFieldsAndValidate',"Unable to process","Record creation failed so update can't be done",'failure',($endTime-$startTime));
					continue;
				}
				$zcrmrecord=ZCRMRecord::getInstance($moduleAPIName, self::$moduleApiNameVsEntityId[$moduleAPIName]);
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
						$val=$fieldLabel.rand(1,19);
						$zcrmrecord->setFieldValue($fieldAPIName,$val);
					}
					elseif($dataType=='datetime')
					{
						$dateTime=TestUtil::getDateTimeISO();
						$zcrmrecord->setFieldValue($fieldAPIName,$dateTime);
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
					elseif($fieldLabel=='Product Details' && ($moduleName=='Quotes' || $moduleName=='SalesOrders' || $moduleName=='PurchaseOrders'|| $moduleName='Invoices'))
					{
						$productObj=array("id"=>self::$productId);
						$productDetailsObj=array("product"=>$productObj,"quantity"=>150);
						$zcrmrecord->setFieldValue($fieldAPIName,array($productDetailsObj));
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
				if($moduleName=='Notes')
				{
					$zcrmrecord->setFieldValue($fieldAPIName,self::$firstParnetId);
					$zcrmrecord->setFieldValue('$se_module',self::$firstParnetModule);
				}
				$isValid=self::validateUpdateResponse($zcrmrecord, $moduleAPIName, $startTime, $endTime);
				if($isValid)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),"ZCRMRecord(".$moduleAPIName.",".self::$moduleApiNameVsEntityId[$moduleAPIName].")",'update()',"Record Updated Successfully","EntityId::".$zcrmrecord->getEntityId(),'success',($endTime-$startTime));
				}
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'updateRecordFieldsAndValidate',$e->getMessage().",id=".self::$moduleApiNameVsEntityId[$moduleAPIName],$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateUpdateResponse($zcrmrecord,$moduleAPIName,$startTime,$endTime)
	{
		try{
			$responseIns=$zcrmrecord->update();
			$endTime=microtime(true)*1000;
			$responseRecord=$responseIns->getData();
			if($responseRecord->getEntityId()==null || $responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $responseIns->getMessage()!='record updated' || $responseIns->getCode()!=APIConstants::CODE_SUCCESS || $responseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $responseIns->getDetails()['id']!=$zcrmrecord->getEntityId())
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateUpdateResponse',"Record update failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			return true;
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateUpdateResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function setRecordFieldsAndValidate($moduleAPIName,$startTime,$endTime)
	{
		try{
			$moduleFields=MetaDataAPIHandlerTest::$moduleVsFieldMap[$moduleAPIName];
			$layoutIds = array_keys( MetaDataAPIHandlerTest::$moduleVsLayoutMap[$moduleAPIName]);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleAPIName];
			if($moduleName=='Attachments')
			{
				Main::incrementTotalCount();
				self::uploadFile($moduleAPIName,$startTime,$endTime);
				return 0;
			}
			else if($moduleName=='Notes')
			{
				Main::incrementTotalCount();
				self::createNote($moduleAPIName,$startTime,$endTime);
				return 0;
			}
			foreach ($layoutIds as $layoutId)
			{
				Main::incrementTotalCount();
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
						$val=$fieldLabel.rand(1,19);
						$zcrmrecord->setFieldValue($fieldAPIName,$val);
					}
					elseif($dataType=='datetime')
					{
						$dateTime=TestUtil::getDateTimeISO();
						$zcrmrecord->setFieldValue($fieldAPIName,$dateTime);
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
					elseif($fieldLabel=='Product Details' && ($moduleName=='Quotes' || $moduleName=='SalesOrders' || $moduleName=='PurchaseOrders'|| $moduleName='Invoices'))
					{
						$productObj=array("id"=>self::$productId);
						$productDetailsObj=array("product"=>$productObj,"quantity"=>150);
						$zcrmrecord->setFieldValue($fieldAPIName,array($productDetailsObj));
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
				if($moduleName=='Notes')
				{
					$zcrmrecord->setFieldValue($fieldAPIName,self::$firstParnetId);
					$zcrmrecord->setFieldValue('$se_module',self::$firstParnetModule);
				}
				$isValid=self::validateCreateResponse($zcrmrecord, $moduleAPIName, $startTime, $endTime);
				if($isValid)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.$moduleAPIName.")",'create',"Record Created Successfully","EntityId::".$zcrmrecord->getEntityId(),'success',($endTime-$startTime));
				}
			}
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'setRecordFields',$e->getMessage().",id=".self::$moduleApiNameVsEntityId[$moduleAPIName],$e->getTraceAsString(),'failure',($endTime-$startTime));
		}
	}
	
	public function validateCreateResponse($zcrmrecord,$moduleAPIName,$startTime,$endTime)
	{
		try{
			$responseIns=$zcrmrecord->create();
			$endTime=microtime(true)*1000;
			$responseRecord=$responseIns->getData();
			if($responseRecord->getEntityId()==null || $responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_CREATED || $responseIns->getCode()!=APIConstants::CODE_SUCCESS || $responseIns->getStatus()!=APIConstants::STATUS_SUCCESS || $responseIns->getDetails()['id']==null)
			{
				var_dump($responseRecord);
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateCreateResponse',"Record Creation Failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleAPIName];
			if($moduleName=='Products')
			{
				self::$productId=$responseRecord->getEntityId();
			}
			if(self::$firstParnetModule==$moduleAPIName)
			{
				self::$firstParnetId=$responseRecord->getEntityId();
			}
			
			self::$moduleApiNameVsEntityId[$moduleAPIName]=$responseRecord->getEntityId();
			
			
			/*$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleAPIName];
			if($moduleName=='Leads' || $moduleName=='Accounts' || $moduleName=='Quotes' || $moduleName=='SalesOrders'||$moduleName=='PurchaseOrders' || $moduleName=='Invoices')
			{
				return true;
			}
			
			$zcrmModule=ZCRMModule::getInstance($moduleAPIName);
			$responseIns=$zcrmModule->getRecord($responseRecord->getEntityId());
			$getRecord=$responseIns->getData();
			$fieldKeyValueMapGET=$getRecord->getData();
			$fieldKeyValueMapCREATE=$zcrmrecord->getData();
			
			foreach ($fieldKeyValueMapCREATE as $key=>$value)
			{
				if($value!=$fieldKeyValueMapGET[$key])
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateCreateResponse',"Invalid Response","Given Field value is not populated(field:".$key.")",'failure',($endTime-$startTime));
					return false;
				}
			}
			*/
			
			return true;
			
		}
		catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.$moduleAPIName.")",'validateCreateResponse',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function uploadFile($moduleAPIName,$startTime,$endTime)
	{
		try{
			$record=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$responseIns=$record->uploadAttachment('../../../resources/image.png');
			$endTime=microtime(true)*1000;
			$attchmentIns=$responseIns->getData();
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $attchmentIns->getId()==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.")",'uploadFile',"File not uploaded",$responseIns->getMessage(),'failure',($endTime-$startTime));
			}
			else {
				self::$moduleApiNameVsEntityId[$moduleAPIName]=$attchmentIns->getId();
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'uploadAttachment',"File uploaded Successfully","EntityId::".$attchmentIns->getId(),'success',($endTime-$startTime));
			}
			
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'uploadFile',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
		try{
			$startTime=microtime(true)*1000;
			Main::incrementTotalCount();
			$record=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$responseIns=$record->uploadLinkAsAttachment("https://www.zoho.com");
			$endTime=microtime(true)*1000;
			$attchmentIns=$responseIns->getData();
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $attchmentIns->getId()==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.")",'uploadFile(ATTACHMENT_URL)',"File not uploaded",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'uploadLinkAsAttachment("https://www.zoho.com")',"URL as File uploaded Successfully","EntityId::".$attchmentIns->getId(),'success',($endTime-$startTime));
			
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'uploadFile(ATTACHMENT_URL)',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function downloadFile($moduleAPIName,$startTime,$endTime)
	{
		try{
			$record=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$responseIns=$record->downloadAttachment(self::$moduleApiNameVsEntityId[$moduleAPIName]);
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $responseIns->getFileContent()==null || $responseIns->getFileName()==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'downloadFile('.self::$moduleApiNameVsEntityId[$record->getModuleApiName()].')',"File download failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
			}
			else{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'downloadAttachment('.self::$moduleApiNameVsEntityId[$moduleAPIName].')',"File Downloaded successfully","Attachment Id:".self::$moduleApiNameVsEntityId[$moduleAPIName],'success',($endTime-$startTime));
			}
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.")",'downloadFile',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
		
		try{
			Main::incrementTotalCount();
			$startTime=microtime(true)*1000;
			$record=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$responseIns=$record->getAttachments();
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || sizeof($responseIns->getData())==0)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'getAttachments',"File download failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'getAttachments()',"Attachments fetched successfully",'Attachments fetched='.sizeof($responseIns->getData()),'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.")",'downloadFile',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function deleteFile($moduleAPIName,$startTime,$endTime)
	{
		try{
			$record=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$responseIns=$record->deleteAttachment(self::$moduleApiNameVsEntityId[$moduleAPIName]);
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $responseIns->getMessage()!='record deleted')
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'deleteFile('.self::$moduleApiNameVsEntityId[$record->getModuleApiName()].')',"File deletion failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'deleteAttachment('.self::$moduleApiNameVsEntityId[$moduleAPIName].')',"File Deleted successfully","Attachment Id:".self::$moduleApiNameVsEntityId[$moduleAPIName],'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'deleteFile('.self::$moduleApiNameVsEntityId[$moduleAPIName].")",$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function createNote($moduleAPIName,$startTime,$endTime)
	{
		try{
			$parentRecord=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$noteIns=ZCRMNote::getInstance($parentRecord);
			$noteIns->setContent("Sample Content");
			$noteIns->setTitle("PHP Client Library");
			$responseIns=$parentRecord->addNote($noteIns);
			$endTime=microtime(true)*1000;
			$zcrmNote=$responseIns->getData();
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_CREATED || $zcrmNote->getId()==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'createNote',"Note Creation failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			self::$moduleApiNameVsEntityId[$moduleAPIName]=$zcrmNote->getId();
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'addNote',"Note added Successfully","EntityId::".$zcrmNote->getId(),'success',($endTime-$startTime));
				
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'createNote',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function updateNote($moduleAPIName,$startTime,$endTime)
	{
		try{
			if(self::$moduleApiNameVsEntityId[$moduleAPIName]==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'updateNote',"Note update failed",'Reason::Note creation failed','failure',($endTime-$startTime));
				return false;
			}
			$parentRecord=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$noteIns=ZCRMNote::getInstance($parentRecord,self::$moduleApiNameVsEntityId[$moduleAPIName]);
			$noteIns->setContent("Sample Content1");
			$noteIns->setTitle("PHP Client Library1");
			$responseIns=$parentRecord->updateNote($noteIns);
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK ||$responseIns->getMessage()!='record updated')
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'updateNote',"Note update failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'updateNote',"Note updated Successfully","EntityId::".self::$moduleApiNameVsEntityId[$moduleAPIName],'success',($endTime-$startTime));
	
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'updateNote',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function getNotes($moduleAPIName,$startTime,$endTime)
	{
		try{
			Main::incrementTotalCount();
			if(self::$moduleApiNameVsEntityId[$moduleAPIName]==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'getNotes',"Related Notes fetching failed",'Reason::Note creation failed','failure',0);
				return false;
			}
			$parentRecord=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$responseIns=$parentRecord->getNotes();
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK ||sizeof($responseIns->getData())==0)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'getNotes',"Related Notes fetching failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'getNotes()',"Related Notes fetched Successfully","Notes Count=".sizeof($responseIns->getData()),'success',($endTime-$startTime));
	
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'getNotes',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public function deleteNote($moduleAPIName,$startTime,$endTime)
	{
		try{
			if(self::$moduleApiNameVsEntityId[$moduleAPIName]==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'deleteNote',"Note deletion failed",'Reason::Note creation failed','failure',0);
				return false;
			}
			$parentRecord=ZCRMRecord::getInstance(self::$firstParnetModule,self::$firstParnetId);
			$noteIns=ZCRMNote::getInstance($parentRecord,self::$moduleApiNameVsEntityId[$moduleAPIName]);
			$responseIns=$parentRecord->deleteNote($noteIns);
			$endTime=microtime(true)*1000;
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK ||$responseIns->getMessage()!='record deleted')
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'deleteNote',"Note deletion failed",$responseIns->getMessage(),'failure',($endTime-$startTime));
				return false;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRecord('.self::$firstParnetModule.','.self::$firstParnetId.")",'updateNote',"Note deleted Successfully","NoteId::".$noteIns->getId(),'success',($endTime-$startTime));
	
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'EntityAPIHandlerTest('.self::$firstParnetModule.','.self::$firstParnetId.")",'deleteNote',$e->getMessage(),$e->getTraceAsString(),'failure',($endTime-$startTime));
			return false;
		}
	}
	
	public static function alterModulePositions($isProductFirst)
	{
		$inventoryModuleFound=false;
		$productModuleFound=false;
		$swapNeeded=false;
		$productAPIName=null;
		foreach (MetaDataAPIHandlerTest::$moduleList as $apiName=>$moduleName)
		{
			if($isProductFirst)
			{
				if($moduleName=="Products")
				{
					$productAPIName=$apiName;
					$productModuleFound=true;
					if(!$inventoryModuleFound)
					{
						break;
					}
				}
				else if(($moduleName=="Quotes" || $moduleName=="SalesOrders" || $moduleName=="PurchaseOrders" || $moduleName=="Invoices") && !$productModuleFound)
				{
					$swapNeeded=true;
				}
			}
			else {
				if($moduleName=="Products")
				{
					$productAPIName=$apiName;
					$productModuleFound=true;
					if(!$inventoryModuleFound)
					{
						$swapNeeded=true;
						break;
					}
				}
				else if($moduleName=="Quotes" || $moduleName=="SalesOrders" || $moduleName=="PurchaseOrders" || $moduleName=="Invoices")
				{
					if($productModuleFound)
					{
						$productAPIName=MetaDataAPIHandlerTest::$moduleNameVsApiName['Products'];
						$swapNeeded=true;
						break;
					}
					$inventoryModuleFound=true;
				}
			}
		}
		$moduleList=MetaDataAPIHandlerTest::$moduleList;
		if($swapNeeded)
		{
			unset($moduleList[$productAPIName]);
			if($isProductFirst)
			{
				$moduleList=array($productAPIName=>"Products")+$moduleList;
			}
			else {
				$moduleList=$moduleList+array($productAPIName=>"Products");
			}
		}
	
		return $moduleList;
	}
	
}
?>