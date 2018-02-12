<?php
require_once realpath(dirname(__FILE__)."/../Main.php");
class Helper
{
	const TRTDOPEN="<tr><td>";
	const TDCLOSEOPEN="</td><td>";
	const TDTRCLOSE="</td></tr>";
	const TDCLOSE="</td>";
	const TDOPEN="<td>";
	const TRCLOSE="</tr>";
	const TROPEN="<tr><td>";
	public static function writeToFile($filePointer,$slNo,$className,$methodName,$message,$exception,$status,$timeTaken)
	{
		Main::$totalCount++;
		if($status=="success")
		{
			$status='<font color="green">success</font>';
			Main::$successCount++;
		}
		else {
			$status='<font color="red">'.$status.'</font>';
			Main::$failureCount++;
		}
		fwrite($filePointer, self::TRTDOPEN.$slNo.self::TDCLOSEOPEN.$className.self::TDCLOSEOPEN.$methodName.self::TDCLOSEOPEN.$message.self::TDCLOSEOPEN.$exception.self::TDCLOSEOPEN.$status.self::TDCLOSEOPEN.round($timeTaken).self::TDTRCLOSE);
	}
}
?>