<?php

class ZCRMProfile
{
	private $id=null;
	private $name=null;
	private $default=null;
	private $createdTime=null;
	private $modifiedTime=null;
	private $modifiedBy=null;
	private $description=null;
	private $createdBy=null;
	private $category=null;
	private $permissionList=array();
	private $sectionsList=array();
	
	private function __construct($id,$profileName)
	{
		$this->id=$id;
		$this->name=$profileName;
	}
	
	public static function getInstance($id,$profileName)
	{
		return new ZCRMProfile($id,$profileName);
	}
	/**
	 * set Profile Id
	 * @param profile $id
	 */
	public function setId($id)
	{
		$this->id=$id;
	}
	/**
	 * Get Profile Id
	 * @return profile $id
	 */
	public function getId()
	{
		return $this->id;
	}
	/**
	 * set Profile Name
	 * @param profile Name
	 */
	public function setName($name)
	{
		$this->name=$name;
	}
	/**
	 * Get Profile Name
	 * @return profile name
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * get to know whether Profile is default profile or not
	 */
	public function isDefaultProfile()
	{
		return $this->default;
	}
	/**
	 * set Profile as default profile
	 * @param boolean
	 */
	public function setDefaultProfile($defaultProfile)
	{
		$this->default=$defaultProfile;
	}
	

    /**
     * Get the createdTime of the profile
     * @return String
     */
    public function getCreatedTime(){
        return $this->createdTime;
    }

    /**
     * Set the createdTime of the profile
     * @param String $createdTime
     */
    public function setCreatedTime($createdTime){
        $this->createdTime = $createdTime;
    }

    /**
     * Get the modifiedTime of the profile
     * @return String
     */
    public function getModifiedTime(){
        return $this->modifiedTime;
    }

    /**
     * Set the modifiedTime of the profile
     * @param String $modifiedTime
     */
    public function setModifiedTime($modifiedTime){
        $this->modifiedTime = $modifiedTime;
    }

    /**
     * Get the modifiedBy of the profile
     * @return ZCRMUser
     */
    public function getModifiedBy(){
        return $this->modifiedBy;
    }

    /**
     * Set the modifiedBy of the profile
     * @param ZCRMUser $modifiedBy
     */
    public function setModifiedBy($modifiedBy){
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * Get the description of the profile
     * @return String
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * Set the description for the profile
     * @param String $description
     */
    public function setDescription($description){
        $this->description = $description;
    }

    /**
     * Get the createdBy of the profile
     * @return ZCRMUser
     */
    public function getCreatedBy(){
        return $this->createdBy;
    }

    /**
     * Set the createdBy of the profile
     * @param ZCRMUser $createdBy
     */
    public function setCreatedBy($createdBy){
        $this->createdBy = $createdBy;
    }

    /**
     * Get the category of the profile
     * @return String
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * Set the category of the profile
     * @param String $category
     */
    public function setCategory($category){
        $this->category = $category;
    }


    /**
     * permissionList
     * @return array of ZCRMPermission instances
     */
    public function getPermissionList(){
        return $this->permissionList;
    }

    /**
     * permissionList
     * @param array $permissionList
     */
    public function addPermission($permissionIns){
        array_push($this->permissionList,$permissionIns);
    }
    
    /**
     * sectionList
     * @return array of ZCRMProfileSection instances
     */
    public function getSectionsList(){
    	return $this->sectionsList;
    }
    
    /**
     * sectionList
     * @param array $sectionList
     */
    public function addSection($sectionIns){
    	array_push($this->sectionsList,$sectionIns);
    }

}
?>