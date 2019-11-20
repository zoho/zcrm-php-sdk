<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMCustomView;
use zcrmsdk\crm\crud\ZCRMCustomViewCategory;
use zcrmsdk\crm\crud\ZCRMCustomViewCriteria;
use zcrmsdk\crm\crud\ZCRMField;
use zcrmsdk\crm\crud\ZCRMLayout;
use zcrmsdk\crm\crud\ZCRMLeadConvertMapping;
use zcrmsdk\crm\crud\ZCRMLeadConvertMappingField;
use zcrmsdk\crm\crud\ZCRMLookupField;
use zcrmsdk\crm\crud\ZCRMModule;
use zcrmsdk\crm\crud\ZCRMModuleRelatedList;
use zcrmsdk\crm\crud\ZCRMPickListValue;
use zcrmsdk\crm\crud\ZCRMSection;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMProfile;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

class ModuleAPIHandler extends APIHandler
{
    
    private $module = null;
    
    private function __construct($module)
    {
        $this->module = $module;
    }
    
    public static function getInstance(ZCRMModule $module)
    {
        return new ModuleAPIHandler($module);
    }
    
    public function getModuleDetails()
    {
        $this->module = MetaDataAPIHandler::getInstance()->getModule($this->module->getAPIName())->getData();
    }
    
