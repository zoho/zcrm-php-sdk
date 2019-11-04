<?php
namespace zcrmsdk\crm\exception;

use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\utility\Logger;

class APIExceptionHandler
{
    
    public static function logException(ZCRMException $e)
    {
        $msg = get_class($e) . " Caused by:'{$e->getMessage()}' in {$e->getFile()}({$e->getLine()})\nTrace::" . $e->getTraceAsString();
        $message = $e->getMessage() . ";;Trace::" . $e->getTraceAsString();
        Logger::err($msg);
    }
    
    public static function getFaultyResponseCodes()
    {
        return array(
            APIConstants::RESPONSECODE_NO_CONTENT,
            APIConstants::RESPONSECODE_NOT_MODIFIED,
            APIConstants::RESPONSECODE_NOT_FOUND,
            APIConstants::RESPONSECODE_AUTHORIZATION_ERROR,
            APIConstants::RESPONSECODE_BAD_REQUEST,
            APIConstants::RESPONSECODE_FORBIDDEN,
            APIConstants::RESPONSECODE_INTERNAL_SERVER_ERROR,
            APIConstants::RESPONSECODE_METHOD_NOT_ALLOWED,
            APIConstants::RESPONSECODE_MOVED_PERMANENTLY,
            APIConstants::RESPONSECODE_MOVED_TEMPORARILY,
            APIConstants::RESPONSECODE_REQUEST_ENTITY_TOO_LARGE,
            APIConstants::RESPONSECODE_TOO_MANY_REQUEST,
            APIConstants::RESPONSECODE_UNSUPPORTED_MEDIA_TYPE
        );
        // return array(200,201,202,204,301,302,400,401,403,404,405,413,415,429,500);
    }
}