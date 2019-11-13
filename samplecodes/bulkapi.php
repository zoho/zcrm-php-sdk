
<?php 
use zcrmsdk\crm\bulkcrud\ZCRMBulkCallBack;
use zcrmsdk\crm\bulkcrud\ZCRMBulkCriteria;
use zcrmsdk\crm\bulkcrud\ZCRMBulkQuery;
use zcrmsdk\crm\bulkcrud\ZCRMBulkRead;
use zcrmsdk\crm\bulkcrud\ZCRMBulkWriteFieldMapping;
use zcrmsdk\crm\bulkcrud\ZCRMBulkWriteResource;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\utility\ZCRMConfigUtil;

class RestClient
{
    public function __construct()
    {
        $configuration = [];
        ZCRMRestClient::initialize($configuration);
    }
    
    public static function createBulkReadJob($moduleAPIName)
    {
        $restClient = ZCRMRestClient::getInstance();//to get the rest client
        
        $bulkReadrecordIns = $restClient->getBulkReadInstance($moduleAPIName, null);//To get the ZCRMBulkRead instance of the module
        
        $group1 = ZCRMBulkCriteria::getInstance();// To get ZCRMCriteria instance
        $group1->setGroupOperator("and");// To set criteria group_operator(Supported values - and, or).
        $grouplist1 = array();// List of ZCRMCriteria instance
        
        $group2 = ZCRMBulkCriteria::getInstance();
        $group2->setGroupOperator("or");
        $grouplist2 = array();
        
        $group3 = ZCRMBulkCriteria::getInstance();
        $group3->setGroupOperator("and");
        $grouplist3 = array();
        
        $group4 = ZCRMBulkCriteria::getInstance();
        $group4->setAPIName("Last_Name");// To set API name of a field.
        $group4->setComparator("equal");// To set comparator(eg: equal, greater_than.).
        $group4->setValue("PHP Test Lead1");// To set the value to be compare.
        
        array_push($grouplist3,$group4);// To add ZCRMCriteria instance.
        
        $group5 = ZCRMBulkCriteria::getInstance();
        $group5->setGroupOperator("and");
        $grouplist5 = array();
        
        $group6 = ZCRMBulkCriteria::getInstance();
        $group6->setAPIName("First_Name");
        $group6->setComparator("equal");
        $group6->setValue("first_name");
        
        array_push($grouplist5, $group6);
        $group5->setGroup($grouplist5);
        
        $group7 = ZCRMBulkCriteria::getInstance();
        $group7->setAPIName("Full_Name");
        $group7->setComparator("equal");
        $group7->setValue("name");
        
        array_push($grouplist5, $group7);
        $group5->setGroup($grouplist5);
        
        array_push($grouplist3,$group5);
        $group3->setGroup($grouplist3);
        
        array_push($grouplist2,$group3);
        
        $group8 = ZCRMBulkCriteria::getInstance();
        $group8->setAPIName("First_Name");
        $group8->setComparator("equal");
        $group8->setValue("testsdk");
        array_push($grouplist2,$group8);
        
        $group9 = ZCRMBulkCriteria::getInstance();
        $group9->setAPIName("Company");
        $group9->setComparator("equal");
        $group9->setValue("ZOHO");
        array_push($grouplist2,$group9);
        
        $group2->setGroup($grouplist2);
        
        array_push($grouplist1,$group2);
        
        $group10 = ZCRMBulkCriteria::getInstance();
        $group10 ->setAPIName("Phone");
        $group10->setComparator("equal");
        $group10->setValue("999-999-9999");
        array_push($grouplist1,$group10);
        
        $group1->setGroup($grouplist1);
        
        $query = ZCRMBulkQuery::getInstance();
        $query->setCvId("34777501");// To set custom view id of the module
        
        $fields = array();// List of Field API Names
        array_push($fields,"First_Name");
        array_push($fields,"Last_Name");
        array_push($fields,"Email");
        $query->setFields($fields);// To set list of API Name of the fields to be fetched.
        
        $query->setPage(1);// To set page value, By default value is 1.
        $query->setCriteria($group1);// To set ZCRMCriteria instance.
        $bulkReadrecordIns->setQuery($query);// To set ZCRMBulkQuery instance.
        
        $callBack = ZCRMBulkCallBack::GetInstance();// To get ZCRMBulkCallBack instance
        $callBack->setUrl("https://www.zoho.com");// To set callback URL.
        $callBack->setMethod("post");// To set the HTTP method of the callback url. The allowed value is post.
        
        $bulkReadrecordIns->setCallBack($callBack);// To set ZCRMBulkCallBack instance
//         $bulkReadrecordIns->setFileType("ics");// Set the value for this key as "ics" to export all records in the Events module as an ICS file.
        
        $recordres = $bulkReadrecordIns->createBulkReadJob();// To create Bulk read job.
        
        echo "HTTP Status Code:" . $recordres->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $recordres->getStatus()."\n"; // To get response status
        echo "Message:" . $recordres->getMessage()."\n"; // To get response message
        echo "Code:" . $recordres->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($recordres->getDetails())."\n";
        echo "Response Json".json_encode($recordres->getResponseJSON())."\n";
        
        $readIns = $recordres->getData();// To get the ZCRMBulkRead instance.
        
        echo ($readIns->getCreatedTime())."\n";
        echo ($readIns->getOperation())."\n";
        echo ($readIns->getState())."\n";
        echo ($readIns->getJobId())."\n";// To get the job_id of bulk read job.
        
        $created_by = $readIns->getCreatedBy();
        
        echo $created_by->getId()."\n";
        echo $created_by->getName()."\n";
        
    }
    
