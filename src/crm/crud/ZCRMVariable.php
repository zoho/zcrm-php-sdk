<?php
namespace zcrmsdk\crm\crud;
use zcrmsdk\crm\api\handler\VariableAPIHandler;

class ZCRMVariable
{
    private $id=null;
    private $name=null;
    private $api_name=null;
    private $type=null;
    private $value=null;
    private $variable_group=array();
    private $description=null;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name=$name;
    }
    public function getApiName()
    {
        return $this->api_name;
    }
    public function setApiName($api_name)
    {
        $this->api_name=$api_name;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type=$type;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value=$value;
    }
    public function getVariableGroup()
    {
        return $this->variable_group;
    }
    public function setVariableGroup($variable_group)
    {
        $this->variable_group=$variable_group;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description=$description;
    }
    public static function  getInstance()
    {
        return  new ZCRMVariable();
    }
    public function getVariable($group)
    {
        $instance = VariableAPIHandler::getInstance();
        $instance->setVariables($this);
        return $instance->getVariable($group);
    }
    public function updateVariable()
    {
        $instance = VariableAPIHandler::getInstance();
        $instance->setVariables($this);
        return $instance->updateVariable();
    }
    public function deleteVariable()
    {
        $instance = VariableAPIHandler::getInstance();
        $instance->setVariables($this);
        return $instance->deleteVariable();
    }
}