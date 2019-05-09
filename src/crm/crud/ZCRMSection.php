<?php
namespace zcrmsdk\crm\crud;

class ZCRMSection
{
    
    /**
     * section name
     *
     * @var string
     */
    private $name = null;
    
    /**
     * section display name
     *
     * @var string
     */
    private $displayName = null;
    
    /**
     * columns in section
     *
     * @var int
     */
    private $columnCount = null;
    
    /**
     * sequence number of the section
     *
     * @var int
     */
    private $sequenceNumber = null;
    
    /**
     * array of fields
     *
     * @var array
     */
    private $fields = null;
    
    /**
     * constructor to assign the name to the section
     *
     * @param string $name section name
     */
    private function __construct($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the instance of the section
     *
     * @param string $name section name
     * @return ZCRMSection instance of the ZCRMSection class
     */
    public static function getInstance($name)
    {
        return new ZCRMSection($name);
    }
    
    /**
     * method to set the section name
     *
     * @param string $name section name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the section name
     *
     * @return string section name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the section display name
     *
     * @param string $displayName section display name
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    
    /**
     * method to get the section display name
     *
     * @return string section display name
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }
    
    /**
     * method to set the column count of the section
     *
     * @param int $count section column count
     */
    public function setColumnCount($count)
    {
        $this->columnCount = $count;
    }
    
    /**
     * method to get the column count of the section
     *
     * @return int section column count
     */
    public function getColumnCount()
    {
        return $this->columnCount;
    }
    
    /**
     * method to set the sequence number of the section
     *
     * @param int $seqNumber section sequence number
     */
    public function setSequenceNumber($seqNumber)
    {
        $this->sequenceNumber = $seqNumber;
    }
    
    /**
     * method to get the sequence number of the section
     *
     * @return int section sequence number
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }
    
    /**
     * method to set the fields of the section
     *
     * @param array $fields array of ZCRMField instances
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * method to get the fields of the section
     *
     * @return array array of ZCRMField instances
     */
    public function getFields()
    {
        return $this->fields;
    }
}