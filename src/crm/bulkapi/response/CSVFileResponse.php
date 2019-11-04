<?php
namespace zcrmsdk\crm\bulkapi\response;

use Exception;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\exception\ZCRMException;

class CSVFileResponse
{
    private $csvFilePointer = null;
    private $moduleAPIName = null;
    private $fieldAPINames = array();
    private $fieldsvsValue = array();
    private $apiHandlerIns = null;
    private $rowNumber = 0;
    private $checkFailedRecord = false;
    private $data = array();
    private $fileType = null;
    
    /**
     * @return multitype:
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param multitype: $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function __construct($moduleAPIName, $csvFilePointer, $checkFailedRecord,$fileType)
    {
        $this->moduleAPIName = $moduleAPIName;
        $this->csvFilePointer = $csvFilePointer;
        $this->checkFailedRecord = $checkFailedRecord;
        $this->fileType = $fileType;
    }
    
    public function setFieldValues($fieldValues)
    {
        if (sizeof($fieldValues) == sizeof($this->fieldAPINames))
        {
            for($index = 0; $index < sizeof($this->fieldAPINames); $index++)
            {
                $this->fieldsvsValue[$this->fieldAPINames[$index]] =  $fieldValues[$index];
            }
        }
    }
    
    public function setModuleAPIName($moduleAPIName)
    {
        $this->moduleAPIName = $moduleAPIName;
    }
    
    public function getModuleAPIName()
    {
        return $this->moduleAPIName;
    }
    
    public function setFieldNames($fieldAPINames)
    {
        $this->fieldAPINames = $fieldAPINames;
    }
    
    public function getFieldNames()
    {
        return $this->fieldAPINames;
    }
    
    public function setEntityAPIHandlerIns($apiHandlerIns)
    {
        $this->apiHandlerIns = $apiHandlerIns;
    }
    
    public function getEntityAPIHandlerIns()
    {
        return $this->apiHandlerIns;
    }
    
    public function next()
    {
        return $this->apiHandlerIns->next($this->moduleAPIName, $this->fieldsvsValue, $this->rowNumber);
    }
    
    public function hasNext()
    {
        $this->fieldsvsValue = array();
        try
        {
            if(($fieldValues = fgetcsv($this->csvFilePointer)) != FALSE)
            {
                if($this->fileType == "ics")
                {
                    do
                    {
                        $value=explode(":", $fieldValues[0],2);
                        if ($value[0] == "END" && count($this->fieldsvsValue) > 0 )
                        {
                            $this->fieldsvsValue[$value[0]] = $value[1]; 
                            return true;
                        }
                        else
                        {
                            $this->fieldsvsValue[$value[0]] = $value[1]; 
                        }
                    }while((($fieldValues = fgetcsv($this->csvFilePointer)) !== FALSE));
                }
                else if($this->checkFailedRecord)
                {
                    do
                    {
                        $this->rowNumber++;
                        if (in_array(APIConstants::BULK_WRITE_STATUS, $this->fieldAPINames))
                        {
                            $index = array_search(APIConstants::BULK_WRITE_STATUS, $this->fieldAPINames);
                            if (!in_array($fieldValues[$index], APIConstants::WRITE_STATUS))
                            {
                                self::setFieldValues($fieldValues);
                                return true;
                            }
                        }
                    }while((($fieldValues = fgetcsv($this->csvFilePointer)) !== FALSE));
                    $this->rowNumber = 0;
                    fclose($this->csvFilePointer);
                }
                else
                {
                    if($fieldValues != null)
                    {
                        self::setFieldValues($fieldValues);
                        $this->rowNumber++;
                        return true;
                    }
                    else
                    {
                        $this->rowNumber = 0;
                        fclose($this->csvFilePointer);
                    }
                }
                
            }
            return false;
        }
        catch(Exception $ex)
        {
            throw new ZCRMException($ex, APIConstants::RESPONSECODE_BAD_REQUEST);
        }
    }
    
    public function close()
    {
        $this->rowNumber = 0;
        fclose($this->csvFilePointer);
    }
    
    public function __destruct()
    {
        $this->moduleAPIName = null;
        $this->fieldAPINames = null;
        $this->fieldValues = null;
        unset($this->apiHandlerIns);
    }
}