#PHP SDK for Zoho CRM
----------------------
PHP SDK for Zoho CRM APIs provides wrapper for Zoho CRM APIs. Hence invoking a Zoho CRM API from your client application is just a method call.It supports both single user as well as multi user authentication.

Registering a Zoho Client
-------------------------
Since Zoho CRM APIs are authenticated with OAuth2 standards, you should register your client app with Zoho. To register your app:
1) Visit this page [https://accounts.zoho.com/developerconsole](https://accounts.zoho.com/developerconsole).
2) Click on `Add Client ID`.
3) Enter Client Name, Client Domain and Redirect URI then click `Create`.
4) Your Client app would have been created and displayed by now.
5) The newly registered app's Client ID and Client Secret can be found by clicking `Options` → `Edit`.
(Options is the three dot icon at the right corner).

Setting Up
----------
PHP SDK is installable through `composer`. Composer is a tool for dependency management in PHP. SDK expects the following from the client app.

>Client app must have PHP 5.6 or above with  curl  extension enabled.

> PHP SDK must be installed into client app though composer.

The function  ZCRMRestClient::initialize($configuration)  must be called on startup of app.

>$configuration - Contains the configuration details as a key-value pair. 

Token persistence handling (storing and utilizing the oauth tokens) can be done in three ways. File, DB and Custom persistence.


Installation of SDK through composer
------------------------------------
Install Composer(if not installed)
Run this command to install the composer

>curl -sS https://getcomposer.org/installer | php

To make the composer accessible globally, follow the instructions from the link below

To install composer on mac/ linux machine:

>https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx

To install composer on windows machine:

>https://getcomposer.org/doc/00-intro.md#installation-windows

Install PHP SDK
---------------
Install PHP SDK
Here's how you install the SDK:

1) Navigate to the workspace of your client app
2) Run the command below: 

>composer require zohocrm/php-sdk

Hence, the PHP SDK would be installed and a package named 'vendor' would be created in the workspace of your client app.

Configurations
--------------
To access the CRM services through SDK, the client application must be first authenticated. This can be done by passing a key-value configuration pair to the initialization process.

>The $configuration array must be created. It will contain the authentication credentials required.
The configuration array must then be passed using the "ZCRMRestClient::initialize($configuration); ".

The user must pass the configuration values as php array(key-value pair) as argument to the ZCRMRestclient::initialize($configuration); function. Below is the list of keys that are to be in the array.

Mandatory keys

>client_id
client_secret
redirect_uri
currentUserEmail

Optional keys

>applicationLogFilePath
sandbox
apiBaseUrl
apiVersion
access_type
accounts_url
persistence_handler_class
token_persistence_path
db_port
db_username
db_password


client_id, client_secret and redirect_uri are your OAuth client’s configurations that you get after registering your Zoho client.

currentUserEmail - In case of single user, this configuration can be set using "ZCRMRestClient->setCurrentUser()".

access_type must be set to offline only because online OAuth client is not supported by the PHP SDK as of now.

apiBaseUrl  - Url to be used when calling an API. It is used to denote the domain of the user. Url may be:
    www.zohoapis.com (default)
    www.zohoapis.eu
    www.zohoapis.com.cn

apiVersion  is "v2".

accounts_url - Default value set as US domain. The value can be changed based on your domain(EU,CN).
    accounts.zoho.com
    accounts.zoho.eu
    accounts.zoho.com.cn

sandbox - To make API calls to sandbox account , please change the value of following key to true. By default the value is false.

applicationLogFilePath - The SDK stores the log information in a file.
    The file path of the folder must be specified in the key and the SDK automatically creates the file. The default file name is the ZCRMClientLibrary.log.
    In case the path isn't specified, the log file will be created inside the project.

persistence_handler_class is the implementation of the ZohoOAuthPersistenceInterface.

>If the Optional keys are not specified, their default values will be assigned automatically.
>The 'apiBaseUrl' and 'accounts_url' are mandatory in case the user is not in the "com" domain. 


Initialization
--------------

The app would be ready to be initialized after defining the configuration array. The user can now proceed to generate the required tokens to run the app.

The generation of the grant token can be done using two methods.

>Self-Client
>Redirection-based code generation

We will be using the self-client option here to demonstrate the process.

Generating self-authorized grant token
--------------------------------------
For self client apps, the self authorized grant token should be generated from the Zoho Developer Console (https://accounts.zoho.com/developerconsole)

>1) Visit https://accounts.zoho.com/developerconsole
2) Click Options → Self Client of the client for which you wish to authorize.
3) Enter one or more(comma separated) valid Zoho CRM scopes, that you wish to authorize, in the “Scope” field and choose a time of expiry.
4) Copy the grant token.
5) Generate refresh_token from grant token by using below URL

