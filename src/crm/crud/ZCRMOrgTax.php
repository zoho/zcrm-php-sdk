<?php
namespace zcrmsdk\crm\crud;


class ZCRMOrgTax

{
    
    private $id;
    
    private $name;
    
    private $displayName;
    
    private $value;
    
    private $sequence;
    
    private function __construct($taxName, $id)
    {
        $this->name = $taxName;
        $this->id = $id;
    }
    
    public static function getInstance($taxName, $id)
    {
        return new ZCRMOrgTax($taxName, $id);
    }
    
    public function setId($taxId)
    {
        $this->id = $taxId;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($taxName)
    {
        $this->name = $taxName;
    }
    
    public function getDisplayName()
    {
        return $this->displayName;
    }
    
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function getSequence()
    {
        return $this->sequence;
    }
    
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }
    
}

?>