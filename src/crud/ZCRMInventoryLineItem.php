<?php

namespace ZCRM\crud;


/**
 * This class is to maintain the details of inventory line item
 * @author sumanth-3058
 *
 */
class ZCRMInventoryLineItem
{
	private $id=null;
	private $product=null;
	private $listPrice=null;
	private $quantity=null;
	private $description=null;
	private $total=null;
	private $discount=null;
	private $discountPercentage=null;
	private $totalAfterDiscount=null;
	private $taxAmount=null;
	private $netTotal=null;
	private $deleteFlag = false;
	private $lineTax = array();
	private function __construct($param)
	{
		if($param instanceof ZCRMRecord)
		{
			$this->product=$param;
		}
		else
		{
			$this->id=$param;
		}
	}
	
	public static function getInstance($param)
	{
		return new ZCRMInventoryLineItem($param);
	}
	

    /**
     * id
     * @return Long
     */
    public function getId(){
        return $this->id;
    }

    /**
     * id
     * @param Long $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * product
     * @return ZCRMRecord
     */
    public function getProduct(){
        return $this->product;
    }

    /**
     * product
     * @param ZCRMRecord $product
     */
    public function setProduct($product){
        $this->product = $product;
    }

    /**
     * listPrice
     * @return Double
     */
    public function getListPrice(){
        return $this->listPrice;
    }

    /**
     * listPrice
     * @param Double $listPrice
     */
    public function setListPrice($listPrice){
        $this->listPrice = $listPrice;
    }

    /**
     * quantity
     * @return Double
     */
    public function getQuantity(){
        return $this->quantity;
    }

    /**
     * quantity
     * @param Double $quantity
     */
    public function setQuantity($quantity){
        $this->quantity = $quantity;
    }

    /**
     * description
     * @return String
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * description
     * @param String $description
     */
    public function setDescription($description){
        $this->description = $description;
    }

    /**
     * total
     * @return Double
     */
    public function getTotal(){
        return $this->total;
    }

    /**
     * total
     * @param Double $total
     */
    public function setTotal($total){
        $this->total = $total;
    }

    /**
     * discount
     * @return Double
     */
    public function getDiscount(){
        return $this->discount;
    }

    /**
     * discount
     * @param Double $discount
     */
    public function setDiscount($discount){
        $this->discount = $discount;
    }

    /**
     * discountPercentage
     * @return Double
     */
    public function getDiscountPercentage(){
        return $this->discountPercentage;
    }

    /**
     * discountPercentage
     * @param Double $discountPercentage
     */
    public function setDiscountPercentage($discountPercentage){
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * totalAfterDiscount
     * @return Double
     */
    public function getTotalAfterDiscount(){
        return $this->totalAfterDiscount;
    }

    /**
     * totalAfterDiscount
     * @param Double $totalAfterDiscount
     */
    public function setTotalAfterDiscount($totalAfterDiscount){
        $this->totalAfterDiscount = $totalAfterDiscount;
    }

    /**
     * taxAmount
     * @return Double
     */
    public function getTaxAmount(){
        return $this->taxAmount;
    }

    /**
     * taxAmount
     * @param Double $taxAmount
     */
    public function setTaxAmount($taxAmount){
        $this->taxAmount = $taxAmount;
    }

    /**
     * netTotal
     * @return Double
     */
    public function getNetTotal(){
        return $this->netTotal;
    }

    /**
     * netTotal
     * @param Double $netTotal
     */
    public function setNetTotal($netTotal){
        $this->netTotal = $netTotal;
    }

    /**
     * deleteFlag
     * @return Boolean
     */
    public function getDeleteFlag(){
        return (boolean)$this->deleteFlag;
    }

    /**
     * deleteFlag
     * @param Boolean $deleteFlag
     */
    public function setDeleteFlag($deleteFlag){
        $this->deleteFlag = $deleteFlag;
    }

    /**
     * lineTax
     * @return Array of ZCRMTax
     */
    public function getLineTax(){
        return $this->lineTax;
    }

    /**
     * lineTax
     * @param Array of ZCRMTax $lineTax
     */
    public function addLineTax($lineTax){
    	array_push($this->lineTax,$lineTax);
    }

}
?>