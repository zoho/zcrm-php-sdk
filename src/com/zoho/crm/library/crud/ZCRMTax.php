<?php

/**
 * 
 * @author sumanth-3058
 *This class is to maintain the details of tax related to Inventory line item
 */
class ZCRMTax
{
	private $taxName=null;
	private $percentage=null;
	private $value=null;
	
	private function __construct($taxName)
	{
		$this->taxName=$taxName;
	}
	
	public static function getInstance($taxName)
	{
		return new ZCRMTax($taxName);
	}
	
	

    /**
     * taxName
     * @return String
     */
    public function getTaxName(){
        return $this->taxName;
    }

    /**
     * taxName
     * @param String $taxName
     */
    public function setTaxName($taxName){
        $this->taxName = $taxName;
    }

    /**
     * percentage
     * @return Double
     */
    public function getPercentage(){
        return $this->percentage;
    }

    /**
     * percentage
     * @param Double $percentage
     */
    public function setPercentage($percentage){
        $this->percentage = $percentage;
    }

    /**
     * value
     * @return Double
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * value
     * @param Double $value
     */
    public function setValue($value){
        $this->value = $value;
    }

}
?>