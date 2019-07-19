<?php
namespace zcrmsdk\oauth\utility;

interface ZohoOAuthLoggerInterface
{
    public function writeToFile($msg);

    public function warn($msg);

    public function info($msg);

    public function severe($msg);

    public function err($msg);

    public function debug($msg);
}
