<?php

class ZCRMSection
{
	private $name=null;
	private $displayName=null;
	private $columnCount=null;
	private $sequenceNumber=null;
	private $fields=null;
	
	private function __construct($name)
	{
		$this->name=$name;
	}
	
	public static function getInstance($name)
	{
		return new ZCRMSection($name);
	}
	
	public function setName($name)
	{
		$this->name=$name;
	}
	public function getName()
	{
		return $this->name;
	}
	
	public function setDisplayName($displayName)
	{
		$this->displayName=$displayName;
	}
	public function getDisplayName()
	{
		return $this->displayName;
	}
	
	public function setColumnCount($count)
	{
		$this->columnCount=$count;
	}
	public function getColumnCount()
	{
		return $this->columnCount;
	}
	
	public function setSequenceNumber($seqNumber)
	{
		$this->sequenceNumber=$seqNumber;
	}
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function setFields($fields)
	{
		$this->fields=$fields;
	}
	public function getFields()
	{
		return $this->fields;
	}
}
?>