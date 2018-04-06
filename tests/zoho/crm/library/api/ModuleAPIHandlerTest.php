<?php

class ModuleAPIHandlerTest
{
	private static $filePointer=null;
	public static $moduleVsFieldIdMap=array();
	public static $moduleVsLayoutIdMap=array();
	public static $moduleVsCustomViewIdMap=array();
	public static $moduleVsRelatedListIdMap=array();
	public static $customViewVsFieldMap=array();
	
	public static function test($fp)
	{
		self::$filePointer=$fp;
		$ins=new ModuleAPIHandlerTest();
		$ins->testGetAllFields();
		$ins->testGetAllLayouts();
		$ins->testGetFieldDetails();
		$ins->testGetLayoutDetails();
		$ins->testGetAllCustomViews();
		$ins->testGetCustomViewDetails();
		$ins->testGetAllRelatedLists();
		$ins->testGetRelatedListDetails();
		$ins->testUpdateCustomView();
		$ins->testUpdateModuleSettings();
	}
	
	public function testGetAllFields()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getAllFields','Invalid Request','Module List is empty','failure',0);
			return;
		}
		foreach (MetaDataAPIHandlerTest::$moduleList as $moduleApiName=>$moduleName)
		{
			if($moduleName!='Activities' && in_array($moduleName,TestUtil::$nonSupportiveModules))
			{
				continue;
			}
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				Main::incrementTotalCount();
				$moduleIns=ZCRMModule::getInstance($moduleApiName);
				$responseInstance=$moduleIns->getAllFields();
				$zcrmFields=$responseInstance->getData();
				$endTime=microtime(true)*1000;
				if($zcrmFields==null || sizeof($zcrmFields)<=0)
				{
					throw new ZCRMException("Field data is not Received");
				}
				$fieldIdList=array();
				foreach ($zcrmFields as $zcrmField)
				{
					if($zcrmField->getId()==null || $zcrmField->getApiName()==null || $zcrmField->getDataType()==null || $zcrmField->getFieldLabel()==null)
					{
						throw new ZCRMException("Invalid Field Data Received");
					}
					if(!is_bool($zcrmField->isCustomField()) || !is_bool($zcrmField->isVisible()) || !is_bool($zcrmField->isReadOnly()) || !is_bool($zcrmField->isBusinessCardSupported()) || !is_string($zcrmField->getFieldLabel()) || !is_long($zcrmField->getId()) || !is_string($zcrmField->getApiName()) || !is_integer($zcrmField->getLength()) || !is_string($zcrmField->getCreatedSource()) || !is_string($zcrmField->getDataType()) || (!(TestUtil::isActivityModule($moduleName) || $moduleName=='Activities') && $zcrmField->getJsonType()==null))
					{
						throw new ZCRMException("Field details not fetched properly");
					}
					array_push($fieldIdList,$zcrmField->getId());
				}
				self::$moduleVsFieldIdMap[$moduleApiName]=$fieldIdList;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllFields()',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllFields()',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetFieldDetails()
	{
		if(sizeof(self::$moduleVsFieldIdMap)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getFieldDetails','Invalid Request','Module Field List is empty','failure',0);
			return;
		}
		foreach (self::$moduleVsFieldIdMap as $moduleApiName=>$fieldList)
		{
			$moduleIns=ZCRMModule::getInstance($moduleApiName);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleApiName];
			foreach ($fieldList as $field)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					Main::incrementTotalCount();
					$responseInstance=$moduleIns->getFieldDetails($field);
					$zcrmField=$responseInstance->getData();
					$endTime=microtime(true)*1000;
						
					if($zcrmField==null || $zcrmField->getId()==null || $zcrmField->getFieldLabel()==null || $zcrmField->getApiName()==null || $zcrmField->getDataType()==null)
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')','Invalid Response','Invalid field response received','failure',($endTime-$startTime));
						continue;
					}
					if(!is_bool($zcrmField->isCustomField()) || !is_bool($zcrmField->isVisible()) || !is_bool($zcrmField->isReadOnly()) || !is_bool($zcrmField->isBusinessCardSupported()) || !is_string($zcrmField->getFieldLabel()) || !is_long($zcrmField->getId()) || !is_string($zcrmField->getApiName()) || !is_integer($zcrmField->getLength()) || !is_string($zcrmField->getCreatedSource()) || !is_string($zcrmField->getDataType()) || ($moduleName!='Events' && $zcrmField->getJsonType()==null))
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')','Invalid Response','Field details not fetched properly','failure',($endTime-$startTime));
						continue;
					}
					if(!TestUtil::isActivityModule($moduleName) && $moduleName!='Activities' && $moduleName!='Attachments')
					{
						$dataType=$zcrmField->getDataType();
						if($dataType=='lookup' && $zcrmField->getLookupField()==null)
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')','Invalid Response','Lookup field data is not fetched','failure',($endTime-$startTime));
							continue;
						}
						else if($dataType=='picklist' && $zcrmField->getPickListFieldValues()==null)
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')','Invalid Response','PickList field values not fetched','failure',($endTime-$startTime));
							continue;
						}
						else if($dataType=='currency' && ($zcrmField->getPrecision()==null || $zcrmField->getDecimalPlace()==null || $zcrmField->getRoundingOption()==null))
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')','Invalid Response','Currency field data not fetched','failure',($endTime-$startTime));
							continue;
						}
					}
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')',null,null,'success',($endTime-$startTime));
				}
				catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getFieldDetails('.$field.')',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
				}
			}
		}
	}
	
	public function testGetAllLayouts()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getAllLayouts','Invalid Request','Module List is empty','failure',0);
			return;
		}
		foreach (MetaDataAPIHandlerTest::$moduleList as $moduleApiName=>$moduleName)
		{
			if($moduleName!='Activities' && in_array($moduleName,TestUtil::$nonSupportiveModules))
			{
				continue;
			}
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				Main::incrementTotalCount();
				$moduleIns=ZCRMModule::getInstance($moduleApiName);
				$responseInstance=$moduleIns->getAllLayouts();
				$zcrmLayouts=$responseInstance->getData();
				$endTime=microtime(true)*1000;
				if($zcrmLayouts==null || sizeof($zcrmLayouts)<=0)
				{
					throw new ZCRMException("Layout data is not Received");
				}
				$layoutIdList=array();
				foreach ($zcrmLayouts as $zcrmLayout)
				{
					if($zcrmLayout->getId()==null || $zcrmLayout->getName()==null || $zcrmLayout->getAccessibleProfiles()==null || $zcrmLayout->getSections()==null || !(sizeof($zcrmLayout->getSections())>=1))
					{
						throw new ZCRMException("Invalid Layout Data Received");
					}
					if(!is_string($zcrmLayout->getName())|| !is_long($zcrmLayout->getId()) || !is_integer($zcrmLayout->getStatus()) || !is_bool($zcrmLayout->isVisible()))
					{
						throw new ZCRMException("Layout details not fetched properly");
					}
					$layoutProfiles=$zcrmLayout->getAccessibleProfiles();
					foreach ($layoutProfiles as $profile)
					{
						if(!is_string($profile->getName()) || !is_long($profile->getId()))
						{
							throw new ZCRMException("layout accessible profiles data not fetched properly");
						}
					}
					$convertMapping=$zcrmLayout->getConvertMapping();
					if(sizeof($convertMapping)>0)
					{
						$accMapIns=$convertMapping[APIConstants::ACCOUNTS];
						$dealMapIns=$convertMapping[APIConstants::DEALS];
						$conMapIns=$convertMapping[APIConstants::CONTACTS];
						if(!is_string($accMapIns->getName()) || !is_long($accMapIns->getId()))
						{
							throw new ZCRMException("Lead convert mapping for Accounts not fetched properly");
						}
						else if(!is_string($dealMapIns->getName()) || !is_long($dealMapIns->getId()))
						{
							throw new ZCRMException("Lead convert mapping for Deals not fetched properly");
						}
						else if(!is_string($conMapIns->getName()) || !is_long($conMapIns->getId()))
						{
							throw new ZCRMException("Lead convert mapping for Contacts not fetched properly");
						}
					}
					$sections=$zcrmLayout->getSections();
					if($sections!=null)
					{
						foreach ($sections as $section)
						{
							if(!is_string($section->getName()) || !is_integer($section->getColumnCount()) || !is_integer($section->getSequenceNumber()) || !is_string($section->getDisplayName()))
							{
								throw new ZCRMException("Layout section data not fetched properly");
							}
								
							$fields=$section->getFields();
							if($fields==null)
							{
								continue;
							}
							foreach ($fields as $field)
							{
								if(!is_string($field->getApiName()) || !is_long($field->getId()) || !is_integer($field->getSequenceNumber()) || !is_bool($field->isMandatory()))
								{
									throw new ZCRMException("Layout section fields data not fetched properly");
								}
							}
						}
					}
					
					array_push($layoutIdList,$zcrmLayout->getId());
				}
				self::$moduleVsLayoutIdMap[$moduleApiName]=$layoutIdList;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllLayouts()',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllLayouts()',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetLayoutDetails()
	{
		if(sizeof(self::$moduleVsLayoutIdMap)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getLayoutDetails','Invalid Request','Module layout List is empty','failure',0);
			return;
		}
		foreach (self::$moduleVsLayoutIdMap as $moduleApiName=>$layoutList)
		{
			$moduleIns=ZCRMModule::getInstance($moduleApiName);
			foreach ($layoutList as $layoutId)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					Main::incrementTotalCount();
					$responseInstance=$moduleIns->getLayoutDetails($layoutId);
					$zcrmLayout=$responseInstance->getData();
					$endTime=microtime(true)*1000;
	
					if($zcrmLayout->getId()==null || $zcrmLayout->getName()==null || $zcrmLayout->getAccessibleProfiles()==null || $zcrmLayout->getSections()==null || !(sizeof($zcrmLayout->getSections())>=1))
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')','Invalid Response','Invalid Layout Data Received','failure',($endTime-$startTime));
						continue;
					}
					if(!is_string($zcrmLayout->getName())|| !is_long($zcrmLayout->getId()) || !is_integer($zcrmLayout->getStatus()) || !is_bool($zcrmLayout->isVisible()))
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')','Invalid Response','Layout details not fetched properly','failure',($endTime-$startTime));
						continue;
					}
					$layoutProfiles=$zcrmLayout->getAccessibleProfiles();
					foreach ($layoutProfiles as $profile)
					{
						if(!is_string($profile->getName()) || !is_long($profile->getId()))
						{
							throw new ZCRMException("layout accessible profiles data not fetched properly");
						}
					}
					$convertMapping=$zcrmLayout->getConvertMapping();
					if(sizeof($convertMapping)>0)
					{
						$accMapIns=$convertMapping[APIConstants::ACCOUNTS];
						$dealMapIns=$convertMapping[APIConstants::DEALS];
						$conMapIns=$convertMapping[APIConstants::CONTACTS];
						if(!is_string($accMapIns->getName()) || !is_long($accMapIns->getId()))
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')','Invalid Response','Lead convert mapping for Accounts not fetched properly','failure',($endTime-$startTime));
							continue;
						}
						else if(!is_string($dealMapIns->getName()) || !is_long($dealMapIns->getId()))
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')','Invalid Response','Lead convert mapping for Deals not fetched properly','failure',($endTime-$startTime));
							continue;
						}
						else if(!is_string($conMapIns->getName()) || !is_long($conMapIns->getId()))
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')','Invalid Response','Lead convert mapping for Contacts not fetched properly','failure',($endTime-$startTime));
							continue;
						}
					}
					$sections=$zcrmLayout->getSections();
					if($sections!=null)
					{
						foreach ($sections as $section)
						{
							if(!is_string($section->getName()) || !is_integer($section->getColumnCount()) || !is_integer($section->getSequenceNumber()) || !is_string($section->getDisplayName()))
							{
								throw new ZCRMException("Layout section data not fetched properly");
							}
					
							$fields=$section->getFields();
							if($fields==null)
							{
								continue;
							}
							foreach ($fields as $field)
							{
								if(!is_string($field->getApiName()) || !is_long($field->getId()) || !is_integer($field->getSequenceNumber()) || !is_bool($field->isMandatory()))
								{
									throw new ZCRMException("Layout section fields data not fetched properly");
								}
							}
						}
					}
	
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')',null,null,'success',($endTime-$startTime));
				}
				catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.")",'getLayoutDetails('.$layoutId.')',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
				}
			}
		}
	}
	
	public function testGetAllCustomViews()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getAllCustomViews','Invalid Request','Module List is empty','failure',0);
			return;
		}
		foreach (MetaDataAPIHandlerTest::$moduleList as $moduleApiName=>$moduleName)
		{
			if('Approvals'==$moduleName || 'Attachments'==$moduleName || 'Notes'==$moduleName || in_array($moduleName, TestUtil::$nonSupportiveModules))
			{
				continue;
			}
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				Main::incrementTotalCount();
				$moduleIns=ZCRMModule::getInstance($moduleApiName);
				$responseInstance=$moduleIns->getAllCustomViews();
				$zcrmCustomViews=$responseInstance->getData();
				$endTime=microtime(true)*1000;
				if($zcrmCustomViews==null || sizeof($zcrmCustomViews)<=0)
				{
					throw new ZCRMException("Custom view data is not Received");
				}
				
				$customviewIds=array();
				foreach ($zcrmCustomViews as $zcrmCustomView)
				{
					if($zcrmCustomView->getId()==null || $zcrmCustomView->getName()==null || !is_bool($zcrmCustomView->isDefault()) || ($zcrmCustomView->getSortBy()!=null && $zcrmCustomView->getSortOrder()==null) || !is_bool($zcrmCustomView->isOffLine()))
					{
						throw new ZCRMException("Invalid Custom View Data Received");
					}
					else if(!TestUtil::isActivityModule($moduleName) && ($zcrmCustomView->getFields()==null || !(sizeof($zcrmCustomView->getFields())>=1)))
					{
						throw new ZCRMException("Custom View Data is not fetched properly");
					}
					$categoryList=$zcrmCustomView->getCategoriesList();
					foreach ($categoryList as $category)
					{
						if($category->getDisplayValue()==null || $category->getActualValue()==null)
						{
							throw new ZCRMException("Custom View Category Data is not Received");
						}
					}
					array_push($customviewIds,$zcrmCustomView->getId());
				}
				self::$moduleVsCustomViewIdMap[$moduleApiName]=$customviewIds;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllCustomViews',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllCustomViews',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetCustomViewDetails()
	{
		if(sizeof(self::$moduleVsCustomViewIdMap)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getCustomViewDetails','Invalid Request','Module custom view List is empty','failure',0);
			return;
		}
		foreach (self::$moduleVsCustomViewIdMap as $moduleApiName=>$customViewIdList)
		{
			$moduleIns=ZCRMModule::getInstance($moduleApiName);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleApiName];
			foreach ($customViewIdList as $customViewId)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					Main::incrementTotalCount();
					$responseInstance=$moduleIns->getCustomView($customViewId);
					$zcrmCustomView=$responseInstance->getData();
					$endTime=microtime(true)*1000;
	
					if($zcrmCustomView==null || $zcrmCustomView->getId()==null || $zcrmCustomView->getName()==null || !is_bool($zcrmCustomView->isDefault()) || ($zcrmCustomView->getSortBy()!=null && $zcrmCustomView->getSortOrder()==null) || !is_bool($zcrmCustomView->isOffLine()))
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getCustomViewDetails('.$customViewId.')','Invalid Response','Invalid Custom view Data Received1','failure',($endTime-$startTime));
						continue;
					}
					else if(!TestUtil::isActivityModule($moduleName) && ($zcrmCustomView->getFields()==null || !(sizeof($zcrmCustomView->getFields())>=1)))
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getCustomViewDetails('.$customViewId.')','Invalid Response','Invalid Custom view Data Received2','failure',($endTime-$startTime));
						continue;
					}
					if($zcrmCustomView->getFields()!=null && sizeof($zcrmCustomView->getFields())!=0)
					{
						if($moduleName=='Contacts' || $moduleName=='Leads')
						{
							self::$customViewVsFieldMap[$customViewId]=$zcrmCustomView->getFields()[1];
						}
						else {
							self::$customViewVsFieldMap[$customViewId]=$zcrmCustomView->getFields()[0];
						}
					}
					
					$categoryList=$zcrmCustomView->getCategoriesList();
					foreach ($categoryList as $category)
					{
						if($category->getDisplayValue()==null || $category->getActualValue()==null)
						{
							Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getCustomViewDetails('.$customViewId.')','Invalid Response','Custom View Category Data is not Received','failure',($endTime-$startTime));
							continue;
						}
					}
	
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getCustomViewDetails('.$customViewId.')',null,null,'success',($endTime-$startTime));
				}
				catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getCustomViewDetails('.$customViewId.')',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
				}
			}
		}
	}
	
	public function testGetAllRelatedLists()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','getAllRelatedLists','Invalid Request','Module List is empty','failure',0);
			return;
		}
		foreach (MetaDataAPIHandlerTest::$moduleList as $moduleApiName=>$moduleName)
		{
			if('Notes'==$moduleName || 'Attachments'==$moduleName || in_array($moduleName, TestUtil::$nonSupportiveModules))
			{
				continue;
			}
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				Main::incrementTotalCount();
				$moduleIns=ZCRMModule::getInstance($moduleApiName);
				$responseInstance=$moduleIns->getAllRelatedLists();
				$zcrmModuleRelatedLists=$responseInstance->getData();
				$endTime=microtime(true)*1000;
				if($zcrmModuleRelatedLists==null || sizeof($zcrmModuleRelatedLists)<=0)
				{
					throw new ZCRMException("RelatedList data is not Received");
				}
	
				$relatedListIds=array();
				foreach ($zcrmModuleRelatedLists as $zcrmModuleRelatedList)
				{
					if($zcrmModuleRelatedList->getId()==null || $zcrmModuleRelatedList->getName()==null || $zcrmModuleRelatedList->getApiName()==null || $zcrmModuleRelatedList->getType()==null)
					{
						throw new ZCRMException("Invalid Related List Data Received");
					}
					array_push($relatedListIds,$zcrmModuleRelatedList->getId());
				}
				self::$moduleVsRelatedListIdMap[$moduleApiName]=$relatedListIds;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllRelatedLists()',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getAllRelatedLists()',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetRelatedListDetails()
	{
		if(sizeof(self::$moduleVsRelatedListIdMap)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getRelatedListDetails('.$relatedListId.')','Invalid Request','Module Related List is empty','failure',0);
			return;
		}
		foreach (self::$moduleVsRelatedListIdMap as $moduleApiName=>$relatedListIds)
		{
			$moduleIns=ZCRMModule::getInstance($moduleApiName);
			foreach ($relatedListIds as $relatedListId)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					Main::incrementTotalCount();
					$responseInstance=$moduleIns->getRelatedListDetails($relatedListId);
					$zcrmModuleRelatedList=$responseInstance->getData();
					$endTime=microtime(true)*1000;
	
					if($zcrmModuleRelatedList->getId()==null || $zcrmModuleRelatedList->getName()==null || $zcrmModuleRelatedList->getApiName()==null || $zcrmModuleRelatedList->getType()==null)
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getRelatedListDetails('.$relatedListId.')','Invalid Response','Invalid Related List Data Received','failure',($endTime-$startTime));
						continue;
					}
	
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getRelatedListDetails('.$relatedListId.')',null,null,'success',($endTime-$startTime));
				}
				catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','getRelatedListDetails('.$relatedListId.')',$e->getMessage(),sizeof($e->getExceptionDetails())>0?$e->getExceptionDetails():$moduleApiName,'failure',($endTime-$startTime));
				}
			}
		}
	}
	
	public function testUpdateCustomView()
	{
		if(sizeof(self::$moduleVsCustomViewIdMap)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','updateCustomView','Invalid Request','Module custom view List is empty','failure',0);
			return;
		}
		foreach (self::$moduleVsCustomViewIdMap as $moduleApiName=>$customViewIdList)
		{
			$moduleIns=ZCRMModule::getInstance($moduleApiName);
			$moduleName=MetaDataAPIHandlerTest::$moduleList[$moduleApiName];
			if(TestUtil::isActivityModule($moduleName))
			{
				continue;
			}
			foreach ($customViewIdList as $customViewId)
			{
				$startTime=microtime(true)*1000;
				$endTime=0;
				try{
					Main::incrementTotalCount();
					$customViewIns=ZCRMCustomView::getInstance($moduleApiName,$customViewId);
					$customViewIns->setSortBy(self::$customViewVsFieldMap[$customViewId]);
					$customViewIns->setSortOrder("desc");
					$responseInstance=$moduleIns->updateCustomView($customViewIns);
					$endTime=microtime(true)*1000;
					if($responseInstance->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $responseInstance->getMessage()!='CustomView Details updated successfully' || $responseInstance->getStatus()!=APIConstants::STATUS_SUCCESS || $responseInstance->getCode()!=APIConstants::CODE_SUCCESS)
					{
						Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','updateCustomView('.$customViewId.')','Invalid Response',$responseInstance->getHttpStatusCode().",".$responseInstance->getMessage(),'failure',($endTime-$startTime));
					}
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','updateCustomView('.$customViewId.')','CustomView Details updated successfully',$customViewIns->getSortBy().",".$customViewIns->getSortOrder(),'success',($endTime-$startTime));
				}
				catch (ZCRMException $e)
				{
					$endTime=$endTime==0?microtime(true)*1000:$endTime;
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','updateCustomView('.$customViewId.')',$e->getMessage(),json_encode($e->getExceptionDetails()),'failure',($endTime-$startTime));
				}
			}
		}
				
	}
	
	public function testUpdateModuleSettings()
	{
		if(sizeof(MetaDataAPIHandlerTest::$moduleList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule','updateModuleSettings','Invalid Request','Module List is empty','failure',0);
			return;
		}
		foreach (MetaDataAPIHandlerTest::$moduleList as $moduleApiName=>$moduleName)
		{
			if(in_array($moduleName, TestUtil::$nonSupportiveModules))
			{
				continue;
			}
			$startTime=microtime(true)*1000;
			$endTime=0;
			try{
				Main::incrementTotalCount();
				$moduleIns=ZCRMModule::getInstance($moduleApiName);
				$moduleIns->setPerPage(40);
				$responseInstance=$moduleIns->updateModuleSettings();
				$endTime=microtime(true)*1000;
				if($responseInstance->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || $responseInstance->getResponseJSON()['modules']['message']!='module updated successfully' || $responseInstance->getStatus()!=APIConstants::STATUS_SUCCESS || $responseInstance->getCode()!=APIConstants::CODE_SUCCESS)
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','updateModuleSettings(per_page=40)','Invalid Response',$responseInstance->getHttpStatusCode().",".json_encode($responseInstance->getResponseJSON()),'failure',($endTime-$startTime));
					continue;
				}
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','updateModuleSettings(per_page=40)','CustomView Details updated successfully',"'per_page':40",'success',($endTime-$startTime));
			}
			catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMModule('.$moduleApiName.')','updateCustomView('.$customViewId.')',$e->getMessage(),json_encode($e->getExceptionDetails()),'failure',($endTime-$startTime));
			}
		}
	}
}
?>