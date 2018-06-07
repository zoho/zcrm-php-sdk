<?php

namespace ZCRM\api\handler;

//require_once 'APIHandler.php';
//require_once 'ModuleAPIHandler.php';
use ZCRM\common\APIConstants;
use ZCRM\common\ZohoHTTPConnector;
use ZCRM\api\APIRequest;
use ZCRM\crud\ZCRMModule;
use ZCRM\users\ZCRMUser;
use ZCRM\users\ZCRMProfile;
use ZCRM\crud\ZCRMModuleRelatedList;
use ZCRM\crud\ZCRMRelatedListProperties;
use ZCRM\crud\ZCRMCustomView;
use ZCRM\crud\ZCRMCustomViewCriteria;

class MetaDataAPIHandler extends APIHandler {

  private function __construct() {
  }

  /**
   * @return MetaDataAPIHandler
   */
  public static function getInstance() {
    return new MetaDataAPIHandler();
  }

  /**
   * @return \ZCRM\api\response\BulkAPIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function getAllModules() {
    try {
      $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
      $this->urlPath = "settings/modules";
      $this->addHeader("Content-Type", "application/json");
      $this->addParam('scope', 'ZohoCRM.settings.modules.read');

      $responseInstance = APIRequest::getInstance($this)->getBulkAPIResponse();
      $responseJSON = $responseInstance->getResponseJSON();
      $modulesArray = $responseJSON['modules'];
      $responseData = [];
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

  /**
   * @param $moduleName
   *
   * @return \ZCRM\api\response\APIResponse
   * @throws \ZCRM\exception\ZCRMException
   */
  public function getModule($moduleName) {
    try {
      $this->requestMethod = APIConstants::REQUEST_METHOD_GET;
      $this->urlPath = "settings/modules/" . $moduleName;
      $this->addHeader("Content-Type", "application/json");
      $this->addParam('scope', 'ZohoCRM.settings.modules.read');
      $res = APIRequest::getInstance($this)->getAPIResponse();
      $moduleArray = $res->getResponseJSON()['modules'];
      $res->setData(self::getZCRMModule($moduleArray[0]));
      return $res;
      
    } catch (ZCRMException $exception) {
      APIExceptionHandler::logException($exception);
      throw $exception;
    }
  }

  /**
   * @param $moduleDetails
   *
   * @return ZCRMModule
   */
  public function getZCRMModule($moduleDetails) {
    $crmModuleInstance = ZCRMModule::getInstance($moduleDetails[APIConstants::API_NAME]);
    $crmModuleInstance->setViewable($moduleDetails['viewable']);
    $crmModuleInstance->setCreatable($moduleDetails['creatable']);
    $crmModuleInstance->setConvertable($moduleDetails['convertable']);
    $crmModuleInstance->setEditable($moduleDetails['editable']);
    $crmModuleInstance->setDeletable($moduleDetails['deletable']);
    $crmModuleInstance->setWebLink(array_key_exists("web_link", $moduleDetails) ? $moduleDetails['web_link'] : NULL);
    $crmModuleInstance->setSingularLabel($moduleDetails['singular_label']);
    $crmModuleInstance->setPluralLabel($moduleDetails['plural_label']);
    $crmModuleInstance->setId($moduleDetails['id']);
    $crmModuleInstance->setModifiedTime($moduleDetails['modified_time']);
    $crmModuleInstance->setApiSupported($moduleDetails['api_supported']);
    $crmModuleInstance->setScoringSupported($moduleDetails['scoring_supported']);
    $crmModuleInstance->setModuleName($moduleDetails['module_name']);
    $crmModuleInstance->setBusinessCardFieldLimit(array_key_exists("business_card_field_limit", $moduleDetails) ? $moduleDetails['business_card_field_limit'] : 0);
    if (isset($moduleDetails['sequence_number'])) {
      $crmModuleInstance->setSequenceNumber($moduleDetails['sequence_number']);
    }

    if (isset($moduleDetails['global_search_supported'])) {
      $crmModuleInstance->setGlobalSearchSupported($moduleDetails['global_search_supported']);
    }

    $zcrmUserInstance = NULL;
    if ($moduleDetails['modified_by'] != NULL) {
      $zcrmUserInstance = ZCRMUser::getInstance(($moduleDetails['modified_by']["id"]), $moduleDetails['modified_by']["name"]);
    }
    $crmModuleInstance->setModifiedBy($zcrmUserInstance);
    if (isset($moduleDetails['generated_type'])) {
      $crmModuleInstance->setCustomModule('custom' === $moduleDetails['generated_type']);
    }

    if (array_key_exists("business_card_fields", $moduleDetails)) {
      $crmModuleInstance->setBusinessCardFields($moduleDetails['business_card_fields']);
    }

    $profileArray = $moduleDetails['profiles'];
    $profileInstanceArray = [];
    foreach ($profileArray as $eachProfile) {
      array_push($profileInstanceArray, ZCRMProfile::getInstance($eachProfile['id'], $eachProfile['name']));
    }
    $crmModuleInstance->setAllProfiles($profileInstanceArray);

    if (array_key_exists("display_field", $moduleDetails)) {
      $crmModuleInstance->setDisplayFieldName(isset($moduleDetails['display_field']['name']) ? $moduleDetails['display_field']['name'] : NULL);
      $crmModuleInstance->setDisplayFieldId(isset($moduleDetails['display_field']['id']) ? $moduleDetails['display_field']['id'] : NULL);
    }
    $relatedListInstanceArray = NULL;
    if (array_key_exists("related_lists", $moduleDetails)) {
      $relatedListArray = $moduleDetails['related_lists'];
      $relatedListInstanceArray = [];
      foreach ($relatedListArray as $relatedListObj) {
        $moduleRelatedListIns = ZCRMModuleRelatedList::getInstance($relatedListObj['api_name']);
        array_push($relatedListInstanceArray, $moduleRelatedListIns->setRelatedListProperties($relatedListObj));
      }
    }
    $crmModuleInstance->setRelatedLists($relatedListInstanceArray);
    if (array_key_exists("layouts", $moduleDetails)) {
      $crmModuleInstance->setLayouts(ModuleAPIHandler::getInstance(ZCRMModule::getInstance($moduleDetails[APIConstants::API_NAME]))
        ->getLayouts($moduleDetails['layouts']));
    }

    if (array_key_exists("fields", $moduleDetails) && $moduleDetails['fields'] != NULL) {
      $crmModuleInstance->setFields(ModuleAPIHandler::getInstance(ZCRMModule::getInstance($moduleDetails[APIConstants::API_NAME]))
        ->getFields($moduleDetails['fields']));
    }

    if (array_key_exists("related_list_properties", $moduleDetails) && $moduleDetails['related_list_properties'] != NULL) {
      $crmModuleInstance->setRelatedListProperties(self::getRelatedListProperties($moduleDetails['related_list_properties']));
    }

    if (array_key_exists('$properties', $moduleDetails) && $moduleDetails['$properties'] != NULL) {
      $crmModuleInstance->setProperties($moduleDetails['$properties']);
    }

    if (array_key_exists('per_page', $moduleDetails) && $moduleDetails['per_page'] != NULL) {
      $crmModuleInstance->setPerPage($moduleDetails['per_page']);
    }

    if (array_key_exists('search_layout_fields', $moduleDetails) && $moduleDetails['search_layout_fields'] != NULL) {
      $crmModuleInstance->setSearchLayoutFields($moduleDetails['search_layout_fields']);
    }
    if (array_key_exists('custom_view', $moduleDetails) && $moduleDetails['custom_view'] != NULL) {
      $crmModuleInstance->setDefaultCustomView(self::getModuleDefaultCustomView($moduleDetails[APIConstants::API_NAME], $moduleDetails['custom_view']));
      $crmModuleInstance->setDefaultCustomViewId($moduleDetails['custom_view']['id']);
    }
    if (array_key_exists('territory', $moduleDetails) && $moduleDetails['territory'] != NULL) {
      $crmModuleInstance->setDefaultTerritoryId($moduleDetails['territory']['id']);
      $crmModuleInstance->setDefaultTerritoryName($moduleDetails['territory']['name']);
    }

    return $crmModuleInstance;
  }

