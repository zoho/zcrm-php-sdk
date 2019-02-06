<?php

namespace ZCRM\crud;

class ZCRMPriceBookPricing {
    private $id = null;
    private $toRange = null;
    private $fromRange = null;
    private $discount = null;

    private function __construct($id) {
        $this->id = $id;
    }

    public static function getInstance($id) {
        return new ZCRMPriceBookPricing($id);
    }

    /**
     * id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * id
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * toRange
     * @return Double
     */
    public function getToRange() {
        return $this->toRange;
    }

    /**
     * toRange
     * @param Double $toRange
     */
    public function setToRange($toRange) {
        $this->toRange = $toRange;
    }

    /**
     * fromRange
     * @return Double
     */
    public function getFromRange() {
        return $this->fromRange;
    }

    /**
     * fromRange
     * @param Double $fromRange
     */
    public function setFromRange($fromRange) {
        $this->fromRange = $fromRange;
    }

    /**
     * discount
     * @return Double
     */
    public function getDiscount() {
        return $this->discount;
    }

    /**
     * discount
     * @param Double $discount
     */
    public function setDiscount($discount) {
        $this->discount = $discount;
    }

}

?>
