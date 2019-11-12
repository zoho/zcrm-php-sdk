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
            $stmt = $this->prepareStatement(
                        $db_link,
                'INSERT INTO oauthtokens(useridentifier,accesstoken,refreshtoken,expirytime) VALUES(?, ?, ?, ?)',
                        'sssi',
                        $zohoOAuthTokens->getUserEmailId(),
                        $zohoOAuthTokens->getAccessToken(),
                        $zohoOAuthTokens->getRefreshToken(),
                        $zohoOAuthTokens->getExpiryTime()
                    );

            $result = $stmt->execute();
            if (! $result) {
                Logger::severe(sprintf('OAuth token insertion failed: (%s) %s', $stmt->errno, $stmt->error));
            }
        } catch (Exception $ex) {
            Logger::severe(sprintf("Exception occured while inserting OAuthTokens into DB(file::ZohoOAuthPersistenceHandler)(%s)\n%s",
                $ex->getMessage(), $ex));
        } finally {
            if ($db_link !== null) {
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
            $stmt = $this->prepareStatement($db_link, 'SELECT * FROM oauthtokens where useridentifier = ?', 's', $userEmailId);

            $resultSet = $stmt->execute();
            if (! $resultSet) {
                Logger::severe(sprintf('Getting result set failed: (%s) %s', $stmt->errno, $stmt->error));
                throw new ZohoOAuthException('No Tokens exist for the given user-identifier,Please generate and try again.');
            } else {
                $result = $stmt->get_result();
                while ($result && $row = $result->fetch_row()) {
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
            if ($db_link !== null) {
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
            $stmt = $this->prepareStatement($db_link, 'DELETE FROM oauthtokens where useridentifier= ?', 's', $userEmailId);

            $resultSet = $stmt->execute();
            if (! $resultSet) {
                Logger::severe(sprintf('Deleting  oauthtokens failed: (%s) %s', $stmt->errno, $stmt->error));
            }
        } catch (Exception $ex) {
            Logger::severe(sprintf("Exception occured while Deleting OAuthTokens from DB(file::ZohoOAuthPersistenceHandler)(%s)\n%s",
                $ex->getMessage(), $ex));
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

    /**
     * @param \mysqli $db_link
     * @param string  $query
     * @param string  $types Parameter Types String
     * @param mixed   ...$parameters Parameters to be bound
     *
     * @throws \InvalidArgumentException Number of arguments does not match type specification
     * @throws \RuntimeException Statement can not be prepared
     * @return \mysqli_stmt
     */
    private function prepareStatement($db_link, $query, $types, ...$parameters) {
        if(count($parameters) !== strlen($types)) {
            throw new \InvalidArgumentException(
                sprintf('Expected %s parameters, %s given', strlen($types), count($parameters))
            );
        }

        $stmt = $db_link->prepare($query);
        $stmt->bind_param($types, $parameters);

        if(!$stmt) {
            throw new \RuntimeException('Could not prepare SQL statement', 1573560073);
        }

        return $stmt;
    }
}