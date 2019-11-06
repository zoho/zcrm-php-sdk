<?php
namespace zcrmsdk\oauth\persistence;

use Exception;
use zcrmsdk\crm\utility\Logger;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use zcrmsdk\oauth\utility\ZohoOAuthConstants;
use zcrmsdk\oauth\utility\ZohoOAuthTokens;

class ZohoOAuthPersistenceHandler implements ZohoOAuthPersistenceInterface
{
    
    public function saveOAuthData($zohoOAuthTokens)
    {
        $db_link = null;
        try {
            self::deleteOAuthTokens($zohoOAuthTokens->getUserEmailId());
            $db_link = self::getMysqlConnection();
            $query = "INSERT INTO oauthtokens(useridentifier,accesstoken,refreshtoken,expirytime) VALUES('" . $zohoOAuthTokens->getUserEmailId() . "','" . $zohoOAuthTokens->getAccessToken() . "','" . $zohoOAuthTokens->getRefreshToken() . "'," . $zohoOAuthTokens->getExpiryTime() . ")";
            
            $result = mysqli_query($db_link, $query);
            if (! $result) {
                Logger::severe("OAuth token insertion failed: (" . $db_link->errno . ") " . $db_link->error);
            }
        } catch (Exception $ex) {
            Logger::severe("Exception occured while inserting OAuthTokens into DB(file::ZohoOAuthPersistenceHandler)({$ex->getMessage()})\n{$ex}");
        } finally {
            if ($db_link != null) {
                $db_link->close();
            }
        }
    }
    
    public function getOAuthTokens($userEmailId)
    {
        $db_link = null;
        $oAuthTokens = new ZohoOAuthTokens();
        try {
            $db_link = self::getMysqlConnection();
            $query = "SELECT * FROM oauthtokens where useridentifier='" . $userEmailId . "'";
            $resultSet = mysqli_query($db_link, $query);
            if (! $resultSet) {
                Logger::severe("Getting result set failed: (" . $db_link->errno . ") " . $db_link->error);
                throw new ZohoOAuthException("No Tokens exist for the given user-identifier,Please generate and try again.");
            } else {
                while ($row = mysqli_fetch_row($resultSet)) {
                    $oAuthTokens->setExpiryTime($row[3]);
                    $oAuthTokens->setRefreshToken($row[2]);
                    $oAuthTokens->setAccessToken($row[1]);
                    $oAuthTokens->setUserEmailId($row[0]);
                    break;
                }
            }
        } catch (Exception $ex) {
            Logger::severe("Exception occured while getting OAuthTokens from DB(file::ZohoOAuthPersistenceHandler)({$ex->getMessage()})\n{$ex}");
        } finally {
            if ($db_link != null) {
                $db_link->close();
            }
        }
        return $oAuthTokens;
    }
    
    public function deleteOAuthTokens($userEmailId)
    {
        $db_link = null;
        try {
            $db_link = self::getMysqlConnection();
            $query = "DELETE FROM oauthtokens where useridentifier='" . $userEmailId . "'";
            $resultSet = mysqli_query($db_link, $query);
            if (! $resultSet) {
                Logger::severe("Deleting  oauthtokens failed: (" . $db_link->errno . ") " . $db_link->error);
            }
        } catch (Exception $ex) {
            Logger::severe("Exception occured while Deleting OAuthTokens from DB(file::ZohoOAuthPersistenceHandler)({$ex->getMessage()})\n{$ex}");
        } finally {
            if ($db_link != null) {
                $db_link->close();
            }
        }
    }
    
    public function getMysqlConnection()
    {
        $mysqli_con = new \mysqli(ZohoOAuth::getConfigValue(ZohoOAuthConstants::HOST_ADDRESS).":". ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_PORT), ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_USERNAME), ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_PASSWORD), ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_NAME));
        if ($mysqli_con->connect_errno) {
            Logger::severe("Failed to connect to MySQL: (" . $mysqli_con->connect_errno . ") " . $mysqli_con->connect_error);
            echo "Failed to connect to MySQL: (" . $mysqli_con->connect_errno . ") " . $mysqli_con->connect_error;
        }
        return $mysqli_con;
    }
}