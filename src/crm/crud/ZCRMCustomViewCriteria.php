<?php
namespace zcrmsdk\crm\crud;

/**
 *
 * @author sumanth-3058
 *
 */
class ZCRMCustomViewCriteria
{
    
    /**
     * comparison operation
     *
     * @var string
     */
    private $comparator = null;
    
    /**
     * api name of the field involved in comparison
     *
     * @var string
     */
    private $field = null;
    
    /**
     * value with which field value will be compared
     *
     * @var string
     */
    private $value = null;
    private $group=null;
    private $group_operator=null;
    private $pattern=null;
    private $index=null;
    private $criteria=null;
    
    private function __construct()
    {}
    
    /**
     * Method to get instance of ZCRMCustomViewCriteria class
     *
     * @return ZCRMCustomViewCriteria instance of ZCRMCustomViewCriteria class
     */
    public static function getInstance()
    {
        return new ZCRMCustomViewCriteria();
    }
    
    /**
     * Method to get the custom view criteria comparator
     *
     * @return string the comparison operation
     */
    public function getComparator()
    {
        return $this->comparator;
    }
    
    /**
     * Method to set the custom view criteria comparator
     *
     * @param string $comparator the comparison operator
     */
    public function setComparator($comparator)
    {
        $this->comparator = $comparator;
    }
    
    /**
     * Method to get the custom view criteria field name
     *
     * @return string field api name
     */
    public function getField()
    {
        return $this->field;
    }
    
    /**
     * Method to set the custom view criteria field name
     *
     * @param string $field field api name
     */
    public function setField($field)
    {
        $this->field = $field;
    }
    
    /**
     * Method to get the custom view criteria field value
     *
     * @return string field value
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Method to set the custom view criteria field value
     *
     * @param string $value field value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getGroup()
    {
        return $this->group;
    }
    public function getGroup_operator()
    {
        return $this->group_operator;
    }
    public function getPattern()
    {
        return $this->pattern;
    }
    public function getIndex()
    {
        return $this->index;
    }
    public function getCriteria()
    {
        return $this->criteria;
    }
    public function setGroup($group)
    {
        $this->group = $group;
    }
    public function setGroup_operator($group_operator)
    {
        $this->group_operator = $group_operator;
    }
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }
    public function setIndex($index)
    {
        $this->index = $index;
    }
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    
    
}