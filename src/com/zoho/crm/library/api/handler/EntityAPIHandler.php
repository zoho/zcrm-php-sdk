<?php

require_once 'APIHandler.php';
require_once realpath(__DIR__.'/../../crud/ZCRMInventoryLineItem.php');
require_once realpath(__DIR__.'/../../crud/ZCRMRecord.php');
require_once realpath(__DIR__.'/../../crud/ZCRMTax.php');
require_once realpath(__DIR__.'/../../exception/APIExceptionHandler.php');
require_once realpath(__DIR__.'/../../common/APIConstants.php');
require_once realpath(__DIR__.'/../APIRequest.php');
require_once realpath(__DIR__.'/../../crud/ZCRMPriceBookPricing.php');
require_once realpath(__DIR__.'/../../crud/ZCRMEventParticipant.php');

class EntityAPIHandler extends APIHandler
{
	protected $record = null;

	private function __construct($zcrmrecord) {
		$this->record = $zcrmrecord;
	}

	public static function getInstance($zcrmrecord) {
		return new EntityAPIHandler($zcrmrecord);
	}

	public function getRecord() {
		try {
			$this->requestMethod = APIConstants::REQUEST_METHOD_GET;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId();
			$this->addHeader('Content-Type', 'application/json');
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

	public function createRecord() {
		try {
			$inputJSON = self::getZCRMRecordAsJSON();
			$this->requestMethod = APIConstants::REQUEST_METHOD_POST;
			$this->urlPath = $this->record->getModuleApiName();
			$this->addHeader('Content-Type', 'application/json');
			$this->requestBody = json_encode(array_filter(array('data' => array($inputJSON))));
			$responseInstance = APIRequest::getInstance($this)->getAPIResponse();
			$responseDataArray = $responseInstance->getResponseJSON()['data'];
			$responseData = $responseDataArray[0];
			$reponseDetails = $responseData['details'];
			$this->record->setEntityId($reponseDetails['id']);
			$this->record->setCreatedTime($reponseDetails['Created_Time']);
			$createdBy = $reponseDetails['Created_By'];
			$this->record->setCreatedBy(ZCRMUser::getInstance((int)$createdBy['id'], $createdBy['name']));
			$responseInstance->setData($this->record);
			return $responseInstance;
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	public function updateRecord() {
		try {
			$inputJSON = self::getZCRMRecordAsJSON();
			$this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId();
			$this->addHeader('Content-Type', 'application/json');
			$this->requestBody = json_encode(array_filter(array('data' => array($inputJSON))));

			$responseInstance = APIRequest::getInstance($this)->getAPIResponse();

			$responseDataArray = $responseInstance->getResponseJSON()['data'];
			$responseData = $responseDataArray[0];
			$reponseDetails = $responseData['details'];
			$this->record->setCreatedTime($reponseDetails['Created_Time']);
			$this->record->setModifiedTime($reponseDetails['Modified_Time']);
			$createdBy = $reponseDetails['Created_By'];
			$this->record->setCreatedBy(ZCRMUser::getInstance((int)$createdBy['id'], $createdBy['name']));
			$modifiedBy = $reponseDetails['Modified_By'];
			$this->record->setModifiedBy(ZCRMUser::getInstance((int)$modifiedBy['id'], $modifiedBy['name']));
			$responseInstance->setData($this->record);

			return $responseInstance;
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	public function deleteRecord() {
		try {
			$this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId();
			$this->addHeader('Content-Type', 'application/json');

			$responseInstance = APIRequest::getInstance($this)->getAPIResponse();

			return $responseInstance;
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	public function convertRecord($potentialRecord, $assignToUser) {
		try {
			$this->requestMethod = APIConstants::REQUEST_METHOD_POST;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId().'/actions/convert';
			$this->addHeader('Content-Type', 'application/json');

			$dataObject = array();
			if ($assignToUser != null) {
				$dataObject['assign_to'] = $assignToUser->getId();
			}
			if ($potentialRecord != null) {
				$dataObject['Deals'] = self::getInstance($potentialRecord)->getZCRMRecordAsJSON();
			}
			if (sizeof($dataObject) > 0) {
				$dataArray = json_encode(array(APIConstants::DATA => array(array_filter($dataObject))));
			} else {
				$dataArray = json_encode(array(APIConstants::DATA => array(new ArrayObject())));
			}
			$this->requestBody = $dataArray;

			$responseInstance = APIRequest::getInstance($this)->getAPIResponse();

			$responseJSON = $responseInstance->getResponseJSON();

			//Process Response JSON
			$convertedIdsJSON = $responseJSON[APIConstants::DATA][0];
			$convertedIds = array();
			$convertedIds[APIConstants::CONTACTS] = isset($convertedIdsJSON[APIConstants::CONTACTS])
			                                      ? $convertedIdsJSON[APIConstants::CONTACTS] + 0
			                                      : null;
			if (isset($convertedIdsJSON[APIConstants::ACCOUNTS]) && $convertedIdsJSON[APIConstants::ACCOUNTS] != null) {
				$convertedIds[APIConstants::ACCOUNTS] = $convertedIdsJSON[APIConstants::ACCOUNTS] + 0;
			}
			if (isset($convertedIdsJSON[APIConstants::DEALS]) && $convertedIdsJSON[APIConstants::DEALS] != null) {
				$convertedIds[APIConstants::DEALS] = $convertedIdsJSON[APIConstants::DEALS] + 0;
			}

			return $convertedIds;
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	public function uploadPhoto($filePath) {
		try {
			$fileContent = file_get_contents($filePath);
			$filePathArray = explode('/', $filePath);
			$fileName = $filePathArray[sizeof($filePathArray)-1];
			if (function_exists('curl_file_create')) { // php 5.6+
				$cFile = curl_file_create($filePath);
			} else { //
				$cFile = '@'.realpath($filePath);
			}
			$post = array('file' => $cFile);

			$this->requestMethod = APIConstants::REQUEST_METHOD_POST;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId().'/photo';
			$this->requestBody = $post;

			$responseInstance=APIRequest::getInstance($this)->getAPIResponse();

			return $responseInstance;
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	public function downloadPhoto() {
		try {
			$this->requestMethod = APIConstants::REQUEST_METHOD_GET;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId().'/photo';

			return APIRequest::getInstance($this)->downloadFile();
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	public function deletePhoto() {
		try {
			$this->requestMethod = APIConstants::REQUEST_METHOD_DELETE;
			$this->urlPath = $this->record->getModuleApiName().'/'.$this->record->getEntityId().'/photo';

			return APIRequest::getInstance($this)->getAPIResponse();
		} catch (ZCRMException $exception) {
			APIExceptionHandler::logException($exception);
			throw $exception;
		}
	}

	function getZCRMRecordAsJSON() {
		$recordJSON = array();
		$apiNameVsValues = $this->record->getData();
		if ($this->record->getOwner() != null) {
			$recordJSON["Owner"]="".$this->record->getOwner()->getId();
		}
		if ($this->record->getLayout()!=null) {
			$recordJSON["Layout"]="".$this->record->getLayout()->getId();
		}
		foreach ($apiNameVsValues as $key => $value) {
			if ($value instanceof ZCRMRecord) {
				$value = (string)$value->getEntityId();
			} elseif ($value instanceof ZCRMUser) {
				$value = (string)$value->getId();
			}
			$recordJSON[$key] = $value;
		}
		if (sizeof($this->record->getLineItems()) > 0) {
			$recordJSON['Product_Details'] = self::getLineItemJSON($this->record->getLineItems());
		}
		if (sizeof($this->record->getParticipants()) > 0) {
			$recordJSON['Participants'] = self::getParticipantsAsJSONArray();
		}
		if (sizeof($this->record->getPriceDetails()) > 0) {
			$recordJSON['Pricing_Details'] = self::getPriceDetailsAsJSONArray();
		}
		if (sizeof($this->record->getTaxList()) > 0) {
			$recordJSON['Tax'] = self::getTaxListAsJSON();
		}
		return array_filter($recordJSON);
	}

	public function getTaxListAsJSON() {
		$taxes = array();
		$taxList = $this->record->getTaxList();
		foreach ($taxList as $taxIns) {
			array_push($taxes, $taxIns->getTaxName());
		}
		return $taxes;
	}

	public function getPriceDetailsAsJSONArray() {
		$priceDetailsArr = array();
		$priceDetailsList = $this->record->getPriceDetails();
		foreach ($priceDetailsList as $priceDetailIns) {
			array_push($priceDetailsArr,self::getZCRMPriceDetailAsJSON($priceDetailIns));
		}
		return $priceDetailsArr;
	}

	public function getZCRMPriceDetailAsJSON(ZCRMPriceBookPricing $priceDetailIns) {
		$priceDetailJSON = array();
		if ($priceDetailIns->getId() != null) {
			$priceDetailJSON['id'] = $priceDetailIns->getId();
		}
		$priceDetailJSON['discount']   = $priceDetailIns->getDiscount();
		$priceDetailJSON['to_range']   = $priceDetailIns->getToRange();
		$priceDetailJSON['from_range'] = $priceDetailIns->getFromRange();
		return $priceDetailJSON;
	}

	public function getParticipantsAsJSONArray() {
		$participantsArr = array();
		$participantsList = $this->record->getParticipants();
		foreach($participantsList as $participantIns) {
			array_push($participantsArr, self::getZCRMParticipantAsJSON($participantIns));
		}
		return $participantsArr;
	}

	public function getZCRMParticipantAsJSON(ZCRMEventParticipant $participantIns) {
		$participantJSON = array();
		$participantJSON['participant'] = (string)$participantIns->getId();
		$participantJSON['type'] = (string)$participantIns->getType();
		$participantJSON['name'] = (string)$participantIns->getName();
		$participantJSON['Email'] = (string)$participantIns->getEmail();
		$participantJSON['invited'] = (boolean)$participantIns->isInvited();
		$participantJSON['status'] = (string)$participantIns->getStatus();

		return $participantJSON;
	}

	public function getLineItemJSON($lineItemsArray) {
		$lineItemsAsJSONArray = array();
		foreach ($lineItemsArray as $lineItem) {
			$lineItemData = array();
			if ($lineItem->getQuantity() == null) {
				throw new ZCRMException("Mandatory Field 'quantity' is missing.", APIConstants::RESPONSECODE_BAD_REQUEST);
			}
			if ($lineItem->getId() != null) {
				$lineItemData['id'] = (string)$lineItem->getId();
			}
			if ($lineItem->getProduct() != null) {
				$lineItemData['product'] = (string)$lineItem->getProduct()->getEntityId();
			}
			if ($lineItem->getDescription() != null) {
				$lineItemData['product_description'] = $lineItem->getDescription();
			}
			if ($lineItem->getListPrice() != null) {
				$lineItemData['list_price'] = $lineItem->getListPrice();
			}
			$lineItemData['quantity'] = $lineItem->getQuantity();
			/*
			 *  Either discount percentage can be 0 or discount value can be 0. So if percentage is 0, set value and vice versa.
			 *	If the intended discount is 0, then both percent and value will be 0. Hence setting either of this to 0, will be enough.
			*/
			$lineItemData['Discount'] = ($lineItem->getDiscountPercentage() == null)
			                          ? $lineItem->getDiscount()
				                      : $lineItem->getDiscountPercentage().'%';
			$lineTaxes = $lineItem->getLineTax();
			$lineTaxArray = array();
			foreach ($lineTaxes as $lineTaxInstance) {
				$tax = array();
				$tax['name'] = $lineTaxInstance->getTaxName();
				$tax['value'] = $lineTaxInstance->getValue();
				$tax['percentage'] = $lineTaxInstance->getPercentage();
				array_push($lineTaxArray,$tax);
			}
			$lineItemData['line_tax'] = $lineTaxArray;

			array_push($lineItemsAsJSONArray, array_filter($lineItemData));
		}
		return array_filter($lineItemsAsJSONArray);
	}

	public function setRecordProperties($recordDetails) {
		foreach ($recordDetails as $key => $value) {
    		switch ($key) {
			    case 'id':
				    $this->record->setEntityId((int)$value);
				    break;
                case 'Product_Details':
    				$this->setInventoryLineItems($value);
    				break;
                case 'Participants':
    				$this->setParticipants($value);
    				break;
                case 'Pricing_Details':
    				$this->setPriceDetails($value);
    				break;
                case 'Created_By':
    				$createdBy = ZCRMUser::getInstance($value['id'], $value['name']);
    				$this->record->setCreatedBy($createdBy);
    				break;
                case 'Modified_By':
				    $modifiedBy = ZCRMUser::getInstance($value['id'], $value['name']);
                    $this->record->setModifiedBy($modifiedBy);
                    break;
                case 'Created_Time':
				    $this->record->setCreatedTime((string)$value);
				    break;
                case 'Modified_Time'
    				$this->record->setModifiedTime((string)$value);
    				break;
                case 'Last_Activity_Time':
				    $this->record->setLastActivityTime((string)$value);
				    break;
                case 'Owner':
    				$owner =ZCRMUser::getInstance($value['id'], $value['name']);
                    $this->record->setOwner($owner);
                    break;
                case 'Layout':
    				$layout = null;
                    if ($value != null) {
					    $layout = ZCRMLayout::getInstance($value['id'] + 0);
                        $layout->setName($value['name']);
				    }
                    $this->record->setLayout($layout);
                    break;
                case 'Handler':
                    if ($value != null) {
                        $handler = ZCRMUser::getInstance($value['id'], $value['name']);
                        $this->record->setFieldValue($key, $handler);
			        }
			        break;
                case 'Tax':
                    if (is_array($value)) {
        				foreach ($value as $taxName) {
        					$taxIns = ZCRMTax::getInstance($taxName);
        					$this->record->addTax($taxIns);
        				}
                    }
                    break;
                default:
                    if (strpos($key, '$') === 0) {
        				$this->record->setProperty(str_replace('$', '', $key), $value);
        			} elseif (is_array($value)) {
        				if (isset($value['id'])) {
        					$lookupRecord = ZCRMRecord::getInstance($key, isset($value['id']) ? (int)$value['id'] : 0);
        					$lookupRecord->setLookupLabel(isset($value['name']) ? $value["name"] : null);
        					$this->record->setFieldValue($key, $lookupRecord);
        				} else {
        					$this->record->setFieldValue($key, $value);
        				}
        			} else {
        				$this->record->setFieldValue($key, $value);
        			}
            }
		}
	}

	private function setParticipants($participants) {
		foreach ($participants as $participantDetail) {
			$this->record->addParticipant(self::getZCRMParticipant($participantDetail));
		}
	}


	private function setPriceDetails($priceDetails) {
		foreach($priceDetails as $priceDetail) {
			$this->record->addPriceDetail(self::getZCRMPriceDetail($priceDetail));
		}
	}

	public function getZCRMParticipant($participantDetail) {
		$participant = ZCRMEventParticipant::getInstance($participantDetail['type'], (int)$participantDetail['participant']);
		$participant->setName($participantDetail['name']);
		$participant->setEmail($participantDetail['Email']);
		$participant->setInvited((boolean)$participantDetail['invited']);
		$participant->setStatus($participantDetail['status']);
		return $participant;
	}

	public function getZCRMPriceDetail($priceDetails) {
		$priceDetailIns = ZCRMPriceBookPricing::getInstance((int)$priceDetails['id']);
		$priceDetailIns->setDiscount((double)$priceDetails['discount']);
		$priceDetailIns->setToRange((double)$priceDetails['to_range']);
		$priceDetailIns->setFromRange((double)$priceDetails['from_range']);
		return $priceDetailIns;
	}

	public function setInventoryLineItems($lineItems) {
		foreach ($lineItems as $lineItem) {
			$this->record->addLineItem(self::getZCRMLineItemInstance($lineItem));
		}
	}

	public function getZCRMLineItemInstance($lineItemDetails) {
		$productDetails = $lineItemDetails['product'];
		$lineItemId = (int)$lineItemDetails['id'];
		$lineItemInstance = ZCRMInventoryLineItem::getInstance($lineItemId);
		$product = ZCRMRecord::getInstance('Products', (int)$productDetails['id']);
		$product->setLookupLabel($productDetails['name']);
		if (isset($productDetails['Product_Code'])) {
			$product->setFieldValue('Product_Code', $productDetails['Product_Code']);
		}
		$lineItemInstance->setProduct($product);
		$lineItemInstance->setDescription($lineItemDetails['product_description']);
		$lineItemInstance->setQuantity((int)$lineItemDetails['quantity']);
		$lineItemInstance->setListPrice((int)$lineItemDetails['list_price']);
		$lineItemInstance->setTotal((int)$lineItemDetails['total']);
		$lineItemInstance->setDiscount((int)$lineItemDetails['Discount']);
		$lineItemInstance->setTotalAfterDiscount((int)$lineItemDetails['total_after_discount']);
		$lineItemInstance->setTaxAmount((int)$lineItemDetails['Tax']);
		$lineTaxes = $lineItemDetails['line_tax'];
		foreach ($lineTaxes as $lineTax) {
			$taxInstance = ZCRMTax::getInstance($lineTax['name']);
			$taxInstance->setPercentage($lineTax['percentage']);
			$taxInstance->setValue((int)$lineTax['value']);
			$lineItemInstance->addLineTax($taxInstance);
		}
		$lineItemInstance->setNetTotal((int)$lineItemDetails['net_total']);
		return $lineItemInstance;
	}
}
