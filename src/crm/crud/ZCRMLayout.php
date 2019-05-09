<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\setup\users\ZCRMUser;

class ZCRMLayout
{
    
    /**
     * layout id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * layout name
     *
     * @var string
     */
    private $name = null;
    
    /**
     * creation time of layout
     *
     * @var string iso 8601 format
     */
    private $createdTime = null;
    
    /**
     * modification time of layout
     *
     * @var string iso 8601 format
     */
    private $modifiedTime = null;
    
    /**
     * visibility of the layout
     *
     * @var boolean
     */
    private $visible = null;
    
    /**
     * user who modified the layout
     *
     * @var ZCRMUser instance of ZCRMUser class
     */
    private $modifiedBy = null;
    
    /**
     * accessible profiles
     *
     * @var array array of ZCRMProfile class instances
     */
    private $accessibleProfiles = null;
    
    /**
     * user who created the layout
     *
     * @var ZCRMUser instance of ZCRMUser class
     */
    private $createdBy = null;
    
    /**
     * sections of the layout
     *
     * @var array array of ZCRMSection class instances
     */
    private $sections = null;
    
    /**
     * status of the layout
     *
     * @var int
     */
    private $status = null;
    
    /**
     * convert mapping
     *
     * @var array array of ZCRMLeadConvertMapping class instances
     */
    private $convertMapping = array();
    
    /**
     * construtor to set the layout id
     *
     * @param string $id layout id
     */
    private function __construct($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the layout instance
     *
     * @param string $id layout id
     * @return ZCRMLayout instance of ZCRMLayout class
     */
    public static function getInstance($id)
    {
        return new ZCRMLayout($id);
    }
    
    /**
     * method to set the layout id
     *
     * @param string $id layout id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the layout id
     *
     * @return string layout id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the layout name
     *
     * @param string $name layout name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the layout name
     *
     * @return string layout name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the creation time of the layout
     *
     * @param string $createdTime creation time of the layout in iso 8601 format
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
    
    /**
     * method to get the creation time of the layout
     *
     * @return string creation time of the layout in iso 8601 format
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }
    
    /**
     * method to set the modification time of the layout
     *
     * @param string $modifiedTime modification time of the layout in iso 8601 format
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    }
    
    /**
     * method to get the modification time of the layout
     *
     * @return string modification time of the layout in iso 8601 format
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    
    /**
     * method to set the visibility of the layout
     *
     * @param boolean $visible true to set layout as visible otherwise false
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }
    
    /**
     * method to check whether the layout is visible
     *
     * @return boolean true if layout is visible otherwise false
     */
    public function isVisible()
    {
        return $this->visible;
    }
    
    /**
     * Method to set the user who modified the layout
     *
     * @param ZCRMUser $modifiedBy user who modified the layout
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
    
    /**
     * Method to get the user who modified the layout
     *
     * @return ZCRMUser user who modified the layout
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * Method to set the creator of that record
     *
     * @param ZCRMUser $createdBy user who created the layout
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Method to get the creator of that record
     *
     * @return ZCRMUser user who created the layout
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * method to set the profiles that can access the layout
     *
     * @param array $profiles array of instances of ZCRMProfile class
     */
    public function setAccessibleProfiles($profiles)
    {
        $this->accessibleProfiles = $profiles;
    }
    
    /**
     * method to get the profiles that can access the layout
     *
     * @return array array of instances of ZCRMProfile class
     */
    public function getAccessibleProfiles()
    {
        return $this->accessibleProfiles;
    }
    
    /**
     * method to set the operational status of the record
     *
     * @param int $status 1 to make the layout active otherwise -1
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * method to get the operational status of the record
     *
     * @return int 1 if the layout is active -1 otherwise
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * method to set the sections of the layout
     *
     * @param array $sections array of ZCRMSection instances
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }
    
    /**
     * method to get the sections of the instances
     *
     * @return array array of ZCRMSection class instances
     */
    public function getSections()
    {
        return $this->sections;
    }
    
    /**
     * method to get the convert mappings of the layout
     *
     * @return array array of ZCRMLeadConvertMapping instances
     */
    public function getConvertMapping()
    {
        return $this->convertMapping;
    }
    
    /**
     * method to set the convert mappings of the layout
     *
     * @param string $module api name of the module
     * @param ZCRMLeadConvertMapping $convertMap instance of the ZCRMLeadConvertMapping class
     */
    public function addConvertMapping($module, $convertMap)
    {
        $this->convertMapping[$module] = $convertMap;
    }
}
