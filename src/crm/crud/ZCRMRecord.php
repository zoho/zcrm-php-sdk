<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\api\handler\EntityAPIHandler;
use zcrmsdk\crm\api\handler\TagAPIHandler;
use zcrmsdk\crm\api\response\APIResponse;
use zcrmsdk\crm\api\response\BulkAPIResponse;
use zcrmsdk\crm\api\response\FileAPIResponse;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

/**
 * Provides methods for basic CRUD operations of the record.
 *
 * @author sumanth-3058
 *
 */
class ZCRMRecord
{
    
    /**
     * the record id
     *
     * @var string
     */
    private $entityId = null;
    
    /**
     * api name of the module
     *
     * @var String
     */
    private $moduleApiName = null;
    
    /**
     * the inventory item list
     *
     * @var array
     */
    private $lineItems = array();
    
    /**
     * the lookup label
     *
     * @var String
     */
    private $lookupLabel = null;
    
    /**
     * the owner of the record
     *
     * @var ZCRMUser
     */
    private $owner = null;
    
    /**
     * the user who created the record
     *
     * @var ZCRMUser
     */
    private $createdBy = null;
    
    /**
     * the user who modified the record
     *
     * @var ZCRMUser
     */
    private $modifiedBy = null;
    
    /**
     * creation time of the record
     *
     * @var String
     */
    private $createdTime = null;
    
    /**
     * modification time of the record
     *
     * @var String
     */
    private $modifiedTime = null;
    
    /**
     * the record data
     *
     * @var array
     */
    private $fieldNameVsValue = array();
    
    /**
     * properties of the record
     *
     * @var array
     */
    private $properties = array();
    
    /**
     * participants in the record
     *
     * @var array
     */
    private $participants = array();
    
    /**
     * price detail of the product
     *
     * @var array
     */
    private $priceDetails = array();
    
    /**
     * layout of the record
     *
     * @var String
     */
    private $layout = null;
    
    /**
     * the list of tax
     *
     * @var array ZCRMTax class instances array
     */
    private $taxList = array();
    
    /**
     * the time of the last activity done on the record
     *
     * @var String
     */
    private $lastActivityTime = null;
    
    /**
     * list of all the tags
     *
     * @var array
     */
    private $tags = array();
    
    /**
     * list of all the tag names
     * @var array
     */
    private $tagnames = array();

    /**
     * bulk write status of the record
     * @var String
     */
    private $status = null;
    
    /**
     * bulk write error message of the record
     * @var String
     */
    private $error = null;
    
    /**
     * csv record row number
     * @var integer
     */
    private $rowNumber;
    
    /**
     * constructor to set the module name and record id
     *
     * @param String $module
     * @param string $entityId
     */
    private function __construct($module, $entityId)
    {
        $this->moduleApiName = $module;
        $this->entityId = $entityId;
    }
       
    /**
     * Method to get the instance of the ZCRMRecord class
     *
     * @param String $module api name of the module
     * @param string $entityId the record id
     * @return ZCRMRecord-instance
     */
    public static function getInstance($module, $entityId)
    {
        return new ZCRMRecord($module, $entityId);
    }
    
    /**
     * Method inserts the tax associated to the record
     *
     * @param ZCRMTax $taxIns the tax instance
     */
    public function addTax($taxIns)
    {
        array_push($this->taxList, $taxIns);
    }
    
    /**
     * Method to get the tax associated to the record
     *
     * @return array array of ZCRMTax tax instances
     */
    public function getTaxList()
    {
        return $this->taxList;
    }
    
    /**
     * Method to get the record id
     *
     * @return string record id
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
    
    /**
     * Method to set the record id
     *
     * @param string $entityId record id
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }
    
    /**
     * Method to get the module api name of that record
     *
     * @return String api name of the module
     */
    public function getModuleApiName()
    {
        return $this->moduleApiName;
    }
    
    /**
     * Method to set the module api name of the record
     *
     * @param String $moduleApiName module api name of the record
     */
    public function setModuleApiName($moduleApiName)
    {
        $this->moduleApiName = $moduleApiName;
    }
    
    /**
     * Method to get the field value by api name of the field of the record
     *
     * @param String $apiName field api name
     * @return String the field value of that field api name
     */
    public function getFieldValue($apiName)
    {
        return $this->fieldNameVsValue[$apiName];
    }
    
