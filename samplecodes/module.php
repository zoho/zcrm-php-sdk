<?php
use zcrmsdk\crm\crud\ZCRMCustomView;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMTag;
use zcrmsdk\crm\crud\ZCRMTax;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
require_once __DIR__ . '/../vendor/autoload.php';
class Module
{

    public function __construct()
    {
        $configuration=[];
        ZCRMRestClient::initialize($configuration);
    }

    public function getFieldDetails()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getFieldDetails("{field_id}"); // to get the field
        $field = $response->getData(); // to get the field data in form of ZCRMField instance.
        echo $field->getApiName(); // to get the field api name
        echo $field->getLength(); // to get the length of the field value
        echo $field->isVisible(); // to check if the field is visible
        echo $field->getFieldLabel(); // to get the field label name
        echo $field->getCreatedSource(); // to get the created source
        echo $field->isMandatory(); // to check if the field is mandatory
        echo $field->getSequenceNumber(); // to get fields sequence number
        echo $field->isReadOnly(); // to check if the field is read only
        echo $field->getDataType(); // to get the field data type
        echo $field->getId(); // to get the field id
        echo $field->isCustomField(); // to check if the field is custom field
        echo $field->isBusinessCardSupported(); // to check if the field is BusinessCard Supported
        echo $field->getDefaultValue(); // to get the default value of the field
        $permissions = $field->getFieldLayoutPermissions(); // get field layout permissions.array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
        foreach ($permissions as $permission) { // for each permission
            echo $permission;
        }
        $lookupfield = $field->getLookupField(); // to get the field lookup information
        if ($field->getDataType() == "Lookup") {
            echo $lookupfield->getModule(); // to get the module name of lookupfield
            echo $lookupfield->getDisplayLabel(); // to get the display label of the lookup field
            echo $lookupfield->getId(); // to get the id of the lookup field
        }
        $picklistfieldvalues = $field->getPickListFieldValues(); // to get the pick list values of the field
        foreach ($picklistfieldvalues as $picklistfieldvalue) {
            echo $picklistfieldvalue->getDisplayValue(); // to get display value of the pick list
            echo $picklistfieldvalue->getSequenceNumber(); // to get the sequence number of the pick list
            echo $picklistfieldvalue->getActualValue(); // to get the actual value of the pick list
            echo $picklistfieldvalue->getMaps();
        }
        echo $field->isUniqueField(); // to check if the field is unique
        echo $field->isCaseSensitive(); // to check if the field is case sensitive
        echo $field->isCurrencyField(); // to check if the field is currency field
        echo $field->getPrecision(); // to get the precision of the field
        echo $field->getRoundingOption(); // to get the rounding option of the field
        echo $field->isFormulaField(); // to check if the field is a formula field
        if ($field->isFormulaField()) {
            echo $field->getFormulaReturnType(); // to get the return type of the formula
            echo $field->getFormulaExpression(); // to get the formula expression
        }
        echo $field->isAutoNumberField(); // to check if the field is auto numbering
        if ($field->isAutoNumberField()) {
            echo $field->getPrefix(); // to get the prefix value
            echo $field->getSuffix(); // to get the suffix value
            echo $field->getStartNumber(); // to get the start number
        }
        echo $field->getDecimalPlace(); // to get the decimal place
        echo $field->getJsonType(); // to get the json type of the field
    }

    public function getAllFields()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getAllFields(); // to get the field
        $fields = $response->getData(); // to get the array of ZCRMField instances
        foreach ($fields as $field) { // each field
            echo $field->getApiName(); // to get the field api name
            echo $field->getLength(); // to get the length of the field value
            echo $field->isVisible(); // to check if the field is visible
            echo $field->getFieldLabel(); // to get the field label name
            echo $field->getCreatedSource(); // to get the created source
            echo $field->isMandatory(); // to check if the field is mandatory
            echo $field->getSequenceNumber(); // to get fields sequence number
            echo $field->isReadOnly(); // to check if the field is read only
            echo $field->getDataType(); // to get the field data type
            echo $field->getId(); // to get the field id
            echo $field->isCustomField(); // to check if the field is custom field
            echo $field->isBusinessCardSupported(); // to check if the field is BusinessCard Supported
            echo $field->getDefaultValue(); // to get the default value of the field
            $permissions = $field->getFieldLayoutPermissions(); // get field layout permissions.array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
            foreach ($permissions as $permission) { // for each permission
                echo $permission;
            }
            $lookupfield = $field->getLookupField(); // to get the field lookup information
            if ($field->getDataType() == "Lookup") {
                echo $lookupfield->getModule(); // to get the module name of lookupfield
                echo $lookupfield->getDisplayLabel(); // to get the display label of the lookup field
                echo $lookupfield->getId(); // to get the id of the lookup field
            }
            $picklistfieldvalues = $field->getPickListFieldValues(); // to get the pick list values of the field
            foreach ($picklistfieldvalues as $picklistfieldvalue) {
                echo $picklistfieldvalue->getDisplayValue(); // to get display value of the pick list
                echo $picklistfieldvalue->getSequenceNumber(); // to get the sequence number of the pick list
                echo $picklistfieldvalue->getActualValue(); // to get the actual value of the pick list
                echo $picklistfieldvalue->getMaps();
            }
            echo $field->isUniqueField(); // to check if the field is unique
            echo $field->isCaseSensitive(); // to check if the field is case sensitive
            echo $field->isCurrencyField(); // to check if the field is currency field
            echo $field->getPrecision(); // to get the precision of the field
            echo $field->getRoundingOption(); // to get the rounding option of the field
            echo $field->isFormulaField(); // to check if the field is a formula field
            if ($field->isFormulaField()) {
                echo $field->getFormulaReturnType(); // to get the return type of the formula
                echo $field->getFormulaExpression(); // to get the formula expression
            }
            echo $field->isAutoNumberField(); // to check if the field is auto numbering
            if ($field->isAutoNumberField()) {
                echo $field->getPrefix(); // to get the prefix value
                echo $field->getSuffix(); // to get the suffix value
                echo $field->getStartNumber(); // to get the start number
            }
            echo $field->getDecimalPlace(); // to get the decimal place
            echo $field->getJsonType(); // to get the json type of the field
        }
    }

    public function getLayoutDetails()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getLayoutDetails("{layout_id}"); // to get the layout
        $layout = $response->getData(); // to get the layout data in form of ZCRMLayout instances
        echo $layout->getId(); // to get the layout id
        echo $layout->getName(); // to get layout name
        echo $layout->getCreatedTime(); // to get the creation time of the layout in iso 8601 format
        echo $layout->getModifiedTime(); // to get the modification time of the layout in iso 8601 format
        echo $layout->isVisible(); // to check if the layout is visible
        $user = $layout->getModifiedBy(); // to get the user details as ZCRMUser instance
        if ($user != null) {
            echo $user->getId(); // to get the id of the user
            echo $user->getName(); // to get the name of the user
        }
        $user = $layout->getCreatedBy(); // to get the user details as ZCRMUser instance
        if ($user != null) {
            echo $user->getId(); // to get the id of the user
            echo $user->getName(); // to get the name of the user
        }
        $profiles = $layout->getAccessibleProfiles(); // to get the accessible profiles details as an array of ZCRMProfile instances
        foreach ($profiles as $profile) { // for each profile
            $profile->getId(); // to get the profile id
            $profile->getName(); // to get the profile name
        }
        echo $layout->getStatus(); // to get the status of the layout
        $sections = $layout->getSections(); // to get the array of sections as ZCRMSection instances
        foreach ($sections as $section) { // for each section
            echo $section->getName(); // to get the section name
            echo $section->getDisplayName(); // to get the display name of the section
            echo $section->getColumnCount(); // to get the column count of the section
            echo $section->getSequenceNumber(); // to get the sequence number of the section
            $fields = $section->getFields(); // to get the array of fields as ZCRMField instances
            foreach ($fields as $field) { // for each field
                echo $field->getApiName(); // to get the field api name
                echo $field->getLength(); // to get the length of the field value
                echo $field->isVisible(); // to check if the field is visible
                echo $field->getFieldLabel(); // to get the field label name
                echo $field->getCreatedSource(); // to get the created source
                echo $field->isMandatory(); // to check if the field is mandatory
                echo $field->getSequenceNumber(); // to get fields sequence number
                echo $field->isReadOnly(); // to check if the field is read only
                echo $field->getDataType(); // to get the field data type
                echo $field->getId(); // to get the field id
                echo $field->isCustomField(); // to check if the field is custom field
                echo $field->isBusinessCardSupported(); // to check if the field is BusinessCard Supported
                echo $field->getDefaultValue(); // to get the default value of the field
                $permissions = $field->getFieldLayoutPermissions(); // get field layout permissions.array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
                foreach ($permissions as $permission) { // for each permission
                    echo $permission;
                }
                $lookupfield = $field->getLookupField(); // to get the field lookup information
                if ($field->getDataType() == "Lookup") {
                    echo $lookupfield->getModule(); // to get the module name of lookupfield
                    echo $lookupfield->getDisplayLabel(); // to get the display label of the lookup field
                    echo $lookupfield->getId(); // to get the id of the lookup field
                }
                $picklistfieldvalues = $field->getPickListFieldValues(); // to get the pick list values of the field
                foreach ($picklistfieldvalues as $picklistfieldvalue) {
                    echo $picklistfieldvalue->getDisplayValue(); // to get display value of the pick list
                    echo $picklistfieldvalue->getSequenceNumber(); // to get the sequence number of the pick list
                    echo $picklistfieldvalue->getActualValue(); // to get the actual value of the pick list
                    echo $picklistfieldvalue->getMaps();
                }
                echo $field->isUniqueField(); // to check if the field is unique
                echo $field->isCaseSensitive(); // to check if the field is case sensitive
                echo $field->isCurrencyField(); // to check if the field is currency field
                echo $field->getPrecision(); // to get the precision of the field
                echo $field->getRoundingOption(); // to get the rounding option of the field
                echo $field->isFormulaField(); // to check if the field is a formula field
                if ($field->isFormulaField()) {
                    echo $field->getFormulaReturnType(); // to get the return type of the formula
                    echo $field->getFormulaExpression(); // to get the formula expression
                }
                echo $field->isAutoNumberField(); // to check if the field is auto numbering
                if ($field->isAutoNumberField()) {
                    echo $field->getPrefix(); // to get the prefix value
                    echo $field->getSuffix(); // to get the suffix value
                    echo $field->getStartNumber(); // to get the start number
                }
                echo $field->getDecimalPlace(); // to get the decimal place
                echo $field->getJsonType(); // to get the json type of the field
                $convertmaps = $field->getConvertMapping();
                foreach ($convertmaps as $key => $value) {
                    echo $key . ":" . $value;
                }
            }
        }
        $convertmappings = $layout->getConvertMapping(); // to get an convert mapping array
        foreach ($convertmappings as $convertmapping) {
            echo $convertmapping->getName();
            echo $convertmapping->getId();
            $fields = $convertmapping->getFields();
            if ($fields) {
                foreach ($fields as $field) {
                    echo $field->getApiName();
                    echo $field->getId();
                    echo $field->getFieldLabel();
                    echo $field->isRequired();
                }
            }
        }
    }

    public function getAllLayouts()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getAllLayouts(); // to get all the layout
        $layouts = $response->getData(); // to get the layout data in form of ZCRMLayout instances
        foreach ($layouts as $layout) {
            echo $layout->getId(); // to get the layout id
            echo $layout->getName(); // to get layout name
            echo $layout->getCreatedTime(); // to get the creation time of the layout in iso 8601 format
            echo $layout->getModifiedTime(); // to get the modification time of the layout in iso 8601 format
            echo $layout->isVisible(); // to check if the layout is visible
            $user = $layout->getModifiedBy(); // to get the user details as ZCRMUser instance
            if ($user != NULL) {
                echo $user->getId(); // to get the id of the user
                echo $user->getName(); // to get the name of the user
            }
            $user = $layout->getCreatedBy(); // to get the user details as ZCRMUser instance
            if ($user != NULL) {
                echo $user->getId(); // to get the id of the user
                echo $user->getName(); // to get the name of the user
            }
            $profiles = $layout->getAccessibleProfiles(); // to get the accessible profiles details as an array of ZCRMProfile instances
            foreach ($profiles as $profile) { // for each profile
                $profile->getId(); // to get the profile id
                $profile->getName(); // to get the profile name
            }
            echo $layout->getStatus(); // to get the status of the layout
            $sections = $layout->getSections(); // to get the array of sections as ZCRMSection instances
            foreach ($sections as $section) { // for each section
                echo $section->getName(); // to get the section name
                echo $section->getDisplayName(); // to get the display name of the section
                echo $section->getColumnCount(); // to get the column count of the section
                echo $section->getSequenceNumber(); // to get the sequence number of the section
                $fields = $section->getFields(); // to get the array of fields as ZCRMField instances
                foreach ($fields as $field) { // for each field
                    echo $field->getApiName(); // to get the field api name
                    echo $field->getLength(); // to get the length of the field value
                    echo $field->isVisible(); // to check if the field is visible
                    echo $field->getFieldLabel(); // to get the field label name
                    echo $field->getCreatedSource(); // to get the created source
                    echo $field->isMandatory(); // to check if the field is mandatory
                    echo $field->getSequenceNumber(); // to get fields sequence number
                    echo $field->isReadOnly(); // to check if the field is read only
                    echo $field->getDataType(); // to get the field data type
                    echo $field->getId(); // to get the field id
                    echo $field->isCustomField(); // to check if the field is custom field
                    echo $field->isBusinessCardSupported(); // to check if the field is BusinessCard Supported
                    echo $field->getDefaultValue(); // to get the default value of the field
                    $permissions = $field->getFieldLayoutPermissions(); // get field layout permissions.array of permissions list like CREATE,EDIT,VIEW,QUICK_CREATE etc.
                    foreach ($permissions as $permission) { // for each permission
                        echo $permission; // to display the permissions
                    }
                    $lookupfield = $field->getLookupField(); // to get the field lookup information
                    if ($field->getDataType() == "Lookup") {
                        echo $lookupfield->getModule(); // to get the module name of lookupfield
                        echo $lookupfield->getDisplayLabel(); // to get the display label of the lookup field
                        echo $lookupfield->getId(); // to get the id of the lookup field
                    }
                    $picklistfieldvalues = $field->getPickListFieldValues(); // to get the pick list values of the field
                    foreach ($picklistfieldvalues as $picklistfieldvalue) {
                        echo $picklistfieldvalue->getDisplayValue(); // to get display value of the pick list
                        echo $picklistfieldvalue->getSequenceNumber(); // to get the sequence number of the pick list
                        echo $picklistfieldvalue->getActualValue(); // to get the actual value of the pick list
                        echo $picklistfieldvalue->getMaps();
                    }
                    echo $field->isUniqueField(); // to check if the field is unique
                    echo $field->isCaseSensitive(); // to check if the field is case sensitive
                    echo $field->isCurrencyField(); // to check if the field is currency field
                    echo $field->getPrecision(); // to get the precision of the field
                    echo $field->getRoundingOption(); // to get the rounding option of the field
                    echo $field->isFormulaField(); // to check if the field is a formula field
                    if ($field->isFormulaField()) {
                        echo $field->getFormulaReturnType(); // to get the return type of the formula
                        echo $field->getFormulaExpression(); // to get the formula expression
                    }
                    echo $field->isAutoNumberField(); // to check if the field is auto numbering
                    if ($field->isAutoNumberField()) {
                        echo $field->getPrefix(); // to get the prefix value
                        echo $field->getSuffix(); // to get the suffix value
                        echo $field->getStartNumber(); // to get the start number
                    }
                    echo $field->getDecimalPlace(); // to get the decimal place
                    echo $field->getJsonType(); // to get the json type of the field
                    $convertmaps = $field->getConvertMapping();
                    foreach ($convertmaps as $key => $value) {
                        echo $key . ":" . $value;
                    }
                }
            }
            $convertmappings = $layout->getConvertMapping(); // to get an convert mapping array
            foreach ($convertmappings as $convertmapping) {
                echo $convertmapping->getName();
                echo $convertmapping->getId();
                $fields = $convertmapping->getFields();
                if ($fields) {
                    foreach ($fields as $field) {
                        echo $field->getApiName();
                        echo $field->getId();
                        echo $field->getFieldLabel();
                        echo $field->isRequired();
                    }
                }
            }
        }
    }

    public function getCustomView()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getCustomView("{custom_view_id}"); // to get the custom view
        $customView = $response->getData(); // to get the custom view in form of ZCRMCustomView
        echo $customView->getDisplayValue(); // to get the display value of the custom view
        echo $customView->isDefault(); // to check if the custom view is default
        echo $customView->getId(); // to get the id of the custom view
        echo $customView->getName(); // to get the name of the custom view
        echo $customView->getSystemName(); // to get the system name of the custom view
        echo $customView->getSortBy(); // to get the customview Sorted By field Name
        echo $customView->getCategory(); // to get the the category of the custom view
        $fields = $customView->getFields(); // to get the array of fields in custom view
        foreach ($fields as $field) {
            echo $field;
        }
        echo $customView->isFavorite(); // to check if the custom view is favourite
        echo $customView->getSortOrder(); // to get the sort order
        echo $customView->getCriteriaPattern(); // to get the criteria pattern
        $criterias = $customView->getCriteria(); // to get the criteria as a ZCRMCustomViewCriteria instance
        foreach ($criterias as $criteria) {
            echo $criteria->getComparator(); // to get the comparator of the criteria
            echo $criteria->getField(); // to get the field of the criteria
            echo $criteria->getValue(); // to get the value of the criteria
            
        }
        echo $customView->getModuleAPIName(); // to get the module api name of the custom view
        $categories = $customView->getCategoriesList(); // to get the categories list as an array of ZCRMCustomViewCategory
        foreach ($categories as $category) { //
            echo $category->getDisplayValue(); // to get the display value of the category
            echo $category->getActualValue(); // to get the actual value of the category
        }
        echo $customView->isOffLine(); // to check if the custom view is offline
    }

    public function getAllCustomViews()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $param_map = array("page"=>"5","per_page"=>"10");//parameters to be passed
        $response = $moduleIns->getAllCustomViews($param_map); // to get all the custom views /$param_map - optional
        $customViews = $response->getData(); // to get the custom view in form of ZCRMCustomView
        foreach ($customViews as $customView) {
            echo $customView->getDisplayValue(); // to get the display value of the custom view
            echo $customView->isDefault(); // to check if the custom view is default
            echo $customView->getId(); // to get the id of the custom view
            echo $customView->getName(); // to get the name of the custom view
            echo $customView->getSystemName(); // to get the system name of the custom view
            echo $customView->getSortBy(); // to get the customview Sorted By field Name
            echo $customView->getCategory(); // to get the the category of the custom view
            
            echo $customView->isFavorite(); // to check if the custom view is favourite
            echo $customView->getSortOrder(); // to get the sort order
            echo $customView->getCriteriaPattern(); // to get the criteria pattern
            $criterias = $customView->getCriteria(); // to get the criteria as a ZCRMCustomViewCriteria instance
            if($criterias!=NULL){
                foreach ($criterias as $criteria) {
                    echo $criteria->getComparator(); // to get the comparator of the criteria
                    echo $criteria->getField(); // to get the field of the criteria
                    echo $criteria->getValue(); // to get the value of the criteria
                }
            }
            echo $customView->getModuleAPIName(); // to get the module api name of the custom view
            $categories = $customView->getCategoriesList(); // to get the categories list as an array of ZCRMCustomViewCategory
            if($categories!=NULL){
                foreach ($categories as $category) { //
                    echo $category->getDisplayValue(); // to get the display value of the category
                    echo $category->getActualValue(); // to get the actual value of the category
                }
            }
            echo $customView->isOffLine(); // to check if the custom view is offline
        }
    }

    public function updateCustomView()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $customViewInstance = ZCRMCustomView::getInstance("{module_api_name}","{custom_view_id}"); // to get the custom view instance
        $customViewInstance->setSortOrder("desc"); // for ascending order
        $customViewInstance->setSortBy("Lead_owner"); // field api names
        $responseIns = $moduleIns->updateCustomView($customViewInstance);
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode(); // To get update customview http response code
        echo "Status:" . $responseIns->getStatus(); // To get update customview response status
        echo "Message:" . $responseIns->getMessage(); // To get update customview response message
        echo "Code:" . $responseIns->getCode(); // To get update customview status code
        echo "Details:" . json_encode($responseIns->getDetails());
    }

    public function getRelatedListDetails()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getRelatedListDetails("{related_list_id}"); // to get the related list
        $relatedlist = $response->getData(); // to get the related lists as the instance of ZCRMModuleRelatedList
        echo $relatedlist->getApiName(); // to get the api name of the module related list
        echo $relatedlist->getModule(); // to get the module api name to which this module related list is belongs
        echo $relatedlist->getDisplayLabel(); // to get the display Label of the module related list
        echo $relatedlist->isVisible(); // to check whether the module related list is visible
        echo $relatedlist->getName(); // to get name of the module related list
        echo $relatedlist->getId(); // to get id of the module related list
        echo $relatedlist->getHref(); // to get the href of the module related list
        echo $relatedlist->getType(); // to get the type of the module related list
    }

    public function getAllRelatedLists()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $response = $moduleIns->getAllRelatedLists(); // to get all the related lists
        $relatedlists = $response->getData(); // to get the related lists as the instance of ZCRMModuleRelatedList
        foreach ($relatedlists as $relatedlist) // for eachrelated list
        {
            echo $relatedlist->getApiName(); // to get the api name of the module related list
            echo $relatedlist->getModule(); // to get the module api name to which this module related list is belongs
            echo $relatedlist->getDisplayLabel(); // to get the display Label of the module related list
            echo $relatedlist->isVisible(); // to check whether the module related list is visible
            echo $relatedlist->getName(); // to get name of the module related list
            echo $relatedlist->getId(); // to get id of the module related list
            echo $relatedlist->getHref(); // to get the href of the module related list
            echo $relatedlist->getType(); // to get the type of the module related list
        }
    }

    public function getRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $param_map=array("page"=>10,"per_page"=>10); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-15T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $response = $moduleIns->getRecords($param_map,$header_map); // to get the records($param_map - parameter map,$header_map - header map
        $records = $response->getData(); // To get response data

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
                if($layouts != null)
                {
                    echo $layouts->getId(); // To get layout_id
                    echo $layouts->getName(); // To get layout name
                }
                
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
                $tags = $record->getTags();
                foreach($tags as $tag)
                {
                    echo $tag->getId();
                    echo $tag->getName();
                }
