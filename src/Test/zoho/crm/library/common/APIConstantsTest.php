<?php
require_once realpath(dirname(__FILE__)."/../../../../../com/zoho/crm/library/common/APIConstants.php");
require_once realpath(dirname(__FILE__)."/../../common/PHPUnitTestUtil.php");
class APIConstantsTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->instance=new PHPUnitTestUtil();
	}
	
	public function tearDown()
	{
		unset($this->instance);
	}
    public function testConstants()
    {
        $this->instance->assertEqualsCheck('error',APIConstants::ERROR);
        $this->instance->assertEqualsCheck('GET',APIConstants::REQUEST_METHOD_GET);
        $this->instance->assertEqualsCheck('PUT',APIConstants::REQUEST_METHOD_PUT);
        $this->instance->assertEqualsCheck('POST',APIConstants::REQUEST_METHOD_POST);
        $this->instance->assertEqualsCheck('DELETE',APIConstants::REQUEST_METHOD_DELETE);
        $this->instance->assertEqualsCheck('Zoho-oauthtoken ',APIConstants::OAUTH_HEADER_PREFIX);
        $this->instance->assertEqualsCheck('Authorization',APIConstants::AUTHORIZATION);
        $this->instance->assertEqualsCheck('api_name',APIConstants::API_NAME);
        $this->instance->assertEqualsCheck('The given id seems to be invalid.',APIConstants::INVALID_ID_MSG);
        $this->instance->assertEqualsCheck('Cannot process more than 100 records at a time.',APIConstants::API_MAX_RECORDS_MSG);
        $this->instance->assertEqualsCheck('INVALID_DATA',APIConstants::INVALID_DATA);
        $this->instance->assertEqualsCheck('error',APIConstants::STATUS_ERROR);
        $this->instance->assertEqualsCheck('success',APIConstants::STATUS_SUCCESS);
        $this->instance->assertEqualsCheck('Leads',APIConstants::LEADS);
        $this->instance->assertEqualsCheck('Accounts',APIConstants::ACCOUNTS);
        $this->instance->assertEqualsCheck('Contacts',APIConstants::CONTACTS);
        $this->instance->assertEqualsCheck('Deals',APIConstants::DEALS);
        $this->instance->assertEqualsCheck('Quotes',APIConstants::QUOTES);
        $this->instance->assertEqualsCheck('SalesOrders',APIConstants::SALESORDERS);
        $this->instance->assertEqualsCheck('Invoices',APIConstants::INVOICES);
        $this->instance->assertEqualsCheck('PurchaseOrders',APIConstants::PURCHASEORDERS);
        $this->instance->assertEqualsCheck('per_page',APIConstants::PER_PAGE);
        $this->instance->assertEqualsCheck('page',APIConstants::PAGE);
        $this->instance->assertEqualsCheck('count',APIConstants::COUNT);
        $this->instance->assertEqualsCheck('more_records',APIConstants::MORE_RECORDS);
        $this->instance->assertEqualsCheck('message',APIConstants::MESSAGE);
        $this->instance->assertEqualsCheck('code',APIConstants::CODE);
        $this->instance->assertEqualsCheck('status',APIConstants::STATUS);
        
        $this->instance->assertEqualsCheck('data',APIConstants::DATA);
        $this->instance->assertEqualsCheck('info',APIConstants::INFO);
        $this->instance->assertEqualsCheck(200,APIConstants::RESPONSECODE_OK);
        $this->instance->assertEqualsCheck(201,APIConstants::RESPONSECODE_CREATED);
        $this->instance->assertEqualsCheck(202,APIConstants::RESPONSECODE_ACCEPTED);
        $this->instance->assertEqualsCheck(204,APIConstants::RESPONSECODE_NO_CONTENT);
        $this->instance->assertEqualsCheck(301,APIConstants::RESPONSECODE_MOVED_PERMANENTLY);
        $this->instance->assertEqualsCheck(302,APIConstants::RESPONSECODE_MOVED_TEMPORARILY);
        $this->instance->assertEqualsCheck(304,APIConstants::RESPONSECODE_NOT_MODIFIED);
        $this->instance->assertEqualsCheck(400,APIConstants::RESPONSECODE_BAD_REQUEST);
        $this->instance->assertEqualsCheck(401,APIConstants::RESPONSECODE_AUTHORIZATION_ERROR);
        $this->instance->assertEqualsCheck(403,APIConstants::RESPONSECODE_FORBIDDEN);
        $this->instance->assertEqualsCheck(404,APIConstants::RESPONSECODE_NOT_FOUND);
        $this->instance->assertEqualsCheck(405,APIConstants::RESPONSECODE_METHOD_NOT_ALLOWED);
        $this->instance->assertEqualsCheck(413,APIConstants::RESPONSECODE_REQUEST_ENTITY_TOO_LARGE);
        $this->instance->assertEqualsCheck(415,APIConstants::RESPONSECODE_UNSUPPORTED_MEDIA_TYPE);
        $this->instance->assertEqualsCheck(429,APIConstants::RESPONSECODE_TOO_MANY_REQUEST);
        $this->instance->assertEqualsCheck(500,APIConstants::RESPONSECODE_INTERNAL_SERVER_ERROR);
        $this->instance->assertEqualsCheck("../../../../../../resources",APIConstants::DOWNLOAD_FILE_PATH);
        
    }
    
}
?>