  /**
   * @param $moduleAPIName
   * @param $d (customViewDetails)
   *
   * @return \ZCRM\crud\ZCRMCustomView
   */
  public function getModuleDefaultCustomView($moduleAPIName, $d) {

    $cvi = ZCRMCustomView::getInstance($moduleAPIName, $d['id']);
    $cvi->setDisplayValue($d['display_value']);
    $cvi->setDefault((boolean) $d['default']);
    $cvi->setName($d['name']);
    $cvi->setSystemName($d['system_name']);
    $cvi->setSortBy(array_key_exists('sort_by', $d) ? $d['sort_by'] : NULL);
    $cvi->setCategory(array_key_exists('category', $d) ? $d['category'] : NULL);
    $cvi->setFields(array_key_exists('fields', $d) ? $d['fields'] : NULL);
    $cvi->setFavorite($d['favorite']);
    $cvi->setSortOrder(array_key_exists('sort_order', $d) ? $d['sort_order'] : NULL);

    if (array_key_exists('criteria', $d) && $d['criteria'] != NULL) {
      $criteriaList = $d['criteria'];
      $criteriaPattern = "";
      $ciarr = [];
      if (isset($criteriaList[0]) && is_array($criteriaList[0])) {
        for ($i = 0; $i < sizeof($criteriaList); $i++) {
          $criteria = array_values($criteriaList)[$i];
          if ($criteria === "or" || $criteria === "and") {
            $criteriaPattern = $criteriaPattern . $criteria;
          }
          else {
            $inst = ZCRMCustomViewCriteria::getInstance();
            $inst->setField($criteria['field']);
            $inst->setValue($criteria['value']);
            $inst->setComparator($criteria['comparator']);
            $criteriaPattern = $criteriaPattern . $i;
            array_push($ciarr, $inst);
          }
        }
      }
      else {
        $inst = ZCRMCustomViewCriteria::getInstance();
        if (isset($criteriaList['field'])) {
          $inst->setField($criteriaList['field']);
        }
        if (isset($criteriaList['value'])) {
          $inst->setValue($criteriaList['value']);
        }
        if (isset($criteriaList['comparator'])) {
          $inst->setComparator($criteriaList['comparator']);
        }
        array_push($ciarr, $inst);
      }
      $cvi->setCriteria($ciarr);
      $cvi->setCriteriaPattern($criteriaPattern);
    }

    if (isset($d['offline'])) {
      $cvi->setOffLine($d['offline']);
    }

    return $cvi;
  }

  public function getRelatedListProperties($relatedListProperties) {

    $relatedListPropInstance = ZCRMRelatedListProperties::getInstance();
    $relatedListPropInstance->setSortBy(array_key_exists("sort_by", $relatedListProperties) ? $relatedListProperties['sort_by'] : NULL);
    $relatedListPropInstance->setSortOrder(array_key_exists("sort_order", $relatedListProperties) ? $relatedListProperties['sort_order'] : NULL);
    $relatedListPropInstance->setFields(array_key_exists("fields", $relatedListProperties) ? $relatedListProperties['fields'] : NULL);

    return $relatedListPropInstance;
  }
}

?>