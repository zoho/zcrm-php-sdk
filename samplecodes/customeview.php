<?php
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
require_once __DIR__ . '/../vendor/autoload.php';


class customView
{

    public function __construct()
    {
        $configuration = [];
        ZCRMRestClient::initialize($configuration);
    }

    public function getrecords()
    {
        $param_map=array("page"=>10,"per_page"=>10); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-15T15:26:49+05:30");//key-value pair  containing Headers to be passed    -optional
        $response = ZCRMRestClient::getCustomViewInstance("{module_api_name}","{custom_view_id}" )->getRecords($param_map, $header_map );//to get the records($param_map - parameter map,$header_map - header map
        $records = $response->getData();
        try {
            foreach ($records as $record) {
                echo "\n\n";
                echo $record->getEntityId(); // To get record id
                echo $record->getModuleApiName(); // To get module api name
                echo $record->getLookupLabel(); // To get lookup object name
                $createdBy = $record->getCreatedBy();
                echo $createdBy->getId(); // To get user_id who created the record
                echo $createdBy->getName(); // To get user name who created the record
                $modifiedBy = $record->getModifiedBy();
                echo $modifiedBy->getId(); // To get user_id who modified the record
                echo $modifiedBy->getName(); // To get user name who modified the record
                $owner = $record->getOwner();
                echo $owner->getId(); // To get record owner_id
                echo $owner->getName(); // To get record owner name
                echo $record->getCreatedTime(); // To get record created time
                echo $record->getModifiedTime(); // To get record modified time
                echo $record->getLastActivityTime(); // To get last activity time(latest modify/view time)
                echo $record->getFieldValue("FieldApiName"); // To get particular field value
                $map = $record->getData(); // To get record data as map
                foreach ($map as $key => $value) {
                    if ($value instanceof ZCRMRecord) // If value is ZCRMRecord object
                    {
                        echo $value->getEntityId(); // to get the record id
                        echo $value->getModuleApiName(); // to get the api name of the module
                        echo $value->getLookupLabel(); // to get the lookup label of the record
                    } else // If value is not ZCRMRecord object
                    {
                        echo $key . ":" . $value;
                    }
                }
                /**
                 * Fields which start with "$" are considered to be property fields *
                 */
                echo $record->getProperty('$fieldName'); // To get a particular property value
                $properties = $record->getAllProperties(); // To get record properties as map
                foreach ($properties as $key => $value) {
                    if (is_array($value)) // If value is an array
                    {
                        echo "KEY::" . $key . "=";
                        foreach ($value as $key1 => $value1) {
                            if (is_array($value1)) {
                                foreach ($value1 as $key2 => $value2) {
                                    echo $key2 . ":" . $value2;
                                }
                            } else {
                                echo $key1 . ":" . $value1;
                            }
                        }
                    } else {
                        echo $key . ":" . $value;
                    }
                }
                $layouts = $record->getLayout(); // To get record layout
                echo $layouts->getId(); // To get layout_id
                echo $layouts->getName(); // To get layout name

                $taxlists = $record->getTaxList(); // To get the tax list
                foreach ($taxlists as $taxlist) {
                    echo $taxlist->getTaxName(); // To get tax name
                    echo $taxlist->getPercentage(); // To get tax percentage
                    echo $taxlist->getValue(); // To get tax value
                }
                $lineItems = $record->getLineItems(); // To get line_items as map
                foreach ($lineItems as $lineItem) {
                    echo $lineItem->getId(); // To get line_item id
                    echo $lineItem->getListPrice(); // To get line_item list price
                    echo $lineItem->getQuantity(); // To get line_item quantity
                    echo $lineItem->getDescription(); // To get line_item description
                    echo $lineItem->getTotal(); // To get line_item total amount
                    echo $lineItem->getDiscount(); // To get line_item discount
                    echo $lineItem->getDiscountPercentage(); // To get line_item discount percentage
                    echo $lineItem->getTotalAfterDiscount(); // To get line_item amount after discount
                    echo $lineItem->getTaxAmount(); // To get line_item tax amount
                    echo $lineItem->getNetTotal(); // To get line_item net total amount
                    echo $lineItem->getDeleteFlag(); // To get line_item delete flag
                    echo $lineItem->getProduct()->getEntityId(); // To get line_item product's entity id
                    echo $lineItem->getProduct()->getLookupLabel(); // To get line_item product's lookup label
                    $linTaxs = $lineItem->getLineTax(); // To get line_item's line_tax as array
                    foreach ($linTaxs as $lineTax) {
                        echo $lineTax->getTaxName(); // To get line_tax name
                        echo $lineTax->getPercentage(); // To get line_tax percentage
                        echo $lineTax->getValue(); // To get line_tax value
                    }
                }
                $pricedetails = $record->getPriceDetails(); // To get the price_details array
                foreach ($pricedetails as $pricedetail) {
                    echo "\n\n";
                    echo $pricedetail->getId(); // To get the record's price_id
                    echo $pricedetail->getToRange(); // To get the price_detail record's to_range
                    echo $pricedetail->getFromRange(); // To get price_detail record's from_range
                    echo $pricedetail->getDiscount(); // To get price_detail record's discount
                    echo "\n\n";
                }
                $participants = $record->getParticipants(); // To get Event record's participants
                foreach ($participants as $participant) {
                    echo $participant->getName(); // To get the record's participant name
                    echo $participant->getEmail(); // To get the record's participant email
                    echo $participant->getId(); // To get the record's participant id
                    echo $participant->getType(); // To get the record's participant type
                    echo $participant->isInvited(); // To check if the record's participant(s) are invited or not
                    echo $participant->getStatus(); // To get the record's participants' status
                }
                /* End Event */
            }
        } catch (ZCRMException $ex) {
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
        }
    }
}
$obj=new customView();
$obj->getrecords();