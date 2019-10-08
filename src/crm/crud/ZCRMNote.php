<?php
namespace zcrmsdk\crm\crud;

use zcrmsdk\crm\setup\users\ZCRMUser;

class ZCRMNote
{
    
    /**
     * note id
     *
     * @var string
     */
    private $id = null;
    
    /**
     * note title
     *
     * @var string
     */
    private $title = null;
    
    /**
     * note content
     *
     * @var string
     */
    private $content = null;
    
    /**
     * parent record of the note
     *
     * @var ZCRMRecord
     */
    private $parentRecord = null;
    
    /**
     * owner of the note
     *
     * @var ZCRMUser
     */
    private $owner = null;
    
    /**
     * creator of the note
     *
     * @var ZCRMUser
     */
    private $createdBy = null;
    
    /**
     * creation time of the note
     *
     * @var string
     */
    private $createdTime = null;
    
    /**
     * modifier of the note
     *
     * @var ZCRMUser
     */
    private $modifiedBy = null;
    
    /**
     * modification time of the note
     *
     * @var string
     */
    private $modifiedTime = null;
    
    /**
     * the attachments of the note
     *
     * @var array array of ZCRMAttachment instances
     */
    private $attachments = array();
    
    /**
     * size of the note
     *
     * @var string
     */
    private $size = null;
    
    /**
     * note has voice note
     *
     * @var boolean
     */
    private $voiceNote = null;
    
    /**
     * parent module of the note
     *
     * @var ZCRMModule
     */
    private $parentModule = null;
    
    /**
     * parent record name of the note
     *
     * @var string
     */
    private $parentName = null;
    
    /**
     * id of the parent record
     *
     * @var string
     */
    private $parentId = null;
    
    /**
     * constructor to assign the parent record and note id to the note
     *
     * @param ZCRMRecord $parentRecord instance of the ZCRMRecord
     * @param string $noteId note id
     */
    private function __construct($parentRecord, $noteId)
    {
        if(!is_null($parentRecord)){
            $this->parentId=$parentRecord->getEntityId();
            $this->parentModule=$parentRecord->getModuleApiName();
            $this->parentRecord = $parentRecord;
        }
        $this->id = $noteId;
    }
    
    /**
     * method to get the instance of the note
     *
     * @param ZCRMRecord $parentRecord instance of the ZCRMRecord
     * @param string $noteId note id
     * @return ZCRMNote instance of the ZCRMNote class
     */
    public static function getInstance($parentRecord=null, $noteId = null)
    {
        return new ZCRMNote($parentRecord, $noteId);
    }
    
    /**
     * method to get the note id
     *
     * @return string the note id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the note id
     *
     * @param string $id the note id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the title of the note
     *
     * @return String title of the note
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * method to set the title of the note
     *
     * @param String $title title of the note
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * method to get the content of the note
     *
     * @return String the content of the note
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * method to set the content of the note
     *
     * @param String $content the content of the note
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * method to get the parent Record of the note
     *
     * @return ZCRMRecord instance of the ZCRMRecord
     */
    public function getParentRecord()
    {
        return $this->parentRecord;
    }
    
    /**
     * method to set the parent Record of the note
     *
     * @param ZCRMRecord $parentRecord instance of the ZCRMRecord
     */
    public function setParentRecord($parentRecord)
    {
        $this->parentRecord = $parentRecord;
    }
    
    /**
     * method to get the owner of the note
     *
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    /**
     * method to get the owner of the note
     *
     * @param ZCRMUser $owner instance of the ZCRMUser class
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
    
    /**
     * method to get the user who created the note
     *
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * method to set the user who created the note
     *
     * @param ZCRMUser $createdBy instance of the ZCRMUser class
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * method to get the creation time of the note
     *
     * @return string creation time of the note in iso 8601 format
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }
    
    /**
     * method to set the creation time of the note
     *
     * @param string $createdTime creation time of the note in iso 8601 format
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
    
    /**
     * method to get the user who modified the note
     *
     * @return ZCRMUser instance of the ZCRMUser class
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * method to set the user who modified the note
     *
     * @param ZCRMUser $modifiedBy instance of the ZCRMUser class
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
    
    /**
     * method to get the modified time of the note
     *
     * @return string modified time of the note in iso 8601 format
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    
    /**
     * method to set the modified time of the note
     *
     * @param String $modifiedTime modified time of the note in iso 8601 format
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    }
    
    /**
     * method to get the attachments of the note
     *
     * @return Array array of ZCRMAttachment instances
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
    
    /**
     * method to set the attachments of the note
     *
     * @param array $attachments array of ZCRMAttachment instances
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }
    
    /**
     * method to set the size of the note
     *
     * @return string size of the note
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * method to set the size of the note
     *
     * @param string $size size of the note
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    
    /**
     * method to check whether the voice note is available for the note
     *
     * @return boolean true if the voice note is available otherwise false
     */
    public function isVoiceNote()
    {
        return $this->voiceNote;
    }
    
    /**
     * method to set the voice note availablity for the note
     *
     * @param boolean $voiceNote true to set as available otherwise false
     */
    public function setVoiceNote($voiceNote)
    {
        $this->voiceNote = $voiceNote;
    }
    
    /**
     * method to get the module name of the the parent
     *
     * @return ZCRMModule the instance of the ZCRMModule class
     */
    public function getParentModule()
    {
        return $this->parentModule;
    }
    
    /**
     * method to set the module name of the the parent
     *
     * @param ZCRMModule $parentModule the instance of the ZCRMModule class
     */
    public function setParentModule($parentModule)
    {
        $this->parentModule = $parentModule;
    }
    
    /**
     * method to set the parent record name of the note
     *
     * @return String the parent record name of the note
     */
    public function getParentName()
    {
        return $this->parentName;
    }
    
    /**
     * method to set the parent record name of the note
     *
     * @param String $parentName the parent record name of the note
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;
    }
    
    /**
     * method to get the record id of the the note's parent
     *
     * @return string the record id of the the note's parent
     */
    public function getParentId()
    {
        return $this->parentId;
    }
    
    /**
     * method to set the record id of the the note's parent
     *
     * @param string $parentId record id of the the note's parent
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }
    public function getAttachmentsOfNote($page = 1, $perPage = 20){
        return ZCRMModuleRelation::getInstance(ZCRMRecord::getInstance("Notes", $this->getId()), "Attachments")->getAttachments($page, $perPage);
    }
    public function uploadAttachment($filePath)
    {
        return ZCRMModuleRelation::getInstance(ZCRMRecord::getInstance("Notes", $this->getId()), "Attachments")->uploadAttachment($filePath);
    }
    public function downloadAttachment($attachmentId){
        return ZCRMModuleRelation::getInstance(ZCRMRecord::getInstance("Notes", $this->getId()), "Attachments")->downloadAttachment($attachmentId);
    }
    public function deleteAttachment($attachmentId)
    {
        return ZCRMModuleRelation::getInstance(ZCRMRecord::getInstance("Notes", $this->getId()), "Attachments")->deleteAttachment($attachmentId);
    }
}