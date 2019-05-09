<?php
namespace zcrmsdk\crm\crud;

class ZCRMModuleRelatedList
{
    
    /**
     * module related list api name
     *
     * @var string
     */
    private $apiName = null;
    
    /**
     * module name
     *
     * @var string
     */
    private $module = null;
    
    /**
     * display name of the related list
     *
     * @var string
     */
    private $displayLabel = null;
    
    /**
     * visible related list
     *
     * @var boolean
     */
    private $visible = null;
    
    /**
     * name of the related list
     *
     * @var string
     */
    private $name = null;
    
    /**
     * id of the related list
     *
     * @var string
     */
    private $id = null;
    
    /**
     * hyperlink of the related list
     *
     * @var string
     */
    private $href = null;
    
    /**
     * type of the related list
     *
     * @var string
     */
    private $type = null;
    
    /**
     * constructor to assign api name to the list
     *
     * @param string $apiName api name to the list
     */
    private function __construct($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * method to get the instance of module related list
     *
     * @param string $apiName api name to the list
     * @return ZCRMModuleRelatedList instance of the ZCRMModuleRelatedList
     */
    public static function getInstance($apiName)
    {
        return new ZCRMModuleRelatedList($apiName);
    }
    
    /**
     * method to set the api name of the module related list
     *
     * @param string $apiName api name of the module related list
     */
    public function setApiName($apiName)
    {
        $this->apiName = $apiName;
    }
    
    /**
     * method to get the api name of the module related list
     *
     * @return string api name of the module related list
     */
    public function getApiName()
    {
        return $this->apiName;
    }
    
    /**
     * method to get the module api name to which this module related list is belongs
     *
     * @return string the module api name to which this module related list is belongs
     */
    public function getModule()
    {
        return $this->module;
    }
    
    /**
     * method to set the module api name to which this module related list is belongs
     *
     * @param string $module the module api name to which this module related list is belongs
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
    
    /**
     * method to get the display Label of the module related list
     *
     * @return string display Label of the module related list
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }
    
    /**
     * method to set the display Label of the module related list
     *
     * @param string $displayLabel the module related list
     */
    public function setDisplayLabel($displayLabel)
    {
        $this->displayLabel = $displayLabel;
    }
    
    /**
     * method to check whether the module related list is visible
     *
     * @return boolean true if the module related list is visible else false
     */
    public function isVisible()
    {
        return $this->visible;
    }
    
    /**
     * method to set the visibility of the module related list
     *
     * @param boolean $visible true to set the module related lsit visible else false
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }
    
    /**
     * method to get name of the module related list
     *
     * @return string name of the module related list
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set name of the module related list
     *
     * @param string $name name of the module related list
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get id of the module related list
     *
     * @return string id of the module related list
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set id of the module related list
     *
     * @param string $id id of the module related list
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the href of the module related list
     *
     * @return string href of the module related list
     */
    public function getHref()
    {
        return $this->href;
    }
    
    /**
     * method to set the href of the module related list
     *
     * @param string $href href of the module related list
     */
    public function setHref($href)
    {
        $this->href = $href;
    }
    
    /**
     * method to get the type of the module related list
     *
     * @return string type of the module related list
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * method to set the type of the module related list
     *
     * @param string $type type of the module related list
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * method to set the related list properties
     *
     * @param ZCRMRelatedListProperties $relatedListDetails instance of the ZCRMRelatedListProperties class
     * @return ZCRMModuleRelatedList instance of the ZCRMRelatedListProperties class
     */
    public function setRelatedListProperties($relatedListDetails)
    {
        $this->setModule($relatedListDetails['module']);
        $this->setDisplaylabel($relatedListDetails['display_label']);
        $this->setId($relatedListDetails['id']);
        $this->setName($relatedListDetails['name']);
        $this->setType($relatedListDetails['type']);
        $this->setHref($relatedListDetails['href']);
        $this->setVisible(isset($relatedListDetails['visible']) ? (boolean) $relatedListDetails['visible'] : false);
        return $this;
    }
}