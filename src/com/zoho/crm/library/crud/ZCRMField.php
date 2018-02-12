<?php

class ZCRMField
{
	private $apiName=null;
	private $customField=null;
	private $lookupFields=null;
	private $convertMapping=null;
	private $visible=null;
	private $fieldLabel=null;
	private $length=null;
	private $createdSource=null;
	private $defaultValue=null;
	private $Mandatory=null;
	private $sequenceNumber=null;
	private $readOnly=null;
	private $uniqueField=null;
	private $caseSensitive=null;
	private $dataType=null;
	private $formulaField=null;
	private $currencyField=null;
	private $id=null;
	private $pickListValues=array();
	private $autoNumber=null;
	private $businessCardSupported=null;
	private $fieldLayoutPermissions=null;
	private $decimalPlace=null;
	
	private $precision=null;
	private $roundingOption=null;
	
	private $formulaReturnType=null;
	private $formulaExpression=null;
	
	private $prefix=null;
	private $suffix=null;
	private $startNumber=null;
	private $jsonType=null;
	
	private function __construct($apiName)
	{
		$this->apiName=$apiName;
	}
	
	public static function getInstance($apiName)
	{
		return new ZCRMField($apiName);
	}
	
	public function setConvertMapping($convertMapping)
	{
		$this->convertMapping=$convertMapping;
	}
	public function getConvertMapping()
	{
		return $this->convertMapping;
	}
	
	public function getApiName()
	{
		return $this->apiName;
	}
	public function setLength($length)
	{
		$this->length=$length;
	}
	public function getLength()
	{
		return $this->length;
	}
	public function setVisible($isVisible)
	{
		$this->visible=$isVisible;
	}
	public function isVisible()
	{
		return $this->visible;
	}
	public function setFieldLabel($fieldLabel)
	{
		$this->fieldLabel=$fieldLabel;
	}
	public function getFieldLabel()
	{
		return $this->fieldLabel;
	}
	public function setCreatedSource($createdSource)
	{
		$this->createdSource=$createdSource;
	}
	public function getCreatedSource()
	{
		return $this->createdSource;
	}
	public function setMandatory($Mandatory)
	{
		$this->Mandatory=$Mandatory;
	}
	public function isMandatory()
	{
		return $this->Mandatory;
	}
	public function setSequenceNumber($seqNumber)
	{
		$this->sequenceNumber=$seqNumber;
	}
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	public function setReadOnly($readOnly)
	{
		$this->readOnly=$readOnly;
	}
	public function isReadOnly()
	{
		return $this->readOnly;
	}
	public function setDataType($dataType)
	{
		$this->dataType=$dataType;
	}
	public function getDataType()
	{
		return $this->dataType;
	}
	public function setId($id)
	{
		$this->id=$id+0;
	}
	public function getId()
	{
		return $this->id;
	}
	public function setCustomField($customField)
	{
		$this->customField=$customField;
	}
	public function isCustomField()
	{
		return $this->customField;
	}
	public function isBusinessCardSupported()
	{
		return $this->businessCardSupported;
	}
	public function setBusinessCardSupported($businessCardSupported)
	{
	 	$this->businessCardSupported=$businessCardSupported;
	}
	
	public function setDefaultValue($defaultVal)
	{
		$this->defaultValue=$defaultVal;
	}
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}
	public function setFieldLayoutPermissions($fieldLayoutPermissions)
	{
		$this->fieldLayoutPermissions=$fieldLayoutPermissions;
	}
	public function getFieldLayoutPermissions()
	{
		return $this->fieldLayoutPermissions;
	}
	public function setLookupField($lookupFields)
	{
		$this->lookupFields=$lookupFields;
	}
	public function getLookupField()
	{
		return $this->lookupFields;
	}
	public function setPickListFieldValues($pickListValues)
	{
		$this->pickListValues=$pickListValues;
	}
	public function getPickListFieldValues()
	{
		return $this->pickListValues;
	}
	
	/*
	 * Unique field related properties
	 */
	public function setUniqueField($uniqueField)
	{
		$this->uniqueField=$uniqueField;
	}
	public function isUniqueField()
	{
		return $this->uniqueField;
	}
	public function setCaseSensitive($caseSensitive)
	{
		$this->caseSensitive=$caseSensitive;
	}
	public function isCaseSensitive()
	{
		return $this->caseSensitive;
	}
	
	/*
	 * Currency field related properties
	 */
	public function setCurrencyField($currencyField)
	{
		$this->currencyField=$currencyField;
	}
	public function isCurrencyField()
	{
		return $this->currencyField;
	}
	public function setPrecision($precision)
	{
		$this->precision=$precision;
	}
	public function getPrecision()
	{
		return $this->precision;
	}
	public function setRoundingOption($roundingOption)
	{
		$this->roundingOption=$roundingOption;
	}
	public function getRoundingOption()
	{
		return $this->roundingOption;
	}
	
	/*
	 * Formula field related properties
	 */
	public function setFormulaField($formulaField)
	{
		$this->formulaField=$formulaField;
	}
	public function isFormulaField()
	{
		return $this->formulaField;
	}
	public function setFormulaReturnType($returnType)
	{
		$this->formulaReturnType=$returnType;
	}
	public function getFormulaReturnType()
	{
		return $this->formulaReturnType;
	}
	public function setFormulaExpression($expression)
	{
		$this->formulaExpression=$expression;
	}
	public function getFormulaExpression()
	{
		return $this->formulaExpression;
	}
	
	/*
	 * Auto number related properties
	 */
	public function setAutoNumber($autoNumberField)
	{
		$this->autoNumber=$autoNumberField;
	}
	public function isAutoNumberField()
	{
		return $this->autoNumber;
	}
	public function setPrefix($prefix)
	{
		$this->prefix=$prefix;
	}
	public function getPrefix()
	{
		return $this->prefix;
	}
	public function setSuffix($suffix)
	{
		$this->suffix=$suffix;
	}
	public function getSuffix()
	{
		return $this->suffix;
	}
	public function setStartNumber($startNumber)
	{
		$this->startNumber=$startNumber;
	}
	public function getStartNumber()
	{
		return $this->startNumber;
	}
	
	public function setDecimalPlace($decimalPlace)
	{
		$this->decimalPlace=$decimalPlace;
	}
	public function getDecimalPlace()
	{
		return $this->decimalPlace;
	}
	
	public function setJsonType($jsonType)
	{
		$this->jsonType=$jsonType;
	}
	public function getJsonType()
	{
		return $this->jsonType;
	}
}
?>