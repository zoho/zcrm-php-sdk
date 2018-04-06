<?php

namespace ZCRM\crud;

class ZCRMTrashRecord {
    private $entityId = null;
    private $displayName;
    private $type;
    private $deletedTime;
    private $createdBy;
    private $deletedBy;

    private function __construct($type, $id) {
        $this->type = $type;
        $this->entityId = $id;
    }

    public static function getInstance($type, $id = null) {
        return new ZCRMTrashRecord($type, $id);
    }

    /**
     * entityId
     * @return Long
     */
    public function getEntityId() {
        return $this->entityId;
    }

    /**
     * entityId
     * @param Long $entityId
     */
    public function setEntityId($entityId) {
        $this->entityId = $entityId;
    }

    /**
     * displayName
     * @return String
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * displayName
     * @param String $displayName
     */
    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * type
     * @return String
     */
    public function getType() {
        return $this->type;
    }

    /**
     * type
     * @param String $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * deletedTime
     * @return DATETIME
     */
    public function getDeletedTime() {
        return $this->deletedTime;
    }

    /**
     * deletedTime
     * @param DATETIME $deletedTime
     */
    public function setDeletedTime($deletedTime) {
        $this->deletedTime = $deletedTime;
    }

    /**
     * createdBy
     * @return ZCRMUser
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * createdBy
     * @param ZCRMUser $createdBy
     */
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    /**
     * deletedBy
     * @return ZCRMUser
     */
    public function getDeletedBy() {
        return $this->deletedBy;
    }

    /**
     * deletedBy
     * @param ZCRMUser $deletedBy
     */
    public function setDeletedBy($deletedBy) {
        $this->deletedBy = $deletedBy;
    }

}

?>