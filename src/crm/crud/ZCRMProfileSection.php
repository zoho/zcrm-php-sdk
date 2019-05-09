<?php
namespace zcrmsdk\crm\crud;

class ZCRMProfileSection
{
    
    /**
     * name of the profile section
     *
     * @var string
     */
    private $name;
    
    /**
     * categories of profile
     *
     * @var array
     */
    private $categories = array();
    
    /**
     * constructor to assign the name to the profile section
     *
     * @param string $name name of the section
     */
    private function __construct($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the instance of the profile section
     *
     * @param string $name name of the profile section
     * @return ZCRMProfileSection instance of the ZCRMProfileSection
     */
    public static function getInstance($name)
    {
        return new ZCRMProfileSection($name);
    }
    
    /**
     * method to get the name of profile section
     *
     * @return string the name of the profile section
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * method to set the name of profile section
     *
     * @param array $name the name of the profile section
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * method to get the categories to the profile section
     *
     * @return array array of ZCRMProfileCategory class instances
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    /**
     * method to add the category to the profile section
     *
     * @param array $categoryIns ZCRMProfileCategory class instance
     */
    public function addCategory($categoryIns)
    {
        array_push($this->categories, $categoryIns);
    }
}