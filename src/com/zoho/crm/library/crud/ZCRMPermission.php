<?php

class ZCRMPermission
{
	private $displayLabel;
	private $module;
	private $id;
	private $name;
	private $enabled;

	private function __construct($name,$id)
	{
		$this->name=$name;
		$this->id=$id;
	}
	
	public static function getInstance($name,$id)
	{
		return new ZCRMPermission($name,$id);
	}
    /**
     * displayLabel
     * @return String
     */
    public function getDisplayLabel(){
        return $this->displayLabel;
    }

    /**
     * displayLabel
     * @param String $displayLabel
     */
    public function setDisplayLabel($displayLabel){
        $this->displayLabel = $displayLabel;
    }

    /**
     * module
     * @return String
     */
    public function getModule(){
        return $this->module;
    }

    /**
     * module
     * @param String $module
     */
    public function setModule($module){
        $this->module = $module;
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
     * @param String $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * enabled
     * @return Boolean
     */
    public function isEnabled(){
        return $this->enabled;
    }

    /**
     * enabled
     * @param Boolean $enabled
     */
    public function setEnabled($enabled){
        $this->enabled = $enabled;
    }

}
?>