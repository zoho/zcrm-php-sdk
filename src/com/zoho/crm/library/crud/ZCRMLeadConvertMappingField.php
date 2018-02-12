<?php

class ZCRMLeadConvertMappingField
{
	private $apiName;
	private $id;
	private $fieldLabel;
	private $required;
	private function __construct($apiName,$id)
	{
		$this->apiName=$apiName;
		$this->id=$id;
	}
	
	public static function getInstance($apiName,$id)
	{
		return new ZCRMLeadConvertMappingField($apiName,$id);
	}

    /**
     * apiName
     * @return String
     */
    public function getApiName(){
        return $this->apiName;
    }

    /**
     * apiName
     * @param String $apiName
     */
    public function setApiName($apiName){
        $this->apiName = $apiName;
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
     * fieldLabel
     * @return String
     */
    public function getFieldLabel(){
        return $this->fieldLabel;
    }

    /**
     * fieldLabel
     * @param String $fieldLabel
     */
    public function setFieldLabel($fieldLabel){
        $this->fieldLabel = $fieldLabel;
    }

    /**
     * visible
     * @return Boolean
     */
    public function isRequired(){
        return $this->required;
    }

    /**
     * visible
     * @param Boolean $visible
     */
    public function setRequired($visible){
        $this->required = $visible;
    }

}
?>