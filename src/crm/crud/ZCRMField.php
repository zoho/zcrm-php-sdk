<?php
namespace zcrmsdk\crm\crud;

class ZCRMField
{
    
    /**
     * api name of the field
     *
     * @var string
     */
    private $apiName = null;
    
    /**
     * used to check if the field is custom field
     *
     * @var boolean
     */
    private $customField = null;
    
    /**
     * instance of the ZCRMLookupField
     *
     * @var ZCRMLookupField
     */
    private $lookupFields = null;
    
    /**
     * convert mapping
     *
     * @var array
     */
    private $convertMapping = null;
    
    /**
     * visibility of the field
     *
     * @var boolean
     */
    private $visible = null;
    
    /**
     * display name of the field
     *
     * @var string
     */
    private $fieldLabel = null;
    
    /**
     * length of the field value
     *
     * @var int
     */
    private $length = null;
    
    /**
     * the creation source of the field
     *
     * @var string
     */
    private $createdSource = null;
    
    /**
     * default value of the field
     *
     * @var string
     */
    private $defaultValue = null;
    
    /**
     * mandatory field
     *
     * @var boolean
     */
    private $Mandatory = null;
    
    /**
     * sequence number of the field
     *
     * @var int
     */
    private $sequenceNumber = null;
    
    /**
     * field read only
     *
     * @var boolean
     */
    private $readOnly = null;
    
    /**
     * unique field
     *
     * @var boolean
     */
    private $uniqueField = null;
    
    /**
     * case sensitivity
     *
     * @var boolean
     */
    private $caseSensitive = null;
    
    /**
     * data type of the field
     *
     * @var string
     */
    private $dataType = null;
    
    /**
     * formula field
     *
     * @var boolean
     */
    private $formulaField = null;
    
    /**
     * currency field
     *
     * @var boolean
     */
    private $currencyField = null;
    
    /**
     * id of the field
     *
     * @var string
     */
    private $id = null;
    
    /**
     * array of instances of ZCRMPickListValue class
     *
     * @var array
     */
    private $pickListValues = array();
    
    /**
     * auto numbering
     *
     * @var String
     */
    private $autoNumber = null;
    
    /**
     * business supported
     *
     * @var boolean
     */
    private $businessCardSupported = null;
    
    /**
     * array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
     *
     * @var array
     */
    private $fieldLayoutPermissions = null;
    
    /**
     * decimal places for the value
     *
     * @var int
     */
    private $decimalPlace = null;
    
    /**
     * precision
     *
     * @var int
     *
     */
    private $precision = null;
    
    /**
     * rounding off options
     *
     * @var string
     */
    private $roundingOption = null;
    
    /**
     * return type of the formula
     *
     * @var string
     */
    private $formulaReturnType = null;
    
    /**
     * formula expression
     *
     * @var string
     */
    private $formulaExpression = null;
    
    /**
     * prefix
     *
     * @var string
     */
    private $prefix = null;
    
    /**
     * suffix
     *
     * @var string
     */
    private $suffix = null;
    
    /**
     * starting number
     *
     * @var int
     */
    private $startNumber = null;
    
    /**
     * json datatype of the field
     *
     * @var string
     */
    private $jsonType = null;
    
    /**
     * constructor to set the api name of the field
     *
     * @param string $apiName
     */
    private function __construct($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * Method to get the instance of the field
     *
     * @param string $apiName
     * @return ZCRMField instance of the ZCRMField
     */
    public static function getInstance($apiName)
    {
        return new ZCRMField($apiName);
    }
    
    /**
     * Method to set the convert mapping of the field
     *
     * @param array $convertMapping array containing module name as the key and value as boolean
     */
    public function setConvertMapping($convertMapping)
    {
        $this->convertMapping = $convertMapping;
    }
    
    /**
     * Method to get the convert mapping of the field
     *
     * @return array array containing module name as the key and value as boolean
     */
    public function getConvertMapping()
    {
        return $this->convertMapping;
    }
    
    /**
     * Method to get the api name of the field
     *
     * @return string api name of the field
     */
    public function getApiName()
    {
        return $this->apiName;
    }
    
    /**
     * Method to set the length of the field value
     *
     * @param int $length length of the value
     */
    public function setLength($length)
    {
        $this->length = $length;
    }
    
    /**
     * Method to get the length of the field value
     *
     * @return int length of the field
     */
    public function getLength()
    {
        return $this->length;
    }
    
    /**
     * Method to make the field visble
     *
     * @param boolean $isVisible true to make the field visible otherwise false
     */
    public function setVisible($isVisible)
    {
        $this->visible = $isVisible;
    }
    
    /**
     * Method to check whether the field is visible
     *
     * @return boolean true if the field is visible otherwise false
     */
    public function isVisible()
    {
        return $this->visible;
    }
    
    /**
     * Method to set the field label
     *
     * @param string $fieldLabel field lable name
     */
    public function setFieldLabel($fieldLabel)
    {
        $this->fieldLabel = $fieldLabel;
    }
    
    /**
     * Method to get the field label
     *
     * @return string field label name
     */
    public function getFieldLabel()
    {
        return $this->fieldLabel;
    }
    
    /**
     * Method to set the creation source of the field
     *
     * @param string $createdSource creation source of field
     */
    public function setCreatedSource($createdSource)
    {
        $this->createdSource = $createdSource;
    }
    
    /**
     * Method to get the creation source of the field
     *
     * @return string creation source of the field
     */
    public function getCreatedSource()
    {
        return $this->createdSource;
    }
    
    /**
     * Method to set the field as mandatory
     *
     * @param boolean $Mandatory true to make the field mandatory otherwise false
     */
    public function setMandatory($Mandatory)
    {
        $this->Mandatory = $Mandatory;
    }
    
    /**
     * Method to check whether the field is mandatory
     *
     * @return boolean true if the field is mandatory otherwise false
     */
    public function isMandatory()
    {
        return $this->Mandatory;
    }
    
    /**
     * Method to set the sequence number to the field
     *
     * @param int $seqNumber the sequence number
     */
    public function setSequenceNumber($seqNumber)
    {
        $this->sequenceNumber = $seqNumber;
    }
    
    /**
     * Method to get the sequence number of the field
     *
     * @return int sequence number
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }
    
    /**
     * Method to set the field as read only
     *
     * @param boolean $readOnly true to set the field as read only otherwise false
     */
    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;
    }
    
