<?php

class ZCRMTag
{	
	private $id=null;
	private $name=null;
	private $createdBy=null;
	private $createdTime=null;
	private $modifiedBy=null;
	private $modifiedTime=null;
	private $count=null;
    private $moduleApiName=null;
    
	private function __construct($id,$moduleApiName)
	{
        $this->id = $id;
        $this->moduleApiName = $moduleApiName;
	}
	
	public static function getInstance($id=null,$moduleApiName=null)
	{
	    return new ZCRMTag($id,$moduleApiName);
	}
	
    /**
     * id
     * @return Long
     */
    public function getId(){
        return $this->id;
    }

    /**
     * id
     * @param Long $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * name
     * @return String
     */
    public function getName(){
        return $this->name;
    }

    /**
     * name
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
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
     * count
     * @return Int
     */
    public function getCount(){
        return $this->count;
    }

    /**
     * count
     * @param Int $count
     */
    public function setCount($count){
        $this->count = $count;
    }
    
    /**
     * moduleApiName
     * @return String
     */
    public function getModuleApiName(){
        return $this->moduleApiName;
    }

    /**
     * coumoduleApiNament
     * @param String $moduleApiName
     */
    public function setModuleApiName($moduleApiName){
        $this->moduleApiName = $moduleApiName;
    }
    public function delete()
    {
        if ($this->id == null || $this->id == 0)
        {
            throw new ZCRMException("Tag ID MUST NOT be null/empty for delete operation");
        }
        return TagAPIHandler::getInstance()->delete($this->id);
    }
    public function merge($mergetag)
    {
        if ($this->id == null || $this->id == 0)
        {
            throw new ZCRMException("Tag ID MUST NOT be null/empty for merge operation");
        }
        if ($mergetag->id == null || $mergetag->id == 0)
        {
            throw new ZCRMException("Merge Tag ID MUST NOT be null/empty for merge operation");
        }
        return TagAPIHandler::getInstance()->merge($this->id, $mergetag->id);
        
    }
    public  function update()
    {
        if ($this->id == null || $this->id == 0)
        {
            throw new ZCRMException("Tag ID MUST NOT be null/empty for update operation");
        }
        if ($this->moduleApiName == null || $this->moduleApiName == "")
        {
            throw new ZCRMException("Module Api Name MUST NOT be null/empty for update operation");
        }
        if ($this->name == null || $this->name == "")
        {
            throw new ZCRMException("Tag Name MUST NOT be null/empty for update operation");
        }
        return TagAPIHandler::getInstance()->update($this);
    }
    
}
?>