>https://accounts.zoho.com/oauth/v2/token?code={grant_token}&redirect_uri={redirect_uri}&client_id={client_id}&client_secret={client_secret}&grant_type=authorization_code
It's a POST request

Copy the refresh_token for backup

Please note that the generated grant token is valid only for the stipulated time you choose while generating it. Hence, refresh token should be generated within that time.

Generating access token
-----------------------
Access token can be generated by grant token or refresh token. Following any one of the two methods is sufficient.    

Access Token from grant token:
------------------------------------
The following code snippet should be executed from your main class to get access token. Please paste the copied grant token in the string literal mentioned below. This is a one-time process.

>$configuration =array("client_id"=>{client_id},"client_secret"=>{client_secret},"redirect_uri"=>{redirect_url},"currentUserEmail"=>{user_email_id});
ZCRMRestClient::initialize($configuration);
$oAuthClient = ZohoOAuth::getClientInstance();
$grantToken = "paste_the_self_authorized_grant_token_here";
$oAuthTokens = $oAuthClient->generateAccessToken($grantToken);


Access Token from refresh token:
------------------------------------
The following code snippet should be executed from your main class to get access token. Please paste the copied refresh token in the string literal mentioned below. This is a one-time process.

>$configuration =array("client_id"=>{client_id},"client_secret"=>{client_secret},"redirect_uri"=>{redirect_url},"currentUserEmail"=>{user_email_id});
ZCRMRestClient::initialize($configuration);
$oAuthClient = ZohoOAuth::getClientInstance();
$refreshToken = "paste_the_refresh_token_here";
$userIdentifier = "provide_user_identifier_like_email_here";
$oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userIdentifier); 


Upon successful execution of the above code snippet, the generated access token and given refresh token would have been persisted through our persistence handler class.

Once the OAuth tokens have been persisted, subsequent API calls would use the persisted access and refresh tokens. The SDK will take care of refreshing the access token using refresh token, as and when required.


App Startup
-----------
The SDK requires the following line of code invoked every time your client app is started.

>$configuration =array("client_id"=>{client_id},"client_secret"=>{client_secret},"redirect_uri"=>{redirect_url},"currentUserEmail"=>{user_email_id});
ZCRMRestClient::initialize($configuration);

Once the SDK has been initialized by the above line, you could use any APIs of the library to get proper results.


Using the SDK
-------------
Add the below line in your client app PHP files, where you would like to make use of SDK.

>require 'vendor/autoload.php'

Through this line, you can access all the functionalities of the PHP SDK.



Class Hierarchy
---------------
All Zoho CRM entities are modelled as classes having members and methods applicable to that particular entity.

ZCRMRestClient  is the base class of the SDK.
    This class has, methods to get instances of various other Zoho CRM entities.

The class relations and hierarchy of the SDK follows the entity hierarchy inside Zoho CRM.

Each class entity has functions to fetch its own properties and to fetch data of its immediate child entities through an API call.
    For example, a Zoho CRM module  (ZCRMModule)  object will have member functions to get a module’s properties like display name, module Id, etc, and will also have functions to fetch all its child objects (like ZCRMLayout).
        
The class hierarchy of various Zoho CRM entities are given below:

 - ZCRMRestClient
   - ZCRMOrganization
     - ZCRMUser
       - ZCRMUserTheme
         - ZCRMUserCustomizeInfo
       - ZCRMRole
       - ZCRMProfile
         - ZCRMPermission
         - ZCRMProfileSection
           - ZCRMProfileCategory
     - ZCRMModule
       - ZCRMLayout
         - ZCRMSection
           - ZCRMField
           - ZCRMPickListValue
           - ZCRMLookupField
       	 - ZCRMLeadConvertMapping
           - ZCRMLeadConvertMappingField
       - ZCRMCustomView
         - ZCRMCustomViewCategory
         - ZCRMCustomViewCriteria
       - ZCRMRelatedListProperties
         - ZCRMModuleRelatedList
       - ZCRMRecord
       - ZCRMNote
       - ZCRMAttachment
       - ZCRMInventoryLineItem
         - ZCRMTax
       - ZCRMEventParticipant
       - ZCRMPriceBookPricing
       - ZCRMModuleRelation
       - ZCRMJunctionRecord
       - ZCRMTrashRecord


Instance object
---------------
It isn’t always effective to follow the complete class hierarchy from the top to fetch the data of an entity at some lower level, since this would involve API calls at each level. In order to handle this, every entity class has a getInstance() function to get its own dummy object and functions to get dummy objects of its child entities.

Please note that the getInstance() function would not have any of its properties filled because it would not fire an API call. This would just return a dummy object that shall be only used to access the non-static functions of the class.

