<?php
require_once __DIR__ . '/../vendor/autoload.php';
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMJunctionRecord;
use zcrmsdk\crm\crud\ZCRMNote;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMTax;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\setup\users\ZCRMUser;


class Record
{

    public function __construct()
    {
        $configuration = [];
        ZCRMRestClient::initialize($configuration);
    }

    public function create()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", NULL); // To get record instance
        $record->setFieldValue("Subject", "test2312"); // This function use to set FieldApiName and value similar to all other FieldApis and Custom field
        $record->setFieldValue("Account_Name", "{account_id}"); // Account Name can be given for a new account, account_id is not mandatory in that case
        /**
         * Following methods are being used only by Inventory modules *
         */

        $lineItem = ZCRMInventoryLineItem::getInstance(null); // To get ZCRMInventoryLineItem instance
        $lineItem->setDescription("Product_description"); // To set line item description
        $lineItem->setDiscount(5); // To set line item discount
        $lineItem->setListPrice(100); // To set line item list price

        $taxInstance1 = ZCRMTax::getInstance("{tax_name}"); // To get ZCRMTax instance
        $taxInstance1->setPercentage(2); // To set tax percentage
        $taxInstance1->setValue(50); // To set tax value
        $lineItem->addLineTax($taxInstance1); // To set line tax to line item

        $taxInstance1 = ZCRMTax::getInstance("{tax_name}");
        $taxInstance1->setPercentage(12);
        $taxInstance1->setValue(50);
        $lineItem->addLineTax($taxInstance1);

        $lineItem->setProduct(ZCRMRecord::getInstance("{module_api_name}", "{record_id}")); // To set product to line item
        $lineItem->setQuantity(100); // To set product quantity to this line item

        $record->addLineItem($lineItem);
        /**
         * photo can be uploaded only for certain modules *
         */
        // $record->uploadPhoto("/path/to/file");//to upload a photo of the record
        $trigger=array();//triggers to include
        $lar_id="lar_id";//lead assignment rule id
        $responseIns = $record->create($trigger,$lar_id);//$trigger , $larid optional
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function update()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        /**
         * only for inventory module *
         */
        $record->setFieldValue("Subject", "test2312"); // This function use to set FieldApiName and value similar to all other FieldApis and Custom field
        $record->setFieldValue("Account_Name", "{account_id}"); // Account Name can be given for a new account, account_id is not mandatory in that case
        $lineItem = ZCRMInventoryLineItem::getInstance("{line_item_id}"); // To get ZCRMInventoryLineItem instance the id of the line item
        $lineItem->setDescription("Product_description"); // To set line item description
        $lineItem->setDiscount(20); // To set line item discount
        $lineItem->setListPrice(3412); // To set line item list price

