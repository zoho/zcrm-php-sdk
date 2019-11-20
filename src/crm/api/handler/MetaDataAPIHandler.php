<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMCustomView;
use zcrmsdk\crm\crud\ZCRMCustomViewCategory;
use zcrmsdk\crm\crud\ZCRMCustomViewCriteria;
use zcrmsdk\crm\crud\ZCRMModule;
use zcrmsdk\crm\crud\ZCRMModuleRelatedList;
use zcrmsdk\crm\crud\ZCRMRelatedListProperties;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMProfile;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

class MetaDataAPIHandler extends APIHandler
{
    
    private function __construct()
    {}
    
    public static function getInstance()
    {
        return new MetaDataAPIHandler();
    }
    
    public function getAllModules()
    {
        try {
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = "settings/modules";
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
            $responseJSON = $responseInstance->getResponseJSON();
            $modulesArray = $responseJSON['modules'];
            $responseData = array();
            foreach ($modulesArray as $eachmodule) {
                $module = self::getZCRMModule($eachmodule);
                array_push($responseData, $module);
            }
            $responseInstance->setData($responseData);
            
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getModule($moduleName)
    {
        try {
            $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
            $this->urlPath = "settings/modules/" . $moduleName;
            $this->addHeader("Content-Type", "application/json");
            $responseInstance = APIRequest::getInstance($this)->getAPIResponse();
            $moduleArray = $responseInstance->getResponseJSON()['modules'];
            $responseInstance->setData(self::getZCRMModule($moduleArray[0]));
            return $responseInstance;
        } catch (ZCRMException $exception) {
            APIExceptionHandler::logException($exception);
            throw $exception;
        }
    }
    
    public function getZCRMModule($moduleDetails)
    {
        $crmModuleInstance = ZCRMModule::getInstance($moduleDetails[APIConstants::API_NAME]);
        $crmModuleInstance->setViewable($moduleDetails['viewable']);
        $crmModuleInstance->setCreatable($moduleDetails['creatable']);
        $crmModuleInstance->setConvertable($moduleDetails['convertable']);
        $crmModuleInstance->setEditable($moduleDetails['editable']);
        $crmModuleInstance->setDeletable($moduleDetails['deletable']);
        $crmModuleInstance->setWebLink(array_key_exists("web_link", $moduleDetails) ? $moduleDetails['web_link'] : null);
        $crmModuleInstance->setSingularLabel($moduleDetails['singular_label']);
        $crmModuleInstance->setPluralLabel($moduleDetails['plural_label']);
        $crmModuleInstance->setId($moduleDetails['id']);
        $crmModuleInstance->setModifiedTime($moduleDetails['modified_time']);
        $crmModuleInstance->setApiSupported($moduleDetails['api_supported']);
        $crmModuleInstance->setScoringSupported($moduleDetails['scoring_supported']);
        $crmModuleInstance->setModuleName($moduleDetails['module_name']);
        $crmModuleInstance->setBusinessCardFieldLimit(array_key_exists("business_card_field_limit", $moduleDetails) ? $moduleDetails['business_card_field_limit'] + 0 : 0);
        if (isset($moduleDetails['sequence_number'])) {
            $crmModuleInstance->setSequenceNumber($moduleDetails['sequence_number']);
        }
        
        if (isset($moduleDetails['global_search_supported'])) {
            $crmModuleInstance->setGlobalSearchSupported($moduleDetails['global_search_supported']);
        }
        
        $zcrmUserInstance = null;
        if ($moduleDetails['modified_by'] != null) {
            $zcrmUserInstance = ZCRMUser::getInstance(($moduleDetails['modified_by']["id"]), $moduleDetails['modified_by']["name"]);
        }
        $crmModuleInstance->setModifiedBy($zcrmUserInstance);
        $crmModuleInstance->setCustomModule('custom' === $moduleDetails['generated_type']);
        
        if (array_key_exists("business_card_fields", $moduleDetails)) {
            $crmModuleInstance->setBusinessCardFields($moduleDetails['business_card_fields']);
        }
        
        $profileArray = $moduleDetails['profiles'];
        $profileInstanceArray = array();
        foreach ($profileArray as $eachProfile) {
            array_push($profileInstanceArray, ZCRMProfile::getInstance($eachProfile['id'], $eachProfile['name']));
        }
        $crmModuleInstance->setAllProfiles($profileInstanceArray);
        
        if (array_key_exists("display_field", $moduleDetails)) {
            $crmModuleInstance->setDisplayFieldName($moduleDetails['display_field']);
        }
        $relatedListInstanceArray = null;
        if (array_key_exists("related_lists", $moduleDetails)) {
            $relatedListArray = $moduleDetails['related_lists'];
            $relatedListInstanceArray = array();
            foreach ($relatedListArray as $relatedListObj) {
                $moduleRelatedListIns = ZCRMModuleRelatedList::getInstance($relatedListObj['api_name']);
                array_push($relatedListInstanceArray, $moduleRelatedListIns->setRelatedListProperties($relatedListObj));
            }
        }
        $crmModuleInstance->setRelatedLists($relatedListInstanceArray);
        if (array_key_exists("layouts", $moduleDetails)) {
            $crmModuleInstance->setLayouts(ModuleAPIHandler::getInstance(ZCRMModule::getInstance($moduleDetails[APIConstants::API_NAME]))->getLayouts($moduleDetails['layouts']));
        }
        
        if (array_key_exists("fields", $moduleDetails) && $moduleDetails['fields'] != null) {
            $crmModuleInstance->setFields(ModuleAPIHandler::getInstance(ZCRMModule::getInstance($moduleDetails[APIConstants::API_NAME]))->getFields($moduleDetails['fields']));
        }
        
        if (array_key_exists("related_list_properties", $moduleDetails) && $moduleDetails['related_list_properties'] != null) {
            $crmModuleInstance->setRelatedListProperties(self::getRelatedListProperties($moduleDetails['related_list_properties']));
        }
        
        if (array_key_exists('$properties', $moduleDetails) && $moduleDetails['$properties'] != null) {
            $crmModuleInstance->setProperties($moduleDetails['$properties']);
        }
        
        if (array_key_exists('per_page', $moduleDetails) && $moduleDetails['per_page'] != null) {
            $crmModuleInstance->setPerPage($moduleDetails['per_page'] + 0);
        }
        
        if (array_key_exists('search_layout_fields', $moduleDetails) && $moduleDetails['search_layout_fields'] != null) {
            $crmModuleInstance->setSearchLayoutFields($moduleDetails['search_layout_fields']);
        }
        if (array_key_exists('custom_view', $moduleDetails) && $moduleDetails['custom_view'] != null) {
            $crmModuleInstance->setDefaultCustomView(self::getZCRMCustomView( $moduleDetails[APIConstants::API_NAME],$moduleDetails['custom_view']));
            $crmModuleInstance->setDefaultCustomViewId($moduleDetails['custom_view']['id']);
        }
        if (array_key_exists('territory', $moduleDetails) && $moduleDetails['territory'] != null) {
            $crmModuleInstance->setDefaultTerritoryId($moduleDetails['territory']['id']);
            $crmModuleInstance->setDefaultTerritoryName($moduleDetails['territory']['name']);
        }
        
        return $crmModuleInstance;
    }
    
    public function getRelatedListProperties($relatedListProperties)
    {
        $relatedListPropInstance = ZCRMRelatedListProperties::getInstance();
        $relatedListPropInstance->setSortBy(array_key_exists("sort_by", $relatedListProperties) ? $relatedListProperties['sort_by'] : null);
        $relatedListPropInstance->setSortOrder(array_key_exists("sort_order", $relatedListProperties) ? $relatedListProperties['sort_order'] : null);
        $relatedListPropInstance->setFields(array_key_exists("fields", $relatedListProperties) ? $relatedListProperties['fields'] : null);
        return $relatedListPropInstance;
    }
    
    public function constructCriteria($criteria,&$index)
    {
        $criteria_instance=ZCRMCustomViewCriteria::getInstance();
        $criteria_instance->setField(isset($criteria['field'])? $criteria['field'] : null);
        $criteria_instance->setComparator(isset($criteria['comparator'])? $criteria['comparator'] : null);
        if(isset($criteria['value']))
        {
            $criteria_instance->setValue($criteria['value']);
            $criteria_instance->setIndex($index);
            $criteria_instance->setPattern((string)$index);
            $index++;
            $criteria_instance->setCriteria("(".$criteria['field'].":".$criteria['comparator'].":".(json_encode($criteria['value'])).")");
        }
        $group_criteria=array();
        if (isset($criteria['group']))
        {
            for ($x = 0; $x < count($criteria['group']); $x++) {
                $ins=self::constructCriteria($criteria['group'][$x],$index);
                array_push($group_criteria,$ins);
            }
        }
        if($group_criteria!=null)
        {
            $criteria_instance->setGroup($group_criteria);
        }
        
        if(isset($criteria['group_operator']))
        {
            $criteriavalue = "(";
            $pattern = "(";
            $criteria_instance->setGroup_operator($criteria['group_operator']);
            $count = sizeof($group_criteria);
            $i = 0;
            foreach ($group_criteria as $criteriaObj)
            {
                $i++;
                $criteriavalue .= $criteriaObj->getCriteria();
                $pattern .= $criteriaObj->getPattern();
                if ($i < $count)
                {
                    $criteriavalue .= $criteria_instance->getGroup_operator();
                    $pattern .= $criteria_instance->getGroup_operator();
                }
            }
            $criteria_instance->setCriteria($criteriavalue . ")");
            $criteria_instance->setPattern($pattern . ")");

            // $criteria_instance->setGroup_operator($criteria['group_operator']);
            // $criteria_instance->setCriteria("(".$group_criteria[0]->getCriteria().$criteria_instance->getGroup_operator().$group_criteria[1]->getCriteria().")");
            // $criteria_instance->setPattern("(".$group_criteria[0]->getPattern().$criteria_instance->getGroup_operator().$group_criteria[1]->getPattern().")");
        }
        return $criteria_instance;
    }
    
    /**
     * Method to process the given custom view details and set them in ZCRMCustomView instance
     * Input:: custom view details as array
     * Returns ZCRMCustomView instance
     */
    public function getZCRMCustomView($moduleApiName,$customViewDetails, $categoriesArr=null)
    {
        $customViewInstance = ZCRMCustomView::getInstance( $moduleApiName,$customViewDetails['id']);
        $customViewInstance->setDisplayValue($customViewDetails['display_value']);
        $customViewInstance->setDefault((boolean) $customViewDetails['default']);
        $customViewInstance->setName($customViewDetails['name']);
        $customViewInstance->setSystemName($customViewDetails['system_name']);
        $customViewInstance->setSortBy(isset($customViewDetails['sort_by']) ? $customViewDetails['sort_by'] : null);
        $customViewInstance->setCategory(isset($customViewDetails['category']) ? $customViewDetails['category'] : null);
        $customViewInstance->setFields(isset($customViewDetails['fields']) ? $customViewDetails['fields'] : null);
        $customViewInstance->setFavorite(isset($customViewDetails['favorite']) ? $customViewDetails['favorite'] : null);
        $customViewInstance->setSortOrder(isset($customViewDetails['sort_order']) ? $customViewDetails['sort_order'] : null);
        if (isset($customViewDetails['criteria']) && $customViewDetails['criteria'] != null) {
            $index=1;
            $criteriaInstance = self::constructCriteria($customViewDetails['criteria'], $index);
            $customViewInstance->setCriteria($criteriaInstance);
            $customViewInstance->setCriteriaPattern($criteriaInstance->getPattern());
            $customViewInstance->setCriteriaCondition($criteriaInstance->getCriteria());
        }
        if ($categoriesArr != null) {
            $categoryInstanceArray = array();
            foreach ($categoriesArr as $key => $value) {
                $customViewCategoryIns = ZCRMCustomViewCategory::getInstance();
                $customViewCategoryIns->setDisplayValue($value);
                $customViewCategoryIns->setActualValue($key);
                array_push($categoryInstanceArray, $customViewCategoryIns);
            }
            $customViewInstance->setCategoriesList($categoryInstanceArray);
        }
        if (isset($customViewDetails['offline'])) {
            $customViewInstance->setOffLine($customViewDetails['offline']);
        }
        return $customViewInstance;
    }
}