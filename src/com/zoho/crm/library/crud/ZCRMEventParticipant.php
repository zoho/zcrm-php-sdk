<?php

class ZCRMEventParticipant
{
	private $email=null;
	private $name=null;
	private $id=null;
	private $type=null;
	private $isInvited=null;
	private $status=null;
	
	private function __construct($type,$id)
	{
		$this->type=$type;
		$this->id=$id;
	}
	
	public static function getInstance($type,$id)
	{
		return new ZCRMEventParticipant($type,$id);
	}

    /**
     * email
     * @return String
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * email
     * @param String $email
     */
    public function setEmail($email){
        $this->email = $email;
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
     * @param String $name
     */
    public function setName($name){
        $this->name = $name;
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
     * @return ZCRMEventParticipant
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * type
     * @return String
     */
    public function getType(){
        return $this->type;
    }

    /**
     * type
     * @param String $type
     */
    public function setType($type){
        $this->type = $type;
    }

    /**
     * isInvited
     * @return boolean
     */
    public function isInvited(){
        return $this->isInvited;
    }

    /**
     * isInvited
     * @param boolean $isInvited
     */
    public function setInvited($isInvited){
        $this->isInvited = $isInvited;
    }

    /**
     * status
     * @return String
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * status
     * @param String $status
     */
    public function setStatus($status){
        $this->status = $status;
    }

}
?>