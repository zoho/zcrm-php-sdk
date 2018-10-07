<?php
require_once realpath(dirname(__FILE__)."/../client/ZohoOAuthPersistenceInterface.php");
require_once realpath(dirname(__FILE__)."/../common/ZohoOAuthException.php");
require_once realpath(dirname(__FILE__)."/../common/OAuthLogger.php");

class ZohoOAuthPersistenceHandler implements ZohoOAuthPersistenceInterface
{
	public function saveOAuthData($zohoOAuthTokens)
	{
		$db_link=null;
		try{
			self::deleteOAuthTokens($zohoOAuthTokens->getUserEmailId());
			$db_link=self::getMysqlConnection();
			$query="INSERT INTO oauthtokens(useridentifier,accesstoken,refreshtoken,expirytime) VALUES('".$zohoOAuthTokens->getUserEmailId()."','".$zohoOAuthTokens->getAccessToken()."','".$zohoOAuthTokens->getRefreshToken()."',".$zohoOAuthTokens->getExpiryTime().")";
			
			/*$query="INSERT INTO oauthtokens(useridentifier,accesstoken,refreshtoken,expirytime) VALUES(?,?,?,?)";
			$stmt=$db_link->prepare($query);
			//ssi represents data types of param values (String,String,Integer)
			$stmt->bind_param("sssi",$zohoOAuthTokens->getUserEmailId(),$zohoOAuthTokens->getAccessToken(),$zohoOAuthTokens->getRefreshToken(),$zohoOAuthTokens->getExpiryTime());
			$stmt->execute();*/
			$result=mysqli_query($db_link, $query);
			if(!$result)
			{
				OAuthLogger::severe("OAuth token insertion failed: (" . $db_link->errno . ") " . $db_link->error);
			}
			
		}
		catch (Exception $ex)
		{
			Logger:severe("Exception occured while inserting OAuthTokens into DB(file::ZohoOAuthPersistenceHandler)({$ex->getMessage()})\n{$ex}");
		}
		finally {
			if($db_link!=null)
			{
				$db_link->close();
			}
		}
	}
	
	public function getOAuthTokens($userEmailId)
	{
		$db_link=null;
		$oAuthTokens=new ZohoOAuthTokens();
		try{
			$db_link=self::getMysqlConnection();
			$query="SELECT * FROM oauthtokens where useridentifier='".$userEmailId."'";
			$resultSet=mysqli_query($db_link,$query);
			if (!$resultSet) {
				OAuthLogger::severe("Getting result set failed: (" . $db_link->errno . ") " . $db_link->error);
				throw new ZohoOAuthException("No Tokens exist for the given user-identifier,Please generate and try again.");
			}else{
				while($row=mysqli_fetch_row($resultSet))
				{
					$oAuthTokens->setExpiryTime($row[3]);
					$oAuthTokens->setRefreshToken($row[2]);
					$oAuthTokens->setAccessToken($row[1]);
					$oAuthTokens->setUserEmailId($row[0]);
					break;
				}
			}
		}
		catch (Exception $ex)
		{
			OAuthLogger::severe("Exception occured while getting OAuthTokens from DB(file::ZohoOAuthPersistenceHandler)({$ex->getMessage()})\n{$ex}");
		}
		finally {
			if($db_link!=null)
			{
				$db_link->close();
			}
		}
		return $oAuthTokens;
	}
	
	public function deleteOAuthTokens($userEmailId)
	{
		$db_link=null;
		try{
			$db_link=self::getMysqlConnection();
			$query="DELETE FROM oauthtokens where useridentifier='".$userEmailId."'";
			$resultSet=mysqli_query($db_link,$query);
			if(!$resultSet) {
				OAuthLogger::severe("Deleting  oauthtokens failed: (" . $db_link->errno . ") " . $db_link->error);
			}
		}
		catch (Exception $ex)
		{
			OAuthLogger::severe("Exception occured while Deleting OAuthTokens from DB(file::ZohoOAuthPersistenceHandler)({$ex->getMessage()})\n{$ex}");
		}
		finally {
			if($db_link!=null)
			{
				$db_link->close();
			}
		}
	}
	
	public function getMysqlConnection()
	{
		$mysqli_con = new mysqli("localhost:".ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_PORT),ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_USERNAME), 
		ZohoOAuth::getConfigValue(ZohoOAuthConstants::DATABASE_PASSWORD), "zohooauth");
		if ($mysqli_con->connect_errno) {
			OAuthLogger::severe("Failed to connect to MySQL: (" . $mysqli_con->connect_errno . ") " . $mysqli_con->connect_error);
			echo "Failed to connect to MySQL: (" . $mysqli_con->connect_errno . ") " . $mysqli_con->connect_error;
		}
		/*$db_link = mysql_connect('localhost:3307', 'root', '');
		if (!$db_link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('zohooauth', $db_link) or die('Could not select database.');
		return $db_link;*/
		
		return $mysqli_con;
	}
}
?>