Summing it up
-------------
ZCRMRestClient::getModule(“Contacts”) would return the actual Contacts module, that has all the properties of the Contacts module filled through an API call.  
ZCRMRestClient::getModuleInstance(“Contacts”) would return a dummy ZCRMModule object that would refer to the Contacts module, with no properties filled, since this doesn’t make an API call.  
Hence, to get records from a module, it is not necessary that you need to start from ZCRMRestClient. Instead, you could get a ZCRMModule instance with ZCRMModule::getInstance() and then invoke its non-static getRecords() function from the created instance. This would avoid the API call which would have been triggered to populate the ZCRMModule object.

Accessing record properties
---------------------------
Since record properties are dynamic across modules, we have only given the common fields like createdTime, createdBy, owner etc, as ZCRMRecord’s default members. All other record properties are available as a map in ZCRMRecord object.
To access the individual field values of a record, use the getter and setter methods available. These methods only support API names.

>To get a field value, use record.getFieldValue(field_api_name);

>To set a field value, use record.setFieldValue(field_api_name, new_value);

The keys of the record properties map are the API names of the module’s fields. They are available in your CRM,

Setup → Developer Space → APIs → CRM API → API Names.

While setting a field value, please make sure of that the set value is of the data type of the field to which you are going to set it.

Response Handling
-----------------

A method seeking a single entity would return APIResponse object, whereas a method seeking a list of entities would return BulkAPIResponse object.

`APIResponse.getData()` would return a single Zoho CRM entity object. Use the function getData() to get the entity data from the response wrapper objects for APIResponse. (ex: ZCRMRecord, ZCRMModule, ZCRMField, etc..). For example: a single record/field/module information.

`BulkAPIResponse.getData()` would return an array of Zoho CRM entity objects (ex: ZCRMRecord, ZCRMModule, ZCRMField, etc..). Use the function `getData()` to get the entity data from the response wrapper objects for BulkAPIResponse. For example: a multiple records/fields/modules information.

`FileAPIResponse` will be returned for file download APIs to download a photo or an attachment from a record or note such as record.downloadPhoto(), record.downloadAttachment() etc. FileAPIResponse has two defined methods namely FileAPIResponse.getFileName() which returns the name of the file that is downloaded and FileAPIResponse.getFileContent() that gives the file content as String.

`ResponseInfo` - any other information, if provided by the API, in addition to the actual data.

>response.getInfo()

`List<EntityResponse>` - status of individual entities in a bulk API. For example: an insert records API may partially fail because of a few records. This dictionary gives the individual records’ creation status. It is available through:

>response.getEntityResponses() 


Exceptions
----------
All unexpected behaviours like faulty API responses, library anomalies are handled by the SDK and are thrown only as a single exception - `ZCRMException`. Hence, it is enough to catch this exception alone in the client app code.

Examples:
---------
Sample Request for insert records:
---------------------------------
>$zcrmModuleIns = ZCRMModule::getInstance("Invoices");  
$bulkAPIResponse=$zcrmModuleIns->createRecords($recordsArray); // $recordsArray - array of ZCRMRecord instances filled with required data for creation.  
$entityResponses = $bulkAPIResponse->getEntityResponses();  
foreach($entityResponses as $entityResponse)  
{  
	if("success"==$entityResponse->getStatus())  
	{  
		echo "Status:".$entityResponse->getStatus();  
		echo "Message:".$entityResponse->getMessage();  
		echo "Code:".$entityResponse->getCode();  
		$createdRecordInstance=$entityResponse->getData();  
		echo "EntityID:".$createdRecordInstance->getEntityId();  
		echo "moduleAPIName:".$createdRecordInstance->getModuleAPIName();  
		….
	}
}

	Sample Invoice record instance with filled data
	-----------------------------------------------
$record=ZCRMRecord::getInstance("Invoices",null);  
$record->setFieldValue("Subject","Iphone sale to John");  
$record->setFieldValue("Account_Name","410405000001016021");  
$productInstance=ZCRMRecord::getInstance("Products",410405000001108011);  
$lineItem=ZCRMInventoryLineItem::getInstance($productInstance);  
$taxInstance1=ZCRMTax::getInstance("Sales Tax");  
$taxInstance1->setPercentage(2);  
$taxInstance1->setValue(10);  
$lineItem->addLineTax($taxInstance1);  
$taxInstance1=ZCRMTax::getInstance("Vat");  
$taxInstance1->setPercentage(12);  
$taxInstance1->setValue(60);  
$lineItem->addLineTax($taxInstance1);  
$lineItem->setQuantity(100);  
$lineItem->setDiscount(0.5);  
$record->addLineItem($lineItem);  


Sample Request to fetch records:
--------------------------------
>$zcrmModuleIns = ZCRMModule::getInstance("Contacts");  
$bulkAPIResponse=$zcrmModuleIns->getRecords();  
$recordsArray = $bulkAPIResponse->getData(); // $recordsArray - array of ZCRMRecord instances  

For more APIs, please refer [this link](https://www.zoho.com/crm/help/developer/api/overview.html)
