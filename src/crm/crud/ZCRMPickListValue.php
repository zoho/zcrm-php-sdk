<?php
namespace zcrmsdk\crm\crud;

class ZCRMPickListValue
{
    
    /**
     * display value
     *
     * @var string
     */
    private $displayValue = null;
    
    /**
     * sequence number of the llist
     *
     * @var int
     */
    private $sequenceNumber = null;
    
    /**
     * actual value of the pick list
     *
     * @var string
     */
    private $actualValue = null;
    
    /**
     * mappings
     *
     * @var array
     */
    private $maps = null;
    
    private function __construct()
    {}
    
    /**
     * method to get the instance of te=he pick list
     *
     * @return ZCRMPickListValue instance of the ZCRMPickListValue class
     */
    public static function getInstance()
    {
        return new ZCRMPickListValue();
    }
    
    /**
     * method to set the display value of the pick list
     *
     * @param string $displayValue the display value of the pick list
     */
    public function setDisplayValue($displayValue)
    {
        $this->displayValue = $displayValue;
    }
    
    /**
     * method to get the display value of the pick list
     *
     * @return string the display value of the pick list
     */
    public function getDisplayValue()
    {
        return $this->displayValue;
    }
    
    /**
     * method to set the sequence number of the pick list
     *
     * @param int $seqNumber the sequence number of the pick list
     */
    public function setSequenceNumber($seqNumber)
    {
        $this->sequenceNumber = $seqNumber;
    }
    
    /**
     * method to get the sequence number of the pick list
     *
     * @return int the sequence number of the pick list
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }
    
    /**
     * method to get the actual value of the pick list
     *
     * @param string $actualValue the actual value of the pick list
     */
    public function setActualValue($actualValue)
    {
        $this->actualValue = $actualValue;
    }
    
    /**
     * method to set the actual value of the pick list
     *
     * @return string the actual value of the pick list
     */
    public function getActualValue()
    {
        return $this->actualValue;
    }
    
    /**
     * method to set the maps for pick ist value
     *
     * @param array $maps array of mappings
     */
    public function setMaps($maps)
    {
        $this->maps = $maps;
    }
    
    /**
     * method to get maps for pick list value
     *
     * @return array array of mappings
     */
    public function getMaps()
    {
        return $this->maps;
    }
}