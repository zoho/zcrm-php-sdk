<?php

namespace ZCRM\crud;

use ZCRM\api\handler\RelatedListAPIHandler;

class ZCRMModuleRelation {

    private $label = null;
    private $apiName = null;
    private $id = null;
    private $parentModuleAPIName = null;
    private $visible = null;

    private $parentRecord = null;
    private $junctionRecord;

    private function __construct($parentModuleAPINameOrParentRecord, $relatedListAPINameOrJunctionRecord) {
        if ($parentModuleAPINameOrParentRecord instanceof ZCRMRecord) {
            $this->parentRecord = $parentModuleAPINameOrParentRecord;
        } else {
            $this->parentModuleAPIName = $parentModuleAPINameOrParentRecord;
        }

        if ($relatedListAPINameOrJunctionRecord instanceof ZCRMJunctionRecord) {
            $this->junctionRecord = $relatedListAPINameOrJunctionRecord;
        } else {
            $this->apiName = $relatedListAPINameOrJunctionRecord;
        }
    }

    public static function getInstance($parentModuleAPINameOrParentRecord, $relatedListAPIName) {
        return new ZCRMModuleRelation($parentModuleAPINameOrParentRecord, $relatedListAPIName);
    }

    public function getRecords($sortByField = null, $sortOrder = null, $page = 1, $perPage = 20) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->getRecords($sortByField, $sortOrder, $page, $perPage);
    }

    public function getNotes($sortByField = null, $sortOrder = null, $page = 1, $perPage = 20) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->getNotes($sortByField, $sortOrder, $page, $perPage);
    }

    public function addNote($zcrmNote) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->addNote($zcrmNote);
    }

    public function updateNote($zcrmNote) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->updateNote($zcrmNote);
    }

    public function deleteNote($zcrmNote) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->deleteNote($zcrmNote);
    }

    public function getAttachments($page, $perPage) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->getAttachments($page, $perPage);
    }

    public function uploadAttachment($filePath) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->uploadAttachment($filePath);
    }

    public function uploadLinkAsAttachment($attachmentUrl) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->uploadLinkAsAttachment($attachmentUrl);
    }

    public function downloadAttachment($attachmentId) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->downloadAttachment($attachmentId);
    }

    public function deleteAttachment($attachmentId) {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->deleteAttachment($attachmentId);
    }

    public function addRelation() {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this->junctionRecord)->addRelation();
    }

    public function removeRelation() {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this->junctionRecord)->removeRelation();
    }


    /**
     * label
     * @return String
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * label
     * @param String $label
     */
    public function setLabel($label) {
        $this->label = $label;
    }

    /**
     * apiName
     * @return String
     */
    public function getApiName() {
        return $this->apiName;
    }

    /**
     * apiName
     * @param String $apiName
     */
    public function setApiName($apiName) {
        $this->apiName = $apiName;
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
     * parentModuleAPIName
     * @return String
     */
    public function getParentModuleAPIName() {
        return $this->parentModuleAPIName;
    }

    /**
     * parentModuleAPIName
     * @param String $parentModuleAPIName
     */
    public function setParentModuleAPIName($parentModuleAPIName) {
        $this->parentModuleAPIName = $parentModuleAPIName;
    }

    /**
     * visible
     * @return boolean
     */
    public function getVisible() {
        return (boolean)$this->visible;
    }

    /**
     * visible
     * @param boolean $visible
     */
    public function setVisible($visible) {
        $this->visible = $visible;
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

}

?>