    /**
     * Method to set the field value by api name of the field of the record
     *
     * @param String $apiName api name of the field
     * @param String $value value of the field (the value must be of the same datatype of the field. Ex. "val1", 10, 200.56, true)
     */
    public function setFieldValue($apiName, $value)
    {
        $this->fieldNameVsValue[$apiName] = $value;
    }
    
    /**
     * Method to get an array(key-value pair) containing field name as key and field data as value for the record
     *
     * @return array key-value pair of field name and field value
     */
    public function getData()
    {
        return $this->fieldNameVsValue;
    }
    
    /**
     * Method to get the line items of the inventory record
     *
     * @return Array containing the ZCRMInventoryLineItem
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }
    
    /**
     * Method adds the line item to the inventory record
     *
     * @param ZCRMInventoryLineItem $lineItem line item to add
     */
    public function addLineItem($lineItem)
    {
        array_push($this->lineItems, $lineItem);
    }
    /**
     * Method update the line item of the inventory record
     *
     * @param ZCRMInventoryLineItem $updatedlineItem updated line item
     */
    public function updateLineItem($updatedlineItem)
    {
        if($updatedlineItem->getId()==NULL)throw new ZCRMException("Line item id missing");
        self::removeLineItem($updatedlineItem->getId());
        array_push($this->lineItems, $updatedlineItem);
    }
    
    /**
     * Method removes the line item from the inventory record
     *
     * @param string $lineItemId line item id to remove
     */
    public function removeLineItem($lineItemId)
    {
        $lineitemexistence=0;
        foreach ($this->lineItems as $key => $lineItem) {
            if ($lineItemId == $lineItem->getId()) {
                $lineitemexistence=1;
                unset($this->lineItems[$key]);
                break;
            }
        }
        if($lineitemexistence==0){
            throw new ZCRMException("Line item with such id doesn't exist");
        }
    }
    
    /**
     * Method to add Line item to existing record
     *
     * @param ZCRMInventoryLineItem $lineitem the line item object
     */
    public function addLineItemtoExistingRecord($lineItem)
    {
        $recordinstance = EntityAPIHandler::getInstance($this)->getRecord()->getData(); // returns ZCRMRecord object
        $recordinstance->addLineItem($lineItem);
        return $recordinstance->update();
    }
    
    /**
     * Method to update Line item from the existing record
     *
     * @param ZCRMInventoryLineItem $updatedlineItem updated line item
     */
    public function updateLineItemofTheExistingRecord($updatedlineItem)
    {
        $recordinstance = EntityAPIHandler::getInstance($this)->getRecord()->getData(); // returns ZCRMRecord object
        $recordinstance->updateLineItem($updatedlineItem);
        return $recordinstance->update();
    }
    /**
     * Method to update Line item from the existing record
     *
     * @param string $lineItemId the line item id
     * @oaram
     */
    public function deleteLineItemFromTheExistingRecord($lineItemId)
    {
        $recordinstance = EntityAPIHandler::getInstance($this)->getRecord()->getData(); // returns ZCRMRecord object
        $recordinstance->removeLineItem($lineItemId);
        return $recordinstance->update();
    }
    
    
    /**
     * Method to get the lookup label of the record
     *
     * @return String -the look up label of the record
     */
    public function getLookupLabel()
    {
        return $this->lookupLabel;
    }
    
    /**
     * Method to set the lookup label for the record
     *
     * @param String $lookupLabel lookup label that you want to set
     */
    public function setLookupLabel($lookupLabel)
    {
        $this->lookupLabel = $lookupLabel;
    }
    
    /**
     * Method to get the owner of the record
     *
     * @return ZCRMUser owner of the record
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    /**
     * Method to set the owner of the record
     *
     * @param ZCRMUser $owner owner of the record
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
    
    /**
     * Method to get the creator of that record
     *
     * @return ZCRMUser user who created the record
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Method to set the creator of that record
     *
     * @param ZCRMUser $createdBy user who created the record
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Method to get the user who modified the record
     *
     * @return ZCRMUser user who modified the record
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * Method to set the user who modified the record
     *
     * @param ZCRMUser $modifiedBy user who modified the record
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
    
    /**
     * Method to get the creation time of the record
     *
     * @return String creation time in ISO 8601 format
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }
    
    /**
     * Method to set the creation time of the record
     *
     * @param String $createdTime creation time in ISO 8601 format
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
    
    /**
     * Method to get the modification time of the record
     *
     * @return String the modification time in ISO 8601 format
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    
    /**
     * Method to set the modification time of the record
     *
     * @param String $modifiedTime modification time in ISO 8601 format
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    }
    
    /**
     * Method to get the tags for the record
     *
     * @return array array of ZCRMTag instances related to the record
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Method to set the tags for the record
     *
     * @param array $tags array of ZCRMTag instances related to the record
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Method to get the tags for the record
     *
     * @return array array of tag name of the record
     */
    public function getTagNames()
    {
        return $this->tagnames;
    }
    