    public static function getBulkReadJobDetails($job_id)
    {
        $record= ZCRMRestClient::getInstance()->getBulkReadInstance(null,$job_id);
        $response = $record->getBulkReadJobDetails();
     
        $read = $response->getData();
        echo $read->getCreatedTime()."\n";
        
        $created_by = $read->getCreatedBy();
        echo $created_by->getId()."\n";
        echo $created_by->getName()."\n";
        
        echo $read->getOperation()."\n";
        echo $read->getState()."\n";
        echo $read->getJobId()."\n";
        
        $query = $read->getQuery();
        echo $query->getPage()."\n";
        print_r($query->getFields());
        echo "\n";
        echo $query->getModuleAPIName()."\n";
        echo $query->getCvId()."\n";
        
        $criteria = $query->getCriteria();
        echo $criteria->getAPIName()."\n";
        var_dump($criteria->getValue());
        echo $criteria->getGroupOperator()."\n";
        echo $criteria->getComparator()."\n";
        //         var_dump($criteria->getGroup());
        $groups = $criteria->getGroup();
        foreach($groups as $group )
        {
            echo $group->getAPIName()."\n";
            var_dump($group->getValue());
            echo $group->getGroupOperator()."\n";
            echo $group->getComparator()."\n";
            print_r($group->getGroup())."\n";
        }
        
        echo $query->getCriteriaPattern()."\n";
        echo ($query->getCriteriaCondition());
        echo "\n";
        $result = $read->getResult();
        echo $result->getCount()."\n";
        echo $result->getDownloadUrl()."\n";
        var_dump($result->getMoreRecords())."\n";
        echo $result->getPage()."\n";
        echo $result->getPerPage()."\n";
        
    }
    
    
    public static function DownloadBulkReadResult($jobId,$filePath)
    {
        $record= ZCRMRestClient::getInstance()->getBulkReadInstance(null,$jobId);
        $response = $record->downloadBulkReadResult();
        $fp = fopen($filePath.$response->getFileName(), "w"); // $filePath - absolute path where downloaded file has to be stored.
        echo "HTTP Status Code:" . $response->getHttpStatusCode();
        echo "File Name:" . $response->getFileName();
        $stream = $response->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
    }

