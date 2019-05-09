<?php
namespace zcrmsdk\oauth\persistence;

use Exception;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use zcrmsdk\oauth\utility\OAuthLogger;
use zcrmsdk\oauth\utility\ZohoOAuthTokens;

class ZohoOAuthPersistenceByFile implements ZohoOAuthPersistenceInterface
{
    
    public function setIncludePath()
    {
        $path = ZohoOAuth::getConfigValue('token_persistence_path');
        $path = trim($path);
        set_include_path($path);
    }
    
    public function saveOAuthData($zohoOAuthTokens)
    {
        try {
            self::deleteOAuthTokens($zohoOAuthTokens->getUserEmailId());
            self::setIncludePath();
            $content = file_get_contents("zcrm_oauthtokens.txt", FILE_USE_INCLUDE_PATH);
            if ($content == "") {
                $arr = array();
            } else {
                $arr = unserialize($content);
            }
            array_push($arr, $zohoOAuthTokens);
            $serialized = serialize($arr);
            file_put_contents("zcrm_oauthtokens.txt", $serialized, FILE_USE_INCLUDE_PATH);
        } catch (Exception $ex) {
            OAuthLogger::severe("Exception occured while Saving OAuthTokens to file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
    
    public function getOAuthTokens($userEmailId)
    {
        try {
            self::setIncludePath();
            $serialized = file_get_contents("zcrm_oauthtokens.txt", FILE_USE_INCLUDE_PATH);
            if (! isset($serialized) || $serialized == "") {
                throw new ZohoOAuthException("No Tokens exist for the given user-identifier,Please generate and try again.");
            }
            $arr = unserialize($serialized);
            $tokens = new ZohoOAuthTokens();
            $isValidUser = false;
            foreach ($arr as $eachObj) {
                if ($userEmailId === $eachObj->getUserEmailId()) {
                    $tokens = $eachObj;
                    $isValidUser = true;
                    break;
                }
            }
            if (! $isValidUser) {
                throw new ZohoOAuthException("No Tokens exist for the given user-identifier,Please generate and try again.");
            }
            
            return $tokens;
        } catch (ZohoOAuthException $e) {
            throw $e;
        } catch (Exception $ex) {
            OAuthLogger::severe("Exception occured while fetching OAuthTokens from file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
    
    public function deleteOAuthTokens($userEmailId)
    {
        try {
            self::setIncludePath();
            $serialized = file_get_contents("zcrm_oauthtokens.txt", FILE_USE_INCLUDE_PATH);
            if (! isset($serialized) || $serialized == "") {
                return;
            }
            $arr = unserialize($serialized);
            $found = false;
            $i = - 1;
            foreach ($arr as $i => $eachObj) {
                if ($userEmailId === $eachObj->getUserEmailId()) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                unset($arr[$i]);
                $arr = array_values(array_filter($arr));
            }
            $serialized = serialize($arr);
            file_put_contents("zcrm_oauthtokens.txt", $serialized, FILE_USE_INCLUDE_PATH);
        } catch (Exception $ex) {
            OAuthLogger::severe("Exception occured while Saving OAuthTokens to file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
}
