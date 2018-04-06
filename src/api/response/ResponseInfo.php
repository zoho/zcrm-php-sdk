<?php

namespace ZCRM\api\response;

use ZCRM\common\APIConstants;

class ResponseInfo {
    private $moreRecords = null;
    private $recordCount = null;
    private $pageNo = null;
    private $perPage = null;

    public function __construct($reponseInfoJSON) {
        $this->moreRecords = (bool)$reponseInfoJSON[APIConstants::MORE_RECORDS];
        $this->recordCount = $reponseInfoJSON[APIConstants::COUNT] + 0;
        $this->pageNo = $reponseInfoJSON[APIConstants::PAGE] + 0;
        $this->perPage = $reponseInfoJSON[APIConstants::PER_PAGE] + 0;
    }

    /**
     * moreRecords
     * @return Boolean
     */
    public function getMoreRecords() {
        return $this->moreRecords;
    }

    /**
     * moreRecords
     * @param Boolean $moreRecords
     */
    public function setMoreRecords($moreRecords) {
        $this->moreRecords = $moreRecords;
    }

    /**
     * recordCount
     * @return int
     */
    public function getRecordCount() {
        return $this->recordCount;
    }

    /**
     * recordCount
     * @param int $recordCount
     */
    public function setRecordCount($recordCount) {
        $this->recordCount = $recordCount;
    }

    /**
     * pageNo
     * @return int
     */
    public function getPageNo() {
        return $this->pageNo;
    }

    /**
     * pageNo
     * @param int $pageNo
     */
    public function setPageNo($pageNo) {
        $this->pageNo = $pageNo;
    }

    /**
     * perPage
     * @return int
     */
    public function getPerPage() {
        return $this->perPage;
    }

    /**
     * perPage
     * @param int $perPage
     */
    public function setPerPage($perPage) {
        $this->perPage = $perPage;
    }

}

?>