    /**
     * Method to set the tags for the record
     *
     * @param array $tagnames array of tag name of the record
     */
    public function setTagNames($tagnames)
    {
        $this->tagnames = $tagnames;
    }
    
    /**
     * To set create record status
     * @param status of the record
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * To get create record status
     * @return String status of the record
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * To set record error message
     * @param error message of the record
     */
    public function setErrorMessage($error)
    {
        $this->error = $error;
    }
    
    /**
     * To get record error message
     * @return String record error message
     */
    public function getErrorMessage()
    {
        return $this->error;
    }
    
    /**
     * To set record row number
     * @param rowNumber of the record
     */
    public function setRecordRowNumber($rowNumber)
    {
        $this->rowNumber = $rowNumber;
    }
    
    /**
     * To get record row number
     * @return integer record row number
     */
    public function getRecordRowNumber()
    {
        return $this->rowNumber;
    }
    
    /**
     * Method creates record
     ** @param string $trigger array of triggers
     * @param string $lar_id lead assignment rule id
     * @throws ZCRMException if Entity ID of the record is not NULL
     * @return APIResponse instance of the APIResponse class which holds the API response.
     *
     */
    public function create( $trigger = null,$lar_id = null,$process = null)
    {
        if (self::getEntityId() != null) {
            $exception = new ZCRMException("Entity ID MUST be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            $exception->setExceptionCode("ID EXIST");
            throw $exception;
        }
        return EntityAPIHandler::getInstance($this)->createRecord($trigger ,$lar_id,$process);
    }
    
    /**
     * Method to update the records
     ** @param string $trigger array of triggers
     * @param string $lar_id lead assignment rule id
     * @throws ZCRMException if Entity ID of the record is NULL
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function update( $trigger = null,$process = null)
    {
        if (self::getEntityId() == null) {
            $exception = new ZCRMException("Entity ID MUST NOT be null for update operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            $exception->setExceptionCode("ID MISSING");
            throw $exception;
        }
        return EntityAPIHandler::getInstance($this)->updateRecord($trigger,$process);
    }
    
    /**
     * Method to delete the record
     *
     * @throws ZCRMException if Entity ID of the record is NULL
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function delete()
    {
        if (self::getEntityId() == null) {
            $exception = new ZCRMException("Entity ID MUST NOT be null for delete operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            $exception->setExceptionCode("ID MISSING");
            throw $exception;
        }
        return EntityAPIHandler::getInstance($this)->deleteRecord();
    }
    
    /**
     * Method to convert the record
     *
     * @param ZCRMRecord $potentialRecord the potential record
     * @param String $assignToUser owner of the converted record
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function convert($potentialRecord = null, $details=null)
    {
        return EntityAPIHandler::getInstance($this)->convertRecord($potentialRecord, $details);
    }
    
    /**
     * Method to get the RelatedList records
     *
     * @param String $relatedListAPIName Api name of the Related List
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API Response
     */
    public function getRelatedListRecords($relatedListAPIName, $param_map=array(),$header_map=array())
    {
        return ZCRMModuleRelation::getInstance($this, $relatedListAPIName)->getRecords($param_map,$header_map);
    }
    
    /**
     * Method to get the notes
     *
     * @param Array $param_map key-value pairs containing parameters 
     * @param Array $header_map key-value pairs containing headers 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the Bulk API response.
     */
    public function getNotes($param_map=array(),$header_map=array())
    {
        return ZCRMModuleRelation::getInstance($this, "Notes")->getNotes($param_map,$header_map);
    }
    
    /**
     * Method adds the note to the record
     *
     * @param ZCRMNote $zcrmNoteIns note instance
     * @throws ZCRMException if the note id of the note is null
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function addNote($zcrmNoteIns)
    {
        if ($zcrmNoteIns->getId() != null) {
            $exception = new ZCRMException("Note ID MUST be null for creating a note.", APIConstants::RESPONSECODE_BAD_REQUEST);
            $exception->setExceptionCode("ID EXIST");
            throw $exception;
        }
        return ZCRMModuleRelation::getInstance($this, "Notes")->addNote($zcrmNoteIns);
    }
    public function addNotes($noteInstances)
    {
        return ZCRMModuleRelation::getInstance($this, "Notes")->addNotes($noteInstances);
    }
    /**
     * Method to update the note of the reecord
     *
     * @param ZCRMNote $zcrmNoteIns Notes instance
     * @throws ZCRMException if note instance is not valid
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function updateNote($zcrmNoteIns)
    {
        if ($zcrmNoteIns->getId() == null) {
            $exception = new ZCRMException("Note ID MUST NOT be null for updating a note.", APIConstants::RESPONSECODE_BAD_REQUEST);
            $exception->setExceptionCode("ID MISSING");
            throw $exception;
        }
        return ZCRMModuleRelation::getInstance($this, "Notes")->updateNote($zcrmNoteIns);
    }
    
    /**
     * Method to delete the note of the record
     *
     * @param ZCRMNote $zcrmNoteIns note instance
     * @throws ZCRMException if note id is not valid
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function deleteNote($zcrmNoteIns)
    {
        if ($zcrmNoteIns->getId() == null) {
            $exception = new ZCRMException("Note ID MUST NOT be null for deleting a note.", APIConstants::RESPONSECODE_BAD_REQUEST);
            $exception->setExceptionCode("ID MISSING");
            throw $exception;
        }
        return ZCRMModuleRelation::getInstance($this, "Notes")->deleteNote($zcrmNoteIns);
    }
    
    /**
     * Method to get the attachments of the record
     * @param Array $param_map key-value pairs containing parameters 
     * @return BulkAPIResponse instance of the BulkAPIResponse class which holds the BulkAPI response.
     */
    public function getAttachments($param_map = array())
    {
        return ZCRMModuleRelation::getInstance($this, "Attachments")->getAttachments($param_map );
    }
    
    /**
     * Method to upload the attachment to the record
     *
     * @param String $filePath the file path of the attachment
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function uploadAttachment($filePath)
    {
        return ZCRMModuleRelation::getInstance($this, "Attachments")->uploadAttachment($filePath);
    }
    
    /**
     * Method to upload the link as the attachment to the record
     *
     * @param String $attachmentUrl the URL of the attachment
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function uploadLinkAsAttachment($attachmentUrl)
    {
        return ZCRMModuleRelation::getInstance($this, "Attachments")->uploadLinkAsAttachment($attachmentUrl);
    }
    
    /**
     * Method to download the attachment of the record
     *
     * @param string $attachmentId the attachment id
     * @return FileAPIResponse instance of the FileAPIResponse class which holds the response.
     */
    public function downloadAttachment($attachmentId)
    {
        return ZCRMModuleRelation::getInstance($this, "Attachments")->downloadAttachment($attachmentId);
    }
    
    /**
     * Method to delete the attachment of the record
     *
     * @param string $attachmentId the attachment id
     * @return APIResponse instance of the APIResponse class which holds the response.
     */
    public function deleteAttachment($attachmentId)
    {
        return ZCRMModuleRelation::getInstance($this, "Attachments")->deleteAttachment($attachmentId);
    }
    
    /**
     * Method to upload a photo to the record
     *
     * @param String $filePath the location of the photo
     * @return APIResponse instance of the APIResponse class which holds the response.
     */
    public function uploadPhoto($filePath)
    {
        return EntityAPIHandler::getInstance($this)->uploadPhoto($filePath);
    }
    
    /**
     * Method to download the photo of the record
     *
     * @return FileAPIResponse instance of the FileAPIResponse class which holds the response.
     */
    public function downloadPhoto()
    {
        return EntityAPIHandler::getInstance($this)->downloadPhoto();
    }
    
    /**
     * Method to delete the photo of the record
     *
     * @return APIResponse instance of the APIResponse class which holds the response.
     */
    public function deletePhoto()
    {
        return EntityAPIHandler::getInstance($this)->deletePhoto();
    }
    
    /**
     * Method to relate the record with another record
     *
     * @param ZCRMJunctionRecord $junctionRecord instance of ZCRMJunctionRecord class with which relation has to be created
     * @return APIResponse APIResponse instance of the APIResponse class which holds the API response.
     */
    public function addRelation(ZCRMJunctionRecord $junctionRecord)
    {
        return ZCRMModuleRelation::getInstance($this, $junctionRecord)->addRelation();
    }
    
    /**
     * Method to delete the relationship between the records
     *
     * @param ZCRMJunctionRecord $junctionRecord instance of ZCRMJunctionRecord class which relation has to be removed
     * @return APIResponse APIResponse instance of the APIResponse class which holds the API response.
     */
    public function removeRelation(ZCRMJunctionRecord $junctionRecord)
    {
        return ZCRMModuleRelation::getInstance($this, $junctionRecord)->removeRelation();
    }
    
    /**
     * Method adds the tag to the record
     *
     * @param String $tagNames tagnames to add(multiple tag names as comma separated values)
     * @throws ZCRMException if the record or module or tag doesn't exist
     * @return APIResponse APIResponse instance of the APIResponse class which holds the API response.
     */
    public function addTags($tagNames)
    {
        if ($this->entityId == null || $this->entityId == "") {
            throw new ZCRMException("Record ID MUST NOT be null/empty for Add Tags to a Specific record operation");
        }
        if ($this->moduleApiName == null || $this->moduleApiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for Add Tags to a Specific record operation");
        }
        if (sizeof($tagNames) <= 0) {
            throw new ZCRMException("Tag Name list MUST NOT be null/empty for Add Tags to a Specific record operation");
        }
        return TagAPIHandler::getInstance()->addTags($this, $tagNames);
    }
    
    /**
     * Method to remove the tags for the record
     *
     * @param String $tagNames tag names to remove(multiple tag names as comma separated values)
     * @throws ZCRMException if the record or module or tag doesn't exist
     * @return APIResponse instance of the APIResponse class which holds the API response.
     */
    public function removeTags($tagNames)
    {
        if ($this->entityId == null || $this->entityId == "") {
            throw new ZCRMException("Record ID MUST NOT be null/empty for Remove Tags from a Specific record operation");
        }
        if ($this->moduleApiName == null || $this->moduleApiName == "") {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for Remove Tags from a Specific record operation");
        }
        if (sizeof($tagNames) <= 0) {
            throw new ZCRMException("Tag Name list MUST NOT be null/empty for Remove Tags from a Specific record operation");
        }
        return TagAPIHandler::getInstance()->removeTags($this, $tagNames);
    }
    
    /**
     * Method to get the properties of a record
     *
     * @return array properties of the record
     */
    public function getAllProperties()
    {
        return $this->properties;
    }
    
    /**
     * Method to get the value of the property name of the record
     *
     * @param String $propertyName name of the property
     * @return String property value of the property name
     */
    public function getProperty($propertyName)
    {
        return $this->properties[$propertyName];
    }
    
    /**
     * Method to set the property value to the property name of the record
     *
     * @param String $key property name
     * @param String $value property value
     */
    public function setProperty($key, $value)
    {
        $this->properties[$key] = $value;
    }
    
    /**
     * method to get the participants of the record
     *
     * @return Array array of ZCRMParticipants instances of the record
     */
    public function getParticipants()
    {
        return $this->participants;
    }
    
    /**
     * method to add the participants to the record
     *
     * @param Array $participant ZCRMParticipants instances of the record
     */
    public function addParticipant($participant)
    {
        array_push($this->participants, $participant);
    }
    
    /**
     * Method to fetch the price details of the record
     *
     * @return Array ZCRMPriceBookPricing instances in the record
     */
    public function getPriceDetails()
    {
        return $this->priceDetails;
    }
    
    /**
     * Method adds the price details to the record of the price book module
     *
     * @param $priceDetail ZCRMPriceBookPricing pricing details of a ZCRMPriceBookPricing record
     */
    public function addPriceDetail($priceDetail)
    {
        array_push($this->priceDetails, $priceDetail);
    }
    
    /**
     * Method to get the layout of the record
     *
     * @return ZCRMLayout Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * Method to set the layout
     *
     * @param ZCRMLayout $layout Layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    /**
     * Method to get the time of last activity on the record
     *
     * @return String Time of last activity
     */
    public function getLastActivityTime()
    {
        return $this->lastActivityTime;
    }
    
    /**
     * Method to set the time of last activity on the record
     *
     * @param String $lastActivityTime Time of last activity
     */
    public function setLastActivityTime($lastActivityTime)
    {
        $this->lastActivityTime = $lastActivityTime;
    }
}