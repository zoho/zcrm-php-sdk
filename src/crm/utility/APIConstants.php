<?php
namespace zcrmsdk\crm\utility;

class APIConstants
{
    
    const ERROR = "error";
    
    const REQUEST_METHOD_GET = "GET";
    
    const REQUEST_METHOD_POST = "POST";
    
    const REQUEST_METHOD_PUT = "PUT";
    
    const REQUEST_METHOD_DELETE = "DELETE";
    
    const OAUTH_HEADER_PREFIX = "Zoho-oauthtoken ";
    
    const AUTHORIZATION = "Authorization";
    
    const API_NAME = "api_name";
    
    const INVALID_ID_MSG = "The given id seems to be invalid.";
    
    const API_MAX_RECORDS_MSG = "Cannot process more than 100 records at a time.";
    
    const API_MAX_ORGTAX_MSG = "Cannot process more than 100 org taxes at a time.";
    
    const API_MAX_NOTES_MSG = "Cannot process more than 100 notes at a time.";
    
    const API_MAX_TAGS_MSG = "Cannot process more than 50 tags at a time.";
    
    const API_MAX_RECORD_TAGS_MSG = "Cannot process more than 10 tags at a time.";
    
    const INVALID_DATA = "INVALID_DATA";
    
    const CODE_SUCCESS = "SUCCESS";
    
    const STATUS_SUCCESS = "success";
    
    const STATUS_ERROR = "error";

    const SDK_ERROR = "ZCRM_INTERNAL_ERROR";
    
    const LEADS = "Leads";
    
    const ACCOUNTS = "Accounts";
    
    const CONTACTS = "Contacts";
    
    const DEALS = "Deals";
    
    const QUOTES = "Quotes";
    
    const SALESORDERS = "SalesOrders";
    
    const INVOICES = "Invoices";
    
    const PURCHASEORDERS = "PurchaseOrders";
    
    const PER_PAGE = "per_page";
    
    const PAGE = "page";
    
    const COUNT = "count";
    
    const MORE_RECORDS = "more_records";
    
    const ALLOWED_COUNT = "allowed_count";
    
    const MESSAGE = "message";
    
    const CODE = "code";
    
    const STATUS = "status";
    
    const DATA = "data";

    const DETAILS = "details";

    const MODULES = "modules";

    const CUSTOM_VIEWS = "custom_views";
    
    const TAGS = "tags";
    
    const TAXES = "taxes";
    
    const INFO = "info";

    const ORG = "org";
    
    const READ = "read";
    
    const RESULT = "result";
    
    const UPLOAD = "upload";
    
    const WRITE = "write";
    
    const CALLBACK = "callback";

    const FILETYPE = "file_type";
    
    const QUERY = "query";
    
    const USERS = "users";
    
    const HTTP_CODE = "http_code";
    
    const VARIABLES = "variables";
    const RESPONSECODE_OK = 200;
    
    const RESPONSECODE_CREATED = 201;
    
    const RESPONSECODE_ACCEPTED = 202;
    
    const RESPONSECODE_NO_CONTENT = 204;
    
    const RESPONSECODE_MOVED_PERMANENTLY = 301;
    
    const RESPONSECODE_MOVED_TEMPORARILY = 302;
    
    const RESPONSECODE_NOT_MODIFIED = 304;
    
    const RESPONSECODE_BAD_REQUEST = 400;
    
    const RESPONSECODE_AUTHORIZATION_ERROR = 401;
    
    const RESPONSECODE_FORBIDDEN = 403;
    
    const RESPONSECODE_NOT_FOUND = 404;
    
    const RESPONSECODE_METHOD_NOT_ALLOWED = 405;
    
    const RESPONSECODE_REQUEST_ENTITY_TOO_LARGE = 413;
    
    const RESPONSECODE_UNSUPPORTED_MEDIA_TYPE = 415;
    
    const RESPONSECODE_TOO_MANY_REQUEST = 429;
    
    const RESPONSECODE_INTERNAL_SERVER_ERROR = 500;
    
    const DOWNLOAD_FILE_PATH = "../../../../../../resources";
    
    const USER_EMAIL_ID = "user_email_id";
    
    const ACTION = "action";
    
    const DUPLICATE_FIELD = "duplicate_field";
    
    const ACCESS_TOKEN_EXPIRY = "X-ACCESSTOKEN-RESET";
    
    const CURR_WINDOW_API_LIMIT = "X-RATELIMIT-LIMIT";
    
    const CURR_WINDOW_REMAINING_API_COUNT = "X-RATELIMIT-REMAINING";
    
    const CURR_WINDOW_RESET = "X-RATELIMIT-RESET";
    
    const API_COUNT_REMAINING_FOR_THE_DAY = "X-RATELIMIT-DAY-REMAINING";
    
    const API_LIMIT_FOR_THE_DAY = "X-RATELIMIT-DAY-LIMIT";
    
    const APPLICATION_LOGFILE_PATH = "applicationLogFilePath";
    
    const APPLICATION_LOGFILE_NAME = "/ZCRMClientLibrary.log";
    
    const CURRENT_USER_EMAIL = "currentUserEmail";

    const FILE_UPLOAD_URL = "fileUploadUrl";
    
    const SANDBOX = "sandbox";
    
    const API_BASE_URL = "apiBaseUrl";
    
    const API_VERSION = "apiVersion";

    const BULK_WRITE_STATUS = "STATUS";
    
    const WRITE_STATUS = array("ADDED", "UPDATED");

    const INVENTORY_MODULES = array("Invoices", "Sales_Orders","Purchase_Orders","Quotes");
}
