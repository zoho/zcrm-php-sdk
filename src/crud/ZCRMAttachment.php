<?php

namespace ZCRM\crud;

class ZCRMAttachment {
    private $id = null;
    private $fileName = null;
    private $fileType = null;
    private $size = null;
    private $owner = null;
    private $createdBy = null;
    private $createdTime = null;
    private $modifiedBy = null;
    private $modifiedTime = null;

    private $parentRecord = null;
    private $parentModule = null;
    private $attachmentType = null;
    private $parentName = null;
    private $parentId = null;

    private function __construct($parentRecord, $attachmentId) {
        $this->parentRecord = $parentRecord;
        $this->id = $attachmentId;
    }

    public static function getInstance($parentRecord, $attachmentId = null) {
        return new ZCRMAttachment($parentRecord, $attachmentId);
    }

    /**
     * id
     * @return Long
     */
    public function getId() {
        return $this->id;
    }

    /**
     * id
     * @param Long $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * fileName
     * @return String
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * fileName
     * @param String $fileName
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    /**
     * fileType
     * @return String
     */
    public function getFileType() {
        return $this->fileType;
    }

    /**
     * fileType
     * @param String $fileType
     */
    public function setFileType($fileType) {
        $this->fileType = $fileType;
    }

    /**
     * size
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * size
     * @param int $size
     */
    public function setSize($size) {
        $this->size = $size;
    }

    /**
     * parentRecord
     * @return ZCRMRecord
     */
    public function getParentRecord() {
        return $this->parentRecord;
    }

    /**
     * parentRecord
     * @param ZCRMRecord $parentRecord
     */
    public function setParentRecord($parentRecord) {
        $this->parentRecord = $parentRecord;
    }

    /**
     * owner
     * @return ZCRMUser
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * owner
     * @param ZCRMUser $owner
     */
    public function setOwner($owner) {
        $this->owner = $owner;
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
     * createdTime
     * @return DateTime  String
     */
    public function getCreatedTime() {
        return $this->createdTime;
    }

    /**
     * createdTime
     * @param DateTime  String $createdTime
     */
    public function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }

    /**
     * modifiedBy
     * @return ZCRMUser
     */
    public function getModifiedBy() {
        return $this->modifiedBy;
    }

    /**
     * modifiedBy
     * @param ZCRMUser $modifiedBy
     */
    public function setModifiedBy($modifiedBy) {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * modifiedTime
     * @return DateTime  String
     */
    public function getModifiedTime() {
        return $this->modifiedTime;
    }

    /**
     * modifiedTime
     * @param DateTime  String $modifiedTime
     */
    public function setModifiedTime($modifiedTime) {
        $this->modifiedTime = $modifiedTime;
    }


    /**
     * parentModule
     * @return String
     */
    public function getParentModule() {
        return $this->parentModule;
    }

    /**
     * parentModule
     * @param String $parentModule
     */
    public function setParentModule($parentModule) {
        $this->parentModule = $parentModule;
    }


    /**
     * attachmentType
     * @return String
     */
    public function getAttachmentType() {
        return $this->attachmentType;
    }

    /**
     * attachmentType
     * @param String $attachmentType
     */
    public function setAttachmentType($attachmentType) {
        $this->attachmentType = $attachmentType;
    }

    /**
     * parentName
     * @return String
     */
    public function getParentName() {
        return $this->parentName;
    }

    /**
     * parentName
     * @param String $parentName
     */
    public function setParentName($parentName) {
        $this->parentName = $parentName;
    }

    /**
     * parentId
     * @return Long
     */
    public function getParentId() {
        return $this->parentId;
    }

    /**
     * parentId
     * @param Long $parentId
     */
    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }

    public function downloadFile() {
        return ZCRMModuleRelation::getInstance($this->parentRecord, "Attachments")->downloadAttachment($this->id);
    }

}

?>