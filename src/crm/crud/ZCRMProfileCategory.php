<?php
namespace zcrmsdk\crm\crud;

class ZCRMProfileCategory
{
    
    /**
     * the name of the profile
     *
     * @var string
     */
    private $name;
    
    /**
     * module name
     *
     * @var string
     */
    private $module;
    
    /**
     * display name of the profile
     *
     * @var string
     */
    private $displayLabel;
    
    /**
     * permission id of the permission enabled
     *
     * @var array
     */
    private $permissionIds = array();
    
    /**
     * constructor to assign name to the profile
     *
     * @param string $name name to assign
     */
    private function __construct($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the instance of the profile
     *
     * @param string $name name of the profile
     * @return ZCRMProfileCategory instance of the ZCRMProfileCategory class
     */
    public static function getInstance($name)
    {
        return new ZCRMProfileCategory($name);
    }
    
    /**
     * method to get the name of the profile
     *
     * @return string the name of the profile
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the name of the profile
     *
     * @param string $name the name of the profile
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the module name to which the profile belongs
     *
     * @return string module name to which the profile belongs
     */
    public function getModule()
    {
        return $this->module;
    }
    
    /**
     * method to set the module name to which the profile belongs
     *
     * @param string $module module name to which the profile belongs
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
    
    /**
     * method to get the display name of the profile
     *
     * @return string display name of the profile
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }
    
    /**
     * method to set the display name of the profile
     *
     * @param string $displayLabel display name of the profile
     */
    public function setDisplayLabel($displayLabel)
    {
        $this->displayLabel = $displayLabel;
    }
    
    /**
     * method to get the permission Ids of the permission applied to the profile
     *
     * @return array array of the the permission Ids of the permission applied to the profile
     */
    public function getPermissionIds()
    {
        return $this->permissionIds;
    }
    
    /**
     * method to set the permission Ids of the permission applied to the profile
     *
     * @param array $permissionIds array of the the permission Ids of the permission applied to the profile
     */
    public function setPermissionIds($permissionIds)
    {
        $this->permissionIds = $permissionIds;
    }
}