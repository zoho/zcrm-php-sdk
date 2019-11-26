<?php
namespace zcrmsdk\oauth\persistence;

use Exception;
use zcrmsdk\crm\utility\Logger;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use zcrmsdk\oauth\utility\ZohoOAuthTokens;

class ZohoOAuthPersistenceByFile implements ZohoOAuthPersistenceInterface
{
    
    public function getTokenPersistencePath()
    {
        $path = ZohoOAuth::getConfigValue('token_persistence_path');
        $path = trim($path);
        return $path;
    }
    
    public function saveOAuthData($zohoOAuthTokens)
    {
        try {
            self::deleteOAuthTokens($zohoOAuthTokens->getUserEmailId());
            $content = file_get_contents(self::getTokenPersistencePath()."/zcrm_oauthtokens.txt" );
            if ($content == "") {
                $arr = array();
            } else {
                $arr = unserialize($content);
            }
            array_push($arr, $zohoOAuthTokens);
            $serialized = serialize($arr);
            file_put_contents(self::getTokenPersistencePath()."/zcrm_oauthtokens.txt",$serialized );
        } catch (Exception $ex) {
            Logger::severe("Exception occured while Saving OAuthTokens to file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
    
    public function getOAuthTokens($userEmailId)
    {
        try {
            $serialized = file_get_contents(self::getTokenPersistencePath()."/zcrm_oauthtokens.txt" );
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
            Logger::severe("Exception occured while fetching OAuthTokens from file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
    
    public function deleteOAuthTokens($userEmailId)
    {
        try {
            $serialized = file_get_contents(self::getTokenPersistencePath()."/zcrm_oauthtokens.txt" );
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
            file_put_contents(self::getTokenPersistencePath()."/zcrm_oauthtokens.txt",$serialized );
        } catch (Exception $ex) {
            Logger::severe("Exception occured while Saving OAuthTokens to file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
}
