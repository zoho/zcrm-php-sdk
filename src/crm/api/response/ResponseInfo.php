<?php
namespace zcrmsdk\crm\api\response;

use zcrmsdk\crm\utility\APIConstants;

class ResponseInfo
{
    
    /**
     * *
     * more records
     *
     * @var boolean
     */
    private $moreRecords = null;
    
    /**
     * record count
     *
     * @var int
     */
    private $recordCount = null;
    
    /**
     * page number
     *
     * @var int
     */
    private $pageNo = null;
    
    /**
     * records per page
     *
     * @var int
     */
    private $perPage = null;
    
    /**
     * number of tags allowed
     *
     * @var int
     */
    private $tagAllowedCount = null;
    
    /**
     * constructor to set response information
     *
     * @param ResponseInfo $reponseInfoJSON instance if the ResponseInfo class
     */
    public function __construct($reponseInfoJSON)
    {
        if (array_key_exists(APIConstants::MORE_RECORDS, $reponseInfoJSON)) {
            $this->moreRecords = (bool) $reponseInfoJSON[APIConstants::MORE_RECORDS];
        }
        if (array_key_exists(APIConstants::COUNT, $reponseInfoJSON)) {
            $this->recordCount = $reponseInfoJSON[APIConstants::COUNT] + 0;
        }
        if (array_key_exists(APIConstants::PAGE, $reponseInfoJSON)) {
            $this->pageNo = $reponseInfoJSON[APIConstants::PAGE] + 0;
        }
        if (array_key_exists(APIConstants::PER_PAGE, $reponseInfoJSON)) {
            $this->perPage = $reponseInfoJSON[APIConstants::PER_PAGE] + 0;
        }
        if (array_key_exists(APIConstants::ALLOWED_COUNT, $reponseInfoJSON)) {
            $this->tagAllowedCount = $reponseInfoJSON[APIConstants::ALLOWED_COUNT] + 0;
        }
    }
    
    /**
     * method to check whether more records are available or not
     *
     * @return Boolean true if more records are available otherwise false
     */
    public function getMoreRecords()
    {
        return $this->moreRecords;
    }
    
    /**
     * method to set more records are available
     *
     * @param Boolean $moreRecords true for more records available otherwise false
     */
    public function setMoreRecords($moreRecords)
    {
        $this->moreRecords = $moreRecords;
    }
    
    /**
     * method to get the record count
     *
     * @return int the record count
     */
    public function getRecordCount()
    {
        return $this->recordCount;
    }
    
    /**
     * method to set the record count
     *
     * @param int $recordCount the record count
     */
    public function setRecordCount($recordCount)
    {
        $this->recordCount = $recordCount;
    }
    
    /**
     * method to get the page number of the records
     *
     * @return int the page number of the records
     */
    public function getPageNo()
    {
        return $this->pageNo;
    }
    
    /**
     * method to set the page number of the records
     *
     * @param int $pageNo the page number of the records
     */
    public function setPageNo($pageNo)
    {
        $this->pageNo = $pageNo;
    }
    
    /**
     * method to get the number of records per page
     *
     * @return int the number of records per page
     */
    public function getPerPage()
    {
        return $this->perPage;
    }
    
    /**
     * method to set the number of records per page
     *
     * @param int $perPage the number of records per page
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }
    
    /**
     * method to get the allowed count of the records
     *
     * @return int the allowed count of the records
     */
    public function getAllowedCount()
    {
        return $this->allowedCount;
    }
    
    /**
     * method to set the allowed count of the records
     *
     * @param int $allowedCount allowed count of the records
     */
    public function setAllowedCount($allowedCount)
    {
        $this->allowedCount = $allowedCount;
    }
}