    /**
     * Method to check whether the field as read only
     *
     * @return boolean true if the field as read only otherwise false
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }
    
    /**
     * Method to set the data type of the field
     *
     * @param string $dataType data type of the field
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }
    
    /**
     * Method to get the data type of the field
     *
     * @return string data type of the field
     */
    public function getDataType()
    {
        return $this->dataType;
    }
    
    /**
     * Method to set the field id
     *
     * @param string $id field id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Method to get the field id
     *
     * @return string field id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Method to set the field as custom field
     *
     * @param boolean $customField true to set field as custom field otherwise false
     */
    public function setCustomField($customField)
    {
        $this->customField = $customField;
    }
    
    /**
     * Method to check whether the field is custom field
     *
     * @return boolean true if the field is custom field otherwise false
     */
    public function isCustomField()
    {
        return $this->customField;
    }
    
    /**
     * Method to check whether the field supports business card
     *
     * @return boolean true if the field supports business card otherwise false
     */
    public function isBusinessCardSupported()
    {
        return $this->businessCardSupported;
    }
    
    /**
     * Method to set the field as business card supported
     *
     * @param boolean $businessCardSupported true to set field as business class supported otherwise false
     */
    public function setBusinessCardSupported($businessCardSupported)
    {
        $this->businessCardSupported = $businessCardSupported;
    }
    
    /**
     * Method to set the default value of the field
     *
     * @param string $defaultVal default field value
     */
    public function setDefaultValue($defaultVal)
    {
        $this->defaultValue = $defaultVal;
    }
    
    /**
     * Method to get the default value of the field
     *
     * @return string default field value
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
    
    /**
     * Method to set the fieldlayout permissions of the field
     *
     * @param array $fieldLayoutPermissions array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
     */
    public function setFieldLayoutPermissions($fieldLayoutPermissions)
    {
        $this->fieldLayoutPermissions = $fieldLayoutPermissions;
    }
    
    /**
     * Method to get the fieldlayout permissions of the field
     *
     * @return array array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
     */
    public function getFieldLayoutPermissions()
    {
        return $this->fieldLayoutPermissions;
    }
    
    /**
     * Method to set the lookup fields of the field
     *
     * @param ZCRMLookupField $lookupFields instance of ZCRMLookupField
     */
    public function setLookupField($lookupFields)
    {
        $this->lookupFields = $lookupFields;
    }
    
    /**
     * Method to get the lookup fields of the field
     *
     * @return ZCRMLookupField instance of ZCRMLookupField
     */
    public function getLookupField()
    {
        return $this->lookupFields;
    }
    
    /**
     * Method to set the Pick list values of the field
     *
     * @param array $pickListValues array of ZCRMPickListValue class instances
     */
    public function setPickListFieldValues($pickListValues)
    {
        $this->pickListValues = $pickListValues;
    }
    
    /**
     * Method to get the Pick list values of the field
     *
     * @return array array of ZCRMPickListValue class instances
     */
    public function getPickListFieldValues()
    {
        return $this->pickListValues;
    }
    
    /**
     * Method to set the field as unique field
     *
     * @param boolean $uniqueField true to set the field as case sensitive otherwise false
     */
    public function setUniqueField($uniqueField)
    {
        $this->uniqueField = $uniqueField;
    }
    