    /** Download the zip and Get list of record instances*/
    public static function DownloadandGetRecords($jobId,$filePath)
    {
        try {
            $recordIns= ZCRMRestClient::getInstance()->getBulkReadInstance("Leads",$jobId);
            $fileResponse =  $recordIns->downloadANDGetRecords($filePath);
            while($fileResponse->hasNext())
            {
                $record = $fileResponse->next();
                echo $record->getEntityId()."\n";
                echo $record->getCreatedTime()."\n";
                echo $record->getFieldValue("Company")."\n";
                echo $record->getModifiedTime()."\n";
                echo $record->getModuleAPIName()."\n";
                
                $owner= $record->getOwner();
                if($owner!=null){
                    echo $owner->getId()."\n";
                }
                $modifiedBy= $record->getModifiedBy();
                if($modifiedBy != null){
                    echo $modifiedBy->getId()."\n";
                }
                $createdBy = $record->getCreatedBy();
                if($createdBy != null){
                    echo $createdBy->getId()."\n";
                }
                
                echo $record->getRecordRowNumber()."\n";
                foreach($record->getData() as $key=>$value)
                {
                    echo "Key\t:".$key."\tValue:".$value."\n";
                }
//                 $fileResponse->close();
            }
        } catch (Exception $e) {
            print_r($e);
        }
        
    }
    
