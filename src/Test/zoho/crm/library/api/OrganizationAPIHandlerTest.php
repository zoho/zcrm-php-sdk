<?php
require_once realpath(dirname(__FILE__)."/../Main.php");
require_once realpath(dirname(__FILE__)."/../common/Helper.php");
class OrganizationAPIHandlerTest
{
	public static $profileNameVsIdMap=array();
	public static $roleNameVsIdMap=array();
	public static $userEmailVsDetails=array();
	public static $roleIdList=array();
	public static $profileIdList=array();
	public static $userIdList=array();
	public static $adminRoleId=null;
	public static $adminProfileId=null;
	private static $filePointer=null;
	private static $userTypeVsMethod=array("ActiveUsers"=>"getAllActiveUsers","DeactiveUsers"=>"getAllDeactiveUsers","ConfirmedUsers"=>"getAllConfirmedUsers","NotConfirmedUsers"=>"getAllNotConfirmedUsers","DeletedUsers"=>"getAllDeletedUsers","ActiveConfirmedUsers"=>"getAllActiveConfirmedUsers","AdminUsers"=>"getAllAdminUsers","ActiveConfirmedAdmins"=>"getAllActiveConfirmedAdmins","CurrentUser"=>"getCurrentUser");
	public static function test($fp)
	{
		$ins=new OrganizationAPIHandlerTest();
		self::$filePointer=$fp;
		$ins->testGetOrganizationDetails();
		$ins->testGetAllProfiles();
		$ins->testGetAllRoles();
		$ins->testGetProfile();
		$ins->testGetRole();
		$ins->testGetAllUsers();
		$ins->testCreateUsers();
		$ins->testGetUser();
		$ins->testSpecificUsers();
	}
	
	public function testGetOrganizationDetails()
	{
		try{
			Main::incrementTotalCount();
			$startTime=microtime(true)*1000;
			$endTime=0;
			$restIns=ZCRMRestClient::getInstance();
			$responseInstance=$restIns->getOrganizationDetails();
			$zcrmOrganization=$responseInstance->getData();
			$endTime=microtime(true)*1000;
			if($zcrmOrganization->getOrgId()==null || $zcrmOrganization->getCompanyName()==null || $zcrmOrganization->getPrimaryEmail()==null || $zcrmOrganization->getPrimaryZuid()==null || $zcrmOrganization->getZgid()==null || $zcrmOrganization->getTimeZone()==null || $zcrmOrganization->getCurrencyLocale()==null || $zcrmOrganization->getCountry()==null|| $zcrmOrganization->getCity()==null ||$zcrmOrganization->getStreet()==null||$zcrmOrganization->getState()==null||$zcrmOrganization->getFax()==null||$zcrmOrganization->getEmployeeCount()==null || $zcrmOrganization->getPhone()==null||$zcrmOrganization->getMobile()==null||$zcrmOrganization->getZipCode()==null||$zcrmOrganization->getWebSite()==null||$zcrmOrganization->getCurrencySymbol()==null ||$zcrmOrganization->getCountryCode()==null||$zcrmOrganization->getIsoCode()==null)
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRestClient','getOrganizationDetails',"Invalid Response","Org details not fetched properly",'failure',($endTime-$startTime));
				return;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRestClient','getOrganizationDetails',"Org Details Fetched Successfully!!",null,'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMRestClient','getOrganizationDetails',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
		}
	}
	
