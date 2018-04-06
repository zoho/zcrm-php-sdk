<?php

namespace ZCRM\crud;

class ZCRMProfileSection {
    private $name;
    private $categories = array();

    private function __construct($name) {
        $this->name = $name;
    }

    public static function getInstance($name) {
        return new ZCRMProfileSection($name);
    }
    
    /**
     * name
     * @return array
     */
    public function getName() {
        return $this->name;
    }

    /**
     * name
     * @param array $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * categories
     * @return array of ZCRMProfileCategory instances
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * categories
     * @param array $categories
     */
    public function addCategory($categoryIns) {
        array_push($this->categories, $categoryIns);
    }

}

?>