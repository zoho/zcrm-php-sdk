<?php
namespace zcrmsdk\crm\crud;

class ZCRMRelatedListProperties
{
    
    /**
     * sorting according to field
     *
     * @var string
     */
    private $sortBy = null;
    
    /**
     * sorting order
     *
     * @var string
     */
    private $sortOrder = null;
    
    /**
     * field api names
     *
     * @var array
     */
    private $fields = array();
    
    private function __construct()
    {}
    
    /**
     * method to get the instance of the related list properties
     *
     * @return ZCRMRelatedListProperties instance of the ZCRMRelatedListProperties class
     */
    public static function getInstance()
    {
        return new ZCRMRelatedListProperties();
    }
    
    /**
     * method to get the field api name based on which the properties are being sorted
     *
     * @return string the field api name based on which the properties are being sorted
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }
    
    /**
     * method to set the field api name based on which the properties should be sorted
     *
     * @param string $sortBy field api name
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }
    
    /**
     * method to get the sort order
     *
     * @return string ascending "asc", descending "desc"
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    
    /**
     * method to set the sort order
     *
     * @param string $sortOrder ascending "asc", descending "desc"
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
    
    /**
     * method to get the fields api names
     *
     * @return array array of the field api names
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * method to set the fields api names
     *
     * @param array $fields array of the field api names
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
}