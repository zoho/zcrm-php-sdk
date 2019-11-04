<?php
namespace zcrmsdk\crm\bulkcrud;

class ZCRMBulkCriteria
{
    /**
     * field api name
     * @var string
     */
    private $apiName = null;
    
    /**
     * field value
     * @var object
     */
    private $apiValue = null;
    
    /**
     *  group operator
     * @var string
     */
    private $groupOperator = null;
    
    /**
     * group of criteria
     * @var array
     */
    private $group = array();
    
    /**
     * comparator
     * @var string
     */
    private $comparator = null;
    
    private $pattern = null;
    private $index = null;
    private $criteria = null;
    
    /**
     * empty constructor
     */
    private function __construct(){}
    
    /**
     * Method to get instance of ZCRMBulkCriteria class
     * @return ZCRMBulkCriteria - instance
     */
    public static function getInstance()
    {
        return new ZCRMBulkCriteria();
    }
    
    /**
     * Method to set the API name of a field to be compared.
     * @param string $apiName
     */
    public function setAPIName($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * Method to get the API name of a field to be compared.
     * @return string
     */
    public function getAPIName()
    {
        return $this->apiName;
    }
    
    /**
     * Method to set the value of a field to be compared.
     * @param string $value
     */
    public function setValue($value)
    {
        $this->apiValue = $value;
    }
    
    /**
     * Method to get the value of a field to be compared.
     * @return string
     */
    public function getValue()
    {
        return $this->apiValue;
    }
    
    /**
     * Method to set the Logical operators.
     * @param string $groupOperator
     */
    public function setGroupOperator($groupOperator)
    {
        $this->groupOperator = $groupOperator;
    }
    
    /**
     * Method to get the Logical operators.
     * @return string
     */
    public function getGroupOperator()
    {
        return $this->groupOperator;
    }
    
    /**
     * Method to set the comparator.
     * @param string $comparator
     */
    public function setComparator($comparator)
    {
        $this->comparator = $comparator;
    }
    
    /**
     * Method to get the comparator.
     * @return string
     */
    public function getComparator()
    {
        return $this->comparator;
    }
    
    /**
     * Method to set the array of criteria objects
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
    
    /**
     * Method to get the array of criteria objects
     * @return array|string
     */
    public function getGroup()
    {
        return $this->group;
    }
    
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }
    
    public function getPattern()
    {
        return $this->pattern;
    }
    
    public function setIndex($index)
    {
        $this->index = $index;
    }
    
    public function getIndex()
    {
        return $this->index;
    }
    
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    
    public function getCriteria()
    {
        return $this->criteria;
    }
}
?>