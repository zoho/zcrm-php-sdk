<?php
require_once realpath(dirname(__FILE__).'/../api/handler/EntityAPIHandler.php');
require_once realpath(dirname(__FILE__).'/../common/APIConstants.php');
require_once 'ZCRMModuleRelation.php';

/**
 * Provides methods for basic CRUD operations of the record.
 * @author sumanth-3058
 *
 */
class ZCRMRecord
{
	private $entityId=null;
	private $moduleApiName=null;
	private $lineItems=array();
	private $lookupLabel=null;
	private $owner=null;
	private $createdBy=null;
	private $modifiedBy=null;
	private $createdTime=null;
	private $modifiedTime=null;
	
	private $fieldNameVsValue=array();
	private $properties = array();
	private $participants = array();
	private $priceDetails = array();
	private $layout=null;
	private $taxList=array();
	private $lastActivityTime=null;
	
	private function __construct($module,$entityId)
	{
		$this->moduleApiName=$module;
		$this->entityId=$entityId;
	}
	
	public static function getInstance($module,$entityId)
	{
		return new ZCRMRecord($module,$entityId);
	}

	
	public function addTax($taxIns)
	{
		array_push($this->taxList,$taxIns);
	}
	
	public function getTaxList()
	{
		return $this->taxList;
	}
    /**
     * entityId
     * @return Long
     */
    public function getEntityId(){
        return $this->entityId;
    }

    /**
     * entityId
     * @param Long $entityId
     */
    public function setEntityId($entityId){
        $this->entityId = $entityId;
    }

    /**
     * moduleApiName
     * @return String
     */
    public function getModuleApiName(){
        return $this->moduleApiName;
    }

    /**
     * moduleApiName
     * @param String $moduleApiName
     */
    public function setModuleApiName($moduleApiName){
        $this->moduleApiName = $moduleApiName;
    }

    /**
     * Method to get the field value by api name
     * @return String
     */
    public function getFieldValue($apiName){
        return $this->fieldNameVsValue[$apiName];
    }

    /**
     * Method to set the field value for api name
     * @param $apiName,$value
     */
    public function setFieldValue($apiName,$value){
        $this->fieldNameVsValue[$apiName] = $value;
    }
    
    public function getData()
    {
    	return $this->fieldNameVsValue;
    }

    /**
     * lineItems
     * @return Array
     */
    public function getLineItems(){
        return $this->lineItems;
    }

    /**
     * lineItems
     * @param Array $lineItems
     */
    public function addLineItem($lineItem){
        array_push($this->lineItems,$lineItem);
    }

    /**
     * lookupLabel
     * @return String
     */
    public function getLookupLabel(){
        return $this->lookupLabel;
    }

    /**
     * lookupLabel
     * @param String $lookupLabel
     */
    public function setLookupLabel($lookupLabel){
        $this->lookupLabel = $lookupLabel;
    }

    /**
     * owner
     * @return ZCRMUser
     */
    public function getOwner(){
        return $this->owner;
    }

    /**
     * owner
     * @param ZCRMUser $owner
     */
    public function setOwner($owner){
        $this->owner = $owner;
    }

    /**
     * createdBy
     * @return ZCRMUser
     */
    public function getCreatedBy(){
        return $this->createdBy;
    }

    /**
     * createdBy
     * @param ZCRMUser $createdBy
     */
    public function setCreatedBy($createdBy){
        $this->createdBy = $createdBy;
    }

    /**
     * modifiedBy
     * @return ZCRMUser
     */
    public function getModifiedBy(){
        return $this->modifiedBy;
    }

