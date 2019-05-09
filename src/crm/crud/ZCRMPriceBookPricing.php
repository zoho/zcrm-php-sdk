<?php
namespace zcrmsdk\crm\crud;

class ZCRMPriceBookPricing
{
    
    /**
     * id of the price booking price
     *
     * @var string
     */
    private $id = null;
    
    /**
     * range upper limit
     *
     * @var double
     */
    private $toRange = null;
    
    /**
     * range upper limit
     *
     * @var double
     */
    private $fromRange = null;
    
    /**
     * discount offered
     *
     * @var double
     */
    private $discount = null;
    
    /**
     * constructor to assign price book pricing id
     *
     * @param string $id price book pricing id
     */
    private function __construct($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the instance of the price book pricing
     *
     * @param string $id price book pricing id
     * @return ZCRMPriceBookPricing instance of the ZCRMPriceBookPricing class
     */
    public static function getInstance($id)
    {
        return new ZCRMPriceBookPricing($id);
    }
    
    /**
     * method to get the price book pricing id
     *
     * @return string price book pricing id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * method to set the price book pricing id
     *
     * @param string $id price book pricing id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * method to get the upper limit of price book pricing
     *
     * @return Double the upper limit of price book pricing
     */
    public function getToRange()
    {
        return $this->toRange;
    }
    
    /**
     * method to set the upper limit of price book pricing
     *
     * @param Double $toRange upper limit of price book pricing
     */
    public function setToRange($toRange)
    {
        $this->toRange = $toRange;
    }
    
    /**
     * method to get the lower limit of price book pricing
     *
     * @return Double the upper limit of price book pricing
     */
    public function getFromRange()
    {
        return $this->fromRange;
    }
    
    /**
     * method to set the lower limit of price book pricing
     *
     * @param Double $fromRange lower limit of price book pricing
     */
    public function setFromRange($fromRange)
    {
        $this->fromRange = $fromRange;
    }
    
    /**
     * method to get the discount of the price book pricing
     *
     * @return Double the discount of the price book pricing
     */
    public function getDiscount()
    {
        return $this->discount;
    }
    
    /**
     * method to set the discount of the price book pricing
     *
     * @param Double $discount the discount of the price book pricing
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }
}