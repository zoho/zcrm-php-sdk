<?php
namespace zcrmsdk\crm\bulkcrud;

class ZCRMBulkWriteFileStatus
{
    /**
     * file status
     * @var string
     */
    private $status = null;
    
    /**
     * file name
     * @var string
     */
    private $name = null;
    
    /**
     * added record count
     * @var int
     */
    private $added_count = null;
    
    /**
     * skipped record count
     * @var int
     */
    private $skipped_count = null;
    
    /**
     * updated record count
     * @var int
     */
    private $updated_count = null;
    
    /**
     * total record count
     * @var int
     */
    private $total_count = null;
    
    /**
     * constructor to set the file name
     * @param string $fileName
     */
    private function __construct($fileName)
    {
        $this->name = $fileName;
    }
    
    /**
     * Method to get the instance of the ZCRMBulkWriteFile class
     * @param string $fileName
     * @return ZCRMBulkWriteFileStatus - class instance
     */
    public static function getInstance($fileName = null)
    {
        return new ZCRMBulkWriteFileStatus($fileName);
    }
    
    /**
     * Method to set the status of the bulk write job for that file.
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Method to get the status of the bulk write job for that file.
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Method to set the name of the CSV file which will get downloaded.
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->name = $fileName;
    }
    
    /**
     * Method to get the name of the CSV file which will get downloaded.
     * @return string
     */
    public function getFileName()
    {
        return $this->name;
    }
    
    /**
     * Method to set the number of records added or imported.
     * @param int $added_count
     */
    public function setAddedCount($added_count)
    {
        $this->added_count = $added_count;
    }
    
    /**
     * Method to get the number of records added or imported.
     * @return number
     */
    public function getAddedCount()
    {
        return $this->added_count;
    }
    
    /**
     * Method to set the number of records skipped due to some issues.
     * @param int $skipped_count
     */
    public function setSkippedCount($skipped_count)
    {
        $this->skipped_count = $skipped_count;
    }
    
    /**
     * Method to get the number of records skipped due to some issues.
     * @return number
     */
    public function getSkippedCount()
    {
        return $this->skipped_count;
    }
    
    /**
     * Method to set the number of records updated during bulk update.
     * @param int $updated_count
     */
    public function setUpdatedCount($updated_count)
    {
        $this->updated_count = $updated_count;
    }
    
    /**
     * Method to get the number of records updated during bulk update.
     * @return number
     */
    public function getUpdatedCount()
    {
        return $this->updated_count;
    }
    
    /**
     * Method to set the total number of records inserted, updated, or skipped during bulk import.
     * @param int $total_count
     */
    public function setTotalCount($total_count)
    {
        $this->total_count = $total_count;
    }
    
    /**
     * Method to get the total number of records inserted, updated, or skipped during bulk import.
     * @return number
     */
    public function getTotalCount()
    {
        return $this->total_count;
    } 
}
?>