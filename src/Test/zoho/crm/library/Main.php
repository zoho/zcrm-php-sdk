<?php
require_once realpath(dirname(__FILE__).'/../../../../com/zoho/crm/library/setup/restclient/ZCRMRestClient.php');
require_once './api/MetaDataAPIHandlerTest.php';
require_once './api/EntityAPIHandlerTest.php';
require_once './api/ModuleAPIHandlerTest.php';
require_once './api/RelatedListAPIHandlerTest.php';
require_once './api/OrganizationAPIHandlerTest.php';
require_once './api/MassEntityAPIHandlerTest.php';
require_once './common/Helper.php';
//require_once '/usr/local/php5/lib/php/Mail/mime.php'; // PEAR Mail_Mime packge

class Main
{
	public static $totalCallsCount=0;
	public static $failureCount=0;
	public static $successCount=0;
	public static $totalCount=0;
	public function startAutomation()
	{
		try{
			ZCRMRestClient::initialize();
			/*$oAuthCli = ZohoOAuth::getClientInstance();
			$grantToken = "1000.e8d1903e61ed8db6450e0199368af7bb.2d2333746dd2cf58be68154c67477ec5";
			$oAuthTokens = $oAuthCli->generateAccessToken($grantToken);
			$accessToken = $oAuthTokens->getAccessToken();
			$refreshToken=$oAuthTokens->getRefreshToken();
			*/
			$startTime=microtime(true)*1000;
			$fileName="automationReport.html";
			$fp=fopen($fileName, "w+");
			$header="<html><head>Report</head><body><h1><center><b><i> PHP Client Library Test Report</i></b></center></h1><hr><br><table border=\"1\" width=\"100%\" cellspacing=\"2\" cellpadding=\"10\"><tr bgcolor=\"B7B2B2\"><td><b><center>SL no.</center></b></td><td><b><center>Class Name</center></b></td><td><b><center>Method Name</center></b></td><td><b><center>Message</center></b></td><td><b><center>Exception</center></b></td><td><b><center>Status</center></b></td><td><b><center>Time Taken(in milliseconds)</center></b></td></tr>";
			fwrite($fp, $header);
			OrganizationAPIHandlerTest::test($fp);
			MetaDataAPIHandlerTest::test($fp);
			ModuleAPIHandlerTest::test($fp);
			EntityAPIHandlerTest::test($fp);
			MassEntityAPIHandlerTest::test($fp);
			
			$endTime=microtime(true)*1000;
			$duration=$endTime-$startTime;
			$duration=round($duration)/1000;
			$duration=round($duration);
			fwrite($fp, Helper::TROPEN.'<td colspan="2"><font color="blue"><h2>Total Count</h1></font>'.Helper::TDCLOSE.'<td colspan="6"><h2>'.self::$totalCount.Helper::TDTRCLOSE);
			fwrite($fp, Helper::TROPEN.'<td colspan="2"><font color="red"><h2>Failure Count</h1></font>'.Helper::TDCLOSE.'<td colspan="6"><h2><font color="red">'.self::$failureCount.Helper::TDTRCLOSE);
			fwrite($fp, Helper::TROPEN.'<td colspan="2"><font color="green"><h2>Success Count</h1></font>'.Helper::TDCLOSE.'<td colspan="6"><h2><font color="green">'.self::$successCount.Helper::TDTRCLOSE);
			fwrite($fp, Helper::TROPEN.'<td colspan="2"><font color="grey"><h2>Run Duration (in min)</h1></font>'.Helper::TDCLOSE.'<td colspan="6"><h2>'.($duration/60).Helper::TDTRCLOSE);
			fclose($fp);
			//self::sendMail($fileName);
		}
		catch (Exception $e)
		{
			echo $e;
		}
	}
	
	public static function incrementTotalCount()
	{
		self::$totalCallsCount++;
	}
	
	public static function getCurrentCount()
	{
		return self::$totalCallsCount;
	}
	
	public function sendMail($file)
	{
		$message="Please verify the Automation Report!!";
		$fileContent = file_get_contents($file);
		$fileContent = chunk_split(base64_encode($fileContent));
		
		// a random hash will be necessary to send mixed content
		$separator = md5(time());
		
		// carriage return type (RFC)
		$eol = "\r\n";
		
		// main header (multipart mandatory)
		$headers = "From: PHP Automation <EMAIL HERE>" . $eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol;
		
		// message
		$body = "--" . $separator . $eol;
		$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
		$body .= "Content-Transfer-Encoding: 8bit" . $eol;
		$body .= $message . $eol;
		
		// attachment
		$body .= "--" . $separator . $eol;
		$body .= "Content-Type: application/octet-stream; name=\"" . $file . "\"" . $eol;
		$body .= "Content-Transfer-Encoding: base64" . $eol;
		$body .= "Content-Disposition: attachment" . $eol;
		$body .= $fileContent . $eol;
		$body .= "--" . $separator . "--";
		
		$mailTo="EMAIL HERE";
		$subject="PHP Client Library Automation Report";
		//SEND Mail
		if (mail($mailTo, $subject, $body, $headers)) {
			echo "Mail sent ... OK";
		} else {
			echo "Mail send ... ERROR!";
			print_r( error_get_last() );
		}
		
	}
	
	public function sendMailWithAuthentication($file)
	{
		$from = "PHP Automation <EMAIL HERE>";
		$to = "Sumanth <EMAIL HERE>";
		$subject = "Automation Report!";
		
		$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
		
		// text and html versions of email.
		$text="Sample Text";
		$html = "Please verify Automation Report";
		
		// attachment
		//$file = '/catpictures/cat.jpg';
		$crlf = "n";
		
		$mime = new Mail_mime($crlf);
		$mime->setTXTBody($text);
		$mime->setHTMLBody($html);
		$mime->addAttachment($file, 'text/plain');
		
		$body = $mime->get();
		$headers = $mime->headers($headers);
		
		$host = "mail.smtp.host";
		$username = "USERNAME HERE";
		$password = "PASSWORD HERE";
		
		$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true,
				'username' => $username,'password' => $password));
		
		$mail = $smtp->send($to, $headers, $body);
		
		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		}
		else {
			echo("<p>Message successfully sent!</p>");
		}
	}
	
}
$instance=new Main();
$instance->startAutomation();
?>