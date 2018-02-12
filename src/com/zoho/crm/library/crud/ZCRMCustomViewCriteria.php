<?php
/**
 * 
 * @author sumanth-3058
 *
 */
class ZCRMCustomViewCriteria
{
	private $comparator=null;
	private $field=null;
	private $value=null;
	
	private function __construct()
	{
		
	}
	
	public static function getInstance()
	{
		return new ZCRMCustomViewCriteria();
	}

    /**
     * Get the custom view criteria comparator
     * @return Comparator
     */
    public function getComparator(){
        return $this->comparator;
    }

    /**
     * Set the custom view criteria comparator
     * @param $comparator
     */
    public function setComparator($comparator){
        $this->comparator = $comparator;
    }

    /**
     * Get the custom view criteria field name
     * @return fieldName
     */
    public function getField(){
        return $this->field;
    }

    /**
     * Set the custom view criteria field name
     * @param $field
     */
    public function setField($field){
        $this->field = $field;
    }

    /**
     * Get the custom view criteria field value
     * @return CriteriaFieldValue
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * Set the custom view criteria field value
     * @param $value
     */
    public function setValue($value){
        $this->value = $value;
    }

}
?>