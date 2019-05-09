<?php
namespace zcrmsdk\crm\setup\users;

class ZCRMRole
{
    
    /**
     * role name
     *
     * @var string
     */
    private $name = null;
    
    /**
     * role id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * reporting to user
     *
     * @var ZCRMUser
     */
    private $reportingTo = null;
    
    /**
     * label name
     *
     * @var string
     */
    private $label = null;
    
    /**
     * admin role
     *
     * @var boolean
     */
    private $isAdmin = null;
    
    /**
     * constructor to assign the role id and role name
     *
     * @param string $roleId the role id
     * @param string $roleName the role name
     */
    private function __construct($roleId, $roleName)
    {
        $this->id = $roleId;
        $this->name = $roleName;
    }
    
    /**
     * method to get the instance of the role
     *
     * @param string $roleId role id
     * @param string $roleName role name
     * @return ZCRMRole instance of the ZCRMRole class
     */
    public static function getInstance($roleId, $roleName)
    {
        return new ZCRMRole($roleId, $roleName);
    }
    
    /**
     * metho to get the Name of the Role
     *
     * @return String Role name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the Role name
     *
     * @param String $name the Role name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the Id of the Role
     *
     * @return string Id of the Role
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to Set the Id of the Role
     *
     * @param string $id Id of the Role
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the Reporting to role
     *
     * @return ZCRMUser instance of ZCRMUser class
     */
    public function getReportingTo()
    {
        return $this->reportingTo;
    }
    
    /**
     * methdo to Set the Reporting to role
     *
     * @param ZCRMUser $reportingTo instance of ZCRMUser class
     */
    public function setReportingTo($reportingTo)
    {
        $this->reportingTo = $reportingTo;
    }
    
    /**
     * method to get the Role label
     *
     * @return String the Role label
     */
    public function getDisplayLabel()
    {
        return $this->label;
    }
    
    /**
     * method to Set the Role label
     *
     * @param String $label the Role label
     */
    public function setDisplayLabel($label)
    {
        $this->label = $label;
    }
    
    /**
     * method to check whether the role is Admin role or not
     *
     * @return boolean true if the admin role otherwise false
     */
    public function isAdminRole()
    {
        return $this->isAdmin;
    }
    
    /**
     * method to Set the role as Admin role
     *
     * @param boolean $isAdmin true to set as admin role otherwise false
     */
    public function setAdminRole($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}