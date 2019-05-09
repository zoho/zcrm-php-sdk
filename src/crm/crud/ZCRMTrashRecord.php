<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\setup\users\ZCRMUser;

class ZCRMTrashRecord
{
    
    /**
     * trash record id
     *
     * @var string
     */
    private $entityId = null;
    
    /**
     * trash record display name
     *
     * @var string
     */
    private $displayName;
    
    /**
     * trash record type
     *
     * @var string
     */
    private $type;
    
    /**
     * trash record delete time
     *
     * @var string
     */
    private $deletedTime;
    
    /**
     * creator of the trash record
     *
     * @var ZCRMUser
     */
    private $createdBy;
    
    /**
     * deletor of the record
     *
     * @var ZCRMUser
     */
    private $deletedBy;
    
    /**
     * constructor to assign the type and id to the trash record
     *
     * @param string $type trash record type
     * @param string $id trash record id
     */
    private function __construct($type, $id)
    {
        $this->type = $type;
        $this->entityId = $id;
    }
    
    /**
     * method to get the instance of the trash record
     *
     * @param string $type trash record type
     * @param string $id trash record id (default is null)
     * @return ZCRMTrashRecord instance of the ZCRMTrashRecord
     */
    public static function getInstance($type, $id = null)
    {
        return new ZCRMTrashRecord($type, $id);
    }
    
    /**
     * method to get the trash record id
     *
     * @return string trash record id
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
    
    /**
     * method to set the trash record id
     *
     * @param string $entityId trash record id
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }
    
    /**
     * method to get the trash record display name
     *
     * @return String trash record display name
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }
    
    /**
     * method to set the trash record display name
     *
     * @param String $displayName trash record display name
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    
    /**
     * method to get the trash record type
     *
     * @return String trash record type
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * method to set the trash record type
     *
     * @param String $type trash record type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * method to get the delete time of the trash record
     *
     * @return string delete time of the trash record
     */
    public function getDeletedTime()
    {
        return $this->deletedTime;
    }
    
    /**
     * method to set the delete time of the trash record
     *
     * @param string $deletedTime delete time of the trash record
     */
    public function setDeletedTime($deletedTime)
    {
        $this->deletedTime = $deletedTime;
    }
    
    /**
     * method to get the creator of the trashed record
     *
     * @return ZCRMUser instance of the ZCRMUser calss
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * method to set the creator of the trashed record
     *
     * @param ZCRMUser $createdBy creator of the trashed record
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * method to get the deletor of the trashed record
     *
     * @return ZCRMUser deletor of the trashed record
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }
    
    /**
     * method to set the deletor of the trashed record
     *
     * @param ZCRMUser $deletedBy deletor of the trashed record
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
}