<?php
namespace zcrmsdk\crm\crud;

class ZCRMPermission
{
    
    /**
     * dsiplay name of the permission
     *
     * @var string
     */
    private $displayLabel;
    
    /**
     * module name of the permission
     *
     * @var string
     */
    private $module;
    
    /**
     * permission id
     *
     * @var string
     */
    private $id;
    
    /**
     * name of the permission
     *
     * @var string
     */
    private $name;
    
    /**
     * permission enabled
     *
     * @var boolean
     */
    private $enabled;
    
    /**
     * constructor to assign permission
     *
     * @param string $name name of the permission
     * @param string $id permission id
     */
    private function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }
    
    /**
     * method to get the instance of the permission
     *
     * @param string $name name of the permission
     * @param string $id permission id
     * @return ZCRMPermission instance of the ZCRMPermission class
     */
    public static function getInstance($name, $id)
    {
        return new ZCRMPermission($name, $id);
    }
    
    /**
     * method to get the display name of the permission
     *
     * @return String display name of the permission
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }
    
    /**
     * method to set the display name of the permission
     *
     * @param String $displayLabel display name of the permission
     */
    public function setDisplayLabel($displayLabel)
    {
        $this->displayLabel = $displayLabel;
    }
    
    /**
     * method to get the name of the module to which permission belongs
     *
     * @return String name of the module to which permission belongs
     */
    public function getModule()
    {
        return $this->module;
    }
    
    /**
     * method to set the name of the module to which permission belongs
     *
     * @param String $module name of the module to which permission belongs
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
    
    /**
     * method to get the permission id
     *
     * @return string the permission id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the permission id
     *
     * @param string $id the permission id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the name of the permission
     *
     * @return String the name of the permission
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the name of the permission
     *
     * @param String $name the name of the permission
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to check whether the permission is enabled
     *
     * @return Boolean true if the permission is enabled otherwise false
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    /**
     * method to enable the permission
     *
     * @param Boolean $enabled true to enable otherwise false
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}