        $taxInstance1 = ZCRMTax::getInstance("{tax_name}"); // to get the tax instance
        $taxInstance1->setPercentage(20); // to set the tax percentage
        $taxInstance1->setValue(50); // to set the tax value
        $lineItem->addLineTax($taxInstance1); // to add the tax to the line item
        $lineItem->setQuantity(101); // To set product quantity to this line item
        $record->addLineItem($lineItem); // to add the line item to the record of invoice
        /**
         * for price book alone
         * $record->setFieldValue("Pricing_Details", json_decode('[ { "to_range": 5, "discount": 0, "from_range": 1 }, { "to_range": 11, "discount": 1, "from_range": 6 }, { "to_range": 17, "discount": 2, "from_range": 12 }, { "to_range": 23, "discount": 3, "from_range": 18 }, { "to_range": 29, "discount": 4, "from_range": 24 } ]',true));//setting the discount , range of the pricebook record
         * $record->setFieldValue("Pricing_Model","Flat"); //setting the price book model*
         */
        $trigger=array();//triggers to include
        $responseIns = $record->update($trigger); // to update the record

        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function delete()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $responseIns = $record->delete();

        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function convert()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Leads", "3524033000001192011"); // To get record instance
        $deal = ZCRMRecord::getInstance("deals", Null); // to get the record of deal in form of ZCRMRecord insatnce
        $deal->setFieldValue("Deal_Name", "test3"); // to set the deal name
        $deal->setFieldValue("Stage", "Qualification"); // to set the stage
        $deal->setFieldValue("Closing_Date", "2016-03-30"); // to set the closing date
        $details = array("overwrite"=>TRUE,"notify_lead_owner"=>TRUE,"notify_new_entity_owner"=>TRUE,"Accounts"=>"3524033000001055001","Contacts"=>"3524033000001248867","assign_to"=>"3524033000000191017");
        $responseIn = $record->convert($deal, $details); // to convert record
        echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIn->getStatus(); // To get response status
        echo "Message:" . $responseIn->getMessage(); // To get response message
        echo "Code:" . $responseIn->getCode(); // To get status code
        echo "Details:" . json_encode($responseIn->getDetails());
    }

    public function getRelatedListRecords()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $param_map=array("page"=>"1","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-10-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $relatedlistrecords = $record->getRelatedListRecords("Attachments",$param_map,$header_map)->getData(); // to get the related list records in form of ZCRMRecord instance

        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("File_Name"); // to get the file name
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
        }
        $relatedlistrecords = $record->getRelatedListRecords("Products")->getData(); // to get the related list record inform of ZCRMRecord instance
        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
            echo $relatedlistrecord->getFieldValue("Product_Name"); // to get the product name
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("Product_Code"); // to get the product code
        }
        $relatedlistrecords = $record->getRelatedListRecords("Activities")->getData(); // to get the related list record inform of ZCRMRecord instance
        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("Subject"); // to get the subject of the activity
            echo $relatedlistrecord->getFieldValue("Due_Date"); // to get the due date of the activity
            echo $relatedlistrecord->getFieldValue("Billable"); // to get the billable value
            echo $relatedlistrecord->getFieldValue("Activity_Type"); // to get the activity type
        }
        $relatedlistrecords = $record->getRelatedListRecords("Campaigns")->getData(); // to get the related list record inform of ZCRMRecord instance
        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("Campaign_Name"); // to get the campaigns name
            echo $relatedlistrecord->getFieldValue("Description"); // to get the campaign's description
            echo $relatedlistrecord->getFieldValue("Member_Status"); // to get the member status
        }
        $relatedlistrecords = $record->getRelatedListRecords("Quotes")->getData(); // to get the related list record inform of ZCRMRecord instance

        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("Carrier"); // to get the carrier
            echo $relatedlistrecord->getFieldValue("Quote_Stage"); // to get the quote stage
            echo $relatedlistrecord->getFieldValue("Subject"); // to get the quote subject
            echo $relatedlistrecord->getFieldValue("Quote_Number"); // to get the quote number
            echo $relatedlistrecord->getFieldValue("currency_symbol"); // to get the currency symbol
        }
        $relatedlistrecords = $record->getRelatedListRecords("SalesOrders")->getData(); // to get the related list record inform of ZCRMRecord instance

        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("Carrier"); // to get the carrier
            echo $relatedlistrecord->getFieldValue("Status"); // to get the status of the sales order
            echo $relatedlistrecord->getFieldValue("Billing_Street"); // to get the billing street
            echo $relatedlistrecord->getFieldValue("Billing_Code"); // to get the billing code
            echo $relatedlistrecord->getFieldValue("Subject"); // to get the subject
            echo $relatedlistrecord->getFieldValue("Billing_City"); // to get the billing city
            echo $relatedlistrecord->getFieldValue("SO_Number"); // to get the sales order number
            echo $relatedlistrecord->getFieldValue("Billing_State"); // to get the billing state
        }
        $relatedlistrecords = $record->getRelatedListRecords("Cases")->getData(); // to get the related list record inform of ZCRMRecord instance
        foreach ($relatedlistrecords as $relatedlistrecord) {
            echo $relatedlistrecord->getModuleApiName(); // to get the api name of the module
            echo $relatedlistrecord->getEntityId(); // to get the entity id
            echo $relatedlistrecord->getFieldValue("Status"); // to get the status of the case
            echo $relatedlistrecord->getFieldValue("Email"); // to get the email id
            echo $relatedlistrecord->getFieldValue("Case_Origin"); // to get the case origin
            echo $relatedlistrecord->getFieldValue("Case_Number"); // to get the case number
        }
    }

    public function addlineitemtoexistingrecord()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance

        $lineItem = ZCRMInventoryLineItem::getInstance(null); // To get ZCRMInventoryLineItem instance
        $lineItem->setDescription("Product_description"); // To set line item description
        $lineItem->setDiscount(5); // To set line item discount
        $lineItem->setListPrice(100); // To set line item list price
        $lineItem->setProduct(ZCRMRecord::getInstance("Products", "{record_id}")); // To set product to line item
        $lineItem->setQuantity(100); //
        $responseIns = $record->addLineItemtoExistingRecord($lineItem);
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function updatelineitemofexistingrecord()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}");// To get record instance

        $lineItem = ZCRMInventoryLineItem::getInstance(null); // To get ZCRMInventoryLineItem instance
        $lineItem->setId("{line_item_id}");
        $lineItem->setDescription("Product_scription"); // To set line item description
        $lineItem->setDiscount(5); // To set line item discount
        $lineItem->setListPrice(12312); // To set line item list price
        $lineItem->setProduct(ZCRMRecord::getInstance("Products", "{record_id}")); // To set product to line item
        $lineItem->setQuantity(100); //
        $responseIns = $record->updateLineItemofTheExistingRecord($lineItem);
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function deletelineitemfromexistingrecord()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $responseIns = $record->deleteLineItemFromTheExistingRecord("{line_item_id}");
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function getNotes()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $param_map=array("page"=>"1","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-12-12T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $notes = $record->getNotes($param_map,$header_map)->getData(); // to get the notes in form of ZCRMNote instances array
        foreach ($notes as $note) {

            echo "\n";
            echo $note->getId(); // To get note id
            echo $note->getTitle(); // To get note title
            echo $note->getContent(); // To get note content
            $parentRecord = $note->getParentRecord(); // To get note's parent record
            echo $parentRecord->getEntityId(); // To get note's parent record id
            echo $note->getParentName(); // To get note's parent name
            echo $note->getParentId(); // To get note's parent id
            $createdBy = $note->getCreatedBy();
            echo $createdBy->getId(); // To get user_id who created the note
            echo $createdBy->getName(); // To get user name who created the note
            $modifiedBy = $note->getModifiedBy();
            echo $modifiedBy->getId(); // To get user_id who modified the note
            echo $modifiedBy->getName(); // To get user name who modified the note
            $owner = $note->getOwner();
            echo $owner->getId(); // To get note_record owner id
            echo $owner->getName(); // To get note_record Owner name
            echo $note->getCreatedTime(); // To get created time of the note
            echo $note->getModifiedTime(); // To get modified time of the note
            echo $note->isVoiceNote(); // Check if the note is voice_note or not
            echo $note->getSize(); // To get note_record size
            $attchments = $note->getAttachments(); // To get attachments of the note_record
            if ($attchments != null) // check If attachments is empty/not
            {
                foreach ($attchments as $attchmentIns) {
                    echo $attchmentIns->getId(); // To get the note's attachment id
                    echo $attchmentIns->getFileName(); // To get the note's attachment file name
                    echo $attchmentIns->getFileType(); // To get the note's attachment file type
                    echo $attchmentIns->getSize(); // To get the note's attachment file size
                    echo $attchmentIns->getParentModule(); // To get the note's attachment parent module name
                    $parentRecord = $attchmentIns->getParentRecord();
                    echo $parentRecord->getEntityId(); // To get the note's parent record id
                    echo $attchmentIns->getParentName(); // To get the note name
                    echo $attchmentIns->getParentId(); // To get the note id
                    $createdBy = $attchmentIns->getCreatedBy();
                    echo $createdBy->getId(); // To get user_id who created the note's attachment
                    echo $createdBy->getName(); // To get user name who created the note's attachment
                    $modifiedBy = $attchmentIns->getModifiedBy();
                    echo $modifiedBy->getId(); // To get user_id who modified the note's attachment
                    echo $modifiedBy->getName(); // To get user name who modified the note's attachment
                    $owner = $attchmentIns->getOwner();
                    echo $owner->getId(); // To get the note's attachment owner id
                    echo $owner->getName(); // To get the note's attachment owner name
                    echo $attchmentIns->getCreatedTime(); // To get attachment created time
                    echo $attchmentIns->getModifiedTime(); // To get attachment modified time
                }
            }
        }
    }

    public function addNote()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $noteIns = ZCRMNote::getInstance($record, NULL); // to get the note instance
        $noteIns->setTitle("Title_API1"); // to set the note title
        $noteIns->setContent("This is test content"); // to set the note content
        $responseIns = $record->addNote($noteIns); // to add the note
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function updateNote()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $noteIns = ZCRMNote::getInstance($record, "{note_id}"); // to get the note instance
        $noteIns->setTitle("Title_API1"); // to set the title of the note
        $noteIns->setContent("This is test cooontent"); // to set the content of the note
        $responseIns = $record->updateNote($noteIns); // to update the note
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function deleteNote()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $noteIns = ZCRMNote::getInstance($record, "{note_id}"); // to get the note instance
        $responseIns = $record->deleteNote($noteIns); // to delete the note

        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function getAttachments()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $param_map=array("page"=>"1","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-12-12T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $responseIns = $record->getAttachments($param_map, $header_map); // to get the attachments
        $attachments = $responseIns->getData(); // to get the attachments in form of ZCRMAttachment instance array
        foreach ($attachments as $attchmentIns) {
            echo $attchmentIns->getId(); // To get the note's attachment id
            echo $attchmentIns->getFileName(); // To get the note's attachment file name
            echo $attchmentIns->getFileType(); // To get the note's attachment file type
            echo $attchmentIns->getSize(); // To get the note's attachment file size
            echo $attchmentIns->getParentModule(); // To get the note's attachment parent module name
            $parentRecord = $attchmentIns->getParentRecord();
            echo $parentRecord->getEntityId(); // To get the note's parent record id
            echo $attchmentIns->getParentName(); // To get the note name
            echo $attchmentIns->getParentId(); // To get the note id
            $createdBy = $attchmentIns->getCreatedBy();
            echo $createdBy->getId(); // To get user_id who created the note's attachment
            echo $createdBy->getName(); // To get user name who created the note's attachment
            $modifiedBy = $attchmentIns->getModifiedBy();
            echo $modifiedBy->getId(); // To get user_id who modified the note's attachment
            echo $modifiedBy->getName(); // To get user name who modified the note's attachment
            $owner = $attchmentIns->getOwner();
            echo $owner->getId(); // To get the note's attachment owner id
            echo $owner->getName(); // To get the note's attachment owner name
            echo $attchmentIns->getCreatedTime(); // To get attachment created time
            echo $attchmentIns->getModifiedTime(); // To get attachment modified time
        }
    }

    public function uploadAttachment()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $responseIns = $record->uploadAttachment("/path/to/file"); // $filePath - absolute path of the attachment to be uploaded.
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function uploadLinkAsAttachment()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $responseIns = $record->uploadLinkAsAttachment("https://www.google.com/url?sa=i&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwiBw56T19vfAhVIfisKHRNrDH4QjRx6BAgBEAU&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fnature%2F&psig=AOvVaw3CtMR6IfHNO2ArtwV_BIGq&ust=1546950855212495"); // $filePath - absolute path of the attachment to be uploaded.
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }
   
    public function downloadAttachment()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $fileResponseIns = $record->downloadAttachment("{attachment_id}");

        $filePath = "/path/to/file";
        $fp = fopen($filePath . $fileResponseIns->getFileName(), "w"); // $filePath - absolute path where downloaded file has to be stored.
        echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        echo "File Name:" . $fileResponseIns->getFileName();
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
    }

    public function deleteAttachment()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $fileResponseIns = $record->downloadAttachment("{attachment_id}");
        echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $fileResponseIns->getStatus(); // To get response status
        echo "Message:" . $fileResponseIns->getMessage(); // To get response message
        echo "Code:" . $fileResponseIns->getCode(); // To get status code
        echo "Details:" . $fileResponseIns->getDetails()['id'];
    }

    public function uploadPhoto()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $responseIns = $record->uploadPhoto("/path/to/file"); // $photoPath - absolute path of the photo to be uploaded.
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function downloadPhoto()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $fileResponseIns = $record->downloadPhoto(); // to download the photo
        echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        echo "File Name:" . $fileResponseIns->getFileName();
        $filePath = "/path/to/file";
        $fp = fopen($filePath . $fileResponseIns->getFileName(), "w"); // $filePath - absolute path where the downloaded photo is stored.
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
    }

    public function deletePhoto()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $responseIns = $record->deletePhoto(); // $photoPath - absolute path of the photo to be uploaded.
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function addRelation()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $junctionrecord = ZCRMJunctionRecord::getInstance("{module_api_name}", "{record_id}"); // to get the junction record instance
        $responseIns = $record->addRelation($junctionrecord); // to add a relation between the record and the junction record
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function removeRelation()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $junctionrecord = ZCRMJunctionRecord::getInstance("{module_api_name}", "{record_id}"); // to get the junction record instance
        $responseIns = $record->removeRelation($junctionrecord); // to add a relation between the record and the junction record
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function addTags()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $tagNames = array(
            "test1",
            "test2"
        ); // to create array of tag names
        $responseIns = $record->addTags($tagNames); // to add tags
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function removeTags()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "{record_id}"); // To get record instance
        $tagNames = array(
            "test1",
            "test2"
        ); // to create array of tag names
        $responseIns = $record->removeTags($tagNames); // to remove tags
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get http response code
        echo "Status:" . $responseIns->getStatus(); // To get response status
        echo "Message:" . $responseIns->getMessage(); // To get response message
        echo "Code:" . $responseIns->getCode(); // To get status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }
}

$obj = new Record();

$obj->getNotes();
?>