	public function testGetAllProfiles()
	{
		try{
			Main::incrementTotalCount();
			$startTime=microtime(true)*1000;
			$endTime=0;
			$orgIns=ZCRMOrganization::getInstance();
			$responseInstance=$orgIns->getAllProfiles();
			$zcrmProfiles=$responseInstance->getData();
			$endTime=microtime(true)*1000;
			if($zcrmProfiles==null || sizeof($zcrmProfiles)<=0)
			{
				throw new ZCRMException("No Profile Received");
			}
			foreach ($zcrmProfiles as $zcrmProfile)
			{
				if($zcrmProfile->getId()==null || $zcrmProfile->getName()==null)
				{
					throw new ZCRMException("Invalid Profile Data Received (Either ID or Name is NULL)");
				}
				if('Administrator'===$zcrmProfile->getName())
				{
					self::$adminProfileId=$zcrmProfile->getId();
				}
				array_push(self::$profileIdList,$zcrmProfile->getId());
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getAllProfiles',null,null,'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getAllProfiles',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
		}
	}
	
	public function testGetAllRoles()
	{
		try{
			Main::incrementTotalCount();
			$startTime=microtime(true)*1000;
			$endTime=0;
			$orgIns=ZCRMOrganization::getInstance();
			$responseInstance=$orgIns->getAllRoles();
			$zcrmRoles=$responseInstance->getData();
			$endTime=microtime(true)*1000;
			if($zcrmRoles==null || sizeof($zcrmRoles)<=0)
			{
				throw new ZCRMException("No Role Received");
			}
			foreach ($zcrmRoles as $zcrmRole)
			{
				if($zcrmRole->getId()==null || $zcrmRole->getName()==null || $zcrmRole->getDisplayLabel()==null || ($zcrmRole->getReportingTo()!=null && ($zcrmRole->getReportingTo()->getId()==null || $zcrmRole->getReportingTo()->getName()==null)))
				{
					throw new ZCRMException("Invalid Role Data Received (Either ID or Name or Label or reportingTo is NULL)");
				}
				if($zcrmRole->isAdminRole())
				{
					self::$adminRoleId=$zcrmRole->getId();
				}
				array_push(self::$roleIdList,$zcrmRole->getId());
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getAllRoles',null,null,'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getAllRoles',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
		}
	}
	
	public function testGetRole()
	{
		if(sizeof(self::$roleIdList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getRole','Invalid Response','Roles List is null or empty','failure',0);
			return;
		}
		$orgIns=ZCRMOrganization::getInstance();
		foreach (self::$roleIdList as $roleId)
		{
			try{
				Main::incrementTotalCount();
				$startTime=microtime(true)*1000;
				$endTime=0;
				$responseInstance=$orgIns->getRole($roleId);
				$endTime=microtime(true)*1000;
				$zcrmRole=$responseInstance->getData();
				if($zcrmRole->getId()==null || $zcrmRole->getName()==null || $zcrmRole->getDisplayLabel()==null || ($zcrmRole->getReportingTo()!=null && ($zcrmRole->getReportingTo()->getId()==null || $zcrmRole->getReportingTo()->getName()==null)))
				{
					throw new ZCRMException("Invalid Role Data Received (Either ID or Name or Label or Reporting To is NULL)");
				}
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getRole('.$roleId.')',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getRole('.$roleId.')',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetProfile()
	{
		if(sizeof(self::$profileIdList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getProfile','Invalid Response','Profile List is null or empty','failure',0);
			return;
		}
		$orgIns=ZCRMOrganization::getInstance();
		foreach (self::$profileIdList as $profileId)
		{
			try{
				Main::incrementTotalCount();
				$startTime=microtime(true)*1000;
				$endTime=0;
				$responseInstance=$orgIns->getProfile($profileId);
				$endTime=microtime(true)*1000;
				$zcrmProfile=$responseInstance->getData();
				if($zcrmProfile->getId()==null || $zcrmProfile->getName()==null) 
				{
					throw new ZCRMException("Invalid Profile Data Received (Either ID or Name is NULL)");
				}
				else if(sizeof($zcrmProfile->getPermissionList())>0)
				{
					$permissionArr=$zcrmProfile->getPermissionList();
					foreach ($permissionArr as $permissionIns)
					{
						if($permissionIns->getId()==null || $permissionIns->getName()==null)
						{
							throw new ZCRMException("Invalid Profile Data Received (Either Profile Permission ID or Permission Name is NULL)");
						}
					}
				}
				else if(sizeof($zcrmProfile->getSectionsList())>0)
				{
					$sectionsArr=$zcrmProfile->getSectionsList();
					foreach ($sectionsArr as $sectionIns)
					{
						if($sectionIns->getName()==null)
						{
							throw new ZCRMException("Invalid Profile Data Received (Permission Name is not fetched)");
						}
						else if(sizeof($sectionIns->getCategories())>0)
						{
							$categories=$sectionIns->getCategories();
							foreach ($categories as $categoryIns)
							{
								if($categoryIns->getName()==null || $categoryIns->getDisplayLabel()==null || $categoryIns->getPermissionIds()==null)
								{
									throw new ZCRMException("Invalid Profile Data Received (Profile Section Category Details not fetched properly)");
								}
							}
						}
					}
				}
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getProfile('.$profileId.')',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getProfile('.$profileId.')',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testGetAllUsers()
	{
		try{
			Main::incrementTotalCount();
			$startTime=microtime(true)*1000;
			$endTime=0;
			$orgIns=ZCRMOrganization::getInstance();
			$responseInstance=$orgIns->getAllUsers();
			$zcrmUsers=$responseInstance->getData();
			$endTime=microtime(true)*1000;
			if($zcrmUsers==null || sizeof($zcrmUsers)<=0)
			{
				throw new ZCRMException("No user Received");
			}
			foreach ($zcrmUsers as $zcrmUser)
			{
				if($zcrmUser->getEmail()==null || $zcrmUser->getId()==null || $zcrmUser->getLastName()==null || $zcrmUser->getRole()==null || $zcrmUser->getProfile()==null ||  $zcrmUser->getLanguage()==null|| $zcrmUser->getLocale()==null || $zcrmUser->getDateFormat()==null|| $zcrmUser->getTimeFormat()==null|| $zcrmUser->getStatus()==null)
				{
					throw new ZCRMException("Invalid User Data Received");
				}
				$userDetails=array();
				$userDetails['id']=$zcrmUser->getId();
				$userDetails['role']=$zcrmUser->getRole();
				$userDetails['time_zone']=$zcrmUser->getTimeZone();
				$userDetails['zuid']=$zcrmUser->getZuid();
				$userDetails['date_format']=$zcrmUser->getDateFormat();
				$userDetails['status']=$zcrmUser->getStatus();
				$userDetails['profile']=$zcrmUser->getProfile();
				$userDetails['id']=$zcrmUser->getId();
				$userDetails['confirm']=$zcrmUser->isConfirm();
				
				self::$userEmailVsDetails[$zcrmUser->getEmail()]=$userDetails;
				array_push(self::$userIdList,$zcrmUser->getId());
			}
			
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getAllUsers',null,null,'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getAllUsers',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
		}
	}
	
	public function testGetUser()
	{
		if(sizeof(self::$userIdList)<=0)
		{
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getUser','Invalid Response','User List is null or empty','failure',0);
			return;
		}
		$orgIns=ZCRMOrganization::getInstance();
		foreach (self::$userIdList as $userId)
		{
			try{
				Main::incrementTotalCount();
				$startTime=microtime(true)*1000;
				$endTime=0;
				$responseInstance=$orgIns->getUser($userId);
				$endTime=microtime(true)*1000;
				$zcrmUser=$responseInstance->getData();
				if($zcrmUser->getEmail()==null || $zcrmUser->getId()==null || $zcrmUser->getLastName()==null || $zcrmUser->getRole()==null || $zcrmUser->getProfile()==null ||  $zcrmUser->getLanguage()==null|| $zcrmUser->getLocale()==null || $zcrmUser->getDateFormat()==null|| $zcrmUser->getTimeFormat()==null|| $zcrmUser->getStatus()==null)
				{
					throw new ZCRMException("Invalid User Data Received (like ID, Email, LastName, Profile, Role,..) is NULL)");
				}
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getUser('.$userId.')',null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','getUser('.$userId.')',$e->getMessage(),$e->getExceptionDetails(),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function testCreateUsers()
	{
		$nameArr=array("automation1");
		$userJSONArray=array();
		$zcrmUser=null;
		foreach ($nameArr as $name)
		{
			$zcrmUser=ZCRMUser::getInstance(null, $name);
			$zcrmUser->setLastName($name);
			$zcrmUser->setEmail("sumanth.chilka+".$name."@zohocorp.com");
			$zcrmUser->setRole(ZCRMRole::getInstance(self::$adminRoleId, null));
			$zcrmUser->setProfile(ZCRMProfile::getInstance(self::$adminProfileId, null));
			array_push($userJSONArray,$zcrmUser);
		}
		$startTime=microtime(true)*1000;
		$endTime=0;
		try{
			Main::incrementTotalCount();
			$orgIns=ZCRMOrganization::getInstance();
			$responseIns=$orgIns->createUser($zcrmUser);
			$endTime=microtime(true)*1000;
			$responseJSON=$responseIns->getResponseJSON()['users'][0];
			if($responseIns->getHttpStatusCode()!=APIConstants::RESPONSECODE_OK || !($responseJSON['code']=='DUPLICATE_DATA'||$responseJSON['code']=='SUCCESS'))
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','createUsers','Invalid Response','Response message is '.$responseIns->getMessage(),'failure',($endTime-$startTime));
				return ;
			}
			$userDetails=$responseJSON['details'];
			$userId=$userDetails['id'];
			$email=$userDetails['email'];
			$responseInstance=$orgIns->getUser($userId);
			$userData=$responseInstance->getData();
			if($responseJSON['code']=='SUCCESS')
			{
				if($userData->getId()==null || $userData->getProfile()->getId()!=$zcrmUser->getProfile()->getId() || $userData->getRole()->getId()!=$zcrmUser->getRole()->getId() || $userData->getLastName()!=$zcrmUser->getLastName() || $userData->getEmail()!=$zcrmUser->getEmail())
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','createUsers','Invalid User details received','User Details mismatched with created user details '.$responseIns->getMessage(),'failure',($endTime-$startTime));
					return;
				}
			}
			else if($responseJSON['code']=='DUPLICATE_DATA')
			{
				if($userData->getId()==null || $userData->getEmail()!=$zcrmUser->getEmail())
				{
					Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','createUsers','Invalid response','Invalid response for duplicate user creation'.$responseIns->getMessage(),'failure',($endTime-$startTime));
					return;
				}
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','createUsers',null,null,'success',($endTime-$startTime));
		}catch (ZCRMException $e)
		{
			$endTime=$endTime==0?microtime(true)*1000:$endTime;
			if("Failed to add user since same email id is already present"==$e->getMessage())
			{
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','createUsers',null,null,'success',($endTime-$startTime));
				return;
			}
			Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization','createUsers',$e->getMessage().",CODE=".$e->getExceptionCode(),$e->getCode().",".json_encode($e->getExceptionDetails()),'failure',($endTime-$startTime));
		}
	}
	
	public function testSpecificUsers()
	{
		$typeArr=array("ActiveUsers","DeactiveUsers","ConfirmedUsers","NotConfirmedUsers","DeletedUsers","ActiveConfirmedUsers","AdminUsers","ActiveConfirmedAdmins","CurrentUser");
		foreach ($typeArr as $type)
		{
			try{
				Main::incrementTotalCount();
				$startTime=microtime(true)*1000;
				$endTime=0;
				$orgIns=ZCRMOrganization::getInstance();
				$methodName=self::$userTypeVsMethod[$type];
				$responseInstance=$orgIns->$methodName();
				$zcrmUsers=$responseInstance->getData();
				$endTime=microtime(true)*1000;
				if($zcrmUsers==null)
				{
					throw new ZCRMException("No user Received");
				}
				foreach ($zcrmUsers as $zcrmUser)
				{
					if($zcrmUser->getEmail()==null || $zcrmUser->getId()==null || $zcrmUser->getLastName()==null || $zcrmUser->getRole()==null || $zcrmUser->getProfile()==null ||  $zcrmUser->getLanguage()==null|| $zcrmUser->getLocale()==null || $zcrmUser->getDateFormat()==null|| $zcrmUser->getTimeFormat()==null|| $zcrmUser->getStatus()==null)
					{
						throw new ZCRMException("Invalid User Data Received");
					}
					self::validateUser($zcrmUser, $type);
				}
			
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization',$methodName,null,null,'success',($endTime-$startTime));
			}catch (ZCRMException $e)
			{
				$endTime=$endTime==0?microtime(true)*1000:$endTime;
				Helper::writeToFile(self::$filePointer,Main::getCurrentCount(),'ZCRMOrganization',$methodName,$e->getMessage().",CODE=".$e->getExceptionCode(),$e->getCode().",".json_encode($e->getExceptionDetails()),'failure',($endTime-$startTime));
			}
		}
	}
	
	public function validateUser($zcrmUser,$type)
	{
		if($type=="ActiveUsers" && $zcrmUser->getStatus()!="active")
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="DeactiveUsers" && $zcrmUser->getStatus()!='disabled')
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="ConfirmedUsers" && !$zcrmUser->isConfirm())
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="NotConfirmedUsers" && $zcrmUser->isConfirm())
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="DeletedUsers" && $zcrmUser->getStatus()!='deleted')
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="ActiveConfirmedUsers" && ($zcrmUser->getStatus()!="active" || !$zcrmUser->isConfirm()))
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="AdminUsers" && $zcrmUser->getProfile()->getId()!=self::$adminProfileId)
		{
			throw new ZCRMException("Invalid User fetched");
		}
		else if($type=="ActiveConfirmedAdmins" && ($zcrmUser->getStatus()!="active" || !$zcrmUser->isConfirm() || $zcrmUser->getProfile()->getId()!=self::$adminProfileId))
		{
			throw new ZCRMException("Invalid User fetched");
		}
	}
}
?>