    /**
     * modifiedBy
     * @param ZCRMUser $modifiedBy
     */
    public function setModifiedBy($modifiedBy){
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * createdTime
     * @return String
     */
    public function getCreatedTime(){
        return $this->createdTime;
    }

    /**
     * createdTime
     * @param String $createdTime
     */
    public function setCreatedTime($createdTime){
        $this->createdTime = $createdTime;
    }

    /**
     * modifiedTime
     * @return String
     */
    public function getModifiedTime(){
        return $this->modifiedTime;
    }

    /**
     * modifiedTime
     * @param String $modifiedTime
     */
    public function setModifiedTime($modifiedTime){
        $this->modifiedTime = $modifiedTime;
    }
    
    /**
     * Returns the API response of the record creation.
     * @return APIResponse of the record creation.
     * @throws ZCRMException if Entity ID of the record is not NULL
     */
    public function create()
    {
    	if(self::getEntityId() != null)
    	{
    		$exception = new ZCRMException("Entity ID MUST be null for create operation.",APIConstants::RESPONSECODE_BAD_REQUEST);
    		$exception->setExceptionCode("ID EXIST");
    		throw $exception;
    	}
    	return EntityAPIHandler::getInstance($this)->createRecord();
    }
    /**
     * Returns the API response of the record update.
     * @return APIResponse of the record update.
     * @throws ZCRMException if Entity ID of the record is NULL
     */
    public function update()
    {
    	if(self::getEntityId() == null)
    	{
    		$exception = new ZCRMException("Entity ID MUST NOT be null for update operation.",APIConstants::RESPONSECODE_BAD_REQUEST);
    		$exception->setExceptionCode("ID MISSING");
    		throw $exception;
    	}
    	return EntityAPIHandler::getInstance($this)->updateRecord();
    }
    
    /**
     * Returns the API response of the record delete.
     * @return APIResponse of the record delete.
     * @throws ZCRMException if Entity ID of the record is NULL
     */
    public function delete()
    {
    	if(self::getEntityId() == null)
    	{
    		$exception= new ZCRMException("Entity ID MUST NOT be null for delete operation.",APIConstants::RESPONSECODE_BAD_REQUEST);
    		$exception->setExceptionCode("ID MISSING");
    		throw $exception;
    	}
    	return EntityAPIHandler::getInstance($this)->deleteRecord();
    }
    
    public function convert($potentialRecord=null,$assignToUser=null,$additionalData=[])
    {
    	return EntityAPIHandler::getInstance($this)->convertRecord($potentialRecord, $assignToUser, $additionalData);
    }
    
    public function getRelatedListRecords($relatedListAPIName,$sortByField=null,$sortOrder=null,$page=1, $perPage=20) 
    {
    	return ZCRMModuleRelation::getInstance($this,$relatedListAPIName)->getRecords($sortByField,$sortOrder,$page,$perPage);
    }
    
    public function getNotes($sortByField=null,$sortOrder=null,$page=1, $perPage=20)
    {
    	return ZCRMModuleRelation::getInstance($this,"Notes")->getNotes($sortByField,$sortOrder,$page,$perPage);
    }
    
    public function addNote($zcrmNoteIns)
    {
    	if($zcrmNoteIns->getId()!=null)
    	{
    		$exception=new ZCRMException("Note ID MUST be null for creating a note.",APIConstants::RESPONSECODE_BAD_REQUEST);
    		$exception->setExceptionCode("ID EXIST");
    		throw $exception;
    	}
    	return ZCRMModuleRelation::getInstance($this,"Notes")->addNote($zcrmNoteIns);
    }
    
    public function updateNote($zcrmNoteIns)
    {
    	if($zcrmNoteIns->getId()==null)
    	{
    		$exception=new ZCRMException("Note ID MUST NOT be null for updating a note.",APIConstants::RESPONSECODE_BAD_REQUEST);
    		$exception->setExceptionCode("ID MISSING");
    		throw $exception;
    	}
    	return ZCRMModuleRelation::getInstance($this,"Notes")->updateNote($zcrmNoteIns);
    }
    
    public function deleteNote($zcrmNoteIns)
    {
    	if($zcrmNoteIns->getId()==null)
    	{
    		$exception=new ZCRMException("Note ID MUST NOT be null for deleting a note.",APIConstants::RESPONSECODE_BAD_REQUEST);
    		$exception->setExceptionCode("ID MISSING");
    		throw $exception;
    	}
    	return ZCRMModuleRelation::getInstance($this,"Notes")->deleteNote($zcrmNoteIns);
    }
    
    public function getAttachments($page=1,$perPage=20)
    {
    	return ZCRMModuleRelation::getInstance($this,"Attachments")->getAttachments($page,$perPage);
    }
    
    public function uploadAttachment($filePath)
    {
    	return ZCRMModuleRelation::getInstance($this,"Attachments")->uploadAttachment($filePath);
    }
    
    public function uploadLinkAsAttachment($attachmentUrl)
    {
    	return ZCRMModuleRelation::getInstance($this,"Attachments")->uploadLinkAsAttachment($attachmentUrl);
    }
    
    public function downloadAttachment($attachmentId)
    {
    	return ZCRMModuleRelation::getInstance($this,"Attachments")->downloadAttachment($attachmentId);
    }
    public function deleteAttachment($attachmentId)
    {
    	return ZCRMModuleRelation::getInstance($this,"Attachments")->deleteAttachment($attachmentId);
    }
    /**
     * To upload photo to the record
     * @param unknown $filePath
     */
    public function uploadPhoto($filePath)
    {
    	return EntityAPIHandler::getInstance($this)->uploadPhoto($filePath);
    }
    /**
     * To Download the photo of the record
     */
    public function downloadPhoto()
    {
    	return EntityAPIHandler::getInstance($this)->downloadPhoto();
    }
    
    /**
     * To Download the photo of the record
     */
    public function deletePhoto()
    {
    	return EntityAPIHandler::getInstance($this)->deletePhoto();
    }

    public function addRelation(ZCRMJunctionRecord $junctionRecord)
    {
    	return ZCRMModuleRelation::getInstance($this, $junctionRecord)->addRelation();
    }
    public function removeRelation(ZCRMJunctionRecord $junctionRecord)
    {
    	return ZCRMModuleRelation::getInstance($this, $junctionRecord)->removeRelation();
    }

    /**
     * properties
     * @return HashMap
     */
    public function getAllProperties(){
    	return $this->properties;
    }
    
    /**
     * properties
     * @return HashMap
     */
    public function getProperty($propertyName){
        return $this->properties[$propertyName];
    }

    /**
     * properties
     * @param HashMap $properties
     */
    public function setProperty($key,$value){
        $this->properties[$key]=$value;
    }

    /**
     * participants
     * @return Array
     */
    public function getParticipants(){
        return $this->participants;
    }

    /**
     * participants
     * @param Array $participants
     */
    public function addParticipant($participant){
        array_push($this->participants,$participant);
    }

    /**
     * priceDetails
     * @return Array
     */
    public function getPriceDetails(){
        return $this->priceDetails;
    }

    /**
     * priceDetails
     * @param Array $priceDetails
     */
    public function addPriceDetail($priceDetail){
        array_push($this->priceDetails, $priceDetail);
    }

    /**
     * layout
     * @return ZCRMLayout
     */
    public function getLayout(){
        return $this->layout;
    }

    /**
     * layout
     * @param ZCRMLayout $layout
     */
    public function setLayout($layout){
        $this->layout = $layout;
    }


    /**
     * lastActivityTime
     * @return String
     */
    public function getLastActivityTime(){
        return $this->lastActivityTime;
    }

    /**
     * lastActivityTime
     * @param String $lastActivityTime
     */
    public function setLastActivityTime($lastActivityTime){
        $this->lastActivityTime = $lastActivityTime;
    }

}
?>