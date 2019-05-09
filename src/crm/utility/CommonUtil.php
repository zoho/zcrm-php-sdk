<?php
namespace zcrmsdk\crm\utility;

class CommonUtil
{
    public static function getEmptyJSONObject()
    {
        return new \ArrayObject();
    }
    
    public static function removeNullValuesAlone($value)
    {
        return $value !== null;
    }
}