    /** Get the list of record instances */
    /** This method used for ics file type supported module. */
    public static function DownloadandGetRecords1($jobId,$filePath)
    {
        try 
        {
            $recordIns= ZCRMRestClient::getInstance()->getBulkReadInstance("Events",$jobId);// To get the ZCRMBulkRead instance using job_id
            $fileResponse =  $recordIns->downloadANDGetRecords($filePath);// To download the zip and get list of record instances.
            foreach($fileResponse->getData() as $key=>$value)
            {
                echo "Key\t:".$key."\tValue:";
                if($key=="EventsData")
                {
                    while($value->hasNext())
                    {
                        $record = $value->next();
                        foreach($record->getData() as $key1=>$value1)
                        {
                            echo "\nKey1\t:".$key1."\tValue1:".$value1."\n";
                        }
                        //$value->close();
                    }
                }
                else
                {
                    echo $value."\n";
                }
            }
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }
    
    /** Get the list of record instances */
    public static function GetRecordsFromFile($moduleAPIName,$fileName,$filePath)
    {
        $recordIns= ZCRMBulkRead::getInstance($moduleAPIName);// To get the ZCRMBulkRead instance of the module
        $fileResponse =  $recordIns->GetRecords($filePath, $fileName);// Absolute path of the downloaded zip and the name of the zip file to fetch record.
        while($fileResponse->hasNext())
        {
            $record = $fileResponse->next();
            echo $record->getEntityId()."\n";
            echo $record->getCreatedTime()."\n";
            echo $record->getFieldValue("Company")."\n";
            echo $record->getModifiedTime()."\n";
            echo $record->getModuleAPIName()."\n";
            
            $owner= $record->getOwner();
            if($owner!=null){
                echo $owner->getId()."\n";
            }
            $modifiedBy= $record->getModifiedBy();
            if($modifiedBy != null){
                echo $modifiedBy->getId()."\n";
            }
            $createdBy = $record->getCreatedBy();
            if($createdBy != null){
                echo $createdBy->getId()."\n";
            }
            
            echo $record->getRecordRowNumber()."\n";
            foreach($record->getData() as $key => $value)
            {
                echo "Key\t:".$key."\tValue:".$value."\n";
            }
//             $fileResponse->close();
        }
       
    }
    
    /** Get the list of record instances */
    /** This method used for ics file type supported module. */
    public static function GetRecordsFromFile1($moduleAPIName,$fileName,$filePath)
    {
        $recordIns= ZCRMBulkRead::getInstance($moduleAPIName);// To get the ZCRMBulkRead instance of the module
        $fileResponse =  $recordIns->GetRecords($filePath, $fileName);// Absolute path of the downloaded zip and the name of the zip file to fetch record.
        foreach($fileResponse->getData() as $key=>$value)
        {
            echo "Key\t:".$key."\tValue:";
            if($key=="EventsData")
            {
                while($value->hasNext())
                {
                    $record = $value->next();
                    foreach($record->getData() as $key1=>$value1)
                    {
                        echo "\nKey1\t:".$key1."\tValue1:".$value1."\n";
                    }
                    //$value->close();
                }
            }
            else
            {
                echo $value."\n";
            }
        }
    }
    

    public static function uploadFile($filePath)
    {
        try 
        {
            $write = ZCRMRestClient::getInstance()->getBulkWriteInstance();
            $headers = array();
            $headers["X-CRM-ORG"] = "6745";
            $headers["feature"] = "bulk-write";
            $resp = $write->uploadFile($filePath, $headers);
            echo "HTTP Status Code:" . $resp->getHttpStatusCode()."\n"; // To get http response code
            echo "Status:" . $resp->getStatus()."\n"; // To get response status
            echo "Message:" . $resp->getMessage()."\n"; // To get response message
            echo "Code:" . $resp->getCode()."\n"; // To get status code
            echo "Details:" . json_encode($resp->getDetails())."\n";
            echo "Response Json".json_encode($resp->getResponseJSON())."\n";
            $attach = $resp->getData();
            echo $attach->getId()."\n";
            echo $attach->getCreatedTime()."\n";
        } catch (Exception $e) 
        {
            var_dump($e);
        }
    }

    public static function createBulkWriteJob($file_id, $modulAPIName)
    {
        $writeJob = ZCRMRestClient::getInstance()->getBulkWriteInstance();
        $writeJob->setOperation("insert");
        
        $writeJob->setCharacterEncoding("UTF-8");
        
        $callBackIns = ZCRMBulkCallBack::getInstance("https://crm.zoho.com/crm/org/tab/Home/begin", "post");
        $writeJob->setCallback($callBackIns);
        
        $resourceIns = ZCRMBulkWriteResource::getInstance($modulAPIName, $file_id);
        $resourceIns->setType("data");
        $resourceIns->setIgnoreEmpty(true);
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Last_Name",0);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Email", 1);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Company", 2);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Phone", 3);
        $resourceIns->setFieldMapping($fieldMappings);
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Website");
        $fieldMappings->setDefaultValue("value", "https://www.zoho.com");
        $resourceIns->setFieldMapping($fieldMappings);
       
        
        $writeJob->setResource($resourceIns);
        
        $response = $writeJob->createBulkWriteJob();
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        echo "Response Json".json_encode($response->getResponseJSON())."\n";
        
        $record = $response->getData();
        
        echo ($record->getJobId())."\n";
        
