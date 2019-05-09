<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\api\handler\RelatedListAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\api\response\BulkAPIResponse;
use zcrmsdk\crm\api\response\FileAPIResponse;

class ZCRMModuleRelation
{
    
    /**
     * display label of the module relation
     *
     * @var string
     */
    private $label = null;
    
    /**
     * api name of the module relation
     *
     * @var string
     */
    private $apiName = null;
    
    /**
     * id of the module relation
     *
     * @var string
     */
    private $id = null;
    
    /**
     * module api name of the parent module
     *
     * @var string
     */
    private $parentModuleAPIName = null;
    
    /**
     * visibility of the module relation
     *
     * @var boolean
     */
    private $visible = null;
    
    /**
     * the instance of the record to which the relation belongs
     *
     * @var ZCRMRecord
     */
    private $parentRecord = null;
    
    /**
     * the instance of the junction record
     *
     * @var ZCRMJunctionRecord
     */
    private $junctionRecord;
    
    /**
     * constructor to assign the parent module api name or the instance of the parent record and the related list api name or the instance of the junction record
     *
     * @param string $parentModuleAPIName module api name of the module
     * @param ZCRMRecord $ParentRecord instance of the ZCRMRecord class
     * @param string $relatedListAPIName related list api name
     * @param ZCRMJunctionRecord instance of the JunctionRecord class
     */
    private function __construct($parentModuleAPINameOrParentRecord, $relatedListAPINameOrJunctionRecord)
    {
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
    
    /**
     * method to get the instance of the module relation
     *
     * @param string $parentModuleAPIName module api name of the module
     * @param ZCRMRecord $ParentRecord instance of the ZCRMRecord class
     * @param string $relatedListAPIName related list api name
     * @return ZCRMModuleRelation instance of the ZCRMModuleRelation
     */
    public static function getInstance($parentModuleAPINameOrParentRecord, $relatedListAPIName)
    {
        return new ZCRMModuleRelation($parentModuleAPINameOrParentRecord, $relatedListAPIName);
    }
    
    /**
     * method to get the module relation records
     *
     * @param string $sortByField api name of the field to be sorted (no sorting by default)
     * @param string $sortOrder order of the sort "asc" for ascending , "desc" for descending order (no sorting by default)
     * @param int $page To get the list of records from the respective pages. Default value for page is 1.
     * @param int $perPage To get the list of records available per page. Default value for per page is 20
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getRecords($sortByField = null, $sortOrder = null, $page = 1, $perPage = 20)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->getRecords($sortByField, $sortOrder, $page, $perPage);
    }
    
    /**
     * method to get the module relation notes
     *
     * @param string $sortByField api name of the field to be sorted (no sorting by default)
     * @param string $sortOrder order of the sort "asc" for ascending , "desc" for descending order (no sorting by default)
     * @param int $page To get the list of notes from the respective pages. Default value for page is 1.
     * @param int $perPage To get the list of notes available per page. Default value for per page is 20
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getNotes($sortByField = null, $sortOrder = null, $page = 1, $perPage = 20)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->getNotes($sortByField, $sortOrder, $page, $perPage);
    }
    
    /**
     * method to add the note to the module relation
     *
     * @param ZCRMNote $zcrmNote instance of the ZCRMNote
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function addNote($zcrmNote)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->addNote($zcrmNote);
    }
    
    /**
     * method to update the note of the module relation
     *
     * @param ZCRMNote $zcrmNote instance of the ZCRMNote
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function updateNote($zcrmNote)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->updateNote($zcrmNote);
    }
    
    /**
     * method to delete the note of the module relation
     *
     * @param ZCRMNote $zcrmNote instance of the ZCRMNote
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function deleteNote($zcrmNote)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->deleteNote($zcrmNote);
    }
    
    /**
     * method to get the module relation attachments
     *
     * @param int $page To get the list of attachments from the respective pages
     * @param int $perPage To get the list of attachments available per page.
     * @return BulkAPIResponse instance of the BulkAPIResponse class containing the bulk api response
     */
    public function getAttachments($page, $perPage)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->getAttachments($page, $perPage);
    }
    
    /**
     * method to upload the attachment by file path of the module relation
     *
     * @param string $filePath filepath of the attachment
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function uploadAttachment($filePath)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->uploadAttachment($filePath);
    }
    
    /**
     * method to upload the attachment by url of the module relation
     *
     * @param string $attachmentUrl attachment url of the attachment
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function uploadLinkAsAttachment($attachmentUrl)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->uploadLinkAsAttachment($attachmentUrl);
    }
    
    /**
     * method to download the attachment of the module relation
     *
     * @param string $attachmentId attachment id of the attachment
     * @return FileAPIResponse instance of the FileAPIResponse class containing the file api response
     */
    public function downloadAttachment($attachmentId)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->downloadAttachment($attachmentId);
    }
    
    /**
     * method to delete the attachment of the module relation
     *
     * @param string $attachmentId attachment id of the attachment
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function deleteAttachment($attachmentId)
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this)->deleteAttachment($attachmentId);
    }
    
    /**
     * method to add the module relation
     *
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function addRelation()
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this->junctionRecord)->addRelation();
    }
    
    /**
     * method to delete the module relation
     *
     * @return APIResponse instance of the APIResponse class containing the api response
     */
    public function removeRelation()
    {
        return RelatedListAPIHandler::getInstance($this->parentRecord, $this->junctionRecord)->removeRelation();
    }
    
    /**
     * method to get the display name label of the module relation
     *
     * @return String the display name label of the module relation
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * method to set the display name label of the module relation
     *
     * @param String $label display name label of the module relation
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    /**
     * method to get the api name of the module relation
     *
     * @return String api name of the module relation
     */
    public function getApiName()
    {
        return $this->apiName;
    }
    
    /**
     * method to set the api name of the module relation
     *
     * @param String $apiName api name of the module relation
     */
    public function setApiName($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * method to get the id of the module relation
     *
     * @return string id of the module relation
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the id of the module relation
     *
     * @param string $id id of the module relation
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the parent Module API Name of the module relation
     *
     * @return String the parent Module API Name of the module relation
     */
    public function getParentModuleAPIName()
    {
        return $this->parentModuleAPIName;
    }
    
    /**
     * method to set the parent Module API Name of the module relation
     *
     * @param String $parentModuleAPIName the parent Module API Name of the module relation
     */
    public function setParentModuleAPIName($parentModuleAPIName)
    {
        $this->parentModuleAPIName = $parentModuleAPIName;
    }
    
    /**
     * method to check whether the module relation is visible
     *
     * @return boolean true if visible otherwise false
     */
    public function getVisible()
    {
        return (boolean) $this->visible;
    }
    
    /**
     * method to set the visibility of the module relation is visible
     *
     * @param boolean $visible true to set the module relation visible otherwise false
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }
    
    /**
     * method to get the record to which the module relation belongs
     *
     * @return ZCRMRecord instance of the ZCRMRecord class
     */
    public function getParentRecord()
    {
        return $this->parentRecord;
    }
    
    /**
     * method to set the record to which the module relation belongs
     *
     * @param ZCRMRecord $parentRecord instance of the ZCRMRecord class
     */
    public function setParentRecord($parentRecord)
    {
        $this->parentRecord = $parentRecord;
    }
}