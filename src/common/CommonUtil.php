<?php

namespace ZCRM\common;

use ZCRM\exception\Logger;

class CommonUtil {
    /**
     * @param $fileHandler
     * @return array
     */
    public static function getFileContentAsMap($fileHandler) {
        
        $reponseMap = array();
        try {
            while (!feof($fileHandler)) {
                $line = fgets($fileHandler);
                $lineAfterSplit = explode("=", $line);
                if (strpos($lineAfterSplit[0], "#") === false) {
                    $reponseMap[trim($lineAfterSplit[0])] = trim($lineAfterSplit[1]);
                }
            }
            fclose($fileHandler);
        } catch (\Exception $ex) {
            Logger::warn("Exception occured while converting file content as map (file::ZohoOAuthUtil.php)");
        }
        return $reponseMap;
    }

    /**
     * @return \ArrayObject
     */
    public static function getEmptyJSONObject() {
        return new \ArrayObject();
    }
}

?>