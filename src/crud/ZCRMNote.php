<?php

namespace ZCRM\crud;

use ZCRM\users\ZCRMUser;

class ZCRMNote {
    private $id = null;
    private $title = null;
    private $content = null;

    private $parentRecord = null;
    private $owner = null;
    private $createdBy = null;
    private $createdTime = null;
    private $modifiedBy = null;
    private $modifiedTime = null;
    private $attachments = null;
    private $size = null;
    private $voiceNote = null;
    private $parentModule = null;
    private $parentName = null;
    private $parentId = null;

    private function __construct($parentRecord, $noteId) {
        $this->parentRecord = $parentRecord;
        $this->id = $noteId;
    }

    public static function getInstance($parentRecord, $noteId = null) {
        return new ZCRMNote($parentRecord, $noteId);
    }

    /**
     * id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * id
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * title
     * @return String
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * title
     * @param String $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * content
     * @return String
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * content
     * @param String $content
     */
    public function setContent($content) {
        $this->content = $content;
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
     * @return DateTime String
     */
    public function getCreatedTime() {
        return $this->createdTime;
    }

    /**
     * createdTime
     * @param DateTime String $createdTime
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
     * @return DateTime String
     */
    public function getModifiedTime() {
        return $this->modifiedTime;
    }

    /**
     * modifiedTime
     * @param DateTime String $modifiedTime
     */
    public function setModifiedTime($modifiedTime) {
        $this->modifiedTime = $modifiedTime;
    }


    /**
     * attachments
     * @return array of ZCRMAttachment instance
     */
    public function getAttachments() {
        return $this->attachments;
    }

    /**
     * attachments
     * @param array of ZCRMAttachment instances $attachments
     */
    public function setAttachments($attachments) {
        $this->attachments = $attachments;
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
     * voiceNote
     * @return boolean
     */
    public function isVoiceNote() {
        return $this->voiceNote;
    }

    /**
     * voiceNote
     * @param boolean $voiceNote
     */
    public function setVoiceNote($voiceNote) {
        $this->voiceNote = $voiceNote;
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
     * @return int
     */
    public function getParentId() {
        return $this->parentId;
    }

    /**
     * parentId
     * @param int $parentId
     */
    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }

}

?>