    /**
     * Method to check whether the field is unique
     *
     * @return boolean true if the field is case sensitive otherwise false
     */
    public function isUniqueField()
    {
        return $this->uniqueField;
    }
    
    /**
     * Method to set the field as case sensitive field
     *
     * @param boolean $caseSensitive true to set the field as case sensitive otherwise false
     */
    public function setCaseSensitive($caseSensitive)
    {
        $this->caseSensitive = $caseSensitive;
    }
    
    /**
     * Method to check whether the field is case sensitive
     *
     * @return boolean true if the field is case sensitive otherwise false
     */
    public function isCaseSensitive()
    {
        return $this->caseSensitive;
    }
    
    /**
     * Method to set the field as a currency field
     *
     * @param boolean $currencyField true to set the field as a currency field otherwise false
     */
    public function setCurrencyField($currencyField)
    {
        $this->currencyField = $currencyField;
    }
    
    /**
     * Method to check the if the field is a currency field
     *
     * @return boolean true if currency field otherwise false
     */
    public function isCurrencyField()
    {
        return $this->currencyField;
    }
    
    /**
     * Method to set the rounding precision of the field
     *
     * @param int $precision precision number
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }
    
    /**
     * Method to get the rounding precision of the field
     *
     * @return int precision number
     */
    public function getPrecision()
    {
        return $this->precision;
    }
    
    /**
     * Method to set the rounding options of the field
     *
     * @param string $roundingOption rounding option of the field
     */
    public function setRoundingOption($roundingOption)
    {
        $this->roundingOption = $roundingOption;
    }
    
    /**
     * Method to get the rounding options of the field
     *
     * @return string rounding options
     */
    public function getRoundingOption()
    {
        return $this->roundingOption;
    }
    
    /**
     * Method to set the field as a formula field
     *
     * @param boolean $formulaField true to set the field as formula field otherwise false
     */
    public function setFormulaField($formulaField)
    {
        $this->formulaField = $formulaField;
    }
    
    /**
     * Method to check if the field is a formula field
     *
     * @return boolean true if the field is the formula field otherwise false
     */
    public function isFormulaField()
    {
        return $this->formulaField;
    }
    
    /**
     * Method to set the return type of the formula
     *
     * @param string $returnType return type of the formula
     */
    public function setFormulaReturnType($returnType)
    {
        $this->formulaReturnType = $returnType;
    }
    
    /**
     * Method to get the return type of the formula for the field
     *
     * @return string return type of the formula
     */
    public function getFormulaReturnType()
    {
        return $this->formulaReturnType;
    }
    
    /**
     * Method to set the formula expression of the field
     *
     * @param string $expression formula expression
     */
    public function setFormulaExpression($expression)
    {
        $this->formulaExpression = $expression;
    }
    
    /**
     * Method to get the formula expression of the field
     *
     * @return string formula expression
     */
    public function getFormulaExpression()
    {
        return $this->formulaExpression;
    }
    
    /**
     * Method to set the field as autonumber
     *
     * @param boolean $autoNumberField
     */
    public function setAutoNumber($autoNumberField)
    {
        $this->autoNumber = $autoNumberField;
    }
    
    /**
     * Method to check if the field is autonumber
     *
     * @return boolean true if autonumbering is enabled
     */
    public function isAutoNumberField()
    {
        return $this->autoNumber;
    }
    
    /**
     * Method to set the prefix of the field
     *
     * @param string $prefix prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
    
    /**
     * Method to get the prefix of the field
     *
     * @return string prefix
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
    
    /**
     * Method to set the suffix of the field
     *
     * @param string $suffix suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }
    
    /**
     * Method to get the suffix of the field
     *
     * @return string suffix
     */
    public function getSuffix()
    {
        return $this->suffix;
    }
    
    /**
     * Method to set the starting number of the field
     *
     * @param int $startNumber
     */
    public function setStartNumber($startNumber)
    {
        $this->startNumber = $startNumber;
    }
    
    /**
     * Method to get the starting number of the field
     *
     * @return int the starting number
     */
    public function getStartNumber()
    {
        return $this->startNumber;
    }
    
    /**
     * Method to set the decimal places of the field
     *
     * @param int $decimalPlace decimal places
     */
    public function setDecimalPlace($decimalPlace)
    {
        $this->decimalPlace = $decimalPlace;
    }
    
    /**
     * Method to get the decimal places of the field
     *
     * @return int decimal places
     */
    public function getDecimalPlace()
    {
        return $this->decimalPlace;
    }
    
    /**
     * Method to set the json datatype of the field
     *
     * @param string $jsonType json datatype
     */
    public function setJsonType($jsonType)
    {
        $this->jsonType = $jsonType;
    }
    
    /**
     * Method to get the json datatype of the field
     *
     * @return string datatype
     */
    public function getJsonType()
    {
        return $this->jsonType;
    }
}