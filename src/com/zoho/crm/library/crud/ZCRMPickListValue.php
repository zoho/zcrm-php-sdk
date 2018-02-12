<?php

class ZCRMPickListValue
{
	private $displayValue=null;
	private $sequenceNumber=null;
	private $actualValue=null;
	private $maps=null;
	
	private function __construct()
	{
		
	}
	
	public static function getInstance()
	{
		return new ZCRMPickListValue();
	}
	
	public function setDisplayValue($displayValue)
	{
		$this->displayValue=$displayValue;
	}
	public function getDisplayValue()
	{
		return $this->displayValue;
	}
	
	public function setSequenceNumber($seqNumber)
	{
		$this->sequenceNumber=$seqNumber;
	}
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function setActualValue($actualValue)
	{
		$this->actualValue=$actualValue;
	}
	public function getActualValue()
	{
		return $this->actualValue;
	}
	
	public function setMaps($maps)
	{
		$this->maps=$maps;
	}
	public function getMaps()
	{
		return $this->maps;
	}
}
?>