        $created_by = $record->getCreatedBy();
        echo $created_by->getId()."\n";
        echo $created_by->getName()."\n";
       
    }
    
    public static function updateBulkWriteJob($file_id, $modulAPIName)
    {
        $writeJob = ZCRMRestClient::getInstance()->getBulkWriteInstance();
        $writeJob->setOperation("update");
        $writeJob->setCharacterEncoding("UTF-8");
        
        $callBackIns = ZCRMBulkCallBack::getInstance("https://crm.zoho.com/crm/org95/tab/Home/begin", "post");
        $writeJob->setCallback($callBackIns);
        
        $resourceIns = ZCRMBulkWriteResource::getInstance($modulAPIName, $file_id);
        $resourceIns->setFindBy("Email");
        $resourceIns->setType("data");
        $resourceIns->setIgnoreEmpty(true);
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Last_Name", 1);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Email", 2);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Company", 3);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Phone", 4);
        $resourceIns->setFieldMapping($fieldMappings);
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Contacts", 5);
        $fieldMappings->setFindBy("Email");
        $resourceIns->setFieldMapping($fieldMappings);
        
        $writeJob->setResource($resourceIns);
        
        $response = $writeJob->createBulkWriteJob();
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        echo "Response Json".json_encode($response->getResponseJSON())."\n";
        
        $record = $response->getData();
        
        echo ($record->getJobId())."\n";
        
        $created_by = $record->getCreatedBy();
        echo $created_by->getId()."\n";
        echo $created_by->getName()."\n";
        
    }
    
    public static function upsertBulkWriteJob($file_id, $modulAPIName)
    {
        $writeJob = ZCRMRestClient::getInstance()->getBulkWriteInstance();
        $writeJob->setOperation("upsert");
        $writeJob->setCharacterEncoding("UTF-8");
        
        $callBackIns = ZCRMBulkCallBack::getInstance("https://crm.zoho.com/crm/org55/tab/Home/begin", "post");
        $writeJob->setCallback($callBackIns);
        
        $resourceIns = ZCRMBulkWriteResource::getInstance($modulAPIName, $file_id);
        $resourceIns->setFindBy("Email");
        $resourceIns->setType("data");
        $resourceIns->setIgnoreEmpty(true);
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Last_Name", 1);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Email", 2);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Company", 3);
        $resourceIns->setFieldMapping($fieldMappings);
        
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Phone", 4);
        $resourceIns->setFieldMapping($fieldMappings);
        
        $fieldMappings = ZCRMBulkWriteFieldMapping::getInstance("Contacts", 5);
        $fieldMappings->setFindBy("Email");
        $resourceIns->setFieldMapping($fieldMappings);
        
        $writeJob->setResource($resourceIns);
       
        $response = $writeJob->createBulkWriteJob();
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        echo "Response Json".json_encode($response->getResponseJSON())."\n";
        
        $record = $response->getData();
        
        echo ($record->getJobId())."\n";
        
        $created_by = $record->getCreatedBy();
        echo $created_by->getId()."\n";
        echo $created_by->getName()."\n";
        
    }
    
    public static function getBulkWriteJobDetails($job_id)
    {
        $writeJob = ZCRMRestClient::getInstance()->getBulkWriteInstance(null,$job_id);
        
        $response = $writeJob->getBulkWriteJobDetails();
        
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        echo "Response Json".json_encode($response->getResponseJSON())."\n\n\n";
        
        $write = $response->getData();
        echo $write->getStatus()."\n";
        echo $write->getCharacterEncoding()."\n";
        echo $write->getJobId()."\n";
        
        $callback = $write->getCallback();
        echo $callback->getUrl()."\n";
        echo $callback->getMethod()."\n";
        
        $result = $write->getResult();
        if($result != null)
        {
            echo $result->getDownloadUrl()."\n";
        }
        
        echo $write->getCreatedBy()->getId()."\n";
        echo $write->getCreatedBy()->getName()."\n";
        
        echo $write->getOperation()."\n";
        echo $write->getCreatedTime()."\n";
        
        
        foreach($write->getResources() as $resource)
        {
            echo $resource->getStatus()."\n";
            echo $resource->getMessage()."\n";
            echo $resource->getType()."\n";
            echo $resource->getModuleAPIName()."\n";
            echo $resource->getFindBy()."\n";
            foreach($resource->getFieldMapping() as $fieldMapping)
            {
                echo $fieldMapping->getFieldAPIName()."\n";
                echo $fieldMapping->getIndex()."\n";
                echo $fieldMapping->getFindBy()."\n";
                echo $fieldMapping->getFormat()."\n";
                if($fieldMapping->getDefaultValue() != null )
                {
                    foreach($fieldMapping->getDefaultValue() as $key=>$value)
                    {
                        echo $key." : ".$value."\n";
                    }
                }
            }
            
            $file = $resource->getFileStatus();
            echo $file->getStatus()."\n";
            echo $file->getFileName()."\n";
            echo $file->getAddedCount()."\n";
            echo $file->getSkippedCount()."\n";
            echo $file->getUpdatedCount()."\n";
            echo $file->getTotalCount()."\n";
        }
       
    }

    public static function downloadBulkWriteResult($filePath, $url)
    {
        $write= ZCRMRestClient::getInstance()->getBulkWriteInstance();
        $response = $write->downloadBulkWriteResult($url);
        
        $fp = fopen($filePath.$response->getFileName(), "w"); // $filePath - absolute path where downloaded file has to be stored.
        echo "HTTP Status Code:" . $response->getHttpStatusCode();
        echo "File Name:" . $response->getFileName();
        $stream = $response->getFileContent();
        //         var_dump($stream);
        fputs($fp, $stream);
        fclose($fp);
    }
    
    public static function downloadANDGetBulkWriteRecords($moduleAPIName, $url, $jobId, $filePath)
    {
        try
        {
            $recordIns = ZCRMRestClient::getInstance()->getBulkWriteInstance(null, $jobId, $moduleAPIName);
            $fileResponse =  $recordIns->downloadANDGetRecords($filePath, $url);
            while($fileResponse->hasNext())
            {
                $record = $fileResponse->next();
                echo $record->getEntityId()."\n";
                echo $record->getFieldValue("Company")."\n";
                echo $record->getModuleAPIName()."\n";
                $owner= $record->getOwner();
                if($owner!=null){
                    echo $owner->getId()."\n";
                }
                echo $record->getStatus()."\n";
                echo $record->getErrorMessage()."\n";
                echo $record->getRecordRowNumber()."\n";
                foreach($record->getData() as $key => $value)
                {
                    echo "Key\t:".$key."\tValue:".$value."\n";
                }
//                 $fileResponse->close();
            }
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }
    
    public static function getListofGetBulkWriteRecords($moduleAPIName, $filePath, $fileName)
    {
        try
        {
            $recordIns = ZCRMRestClient::getInstance()->getBulkWriteInstance(null, null, $moduleAPIName);
            $fileResponse =  $recordIns->getRecords($filePath, $fileName);
            while($fileResponse->hasNext())
            {
                $record = $fileResponse->next();
                echo $record->getEntityId()."\n";
                echo $record->getFieldValue("Company")."\n";
                echo $record->getModuleAPIName()."\n";
                $owner= $record->getOwner();
                if($owner!=null){
                    echo $owner->getId()."\n";
                }
                echo $record->getStatus()."\n";
                echo $record->getErrorMessage()."\n";
                echo $record->getRecordRowNumber()."\n";
                foreach($record->getData() as $key => $value)
                {
                    echo "Key\t:".$key."\tValue:".$value."\n";
                }
//                 $fileResponse->close();
            }
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }
    
    public static function downloadANDGetFaildRecords($moduleAPIName, $url, $jobId, $filePath)
    {
        try
        {
            $recordIns = ZCRMRestClient::getInstance()->getBulkWriteInstance(null, $jobId, $moduleAPIName);
            $fileResponse =  $recordIns->downloadANDGetFailedRecords($filePath, $url);
            while($fileResponse->hasNext())
            {
                $record = $fileResponse->next();
                echo $record->getEntityId()."\n";
                echo $record->getFieldValue("Company")."\n";
                echo $record->getModuleAPIName()."\n";
                
                $owner= $record->getOwner();
                if($owner!=null){
                    echo $owner->getId()."\n";
                }
                echo $record->getStatus()."\n";
                echo $record->getErrorMessage()."\n";
                echo $record->getRecordRowNumber()."\n";
                foreach($record->getData() as $key => $value)
                {
                    echo "Key\t:".$key."\tValue:".$value."\n";
                }
                $fileResponse->close();
            }
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }
    
    public static function getListofGetFailedBulkWriteRecords($moduleAPIName, $filePath, $fileName)
    {
        try
        {
            $recordIns = ZCRMRestClient::getInstance()->getBulkWriteInstance(null, null, $moduleAPIName);
            $fileResponse =  $recordIns->getFailedRecords($filePath, $fileName);
            while($fileResponse->hasNext())
            {
                $record = $fileResponse->next();
                echo $record->getEntityId()."\n";
                echo $record->getFieldValue("Company")."\n";
                echo $record->getModuleAPIName()."\n";
                $owner= $record->getOwner();
                if($owner!=null)
                {
                    echo $owner->getId()."\n";
                }
                echo $record->getStatus()."\n";
                echo $record->getErrorMessage()."\n";
                echo $record->getRecordRowNumber()."\n";
                foreach($record->getData() as $key => $value)
                {
                    echo "Key\t:".$key."\tValue:".$value."\n";
                }
                $fileResponse->close();
            }
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }
    
    public static function deleteBulkWriteRecord($moduleAPIName, $url, $jobId, $filePath)
    {
        try
        {
            $recordIns = ZCRMRestClient::getInstance()->getBulkWriteInstance(null, $jobId, $moduleAPIName);
            $fileResponse =  $recordIns->downloadANDGetRecords($filePath, $url);
            while($fileResponse->hasNext())
            {
                $record = $fileResponse->next();
                echo $record->getEntityId()."\n";
                echo $record->getStatus()."\n";
                if($record->getStatus() == "ADDED" || $record->getStatus() == "UPDATED")
                {
                    $curl = curl_init();
                    
                    curl_setopt($curl, CURLOPT_URL,'https://www.zohoapis.com/crm/v2/' . $moduleAPIName . '/' .$record->getEntityId());
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.ZCRMConfigUtil::getAccessToken()));
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                    
                    $result = json_decode(curl_exec($curl));
                    var_dump($result);
                }
            }
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }

}


$obj = new RestClient();
$file_path = "/Users/Documents/PHPSDK/write";
$download_url = "https://download-accl.zoho.com/v2/crm/675/bulk-write/3477586003/3477586003.zip";
$job_id = "3477586003";
// $obj->createBulkReadJob("Leads");
// $obj->getBulkReadJobDetails("34770610001");
// $obj->downloadBulkReadResult("34770610001","/Users/Documents/PHPSDK/csvfile/");
// $obj->DownloadandGetRecords("34770610001", "/Users/Documents/PHPSDK/csvfile/read");
// $obj->GetRecordsFromFile("Leads","34770610001", "/Users/Documents/PHPSDK/csvfile/read");
// $obj->DownloadandGetRecords1("34770610001", "/Users/Documents/PHPSDK/csvfile/read");
// $obj->GetRecordsFromFile1("Events","34770610001", "/Users/Documents/PHPSDK/csvfile/read");

// $obj->uploadFile("/Users/Documents/Leads.zip");
$obj->createBulkWriteJob("3477061000","Leads");
// $obj->updateBulkWriteJob("34770595001","Leads");
// $obj->upsertBulkWriteJob("34770595001","Leads");
// $obj->getBulkWriteJobDetails($job_id);
// $obj->downloadBulkWriteResult($file_path, $download_url );
// $obj->downloadANDGetBulkWriteRecords("Leads", $download_url , $job_id, $file_path);
// $obj->getListofGetBulkWriteRecords("Leads",$file_path,"Leads-Leads");
// $obj->downloadANDGetFaildRecords("Leads", $download_url ,$job_id ,$file_path);
// $obj->getListofGetFailedBulkWriteRecords("Leads","$file_path",$job_id);
// $obj->deleteBulkWriteRecord("Leads", $download_url, $job_id, $file_path);




?>


 