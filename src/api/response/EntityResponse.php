<?php

namespace ZCRM\api\response;

use ZCRM\common\APIConstants;

class EntityResponse {
    private $status = null;
    private $message = null;
    private $code = null;
    private $responseJSON = null;
    private $data = null;
    private $upsertDetails = array();
    private $details = null;

    public function __construct($entityResponseJSON) {
        $this->responseJSON = $entityResponseJSON;
        $this->status = $entityResponseJSON[APIConstants::STATUS];
        $this->message = $entityResponseJSON[APIConstants::MESSAGE];
        $this->code = $entityResponseJSON[APIConstants::CODE];

        if (array_key_exists(APIConstants::ACTION, $entityResponseJSON)) {
            $this->upsertDetails[APIConstants::ACTION] = $entityResponseJSON[APIConstants::ACTION];
        }
        if (array_key_exists(APIConstants::DUPLICATE_FIELD, $entityResponseJSON)) {
            $this->upsertDetails[APIConstants::DUPLICATE_FIELD] = $entityResponseJSON[APIConstants::DUPLICATE_FIELD];
        }
        if (array_key_exists("details", $entityResponseJSON)) {
            $this->details = $entityResponseJSON["details"];
        }
    }

    /**
     * status
     * @return String
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * status
     * @param String $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * message
     * @return String
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * message
     * @param String $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * code
     * @return String
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * code
     * @param String $code
     */
    public function setCode($code) {
        $this->code = $code;
    }


    /**
     * responseJson
     * @return mixed JSONObject
     */
    public function getResponseJSON() {
        return $this->responseJSON;
    }


    /**
     * data
     * @return mixed Entity Data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * data
     * @param mixed $data Entity Data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /*
     * Returns upsert details like action,duplicate_field
     */
    public function getUpsertDetails() {
        return $this->upsertDetails;
    }

    public function setDetails($details) {
        $this->details = $details;
    }

    public function getDetails() {
        return $this->details;
    }

}

?>
