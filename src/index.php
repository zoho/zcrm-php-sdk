<?php

//all handler classes

require_once 'com/zoho/crm/library/api/APIRequest.php';
require_once 'com/zoho/crm/library/api/handler/APIHandler.php';
require_once 'com/zoho/crm/library/api/handler/APIHandlerInterface.php';
require_once 'com/zoho/crm/library/api/handler/EntityAPIHandler.php';
require_once 'com/zoho/crm/library/api/handler/MassEntityAPIHandler.php';
require_once 'com/zoho/crm/library/api/handler/MetaDataAPIHandler.php';
require_once 'com/zoho/crm/library/api/handler/ModuleAPIHandler.php';
require_once 'com/zoho/crm/library/api/handler/RelatedListAPIHandler.php';
require_once 'com/zoho/crm/library/api/handler/OrganizationAPIHandler.php';
require_once 'com/zoho/crm/library/api/handler/TagAPIHandler.php';


//crud operation related
require_once 'com/zoho/crm/library/crud/ZCRMAttachment.php';
require_once 'com/zoho/crm/library/crud/ZCRMCustomView.php';
require_once 'com/zoho/crm/library/crud/ZCRMCustomViewCategory.php';
require_once 'com/zoho/crm/library/crud/ZCRMCustomViewCriteria.php';
require_once 'com/zoho/crm/library/crud/ZCRMEventParticipant.php';
require_once 'com/zoho/crm/library/crud/ZCRMField.php';
require_once 'com/zoho/crm/library/crud/ZCRMInventoryLineItem.php';
require_once 'com/zoho/crm/library/crud/ZCRMLayout.php';
require_once 'com/zoho/crm/library/crud/ZCRMLookupField.php';
require_once 'com/zoho/crm/library/crud/ZCRMModule.php';
require_once 'com/zoho/crm/library/crud/ZCRMModuleRelatedList.php';
require_once 'com/zoho/crm/library/crud/ZCRMModuleRelation.php';
require_once 'com/zoho/crm/library/crud/ZCRMNote.php';
require_once 'com/zoho/crm/library/crud/ZCRMPickListValue.php';
require_once 'com/zoho/crm/library/crud/ZCRMPriceBookPricing.php';
require_once 'com/zoho/crm/library/crud/ZCRMRecord.php';
require_once 'com/zoho/crm/library/crud/ZCRMRelatedListProperties.php';
require_once 'com/zoho/crm/library/crud/ZCRMSection.php';
require_once 'com/zoho/crm/library/crud/ZCRMTax.php';
require_once 'com/zoho/crm/library/crud/ZCRMJunctionRecord.php';
require_once 'com/zoho/crm/library/crud/ZCRMTrashRecord.php';
require_once 'com/zoho/crm/library/crud/ZCRMPermission.php';
require_once 'com/zoho/crm/library/crud/ZCRMLeadConvertMapping.php';
require_once 'com/zoho/crm/library/crud/ZCRMLeadConvertMappingField.php';
require_once 'com/zoho/crm/library/crud/ZCRMProfileSection.php';
require_once 'com/zoho/crm/library/crud/ZCRMProfileCategory.php';
require_once 'com/zoho/crm/library/crud/ZCRMTag.php';

require_once 'com/zoho/crm/library/exception/ZCRMException.php';

//setup related
require_once 'com/zoho/crm/library/setup/metadata/ZCRMOrganization.php';
require_once 'com/zoho/crm/library/setup/restclient/ZCRMRestClient.php';

require_once 'com/zoho/crm/library/setup/users/ZCRMProfile.php';
require_once 'com/zoho/crm/library/setup/users/ZCRMRole.php';
require_once 'com/zoho/crm/library/setup/users/ZCRMUser.php';
require_once 'com/zoho/crm/library/setup/users/ZCRMUserCustomizeInfo.php';
require_once 'com/zoho/crm/library/setup/users/ZCRMUserTheme.php';

require_once 'com/zoho/crm/library/api/response/APIResponse.php';
require_once 'com/zoho/crm/library/api/response/BulkAPIResponse.php';
require_once 'com/zoho/crm/library/api/response/CommonAPIResponse.php';
require_once 'com/zoho/crm/library/api/response/EntityResponse.php';
require_once 'com/zoho/crm/library/api/response/FileAPIResponse.php';
require_once 'com/zoho/crm/library/api/response/ResponseInfo.php';

require_once 'com/zoho/crm/library/common/APIConstants.php';
require_once 'com/zoho/crm/library/common/CommonUtil.php';
require_once 'com/zoho/crm/library/common/ZCRMConfigUtil.php';
require_once 'com/zoho/crm/library/common/ZohoHTTPConnector.php';
?>