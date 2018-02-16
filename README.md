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

>Client app must have PHP 5.6 or above with curl extension enabled.
Client library must be installed into client app though composer.
The function ZCRMRestClient::initialize() must be called on startup of app.

>MySQL should run in the same machine serving at the default port 3306.  
The database name should be "zohooauth".  
There must be a table "oauthtokens" with the columns "useridentifier"(varchar(100)), "accesstoken"(varchar(100)), "refreshtoken"(varchar(100)), "expirytime"(bigint).  

**If `token_persistence_path` provided in `oauth_configuration.properties` file, then persistence happens in file only. In this case, no need of MySQL**
please create a empty file with name **zcrm_oauthtokens.txt** in the mentioned `token_persistence_path`

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
Here's how you install the SDK  
Navigate to the workspace of your client app  
Run the command below:

>composer require zohocrm/php-sdk

Hence, the SDK would be installed and a package named `vendor` would be created in the workspace of your client app.

Configurations
--------------
Your OAuth Client details should be given to the SDK as a property file.  
In SDK, we have placed a configuration file (oauth_configuration.properties).   
Please place the respective values in that file.  
You can find that file under `vendor/zohocrm/php-sdk/src/resources`.  

Please fill only the following keys. Based on your domain(EU,CN) please change the value of `accounts_url`. Default value set as US domain

>client_id=  
client_secret=  
redirect_uri=  
accounts_url=https://accounts.zoho.com  
token_persistence_path=  

Only the keys displayed above are to be filled.  
`client_id`, `client_secret` and `redirect_uri` are your OAuth client’s configurations that you get after registering your Zoho client.  
`token_persistence_path` is the path to store the OAuth related tokens in file. If this is set then, no need of `database` for persistence. Persistence happens through `file` only.  
`access_type` must be set to offline only because online OAuth client is not supported by the SDK as of now.  
`persistence_handler_class` is the implementation of the ZohoOAuthPersistenceInterface  

Create a file named `ZCRMClientLibrary.log` in your client app machine and mention the absolute path of the created file in `configuration.properties` for the key `applicationLogFilePath`.   
You can find that file under `vendor/zohocrm/php-sdk/src/resources`. This file is to log the exceptions occurred during the usage of SDK.  

Please fill only the following key

>applicationLogFilePath=

To make API calls to `sandbox account`, please change the value of following key to `true` in `configurations.properties`. By default the value is `false`  

>sandbox=true


If your application needs only a single user authentication then you have to set the user EmailId in configurations.properties file as given below:

>currentUserEmail=user@email.com

In order to work with multi user authentication, you need to set the user EmailId in PHP super global variable ‘$_SERVER’ as given below:

>$_SERVER[‘user_email_id’]=“user@email.com”

You can use `$_SERVER` variable for single user authentication as well, but it is recommended to go with setting up of email Id in `configuration.properties` file.

If you do not set the user email in super global variable then SDK expect it from `configuration.properties` file. If user email is not set in any of these two then SDK will throw exception.


Initialization
--------------
The app would be ready to be initialized after defining the OAuth configuration file.


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

>ZCRMRestClient::initialize();  
$oAuthClient = ZohoOAuth::getClientInstance();  
$grantToken = "paste_the_grant_token_here";  
$oAuthTokens = $oAuthClient->generateAccessToken($grantToken);


Access Token from refresh token:
------------------------------------
The following code snippet should be executed from your main class to get access token. Please paste the copied refresh token in the string literal mentioned below. This is a one-time process.

>ZCRMRestClient::initialize();  
$oAuthClient = ZohoOAuth::getClientInstance();  
$refreshToken = "paste_the_refresh_token_here";  
$userIdentifier = "provide_user_identifier_like_email_here";  
$oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userIdentifier);


Upon successful execution of the above code snippet, the generated access token and given refresh token would have been persisted through our persistence handler class.

Once the OAuth tokens have been persisted, subsequent API calls would use the persisted access and refresh tokens. The SDK will take care of refreshing the access token using refresh token, as and when required.


App Startup
-----------
The SDK requires the following line of code invoked every time your client app is started.

>ZCRMRestClient::initialize();

Once the SDK has been initialized by the above line, you could use any APIs of the library to get proper results.


Using the SDK
-------------
Add the below line in your client app PHP files, where you would like to make use of SDK.

>require 'vendor/autoload.php'

Through this line, you can access all the functionalities of the PHP SDK.



Class Hierarchy
---------------
All Zoho CRM entities are modelled as classes having properties and functions applicable to that particular entity. ZCRMRestClient is the base class of the SDK. ZCRMRestClient has functions to get instances of various other Zoho CRM entities.

The class relations and hierarchy of the library follows the entity hierarchy inside Zoho CRM. The class hierarchy of various Zoho CRM entities are given below:

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

Each entity class has functions to fetch its own properties and to fetch data of its immediate child entities through an API call.

For example: a Zoho CRM module (ZCRMModule) object will have member functions to get a module’s properties like display name, module Id, etc, and will also have functions to fetch all its child objects (like ZCRMLayout).

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
Since record properties are dynamic across modules, only the fields like createdTime, createBy, owner etc, are given as ZCRMRecord’s default properties. All other record properties are available as a map in ZCRMRecord object.

To access the individual field values of a record, use the getter and setter functions available. The keys of the record properties map are the API names of the module’s fields. All fields API names of all modules are available under Setup → Marketplace → APIs → CRM API → API Names.  

To get a field value, use $record → getFieldValue($fieldAPIName);  
To set a field value, use $record → setFieldValue($fieldAPIName, $newValue);  
While setting a field value, make sure that the set value is of the apt data type of the field to which you are going to set it.

Response Handling
-----------------
`APIResponse` and `BulkAPIResponse` are wrapper objects for Zoho CRM APIs’ responses. All API calling functions would return one of these two objects.

DownloadFile and downloadPhoto returns `FileAPIResponse` instead of APIResponse.  
A function which seeks a single entity would return an APIResponse, and a function which seeks a list of entities would return a BulkAPIResponse object.
Use the `getData()` function to get the entity data alone from the response wrapper objects. 
`APIResponse → getData()` would return a single Zoho CRM entity object, whereas `BulkAPIResponse → getData()`` would return a list of Zoho CRM entity objects.
Other than data, these response wrapper objects have the following properties:

`ResponseHeaders` - remaining API counts for the present day/window and time elapsed for the present window reset.  
`ResponseInfo` - any other information, if provided by the API, in addition to the actual data.  
`Array of EntityResponse(s)` - status of individual entities in a bulk API.  
For example: an insert records API may partially fail because of a few records. This array gives the individual records’ creation status.

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

For more APIs, please refer [this link](https://www.zoho.com/crm/help/api/v2/#api-reference)
