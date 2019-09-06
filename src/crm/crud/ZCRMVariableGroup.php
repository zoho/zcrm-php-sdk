<?php
namespace zcrmsdk\crm\crud;
use zcrmsdk\crm\api\handler\VariableGroupAPIHandler;

class ZCRMVariableGroup
{
    private $id=null;
    private $name=null;
    private $api_name=null;
    private $display_label=null;
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
    public function getDisplayLabel()
    {
        return $this->display_label;
    }
    public function setDisplayLabel($display_label)
    {
        $this->display_label=$display_label;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description=$description;
    }
    public static function getInstance()
    {
        return  new ZCRMVariableGroup();
    }
    public function getVariableGroup()
    {
        $instance = VariableGroupAPIHandler::getInstance();
        $instance->setVariableGroups($this);
        return $instance->getVariableGroup();
    }
}