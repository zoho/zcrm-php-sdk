<?php

namespace ZCRM\api\handler;

use ZCRM\crud\ZCRMInventoryLineItem;
use ZCRM\crud\ZCRMRecord;
use ZCRMTax;
use ZCRM\exception\APIExceptionHandler;
use ZCRM\common\APIConstants;
use ZCRM\api\APIRequest;
use ZCRM\crud\ZCRMPriceBookPricing;
use ZCRM\crud\ZCRMEventParticipant;
use ZCRM\users\ZCRMUser;


class EntityAPIHandler extends APIHandler {

  protected $record = NULL;

  private function __construct($zcrmrecord) {
    $this->record = $zcrmrecord;
  }

  public static function getInstance($zcrmrecord) {
    return new EntityAPIHandler($zcrmrecord);
  }

  public function getRecord() {
    try {
      $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
      $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId();
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

  /**
   * @return \ZCRM\api\response\APIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function createRecord() {
    try {
      $inputJSON = self::getZCRMRecordAsJSON();
      $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
      $this->urlPath = $this->record->getModuleApiName();
      $this->addHeader("Content-Type", "application/json");
      $this->requestBody = json_encode(array_filter(["data" => [$inputJSON]]));
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

  /**
   * @return \ZCRM\api\response\APIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function updateRecord() {
    try {
      $inputJSON = self::getZCRMRecordAsJSON();
      $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
      $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId();
      $this->addHeader("Content-Type", "application/json");
      $this->requestBody = json_encode(array_filter(["data" => [$inputJSON]]));;

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

  /**
   * @return \ZCRM\api\response\APIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function deleteRecord() {
    try {
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


  /**
   * @param $potentialRecord
   * @param $assignToUser
   *
   * @return array
   * @throws \ZCRM\exception\ZCRMException
   */
  public function convertRecord($potentialRecord, $assignToUser) {
    try {
      $this->requestMethod = APIConstants::REQUEST_METHOD_POST;
      $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/actions/convert";
      $this->addHeader("Content-Type", "application/json");

      $dataObject = [];
      if ($assignToUser != NULL) {
        $dataObject['assign_to'] = $assignToUser->getId();
      }
      if ($potentialRecord != NULL) {
        $dataObject['Deals'] = self::getInstance($potentialRecord)
          ->getZCRMRecordAsJSON();
      }
      if (sizeof($dataObject) > 0) {
        $dataArray = json_encode([APIConstants::DATA => [array_filter($dataObject)]]);
      }
      else {
        $dataArray = json_encode([APIConstants::DATA => [new ArrayObject()]]);
      }
      $this->requestBody = $dataArray;

      $responseInstance = APIRequest::getInstance($this)->getAPIResponse();

      $responseJSON = $responseInstance->getResponseJSON();


      //Process Response JSON
      $convertedIdsJSON = $responseJSON[APIConstants::DATA][0];
      $convertedIds = [];
      $convertedIds[APIConstants::CONTACTS] = isset($convertedIdsJSON[APIConstants::CONTACTS]) ? $convertedIdsJSON[APIConstants::CONTACTS] : NULL;
      if (isset($convertedIdsJSON[APIConstants::ACCOUNTS]) && $convertedIdsJSON[APIConstants::ACCOUNTS] != NULL) {
        $convertedIds[APIConstants::ACCOUNTS] = $convertedIdsJSON[APIConstants::ACCOUNTS];
      }
      if (isset($convertedIdsJSON[APIConstants::DEALS]) && $convertedIdsJSON[APIConstants::DEALS] != NULL) {
        $convertedIds[APIConstants::DEALS] = $convertedIdsJSON[APIConstants::DEALS];
      }

      return $convertedIds;
    } catch (ZCRMException $exception) {
      APIExceptionHandler::logException($exception);
      throw $exception;
    }
  }

  /**
   * @param $filePath
   *
   * @return \ZCRM\api\response\APIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function uploadPhoto($filePath) {
    try {
      $fileContent = file_get_contents($filePath);
      $filePathArray = explode('/', $filePath);
      $fileName = $filePathArray[sizeof($filePathArray) - 1];
      if (function_exists('curl_file_create')) { // php 5.6+
        $cFile = curl_file_create($filePath);
      }
      else { //
        $cFile = '@' . realpath($filePath);
      }
      $post = ['file' => $cFile];

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

  /**
   * @return APIRequest
   * @throws \ZCRM\exception\ZCRMException
   */
  public function downloadPhoto() {
    try {
      $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
      $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/photo";

      return APIRequest::getInstance($this)->downloadFile();
    } catch (ZCRMException $exception) {
      APIExceptionHandler::logException($exception);
      throw $exception;
    }
  }

  /**
   * @return \ZCRM\api\response\APIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function deletePhoto() {
    try {
      $this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
      $this->urlPath = $this->record->getModuleApiName() . "/" . $this->record->getEntityId() . "/photo";

      return APIRequest::getInstance($this)->getAPIResponse();
    } catch (ZCRMException $exception) {
      APIExceptionHandler::logException($exception);
      throw $exception;
    }
  }

  /**
   * @return array
   */
  function getZCRMRecordAsJSON() {
    $recordJSON = [];
    $apiNameVsValues = $this->record->getData();
    if ($this->record->getOwner() != NULL) {
      $recordJSON["Owner"] = "" . $this->record->getOwner()->getId();
    }
    if ($this->record->getLayout() != NULL) {
      $recordJSON["Layout"] = "" . $this->record->getLayout()->getId();
    }
    foreach ($apiNameVsValues as $key => $value) {
      if ($value instanceof ZCRMRecord) {
        $value = "" . $value->getEntityId();
      }
      else {
        if ($value instanceof ZCRMUser) {
          $value = "" . $value->getId();
        }
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
      $recordJSON["Tax"] = self::getTaxListAsJSON();
    }
    return array_filter($recordJSON);
  }

  /**
   * @return array
   */
  public function getTaxListAsJSON() {
    $taxes = [];
    $taxList = $this->record->getTaxList();
    foreach ($taxList as $taxIns) {
      array_push($taxes, $taxIns->getTaxName());
    }
    return $taxes;
  }

  /**
   * @return array
   */
  public function getPriceDetailsAsJSONArray() {
    $priceDetailsArr = [];
    $priceDetailsList = $this->record->getPriceDetails();
    foreach ($priceDetailsList as $priceDetailIns) {
      array_push($priceDetailsArr, self::getZCRMPriceDetailAsJSON($priceDetailIns));
    }
    return $priceDetailsArr;
  }

  /**
   * @param ZCRMPriceBookPricing $priceDetailIns
   *
   * @return array
   */
  public function getZCRMPriceDetailAsJSON(ZCRMPriceBookPricing $priceDetailIns) {
    $priceDetailJSON = [];
    if ($priceDetailIns->getId() != NULL) {
      $priceDetailJSON["id"] = $priceDetailIns->getId();
    }
    $priceDetailJSON["discount"] = $priceDetailIns->getDiscount();
    $priceDetailJSON["to_range"] = $priceDetailIns->getToRange();
    $priceDetailJSON["from_range"] = $priceDetailIns->getFromRange();
    return $priceDetailJSON;
  }

  /**
   * @return array
   */
  public function getParticipantsAsJSONArray() {
    $participantsArr = [];
    $participantsList = $this->record->getParticipants();
    foreach ($participantsList as $participantIns) {
      array_push($participantsArr, self::getZCRMParticipantAsJSON($participantIns));
    }
    return $participantsArr;
  }

  /**
   * @param ZCRMEventParticipant $participantIns
   *
   * @return array
   */
  public function getZCRMParticipantAsJSON(ZCRMEventParticipant $participantIns) {
    $participantJSON = [];
    $participantJSON["participant"] = "" . $participantIns->getId();
    $participantJSON["type"] = "" . $participantIns->getType();
    $participantJSON["name"] = "" . $participantIns->getName();
    $participantJSON["Email"] = "" . $participantIns->getEmail();
    $participantJSON["invited"] = (boolean) $participantIns->isInvited();
    $participantJSON["status"] = "" . $participantIns->getStatus();

    return $participantJSON;
  }

  /**
   * @param $lineItemsArray
   *
   * @return array
   */
  public function getLineItemJSON($lineItemsArray) {
    $lineItemsAsJSONArray = [];
    foreach ($lineItemsArray as $lineItem) {
      $lineItemData = [];
      if ($lineItem->getQuantity() == NULL) {
        throw new ZCRMException("Mandatory Field 'quantity' is missing.", APIConstants::RESPONSECODE_BAD_REQUEST);
      }
      if ($lineItem->getId() != NULL) {
        $lineItemData["id"] = "" . $lineItem->getId();
      }
      if ($lineItem->getProduct() != NULL) {
        $lineItemData["product"] = "" . $lineItem->getProduct()->getEntityId();
      }
      if ($lineItem->getDescription() != NULL) {
        $lineItemData["product_description"] = $lineItem->getDescription();
      }
      if ($lineItem->getListPrice() != NULL) {
        $lineItemData["list_price"] = $lineItem->getListPrice();
      }
      $lineItemData["quantity"] = $lineItem->getQuantity();
      /*
       *  Either discount percentage can be 0 or discount value can be 0. So if percentage is 0, set value and vice versa.
       *	If the intended discount is 0, then both percent and value will be 0. Hence setting either of this to 0, will be enough.
      */
      if ($lineItem->getDiscountPercentage() == NULL) {
        $lineItemData["Discount"] = $lineItem->getDiscount();
      }
      else {
        $lineItemData["Discount"] = $lineItem->getDiscountPercentage() . "%";
      }
      $lineTaxes = $lineItem->getLineTax();
      $lineTaxArray = [];
      foreach ($lineTaxes as $lineTaxInstance) {
        $tax = [];
        $tax['name'] = $lineTaxInstance->getTaxName();
        $tax['value'] = $lineTaxInstance->getValue();
        $tax['percentage'] = $lineTaxInstance->getPercentage();
        array_push($lineTaxArray, $tax);
      }
      $lineItemData['line_tax'] = $lineTaxArray;

      array_push($lineItemsAsJSONArray, array_filter($lineItemData));
    }
    return array_filter($lineItemsAsJSONArray);
  }

  /**
   * @param $recordDetails
   */
  public function setRecordProperties($recordDetails) {
    foreach ($recordDetails as $key => $value) {
      if ("id" == $key) {
        $this->record->setEntityId($value);
      }
      else {
        if ("Product_Details" == $key) {
          $this->setInventoryLineItems($value);
        }
        else {
          if ("Participants" == $key) {
            $this->setParticipants($value);
          }
          else {
            if ("Pricing_Details" == $key) {
              $this->setPriceDetails($value);
            }
            else {
              if ("Created_By" == $key) {
                $createdBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                $this->record->setCreatedBy($createdBy);
              }
              else {
                if ("Modified_By" == $key) {
                  $modifiedBy = ZCRMUser::getInstance($value["id"], $value["name"]);
                  $this->record->setModifiedBy($modifiedBy);
                }
                else {
                  if ("Created_Time" == $key) {
                    $this->record->setCreatedTime("" . $value);
                  }
                  else {
                    if ("Modified_Time" == $key) {
                      $this->record->setModifiedTime("" . $value);
                    }
                    else {
                      if ("Last_Activity_Time" == $key) {
                        $this->record->setLastActivityTime("" . $value);
                      }
                      else {
                        if ("Owner" == $key) {
                          $owner = ZCRMUser::getInstance($value["id"], $value["name"]);
                          $this->record->setOwner($owner);
                        }
                        else {
                          if ("Layout" == $key) {
                            $layout = NULL;
                            if ($value != NULL) {
                              $layout = ZCRMLayout::getInstance($value["id"]);
                              $layout->setName($value["name"]);
                            }
                            $this->record->setLayout($layout);
                          }
                          else {
                            if ("Handler" == $key && $value != NULL) {
                              $handler = ZCRMUser::getInstance($value["id"], $value["name"]);
                              $this->record->setFieldValue($key, $handler);
                            }
                            else {
                              if ("Tax" === $key && is_array($value)) {
                                foreach ($value as $taxName) {
                                  $taxIns = ZCRMTax::getInstance($taxName);
                                  $this->record->addTax($taxIns);
                                }
                              }
                              else {
                                if (substr($key, 0, 1) == "$") {
                                  $this->record->setProperty(str_replace('$', '', $key), $value);
                                }
                                else {
                                  if (is_array($value)) {
                                    if (isset($value["id"])) {
                                      $lookupRecord = ZCRMRecord::getInstance($key, isset($value["id"]) ? $value["id"] : 0);
                                      $lookupRecord->setLookupLabel(isset($value["name"]) ? $value["name"] : NULL);
                                      $this->record->setFieldValue($key, $lookupRecord);
                                    }
                                    else {
                                      $this->record->setFieldValue($key, $value);
                                    }

                                  }
                                  else {
                                    $this->record->setFieldValue($key, $value);
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  /**
   * @param $participants
   */
  private function setParticipants($participants) {
    foreach ($participants as $participantDetail) {
      $this->record->addParticipant(self::getZCRMParticipant($participantDetail));
    }
  }


  /**
   * @param $priceDetails
   */
  private function setPriceDetails($priceDetails) {
    foreach ($priceDetails as $priceDetail) {
      $this->record->addPriceDetail(self::getZCRMPriceDetail($priceDetail));
    }
  }

  /**
   * @param $participantDetail
   *
   * @return ZCRMEventParticipant
   */
  public function getZCRMParticipant($participantDetail) {
    $participant = ZCRMEventParticipant::getInstance($participantDetail['type'], $participantDetail['participant']);
    $participant->setName($participantDetail["name"]);
    $participant->setEmail($participantDetail["Email"]);
    $participant->setInvited((boolean) $participantDetail["invited"]);
    $participant->setStatus($participantDetail["status"]);

    return $participant;
  }

  /**
   * @param $priceDetails
   *
   * @return ZCRMPriceBookPricing
   */
  public function getZCRMPriceDetail($priceDetails) {
    $priceDetailIns = ZCRMPriceBookPricing::getInstance($priceDetails["id"]);
    $priceDetailIns->setDiscount((double) $priceDetails["discount"]);
    $priceDetailIns->setToRange((double) $priceDetails["to_range"]);
    $priceDetailIns->setFromRange((double) $priceDetails["from_range"]);

    return $priceDetailIns;
  }

  /**
   * @param $lineItems
   */
  public function setInventoryLineItems($lineItems) {
    foreach ($lineItems as $lineItem) {
      $this->record->addLineItem(self::getZCRMLineItemInstance($lineItem));
    }
  }

  /**
   * @param $lineItemDetails
   *
   * @return ZCRMInventoryLineItem
   */
  public function getZCRMLineItemInstance($lineItemDetails) {
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
    $lineItemInstance->setQuantity($lineItemDetails["quantity"]);
    $lineItemInstance->setListPrice($lineItemDetails["list_price"]);
    $lineItemInstance->setTotal($lineItemDetails["total"]);
    $lineItemInstance->setDiscount($lineItemDetails["Discount"]);
    $lineItemInstance->setTotalAfterDiscount($lineItemDetails["total_after_discount"]);
    $lineItemInstance->setTaxAmount($lineItemDetails["Tax"]);
    $lineTaxes = $lineItemDetails["line_tax"];
    foreach ($lineTaxes as $lineTax) {
      $taxInstance = ZCRMTax::getInstance($lineTax["name"]);
      $taxInstance->setPercentage($lineTax['percentage']);
      $taxInstance->setValue($lineTax['value']);
      $lineItemInstance->addLineTax($taxInstance);
    }
    $lineItemInstance->setNetTotal($lineItemDetails["net_total"]);

    return $lineItemInstance;
  }
}

?>