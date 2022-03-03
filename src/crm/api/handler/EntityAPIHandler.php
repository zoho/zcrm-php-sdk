<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMEventParticipant;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMLayout;
use zcrmsdk\crm\crud\ZCRMPriceBookPricing;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMTag;
use zcrmsdk\crm\crud\ZCRMTax;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

class EntityAPIHandler extends APIHandler
{
    
    protected $record = null;
    
    private function __construct($zcrmrecord)
    {
        $this->record = $zcrmrecord;
    }
    
    public static function getInstance($zcrmrecord)
    {
        return new EntityAPIHandler($zcrmrecord);
    }
    
    public function getRecord($param_map=array(),$header_map=array())
    {
        try {
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId();
            foreach ($param_map as $key => $value) {
                if($value!==null)$this->addParam($key, $value);
            }
            foreach ($header_map as $key => $value) {
                if($value!==null)$this->addHeader($key, $value);
            }
            
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $recordDetails = $responseInstance->getResponseJSON()['data'];
            self::setRecordProperties($recordDetails[0]);
            $responseInstance->setData($this->record);
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function createRecord($trigger, $lar_id,$process)
    {
        try {
            if ($this->record->getEntityId() != NULL) {
                throw new ZCRMException("Entity ID MUST be null for create operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $this->record->getModuleApiName();
            $this->addHeader("Content-Type", "application/json");
            $requestBodyObj = array();
            $dataArray = array();
            array_push($dataArray, self::getZCRMRecordAsJSON());
            $requestBodyObj["data"] = $dataArray;
            if ($trigger !== null && is_array($trigger)) {
                $requestBodyObj["trigger"] = $trigger;
            }
            if ($lar_id !== null) {
                $requestBodyObj["lar_id"] = $lar_id;
            }
            if($process !== null && is_array($process) ){
                $requestBodyObj["process"] =$process;
            }
            
            $this->requestBody = json_encode($requestBodyObj);
            
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseDataArray = $responseInstance->getResponseJSON()['data'];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData['details'];
            $this->record->setEntityId($reponseDetails['id']);
            $this->record->setCreatedTime($reponseDetails['Created_Time']);
            $createdBy = $reponseDetails['Created_By'];
            $this->record->setCreatedBy(ZCRMUser::getInstance($createdBy['id'], $createdBy['name']));
            $responseInstance->setData($this->record);
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function updateRecord($trigger,$process)
    {
        try {
            if ($this->record->getEntityId() == NULL) {
                throw new ZCRMException("Entity ID MUST not be null for update operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId();
            $this->addHeader("Content-Type", "application/json");
            $requestBodyObj = array();
            $dataArray = array();
            array_push($dataArray, self::getZCRMRecordAsJSON());
            $requestBodyObj["data"] = $dataArray;
            if ($trigger !== null && is_array($trigger)) {
                $requestBodyObj["trigger"] = $trigger;
            }
            if($process !== null && is_array($process) ){
                $requestBodyObj["process"] =$process;
            }
            
            $this->requestBody =json_encode( $requestBodyObj);
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            $responseDataArray = $responseInstance->getResponseJSON()['data'];
            $responseData = $responseDataArray[0];
            $reponseDetails = $responseData['details'];
            $this->record->setCreatedTime($reponseDetails['Created_Time']);
            $this->record->setModifiedTime($reponseDetails['Modified_Time']);
            $createdBy = $reponseDetails['Created_By'];
            $this->record->setCreatedBy(ZCRMUser::getInstance($createdBy['id'], $createdBy['name']));
            $modifiedBy = $reponseDetails['Modified_By'];
            $this->record->setModifiedBy(ZCRMUser::getInstance($modifiedBy['id'], $modifiedBy['name']));
            $responseInstance->setData($this->record);
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deleteRecord()
    {
        try {
            if ($this->record->getEntityId() == NULL) {
                throw new ZCRMException("Entity ID MUST not be null for delete operation.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId();
            $this->addHeader("Content-Type", "application/json");
            
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function convertRecord($potentialRecord, $details)
    {
        try {
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/actions/convert";
            $this->addHeader("Content-Type", "application/json");
            $dataObject = array();
            if($details!=NULL){
                foreach($details as $key=>$value){
                    if($key=="overwrite"){
                        $dataObject['overwrite']=$value;
                    }
                    if($key=="notify_lead_owner"){
                        $dataObject['notify_lead_owner']=$value;
                    }
                    if($key=="notify_new_entity_owner"){
                        $dataObject['notify_new_entity_owner']=$value;
                    }
                    if($key=="Accounts"){
                        $dataObject['Accounts']=$value;
                    }
                    if($key=="Contacts"){
                        $dataObject['Contacts']=$value;
                    }
                    if($key=="assign_to"){
                        $dataObject['assign_to']=$value;
                    }
                }
            }
            if ($potentialRecord != null) {
                $dataObject['Deals'] = self::getInstance($potentialRecord)->getZCRMRecordAsJSON();
            }
            if (sizeof($dataObject) > 0) {
                $dataArray = json_encode(array(
                    APIConstants::DATA => array(
                        array_filter($dataObject)
                    )
                ));
            } else {
                $dataArray = json_encode(array(
                    APIConstants::DATA => array(
                        new \ArrayObject()
                    )
                ));
            }
            $this->requestBody = $dataArray;
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            // Process Response JSON
            $convertedIdsJSON = $responseJSON[APIConstants::DATA][0];
            $convertedIds = array();
            $convertedIds[APIConstants::CONTACTS] = isset($convertedIdsJSON[APIConstants::CONTACTS]) ? $convertedIdsJSON[APIConstants::CONTACTS] : null;
            if (isset($convertedIdsJSON[APIConstants::ACCOUNTS]) && $convertedIdsJSON[APIConstants::ACCOUNTS] != null) {
                $convertedIds[APIConstants::ACCOUNTS] = $convertedIdsJSON[APIConstants::ACCOUNTS];
            }
            if (isset($convertedIdsJSON[APIConstants::DEALS]) && $convertedIdsJSON[APIConstants::DEALS] != null) {
                $convertedIds[APIConstants::DEALS] = $convertedIdsJSON[APIConstants::DEALS];
            }
            return $convertedIds;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function uploadPhoto($filePath)
    {
        try {
            if (function_exists('curl_file_create')) { // php 5.6+
                $cFile = curl_file_create($filePath);
            } else { //
                $cFile = '@' . realpath($filePath);
            }
            $post = array(
                'file' => $cFile
            );
            $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/photo";
            $this->requestBody = $post;
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function downloadPhoto()
    {
        try {
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/photo";
            return APIRequest::getInstance($this)->downloadFile();
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function deletePhoto()
    {
        try {
            $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
            $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/photo";
            return APIRequest::getInstance($this)->getAPIResponse();
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getZCRMRecordAsJSON()
    {
        $recordJSON = array();
        $apiNameVsValues = $this->record->getData();
        if ($this->record->getOwner() != null) {
            $recordJSON["Owner"] = "" . $this->record->getOwner()->getId();
        }
        if ($this->record->getLayout() != null) {
            $recordJSON["Layout"] = "" . $this->record->getLayout()->getId();
        }
        foreach ($apiNameVsValues as $key => $value) {
            if ($value instanceof ZCRMRecord) {
                $value = "" . $value->getEntityId();
            } else if ($value instanceof ZCRMUser) {
                $value = "" . $value->getId();
            }
            $recordJSON[$key] = $value;
        }
        if (sizeof($this->record->getLineItems()) > 0) {
            $recordJSON["Product_Details"] = self::getLineItemJSON($this->record->getLineItems());
        }
        if (sizeof($this->record->getParticipants()) > 0) {
            $recordJSON["Participants"] = self::getParticipantsAsJSONArray();
        }
        if (sizeof($this->record->getPriceDetails()) > 0) {
            $recordJSON["Pricing_Details"] = self::getPriceDetailsAsJSONArray();
        }
        if (sizeof($this->record->getTaxList()) > 0) {
            if ($this->record->getModuleApiName() == "Products")
                $key = "Tax";
                else
                    $key = "\$line_tax";
                    
                    $recordJSON[$key] = self::getTaxListAsJSON($key);
        }
        
        return $recordJSON;
    }
    
    public function getTaxListAsJSON($key)
    {
        $taxes = array();
        $taxList = $this->record->getTaxList();
        if ($key == "Tax") {
            foreach ($taxList as $taxIns) {
                array_push($taxes, $taxIns->getTaxName());
            }
        } else {
            
            foreach ($taxList as $lineTaxInstance) {
                
                $tax = array();
                $tax['name'] = $lineTaxInstance->getTaxName();
                $tax['value'] = $lineTaxInstance->getValue();
                $tax['percentage'] = $lineTaxInstance->getPercentage();
                array_push($taxes, $tax);
            }
        }
        
        return $taxes;
    }
    
    public function getPriceDetailsAsJSONArray()
    {
        $priceDetailsArr = array();
        $priceDetailsList = $this->record->getPriceDetails();
        foreach ($priceDetailsList as $priceDetailIns) {
            array_push($priceDetailsArr, self::getZCRMPriceDetailAsJSON($priceDetailIns));
        }
        return $priceDetailsArr;
    }
    
    public function getZCRMPriceDetailAsJSON(ZCRMPriceBookPricing $priceDetailIns)
    {
        $priceDetailJSON = array();
        if ($priceDetailIns->getId() != null) {
            $priceDetailJSON["id"] = $priceDetailIns->getId();
        }
        $priceDetailJSON["discount"] = $priceDetailIns->getDiscount();
        $priceDetailJSON["to_range"] = $priceDetailIns->getToRange();
        $priceDetailJSON["from_range"] = $priceDetailIns->getFromRange();
        return $priceDetailJSON;
    }
    
    public function getParticipantsAsJSONArray()
    {
        $participantsArr = array();
        $participantsList = $this->record->getParticipants();
        foreach ($participantsList as $participantIns) {
            array_push($participantsArr, self::getZCRMParticipantAsJSON($participantIns));
        }
        return $participantsArr;
    }
    
    public function getZCRMParticipantAsJSON(ZCRMEventParticipant $participantIns)
    {
        $participantJSON = array();
        $participantJSON["participant"] = "" . $participantIns->getId();
        $participantJSON["type"] = "" . $participantIns->getType();
        $participantJSON["name"] = "" . $participantIns->getName();
        $participantJSON["Email"] = "" . $participantIns->getEmail();
        $participantJSON["invited"] = (boolean) $participantIns->isInvited();
        $participantJSON["status"] = "" . $participantIns->getStatus();
        
        return $participantJSON;
    }
    
    public function getLineItemJSON($lineItemsArray)
    {
        $lineItemsAsJSONArray = array();
        foreach ($lineItemsArray as $lineItem) {
            $lineItemData = array();
            if ($lineItem->getQuantity() == null) {
                throw new ZCRMException("Mandatory Field 'quantity' is missing.", APIConstants::RESPONSECODE_BAD_REQUEST);
            }
            if ($lineItem->getId() != null) {
                $lineItemData["id"] = "" . $lineItem->getId();
            }
            if ($lineItem->getProduct() != null) {
                $lineItemData["product"] = "" . $lineItem->getProduct()->getEntityId();
            }
            if ($lineItem->getDescription() != null) {
                $lineItemData["product_description"] = $lineItem->getDescription();
            }
            if ($lineItem->getListPrice() !== null) {
                $lineItemData["list_price"] = $lineItem->getListPrice();
            }
            $lineItemData["quantity"] = $lineItem->getQuantity();
            /*
             * Either discount percentage can be 0 or discount value can be 0. So if percentage is 0, set value and vice versa.
             * If the intended discount is 0, then both percent and value will be 0. Hence setting either of this to 0, will be enough.
             */
            if ($lineItem->getDiscountPercentage() == null) {
                $lineItemData["Discount"] = $lineItem->getDiscount();
            } else {
                $lineItemData["Discount"] = $lineItem->getDiscountPercentage() . "%";
            }
            $lineTaxes = $lineItem->getLineTax();
            $lineTaxArray = array();
            foreach ($lineTaxes as $lineTaxInstance) {
                $tax = array();
                $tax['name'] = $lineTaxInstance->getTaxName();
                $tax['value'] = $lineTaxInstance->getValue();
                $tax['percentage'] = $lineTaxInstance->getPercentage();
                array_push($lineTaxArray, $tax);
            }
            $lineItemData['line_tax'] = $lineTaxArray;
            
            array_push($lineItemsAsJSONArray, array_filter($lineItemData, 'zcrmsdk\crm\utility\CommonUtil::removeNullValuesAlone'));
        }
        return array_filter($lineItemsAsJSONArray);
    }
    
    public function setRecordProperties($recordDetails)
    {
        foreach ($recordDetails as $key => $value) {
            if ("id" == $key) {
                $this->record->setEntityId($value);
            } else if ("Product_Details" == $key && in_array($this->record->getModuleApiName(), APIConstants::INVENTORY_MODULES)) {
                $this->setInventoryLineItems($value);
            } else if ("Participants" == $key && $this->record->getModuleApiName() == "Events") {
                $this->setParticipants($value);
            } else if ("Pricing_Details" == $key && $this->record->getModuleApiName() == "Price_Books") {
                $this->setPriceDetails($value);
            } else if ("Created_By" == $key) {
                $createdBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setCreatedBy($createdBy);
            } else if ("Modified_By" == $key) {
                $modifiedBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setModifiedBy($modifiedBy);
            } else if ("Created_Time" == $key) {
                $this->record->setCreatedTime("" . $value);
            } else if ("Modified_Time" == $key) {
                $this->record->setModifiedTime("" . $value);
            } else if ("Last_Activity_Time" == $key) {
                $this->record->setLastActivityTime("" . $value);
            } else if ("Owner" == $key) {
                $owner = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setOwner($owner);
            } else if ("Layout" == $key) {
                $layout = null;
                if ($value != null) {
                    $layout = ZCRMLayout::getInstance($value["id"]);
                    $layout->setName($value["name"]);
                }
                $this->record->setLayout($layout);
            } else if ("Handler" == $key && $value != null) {
                $handler = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setFieldValue($key, $handler);
            } else if ("Tax" === $key && is_array($value)) {
                foreach ($value as $taxName) {
                    $taxIns = ZCRMTax::getInstance($taxName);
                    $this->record->addTax($taxIns);
                }
            }else if ("Tag" === $key && is_array($value)) {
                $tags = array();
                foreach ($value as $tag)
                {
                    $tagIns = ZCRMTag::getInstance($tag["id"], $tag["name"]);
                    array_push($tags,$tagIns);
                }
                $this->record->setTags($tags);
            }else if ("tags" === $key && is_array($value))
            {
                $this->record->setTagNames($value);
            }
            else if ("\$line_tax" === $key && is_array($value)) {
                foreach ($value as $lineTax) {
                    $taxIns = ZCRMTax::getInstance($lineTax["name"]);
                    $taxIns->setPercentage($lineTax["percentage"]);
                    $taxIns->setValue($lineTax["value"]);
                    $this->record->addTax($taxIns);
                }
            } else if (substr($key, 0, 1) == "$") {
                $this->record->setProperty(str_replace('$', '', $key), $value);
            } else if (is_array($value)) {
                if (isset($value["id"])) {
                    $lookupRecord = ZCRMRecord::getInstance($key, isset($value["id"]) ? $value["id"] : "0");
                    $lookupRecord->setLookupLabel(isset($value["name"]) ? $value["name"] : null);
                    $this->record->setFieldValue($key, $lookupRecord);
                } else {
                    $this->record->setFieldValue($key, $value);
                }
            } else {
                $this->record->setFieldValue($key, $value);
            }
        }
    }
    
    private function setParticipants($participants)
    {
        foreach ($participants as $participantDetail) {
            $this->record->addParticipant(self::getZCRMParticipant($participantDetail));
        }
    }
    
    private function setPriceDetails($priceDetails)
    {
        foreach ($priceDetails as $priceDetail) {
            $this->record->addPriceDetail(self::getZCRMPriceDetail($priceDetail));
        }
    }
    
    public function getZCRMParticipant($participantDetail)
    {
        $id = null;
        $email = null;
        if(array_key_exists("Email", $participantDetail)){
            $email = $participantDetail["Email"];
            $id = $participantDetail['participant'];
        }
        else{
            $email =$participantDetail['participant'];
        }
        $participant = ZCRMEventParticipant::getInstance($participantDetail['type'], $id);
        $participant->setName($participantDetail["name"]);
        $participant->setEmail($email);
        $participant->setInvited((boolean) $participantDetail["invited"]);
        $participant->setStatus($participantDetail["status"]);
        
        return $participant;
    }
    
    public function getZCRMPriceDetail($priceDetails)
    {
        $priceDetailIns = ZCRMPriceBookPricing::getInstance($priceDetails["id"]);
        $priceDetailIns->setDiscount((double) $priceDetails["discount"]);
        $priceDetailIns->setToRange((double) $priceDetails["to_range"]);
        $priceDetailIns->setFromRange((double) $priceDetails["from_range"]);
        
        return $priceDetailIns;
    }
    
    public function setInventoryLineItems($lineItems)
    {
        foreach ($lineItems as $lineItem) {
            $this->record->addLineItem(self::getZCRMLineItemInstance($lineItem));
        }
    }
    
    public function getZCRMLineItemInstance($lineItemDetails)
    {
        $productDetails = $lineItemDetails["product"];
        $lineItemId = $lineItemDetails["id"];
        $lineItemInstance = ZCRMInventoryLineItem::getInstance($lineItemId);
        $product = ZCRMRecord::getInstance("Products", $productDetails["id"]);
        $product->setLookupLabel($productDetails["name"]);
        if (isset($productDetails['Product_Code'])) {
            $product->setFieldValue('Product_Code', $productDetails['Product_Code']);
        }
        $lineItemInstance->setProduct($product);
        $lineItemInstance->setDescription($lineItemDetails["product_description"]);
        $lineItemInstance->setQuantity($lineItemDetails["quantity"] + 0);
        $lineItemInstance->setListPrice($lineItemDetails["list_price"] + 0);
        $lineItemInstance->setTotal($lineItemDetails["total"] + 0);
        $lineItemInstance->setDiscount($lineItemDetails["Discount"] + 0);
        $lineItemInstance->setTotalAfterDiscount($lineItemDetails["total_after_discount"] + 0);
        $lineItemInstance->setTaxAmount($lineItemDetails["Tax"] + 0);
        $lineTaxes = $lineItemDetails["line_tax"];
        foreach ($lineTaxes as $lineTax) {
            $taxInstance = ZCRMTax::getInstance($lineTax["name"]);
            $taxInstance->setPercentage($lineTax['percentage']);
            $taxInstance->setValue($lineTax['value'] + 0);
            $lineItemInstance->addLineTax($taxInstance);
        }
        $lineItemInstance->setNetTotal($lineItemDetails["net_total"] + 0);
        
        return $lineItemInstance;
    }
}