//                 /* End Event */
            }
        } catch (ZCRMException $ex) {
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
        }
    }

    public function getRecord()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $param_map = array("fields"=>"Company,Last_Name"); // key-value pair containing all the params - optional
        $header_map = array("header_name"=>"header_value"); // key-value pair containing all the headers - optional
        $response = $moduleIns->getRecord("{record_id}",$param_map,$header_map); // To get module records
        $record = $response->getData(); // To get response data
        try {
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
            if($layouts != null)
            {
                echo $layouts->getId(); // To get layout_id
                echo $layouts->getName(); // To get layout name
            }

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
            
            $tags = $record->getTags();
            foreach($tags as $tag)
            {
                echo $tag->getId();
                echo $tag->getName();
            }
            /* End Event */
        } catch (ZCRMException $ex) {
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
        }
    }

    public function searchRecordsByWord()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $searchWord="automated";//word to search for
        $param_map=array("page"=>1,"per_page"=>1); // key-value pair containing all the parameters
        $response = $moduleIns->searchRecordsByWord($searchWord,$param_map) ;// To get module records// $searchWord word to be searched// $param_map-parameters key-value pair - optional
        $records = $response->getData(); // To get response data
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
//                 echo $layouts->getId(); // To get layout_id
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

    public function searchRecordsByPhone()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $phone=313213;//phone number to search for
        $param_map=array("page"=>1,"per_page"=>1); // key-value pair containing all the parameters
        $response = $moduleIns->searchRecordsByPhone($phone,$param_map) ;// To get module records// $phone phone to be searched// $param_map-parameters key-value pair - optional
        $records = $response->getData(); // To get response data
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
                        echo $value->getEntityId();
                        echo $value->getModuleApiName();
                        echo $value->getLookupLabel();
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

    public function searchRecordsByEmail()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $email="email_id";//email id  to search for
        $param_map=array("page"=>1,"per_page"=>1); // key-value pair containing all the parameters
        try {
            $response = $moduleIns->searchRecordsByEmail($email,$param_map) ;// To get module records// $email email id  to search for// $param_map-parameters key-value pair - optional
            $records = $response->getData(); // To get response data
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
                        echo $value->getEntityId();
                        echo $value->getModuleApiName();
                        echo $value->getLookupLabel();
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

    public function searchRecordsByCriteria()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // To get module instance
        $criteria="criteria";//criteria to search for
        $param_map=array("page"=>1,"per_page"=>1); // key-value pair containing all the parameters
        $response = $moduleIns->searchRecordsByCriteria($criteria,$param_map) ;// To get module records// $criteria to search for  to search for// $param_map-parameters key-value pair - optional
        $records = $response->getData(); // To get response data
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

    public function massUpdateRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $entityIds = array(
            "{record_id}"
        ); // array of entity ids
        $responseIn = $moduleIns->massUpdateRecords($entityIds, "{field_api_name}", "field_value}"); // to update the field api name with corresponding field value for the entities
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }

    public function updateRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $inventoryRecords = array();
        /**
         * Following methods are being used only by same Inventory only  *
         */
        $record = ZCRMRecord::getInstance("{module_api_name}", "{record_id}"); // to get the instance of the record
        $record->setFieldValue("Subject", "Invoice3"); // This function use to set FieldApiName and value similar to all other FieldApis and Custom field
        $record->setFieldValue("Account_Name", "{account_id}");
        $lineItem = ZCRMInventoryLineItem::getInstance("{line_item_id}"); // To get ZCRMInventoryLineItem instance
        $lineItem->setDescription("Product_description"); // To set line item description
        $lineItem->setDiscount(20); // To set line item discount
        $lineItem->setListPrice(3412); // To set line item list price

        $taxInstance1 = ZCRMTax::getInstance("{tax_name}"); // to get the tax instance
        $taxInstance1->setPercentage(20); // to set the tax percentage
        $taxInstance1->setValue(50); // to set the tax value
        $lineItem->addLineTax($taxInstance1); // to add the tax to the line item

        $lineItem->setQuantity(101); // To set product quantity to this line item
        $record->addLineItem($lineItem); // to add the line item to the record of invoice
        

        
        array_push($inventoryRecords, $record); // pushing the record to the array
        
        $record2 = ZCRMRecord::getInstance("{module_api_name}", "{record_id}"); // to get the instance of the record
        $record2->setFieldValue("Subject", "Invoice3"); // This function use to set FieldApiName and value similar to all other FieldApis and Custom field
        $record2->setFieldValue("Account_Name", "{account_id}");
        $lineItem = ZCRMInventoryLineItem::getInstance("{line_item_id}"); // To get ZCRMInventoryLineItem instance
        $lineItem->setDescription("Product_description"); // To set line item description
        $lineItem->setDiscount(20); // To set line item discount
        $lineItem->setListPrice(3412); // To set line item list price

        $taxInstance1 = ZCRMTax::getInstance("{tax_name}"); // to get the tax instance
        $taxInstance1->setPercentage(20); // to set the tax percentage
        $taxInstance1->setValue(50); // to set the tax value
        $lineItem->addLineTax($taxInstance1); // to add the tax to the line item

        $lineItem->setQuantity(101); // To set product quantity to this line item
        $record2->addLineItem($lineItem); // to add the line item to the record of invoice
        

        
        array_push($inventoryRecords, $record2); // pushing the record to the array
        
        
        /**
         * for Price books module only
         */
        $pricebookRecords = array();
        
        $record = ZCRMRecord::getInstance("Price_Books", "price_book_id"); // to get the price book record
        $record->setFieldValue("Pricing_Details", json_decode('[ { "to_range": 5, "discount": 0, "from_range": 1 }, { "to_range": 11, "discount": 1, "from_range": 6 }, { "to_range": 17, "discount": 2, "from_range": 12 }, { "to_range": 23, "discount": 3, "from_range": 18 }, { "to_range": 29, "discount": 4, "from_range": 24 } ]', true)); // setting the discount , range of the pricebook record
        $record->setFieldValue("Pricing_Model", "Flat"); // setting the price book model
        array_push($pricebookRecords, $record); // pushing the record to the array

        
        $trigger=array();//triggers to include
        $responseIn = $moduleIns->updateRecords($inventoryRecords,$trigger); // updating the records.$trigger is optional , to update price book records$pricebookRecords can be used in the place of $inventoryRecords
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }
    public function upsertRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Leads"); // to get the instance of the module
        $records = array();
        /**
         * Following methods are being used only by Inventory modules *
         */
        $record = ZCRMRecord::getInstance("Leads", null); // to get the instance of the record
        $record->setFieldValue("Comapny", "Invoice3"); // This function use to set FieldApiName and value similar to all other FieldApis and Custom field
        $record->setFieldValue("Email", "asdasd@asd.com");

         
        array_push($records, $record); // pushing the record to the array

        $responseIn = $moduleIns->upsertRecords($records); // updating the records.$trigger
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }
    public function createRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $records = array();
        $record = ZCRMRecord::getInstance("{module_api_name}", null); // To get ZCRMRecord instance
        $record->setFieldValue("Subject", "Invoice"); // This function use to set FieldApiName and value similar to all other FieldApis and Custom field
        $record->setFieldValue("Account_Name", "{account_id}"); // This function is for Invoices module
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

        $taxInstance1 = ZCRMTax::getInstance("{tax_name}"); // to get the tax instance
        $taxInstance1->setPercentage(12); // to set the tax percentage
        $taxInstance1->setValue(50); // to set the tax value
        $lineItem->addLineTax($taxInstance1); // to add the tax to line item

        $lineItem->setProduct(ZCRMRecord::getInstance("{module_api_name}", "{record_id}")); // To set product to line item
        $lineItem->setQuantity(100); // To set product quantity to this line item

        $record->addLineItem($lineItem); // to add the line item to the record

        array_push($records, $record); // pushing the record to the array.
        $trigger=array();//triggers to include
        $lar_id="lar_id";//lead assignment rule id
        $responseIn = $moduleIns->createRecords($records,$trigger,$lar_id); // updating the records.$trigger,$lar_id are optional
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }

    public function deleteRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $recordids = array(
            "{record_id}",
            "{record_id}"
        ); // to create an array of record ids
        $responseIn = $moduleIns->deleteRecords($recordids); // to delete the records

        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }

    public function getAllDeletedRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $trashRecords = $moduleIns->getAllDeletedRecords($param_map,$header_map)->getData(); // to get the trashrecords inform of ZCRMTrashRecord array instances/$param_map - parameter map, $header_map - header_map
        foreach ($trashRecords as $trashrecord) {
            echo $trashrecord->getEntityId(); // to get the entity if of the trash record
            echo $trashrecord->getDisplayName(); // to get the display name if the trash record
        }
    }

    public function getRecycleBinRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $trashRecords = $moduleIns->getRecycleBinRecords($param_map,$header_map)->getData(); // to get the trashrecords inform of ZCRMTrashRecord array instances/$param_map - parameter map, $header_map - header_map
        foreach ($trashRecords as $trashrecord) {
            echo $trashrecord->getEntityId(); // to get the entity if of the trash record
            echo $trashrecord->getDisplayName(); // to get the display name if the trash record
        }
    }

    public function getPermanentlyDeletedRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $param_map=array("page"=>"20","per_page"=>"200"); // key-value pair containing all the parameters - optional
        $header_map = array("if-modified-since"=>"2019-11-10T15:26:49+05:30"); // key-value pair containing all the headers - optional
        $trashRecords = $moduleIns->getPermanentlyDeletedRecords($param_map,$header_map)->getData(); // to get the trashrecords inform of ZCRMTrashRecord array instances/$param_map - parameter map, $header_map - header_map
        foreach ($trashRecords as $trashrecord) {
            echo $trashrecord->getEntityId(); // to get the entity if of the trash record
            echo $trashrecord->getDisplayName(); // to get the display name if the trash record
        }
    }

    public function getTagCount()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $tag_count = $moduleIns->getTagCount("{record_id}")
            ->getData()
            ->getCount(); // to get the tag count
        echo $tag_count;
    }

    public function createTags()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $tags = array(); // to create ZCRMTag instances array
        $tag = ZCRMTag::getInstance(); // to get the tag instance
        $tag->setName("test4"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $responseIn = $moduleIns->createTags($tags); // to create the tags
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }

    public function updateTags()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $tags = array(); // to create ZCRMTag instances array
        $tag = ZCRMTag::getInstance("{tag_id}"); // to get the tag instance
        $tag->setName("testnew"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $tag = ZCRMTag::getInstance("{tag_id}"); // to get the tag instance
        $tag->setName("testnew2"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $responseIn = $moduleIns->updateTags($tags); // to update the tags
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }

    public function addTagsToRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $recordids = array(
            "{record_id}",
            "{record_id}"
        ); // array of record ids from which tags must be added
        $tagnames = array(
            "tea",
            "test2",
            "test3"
        ); // array of tags to be added
        $responseIn = $moduleIns->addTagsToRecords($recordids, $tagnames); // to add the tags to the record
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }
    }

    public function removeTagsFromRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $recordids = array(
            "{record_id}",
            "{record_id}"
        ); // array of record ids from which tags must be removed
        $tagnames = array(
            "tea",
            "test2",
            "test3"
        ); // array of tags to be removed
        $responseIn = $moduleIns->removeTagsFromRecords($recordids, $tagnames); // to remove the tags from the records
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus();  //To get response status
        echo "Message:".$responseIns->getMessage();  //To get response message
        echo "Code:".$responseIns->getCode();  //To get status code
        echo "Details:".json_encode($responseIns->getDetails());
    }
}
}

$obj = new Module();
$obj->getRecord();
?>