    /**
     * Method to get the specified Field details
     * Returns api response with ZCRMField instance
     */
    public function getFieldDetails($fieldId)
    {
        try {
            $this->urlPath = "settings/fields/" . $fieldId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $fieldObj = $responseJSON['fields'][0];
            $responseInstance->setData(self::getZCRMField($fieldObj));
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to get all the Fields of a module
     * Returns api response with array of ZCRMField instances
     */
    public function getAllFields()
    {
        try {
            $this->urlPath = "settings/fields";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $fields = $responseJSON['fields'];
            $fieldInstancesArray = array();
            foreach ($fields as $fieldObj) {
                array_push($fieldInstancesArray, self::getZCRMField($fieldObj));
            }
            $responseInstance->setData($fieldInstancesArray);
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
        
        return $responseInstance;
    }
    
    /**
     * Method to get all the layouts of a module
     * Returns api response with array of ZCRMLayout instances
     */
    public function getAllLayouts()
    {
        try {
            $this->urlPath = "settings/layouts";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $allLayouts = $responseJSON['layouts'];
            $layoutInstancesArray = array();
            foreach ($allLayouts as $layoutObj) {
                array_push($layoutInstancesArray, self::getZCRMLayout($layoutObj));
            }
            $responseInstance->setData($layoutInstancesArray);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to get the specified layout
     * Input:: layout id
     * Returns api response with ZCRMLayout instance
     */
    public function getLayoutDetails($layoutId)
    {
        try {
            $this->urlPath = "settings/layouts/" . $layoutId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $layoutDetails = $responseJSON['layouts'][0];
            $responseInstance->setData(self::getZCRMLayout($layoutDetails));
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to get the specified custom view details
     * Input:: custom view id
     * Returns api response with ZCRMCustomView instance
     */
    public function getCustomView($customViewId)
    {
        try {
            $this->urlPath = "settings/custom_views/" . $customViewId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $categories = $responseJSON['info']['translation'];
            $responseInstance->setData(MetaDataAPIHandler::getInstance()->getZCRMCustomView($this->module->getAPIName(),$responseJSON['custom_views'][0], $categories));
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to get all the custom views of a module
     * Returns api response with array of ZCRMCustomView instances
     */
    public function getAllCustomViews($param_map)
    {
        try {
            $this->urlPath = "settings/custom_views";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            foreach($param_map as $key=>$value){
                if($value!=null)$this->addParam($key,$value);
            }
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $customViews = $responseJSON['custom_views'];
            $categories = $responseJSON['info']['translation'];
            $customViewInstances = array();
            foreach ($customViews as $customView) {
                array_push($customViewInstances, MetaDataAPIHandler::getInstance()->getZCRMCustomView($this->module->getAPIName(),$customView, $categories));
            }
            $responseInstance->setData($customViewInstances);
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to update module settings
     * Input:: ZCRMModule instance with the properties to get updated
     * Returns api response
     */
    public function updateModuleSettings()
    {
        try {
            $inputJSON = self::constructJSONForModuleUpdate($this->module);
            $this->urlPath = "settings/modules/" . $this->module->getAPIName();
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $this->requestBody = $inputJSON;
            $this->apiKey = 'modules';
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to update custom view settings of a module
     * Input:: ZCRMCustomView instance with the properties to get updated
     * Returns api response
     */
    public function updateCustomView($customViewInstance)
    {
        try {
            $inputJSON = self::constructJSONForCustomView($customViewInstance);
            $this->urlPath = "settings/custom_views/" . $customViewInstance->getId();
            $this->requestMethod = APIConstants::REQUEST_METHOD_PUT;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $this->requestBody = $inputJSON;
            // $this->apiKey='custom_views';
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to get all the related lists of a module
     * Returns api response with array of related list instances
     */
    public function getAllRelatedLists()
    {
        try {
            $this->urlPath = "settings/related_lists";
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $relatedListArray = $responseJSON['related_lists'];
            $relatedListInstanceArray = array();
            foreach ($relatedListArray as $relatedListObj) {
                $moduleRelatedListIns = ZCRMModuleRelatedList::getInstance($relatedListObj['api_name']);
                array_push($relatedListInstanceArray, $moduleRelatedListIns->setRelatedListProperties($relatedListObj));
            }
            $responseInstance->setData($relatedListInstanceArray);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    /**
     * Method to get the specified related list
     * Returns api response with related list instance
     */
    public function getRelatedListDetails($relatedListId)
    {
        try {
            $this->urlPath = "settings/related_lists/" . $relatedListId;
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->addHeader("Content-Type", "application/json");
            $this->addParam("module", $this->module->getAPIName());
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $relatedListArray = $responseJSON['related_lists'];
            $relatedListObj = $relatedListArray[0];
            $moduleRelatedListIns = ZCRMModuleRelatedList::getInstance($relatedListObj['api_name']);
            $moduleRelatedListIns = $moduleRelatedListIns->setRelatedListProperties($relatedListObj);
            $responseInstance->setData($moduleRelatedListIns);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getLayouts($allLayoutDetails)
    {
        $layoutArray = array();
        foreach ($allLayoutDetails as $eachLayout) {
            array_push($layoutArray, self::getZCRMLayout($eachLayout));
        }
        return $layoutArray;
    }
    
    public function getAllSectionsOfLayout($allSectionDetails)
    {
        $sectionsArray = array();
        foreach ($allSectionDetails as $eachSection) {
            $sectionInstance = ZCRMSection::getInstance($eachSection['name']);
            
            $sectionInstance->setDisplayName($eachSection['display_label']);
            $sectionInstance->setColumnCount($eachSection['column_count'] + 0);
            $sectionInstance->setSequenceNumber($eachSection['sequence_number'] + 0);
            $sectionInstance->setFields(self::getSectionFields($eachSection['fields']));
            
            array_push($sectionsArray, $sectionInstance);
        }
        
        return $sectionsArray;
    }
    
    public function getSectionFields($allFieldArray)
    {
        $fieldsArray = array();
        foreach ($allFieldArray as $eachField) {
            array_push($fieldsArray, self::getZCRMField($eachField));
        }
        return $fieldsArray;
    }
    
    public function getFields($allFieldArray)
    {
        $fieldsArray = array();
        foreach ($allFieldArray as $eachField) {
            array_push($fieldsArray, self::getZCRMField($eachField));
        }
        return $fieldsArray;
    }
    
    /**
     * Method to process the given section field details and set them in ZCRMField instance
     * Input:: section field details as array
     * Returns ZCRMField instance
     */
    public function getZCRMFieldForSection($fieldDetails)
    {
        $fieldInstance = ZCRMField::getInstance($fieldDetails['api_name']);
        $fieldInstance->setSequenceNumber($fieldDetails['sequence_number'] + 0);
        $fieldInstance->setMandatory((boolean) $fieldDetails['required']);
        $fieldInstance->setDefaultValue($fieldDetails['default_value']);
        $fieldInstance->setId($fieldDetails['id']);
        $pickListArray = $fieldDetails['pick_list_values'];
        $pickListInstanceArray = array();
        foreach ($pickListArray as $pickList) {
            array_push($pickListInstanceArray, self::getPickListValueInstance($pickList));
        }
        $fieldInstance->setPickListFieldValues($pickListInstanceArray);
        
        return $fieldInstance;
    }
    
    /**
     * Method to process the given field details and set them in ZCRMField instance
     * Input:: field details as array
     * Returns ZCRMField instance
     */
    public function getZCRMField($fieldDetails)
    {
        $fieldInstance = ZCRMField::getInstance($fieldDetails['api_name']);
        $fieldInstance->setSequenceNumber(isset($fieldDetails['sequence_number']) ? $fieldDetails['sequence_number'] + 0 : 0);
        $fieldInstance->setId($fieldDetails['id']);
        $fieldInstance->setMandatory(isset($fieldDetails['required']) ? (boolean) $fieldDetails['required'] : false);
        $fieldInstance->setDefaultValue(isset($fieldDetails['default_value']) ? $fieldDetails['default_value'] : null);
        if (array_key_exists("custom_field", $fieldDetails)) {
            $fieldInstance->setCustomField((boolean) $fieldDetails['custom_field']);
        }
        if (array_key_exists("visible", $fieldDetails)) {
            $fieldInstance->setVisible((boolean) $fieldDetails['visible']);
        }
        if (array_key_exists("field_label", $fieldDetails)) {
            $fieldInstance->setFieldLabel($fieldDetails['field_label']);
        }
        if (array_key_exists("length", $fieldDetails)) {
            $fieldInstance->setLength($fieldDetails['length'] + 0);
        }
        if (array_key_exists("created_source", $fieldDetails)) {
            $fieldInstance->setCreatedSource($fieldDetails['created_source']);
        }
        if (array_key_exists("read_only", $fieldDetails)) {
            $fieldInstance->setReadOnly((boolean) $fieldDetails['read_only']);
        }
        if (array_key_exists("businesscard_supported", $fieldDetails)) {
            $fieldInstance->setBusinessCardSupported((boolean) $fieldDetails['businesscard_supported']);
        }
        if (array_key_exists("data_type", $fieldDetails)) {
            $fieldInstance->setDataType($fieldDetails['data_type']);
        }
        if (array_key_exists("convert_mapping", $fieldDetails)) {
            $fieldInstance->setConvertMapping($fieldDetails['convert_mapping']);
        }
        
        if (array_key_exists("view_type", $fieldDetails)) {
            $viewTypeArray = $fieldDetails['view_type'];
            $fieldLayoutPermissions = array();
            if ($viewTypeArray['view']) {
                array_push($fieldLayoutPermissions, "VIEW");
            }
            if ($viewTypeArray['quick_create']) {
                array_push($fieldLayoutPermissions, "QUICK_CREATE");
            }
            if ($viewTypeArray['create']) {
                array_push($fieldLayoutPermissions, "CREATE");
            }
            if ($viewTypeArray['edit']) {
                array_push($fieldLayoutPermissions, "EDIT");
            }
            $fieldInstance->setFieldLayoutPermissions($fieldLayoutPermissions);
        }
        
        $pickListArray = $fieldDetails['pick_list_values'];
        if (sizeof($pickListArray) > 0) {
            $pickListInstanceArray = array();
            foreach ($pickListArray as $pickList) {
                array_push($pickListInstanceArray, self::getPickListValueInstance($pickList));
            }
            $fieldInstance->setPickListFieldValues($pickListInstanceArray);
        }
        if (array_key_exists("lookup", $fieldDetails) && sizeof($fieldDetails['lookup']) > 0) {
            $fieldInstance->setLookUpField(self::getLookupFieldInstance($fieldDetails['lookup']));
        }
        
        if (array_key_exists("unique", $fieldDetails) && sizeof($fieldDetails['unique']) > 0) {
            $fieldInstance->setUniqueField(true);
            $fieldInstance->setCaseSensitive((boolean) ($fieldDetails['unique']['casesensitive']));
        }
        if (array_key_exists("decimal_place", $fieldDetails) && $fieldDetails['decimal_place'] != null) {
            $fieldInstance->setDecimalPlace($fieldDetails['decimal_place'] + 0);
        }
        if (array_key_exists("json_type", $fieldDetails) && $fieldDetails['json_type'] != null) {
            $fieldInstance->setJsonType($fieldDetails['json_type']);
        }
        if (array_key_exists("formula", $fieldDetails) && sizeof($fieldDetails['formula']) > 0) {
            $fieldInstance->setFormulaField(true);
            $fieldInstance->setFormulaReturnType($fieldDetails['formula']['return_type']);
            if (isset($fieldDetails['formula']['expression'])) {
                $fieldInstance->setFormulaExpression($fieldDetails['formula']['expression']);
            }
        }
        if (array_key_exists("currency", $fieldDetails) && sizeof($fieldDetails['currency']) > 0) {
            $fieldInstance->setCurrencyField(true);
            $currencyFieldDetails = $fieldDetails['currency'];
            $fieldInstance->setPrecision(isset($currencyFieldDetails['precision']) ? $currencyFieldDetails['precision'] + 0 : 0);
            if (isset($currencyFieldDetails['rounding_option'])) {
                $fieldInstance->setRoundingOption($currencyFieldDetails['rounding_option']);
            }
        }
        if (array_key_exists("auto_number", $fieldDetails) && sizeof($fieldDetails['auto_number']) > 0) {
            $fieldInstance->setAutoNumber(true);
            $fieldInstance->setPrefix(array_key_exists('prefix', $fieldDetails['auto_number']) ? $fieldDetails['auto_number']['prefix'] : null);
            $fieldInstance->setSuffix(array_key_exists('suffix', $fieldDetails['auto_number']) ? $fieldDetails['auto_number']['suffix'] : null);
            $fieldInstance->setStartNumber(array_key_exists('start_number', $fieldDetails['auto_number']) ? $fieldDetails['auto_number']['start_number'] + 0 : null);
        }
        return $fieldInstance;
    }
    
    /**
     * Method to process the given lookup field details and set them in ZCRMLookupField instance
     * Input:: lookup field details as array
     * Returns ZCRMLookupField instance
     */
    public function getLookupFieldInstance($lookupDetails)
    {
        $lookupInstance = ZCRMLookupField::getInstance(isset($lookupDetails['api_name'])?$lookupDetails['api_name']:null);
        
        if(isset($lookupDetails['display_label']))
            $lookupInstance->setDisplayLabel($lookupDetails['display_label']);
            if(isset($lookupDetails['id']))
                $lookupInstance->setId($lookupDetails['id']);
                if(isset($lookupDetails['module']))
                    $lookupInstance->setModule($lookupDetails['module']);
                    return $lookupInstance;
    }
    
    /**
     * Method to process the given Picklist details and set them in ZCRMPickListValue instance
     * Input:: picklist details as array
     * Returns ZCRMPickListValue instance
     */
    public function getPickListValueInstance($pickListDetails)
    {
        $pickListInstance = ZCRMPickListValue::getInstance();
        $pickListInstance->setDisplayValue($pickListDetails['display_value']);
        $pickListInstance->setActualValue($pickListDetails['actual_value']);
        if (isset($pickListDetails['sequence_number'])) {
            $pickListInstance->setSequenceNumber($pickListDetails['sequence_number']);
        }
        if (isset($pickListDetails['maps'])) {
            $pickListInstance->setMaps($pickListDetails['maps']);
        }
        
        return $pickListInstance;
    }
    
    /**
     * Method to process the given layout details and set them in ZCRMLayout instance
     * Input:: layout details as array
     * Returns ZCRMLayout instance
     */
    public function getZCRMLayout($layoutDetails)
    {
        $layoutInstance = ZCRMLayout::getInstance($layoutDetails['id']);
        $layoutInstance->setCreatedTime($layoutDetails['created_time']);
        $layoutInstance->setModifiedTime($layoutDetails['modified_time']);
        $layoutInstance->setName($layoutDetails['name']);
        $layoutInstance->setVisible((boolean) $layoutDetails['visible']);
        if ($layoutDetails['created_by'] != null) {
            $userInstance = ZCRMUser::getInstance((($layoutDetails['created_by']['id'])), $layoutDetails['created_by']['name']);
            $layoutInstance->setCreatedBy($userInstance);
        }
        if ($layoutDetails['modified_by'] != null) {
            $userInstance = ZCRMUser::getInstance((($layoutDetails['modified_by']['id'])), $layoutDetails['modified_by']['name']);
            $layoutInstance->setModifiedBy($userInstance);
        }
        $accessibleProfileArray = $layoutDetails['profiles'];
        $accessibleProfileInstances = array();
        foreach ($accessibleProfileArray as $profile) {
            $profileInstance = ZCRMProfile::getInstance($profile['id'], $profile['name']);
            $profileInstance->setDefaultProfile((boolean) $profile['default']);
            array_push($accessibleProfileInstances, $profileInstance);
        }
        $layoutInstance->setAccessibleProfiles($accessibleProfileInstances);
        
        $layoutInstance->setSections(self::getAllSectionsOfLayout($layoutDetails['sections']));
        
        $layoutInstance->setStatus($layoutDetails['status']);
        
        if (isset($layoutDetails['convert_mapping'])) {
            $convertModules = array(
                'Contacts',
                'Deals',
                'Accounts'
            );
            foreach ($convertModules as $convertModule) {
                if (isset($layoutDetails['convert_mapping'][$convertModule])) {
                    $contactsMap = $layoutDetails['convert_mapping'][$convertModule];
                    $convertMapIns = ZCRMLeadConvertMapping::getInstance($contactsMap['name'], $contactsMap['id']);
                    if (isset($contactsMap['fields'])) {
                        $fields = $contactsMap['fields'];
                        foreach ($fields as $field) {
                            $convertMappingFieldIns = ZCRMLeadConvertMappingField::getInstance($field['api_name'], $field['id']);
                            $convertMappingFieldIns->setFieldLabel($field['field_label']);
                            $convertMappingFieldIns->setRequired($field['required']);
                            $convertMapIns->addFields($convertMappingFieldIns);
                        }
                    }
                    $layoutInstance->addConvertMapping($convertModule, $convertMapIns);
                }
            }
        }
        
        return $layoutInstance;
    }
    
    public function constructJSONForCustomView($customViewInstance)
    {
        $customViewDetails = array();
        if ($customViewInstance->getSortBy() !== null) {
            $customViewDetails['sort_by'] = $customViewInstance->getSortBy();
        }
        if ($customViewInstance->getSortOrder() !== null) {
            $customViewDetails['sort_order'] = $customViewInstance->getSortOrder();
        }
        /*
         * if($customViewInstance->getDisplayValue()!=null)
         * {
         * $customViewDetails['display_value']=$customViewInstance->getDisplayValue();
         * }
         * if($customViewInstance->isDefault()!=null)
         * {
         * $customViewDetails['default']=(boolean)$customViewInstance->isDefault();
         * }
         * if($customViewInstance->getName()!=null)
         * {
         * $customViewDetails['name']=$customViewInstance->getName();
         * }
         * if($customViewInstance->isFavorite()!=null)
         * {
         * $customViewDetails['favorite']=(boolean)$customViewInstance->isFavorite();
         * }
         * if($customViewInstance->getFields()!=null)
         * {
         * $customViewDetails['fields']=$customViewInstance->getFields();
         * }
         * if($customViewInstance->getCriteria()!=null)
         * {
         * $criteriaInstances=$customViewInstance->getCriteria();
         * }
         */
         $customViewJSON = array(
             "custom_views" => array(
                 $customViewDetails
             )
         );
         
         return json_encode($customViewJSON);
    }
    
    public function constructJSONForModuleUpdate($moduleInstance)
    {
        $moduleSettings = array();
        if ($moduleInstance->getPerPage() != null) {
            $moduleSettings['per_page'] = $moduleInstance->getPerPage() + 0;
        }
        if ($moduleInstance->getBusinessCardFields() != null) {
            $moduleSettings['business_card_fields'] = $moduleInstance->getBusinessCardFields();
        }
        if ($moduleInstance->getDefaultCustomViewId() != null) {
            $moduleSettings['custom_view'] = array(
                "id" => $moduleInstance->getDefaultCustomViewId()
            );
        }
        if ($moduleInstance->getDefaultTerritoryId() != null) {
            $moduleSettings['territory'] = array(
                "id" => $moduleInstance->getDefaultTerritoryId()
            );
        }
        if ($moduleInstance->getRelatedListProperties() != null) {
            $propArray = array();
            $relatedListProps = $moduleInstance->getRelatedListProperties();
            $propArray['sort_by'] = $relatedListProps->getSortBy();
            $propArray['sort_order'] = $relatedListProps->getSortOrder();
            $propArray['fields'] = $relatedListProps->getFields();
            $moduleSettings['related_list_properties'] = $propArray;
        }
        $moduleJSON = array(
            "modules" => array(
                $moduleSettings
            )
        );
        
        return json_encode($moduleJSON);
    }
}