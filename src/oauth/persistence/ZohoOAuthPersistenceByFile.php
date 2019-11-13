<?php
namespace zcrmsdk\oauth\persistence;

use Exception;
use zcrmsdk\crm\utility\Logger;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use zcrmsdk\oauth\utility\ZohoOAuthTokens;

class ZohoOAuthPersistenceByFile implements ZohoOAuthPersistenceInterface
{

    private $path;
    private $tokenfile;

    public function __construct()
    {
        $this->path = trim(ZohoOAuth::getConfigValue('token_persistence_path'));
        $this->tokenfile = $this->path . '/zcrm_oauthtokens.txt';
    }

    /**
     * @return array
     *      Empty array if TokenFile does not exist or cannot be unserialized into an array
     *      Array of ZohoOAuthTokens on success
     */
    public function getFileContents()
    {
        $realfile = realpath($this->tokenfile);
        $realpath = realpath(dirname($this->tokenfile));
        if ($realpath === false) {
            $msg = "Exception occured while Getting OAuthTokens to path(file::ZohoOAuthPersistenceByFile): Token path not found ({$this->path})";
            Logger::severe($msg);
            throw new \Exception($msg);
        }

        if ($realfile !== false && is_readable($realfile)) {
            $content = file_get_contents($realfile);
            $zarr = unserialize($content);
            if (is_array($zarr)) {
                return $zarr;
            }
        }
        return array();
    }

    /**
     * Writes serialized string to TokenFile.
     * @param array $array  An Array of ZohoOAuthTokens
     * @return int          Number of bytes written to TokenFile
     */
    public function putFileContents($array)
    {

        if (($res = file_put_contents($this->tokenfile, serialize($array))) === false) {
            $msg = "Exception occured while Getting OAuthTokens to path(file::ZohoOAuthPersistenceByFile): Write failed to ({$this->tokenfile})";
            Logger::severe($msg);
            throw Exception($msg);
        }
        return $res;
    }

    public function saveOAuthData($zohoOAuthTokens)
    {
        try {
            self::deleteOAuthTokens($zohoOAuthTokens->getUserEmailId());
            $arr = $this->getFileContents();
            array_push($arr, $zohoOAuthTokens);
            $this->putFileContents($arr);
        } catch (Exception $ex) {
            Logger::severe("Exception occured while Saving OAuthTokens to file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }

    public function getOAuthTokens($userEmailId)
    {
        try {
            $arr = $this->getFileContents();
            if (empty($arr) || $arr == "") {
                throw new ZohoOAuthException("No Tokens Persisted, Please generate and try again.");
            }
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
                throw new ZohoOAuthException("No Tokens exist for the given user-identifier, Please generate and try again.");
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
            $arr = $this->getFileContents();
            if (empty($arr)) {
                return;
            }
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
            $this->putFileContents($arr);
        } catch (Exception $ex) {
            Logger::severe("Exception occured while Saving OAuthTokens to file(file::ZohoOAuthPersistenceByFile)({$ex->getMessage()})\n{$ex}");
            throw $ex;
        }
    }
}
