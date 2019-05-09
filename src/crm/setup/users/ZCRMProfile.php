<?php
namespace zcrmsdk\crm\setup\users;

use zcrmsdk\crm\crud\ZCRMPermission;
use zcrmsdk\crm\crud\ZCRMProfileSection;

class ZCRMProfile
{
    
    /**
     * profile id
     *
     * @var string profile id
     */
    private $id = null;
    
    /**
     * profile name
     *
     * @var string
     */
    private $name = null;
    
    /**
     * default profile
     *
     * @var boolean
     */
    private $default = null;
    
    /**
     * creation time of the profile
     *
     * @var string
     */
    private $createdTime = null;
    
    /**
     * modification time of the profile
     *
     * @var string
     */
    private $modifiedTime = null;
    
    /**
     * modifier of the profile
     *
     * @var ZCRMUser
     */
    private $modifiedBy = null;
    
    /**
     * description of the profile
     *
     * @var string
     */
    private $description = null;
    
    /**
     * creator of the profile
     *
     * @var ZCRMUser
     */
    private $createdBy = null;
    
    /**
     * category
     *
     * @var string
     */
    private $category = null;
    
    /**
     * permission list
     *
     * @var array
     */
    private $permissionList = array();
    
    /**
     * section list
     *
     * @var array
     */
    private $sectionsList = array();
    
    /**
     * constructor to set the profile id and profile name
     *
     * @param string $id the Profile Id
     * @param string $profileName the profile name
     */
    private function __construct($id, $profileName)
    {
        $this->id = $id;
        $this->name = $profileName;
    }
    
    /**
     * method to get the instance of the profile
     *
     * @param string $id the Profile Id
     * @param string $profileName the profile name
     * @return ZCRMProfile instance of the ZCRMProfile class
     */
    public static function getInstance($id, $profileName)
    {
        return new ZCRMProfile($id, $profileName);
    }
    
    /**
     * method to set the Profile Id
     *
     * @param string $id the Profile Id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to Get the Profile Id
     *
     * @return string profile $id the Profile Id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the Profile Name
     *
     * @param string $name Name the Profile Name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to Get Profile Name
     *
     * @return string profile name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to check whether the profile is set as default
     *
     * @return true if the profile is default else false
     */
    public function isDefaultProfile()
    {
        return $this->default;
    }
    
    /**
     * method to set Profile as default profile
     *
     * @param boolean $defaultProfile true to set the profile as default otherwise false
     */
    public function setDefaultProfile($defaultProfile)
    {
        $this->default = $defaultProfile;
    }
    
    /**
     * method to get the creation Time of the profile
     *
     * @return String the creation Time of the profile in iso 8601 format
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }
    
    /**
     * method to set the creation Time of the profile
     *
     * @param String $createdTime the creation Time of the profile in iso 8601 format
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
    
    /**
     * method to get the modification Time of the profile
     *
     * @return String the modification Time of the profile in iso 8601 format
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    
    /**
     * method to Set the modification Time of the profile
     *
     * @param String $modifiedTime the modification Time of the profile in iso 8601 format
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    }
    
    /**
     * method to get the modifier of the profile
     *
     * @return ZCRMUser the modifier of the profile
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * method to Set the modifier of the profile
     *
     * @param ZCRMUser $modifiedBy the modifier of the profile
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
    
    /**
     * method to Get the description of the profile
     *
     * @return String the description of the profile
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * method to Set the description for the profile
     *
     * @param String $description description of the profile
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * method to get the creator of the profile
     *
     * @return ZCRMUser ZCRMUser class instance
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * method to Set the creator of the profile
     *
     * @param ZCRMUser $createdBy ZCRMUser class instance
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * method to Get the category of the profile
     *
     * @return String the category of the profile
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * method to Set the category of the profile
     *
     * @param String $category the category of the profile
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    /**
     * method to get the permission list of the profile
     *
     * @return array array of ZCRMPermission class instances
     */
    public function getPermissionList()
    {
        return $this->permissionList;
    }
    
    /**
     * method to add permission to the permission list
     *
     * @param ZCRMPermission $permissionIns ZCRMPermission class instances
     */
    public function addPermission($permissionIns)
    {
        array_push($this->permissionList, $permissionIns);
    }
    
    /**
     * method to get the section to the profile
     *
     * @return array array of ZCRMProfileSection class instances
     */
    public function getSectionsList()
    {
        return $this->sectionsList;
    }
    
    /**
     * method to add the section to the profile
     *
     * @param ZCRMProfileSection $sectionIns ZCRMProfileSection class instance
     */
    public function addSection($sectionIns)
    {
        array_push($this->sectionsList, $sectionIns);
    }
}