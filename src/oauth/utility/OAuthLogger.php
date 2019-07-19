<?php
namespace zcrmsdk\oauth\utility;

class OAuthLogger
{
    /** @var \zcrmsdk\oauth\utility\ZohoOAuthLoggerInterface */
    private static $oauthLogger;

    private static function initializeLogger()
    {
        if (!$self::oauthLogger) {
            $loggerClassName = ZohoOAuth::getConfigValue(ZohoOAuthConstants::OAUTH_LOGGER_CLASS);
            self::$oauthLogger = new $loggerClassName();
        }
    }

    public static function writeToFile($msg)
    {
        self::initializeLogger();
        return self::$oauthLogger->writeToFile($msg);
    }

    public static function warn($msg)
    {
        self::initializeLogger();
        return self::$oauthLogger->warn($msg);
    }

    public static function info($msg)
    {
        self::initializeLogger();
        return self::$oauthLogger->info($msg);
    }

    public static function severe($msg)
    {
        self::initializeLogger();
        return self::$oauthLogger->severe($msg);
    }

    public static function err($msg)
    {
        self::initializeLogger();
        return self::$oauthLogger->err($msg);
    }

    public static function debug($msg)
    {
        self::initializeLogger();
        return self::$oauthLogger->debug($msg);
    }
}
