<?php
use zcrmsdk\crm\crud\ZCRMTag;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class TAGAPI
{
    public function __construct()
    {
        $configuration = [];
        ZCRMRestClient::initialize($configuration);
    }
    public static function getTags()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $tags = $moduleIns->getTags()->getData(); // to get the trashrecords inform of ZCRMTag array instances
        foreach($tags as $tag)
        {
            echo $tag->getCreatedTime()."\n";
            echo $tag->getModifiedTime()."\n";
            echo $tag->getName()."\n";
            if( $tag->getModifiedBy())
            {
                $user= $tag->getModifiedBy();
                echo $user->getId()."\n";
                echo $user->getName()."\n";
            }
            echo $tag->getId()."\n";
            if( $tag->getCreatedBy())
            {
                $user = $tag->getCreatedBy();
                echo $user->getId()."\n";
                echo $user->getName()."\n";
            }
        }
    }
    public function getTagCount()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the instance of the module
        $tag_count = $moduleIns->getTagCount("34740001");//34740001 tag id
        $tag = $tag_count->getData();
        echo $tag->getCount(); // to get the tag count
    }
    
    public function createTags()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $tags = array(); // to create ZCRMTag instances array
        $tag = ZCRMTag::getInstance(); // to get the tag instance
        $tag->setName("TagName3"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $tag = ZCRMTag::getInstance(); // to get the tag instance
        $tag->setName("TagName4"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $response = $moduleIns->createTags($tags); // to create the tags
        foreach ($response->getEntityResponses() as $responseIns)
        {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode()."\n"; // To get http response code
            echo "Status:" . $responseIns->getStatus()."\n"; // To get response status
            echo "Message:" . $responseIns->getMessage()."\n"; // To get response message
            echo "Code:" . $responseIns->getCode()."\n"; // To get status code
            echo "Details:" . json_encode($responseIns->getDetails())."\n";
            $tag = $responseIns->getData();
            echo $tag->getCreatedTime()."\n";
            echo $tag->getModifiedTime()."\n";
            echo $tag->getName()."\n";
            if( $tag->getModifiedBy())
            {
                $user= $tag->getModifiedBy();
                echo $user->getId()."\n";
                echo $user->getName()."\n";
            }
            echo $tag->getId()."\n";
            if( $tag->getCreatedBy())
            {
                $user = $tag->getCreatedBy();
                echo $user->getId()."\n";
                echo $user->getName()."\n";
            }
        }
    }
    
    public function updateTags()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $tags = array(); // to create ZCRMTag instances array
        $tag = ZCRMTag::getInstance("34770626005"); // to get the tag instance
        $tag->setName("testnew"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $tag = ZCRMTag::getInstance("34770006"); // to get the tag instance
        $tag->setName("testnew2"); // to set the tag name
        array_push($tags, $tag); // to push the tag to array of ZCRMTag instances
        $response = $moduleIns->updateTags($tags); // to update the tags
        foreach ($response->getEntityResponses() as $responseIns)
        {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode()."\n"; // To get http response code
            echo "Status:" . $responseIns->getStatus()."\n"; // To get response status
            echo "Message:" . $responseIns->getMessage()."\n"; // To get response message
            echo "Code:" . $responseIns->getCode()."\n"; // To get status code
            echo "Details:" . json_encode($responseIns->getDetails())."\n";
            $tag = $responseIns->getData();
            echo $tag->getCreatedTime()."\n";
            echo $tag->getModifiedTime()."\n";
            echo $tag->getName()."\n";
            if( $tag->getModifiedBy())
            {
                $user= $tag->getModifiedBy();
                echo $user->getId()."\n";
                echo $user->getName()."\n";
            }
            echo $tag->getId()."\n";
            if( $tag->getCreatedBy())
            {
                $user = $tag->getCreatedBy();
                echo $user->getId()."\n";
                echo $user->getName()."\n";
            }
        }
    }
    
    public function addTagsToRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $recordids = array(
            "3477501063",
            "3477001062",
            "3477061"
        ); // array of record ids from which tags must be added
        $tagnames = array(
            "tea123",
            "test32",
            "test34"
        ); // array of tags to be added
        $response = $moduleIns->addTagsToRecords($recordids, $tagnames); // to add the tags to the record
        foreach ($response->getEntityResponses() as $responseIns)
        {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode()."\n"; // To get http response code
            echo "Status:" . $responseIns->getStatus()."\n"; // To get response status
            echo "Message:" . $responseIns->getMessage()."\n"; // To get response message
            echo "Code:" . $responseIns->getCode()."\n"; // To get status code
            echo "Details:" . json_encode($responseIns->getDetails())."\n";
            $record = $responseIns->getData();
            echo $record->getEntityId()."\n";
            print_r($record->getTagNames());
        }
    }
    
    public function removeTagsFromRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("{module_api_name}"); // to get the module instance
        $recordids = array(
            "34770501063",
            "34770601062"
        ); // array of record ids from which tags must be removed
        $tagnames = array(
            "test32",
            "tea123"
        ); // array of tags to be removed
        $response = $moduleIns->removeTagsFromRecords($recordids, $tagnames); // to remove the tags from the records
        foreach ($response->getEntityResponses() as $responseIns)
        {
            echo "HTTP Status Code:" . $responseIns->getHttpStatusCode()."\n"; // To get http response code
            echo "Status:" . $responseIns->getStatus()."\n"; // To get response status
            echo "Message:" . $responseIns->getMessage()."\n"; // To get response message
            echo "Code:" . $responseIns->getCode()."\n"; // To get status code
            echo "Details:" . json_encode($responseIns->getDetails())."\n";
            $record = $responseIns->getData();
            echo $record->getEntityId()."\n";
            print_r($record->getTagNames());
        }
    }
    
    public function addTags()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("{module_api_name}", "3402501063"); // To get record instance
        $tagNames = array(
            "test1",
            "test2"
        ); // to create array of tag names
        $response = $record->addTags($tagNames); // to add tags
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        $record = $response->getData();
        echo $record->getEntityId()."\n";
        print_r($record->getTagNames());
    }
    
    
    public function removeTags()
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Leads", "347702501063"); // To get record instance
        $tagNames = array(
            "test1",
            "test2"
        ); // to create array of tag names
        $response = $record->removeTags($tagNames); // to remove tags
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        $record = $response->getData();
        echo $record->getEntityId()."\n";
        print_r($record->getTagNames());
    }
    
    public function delete()
    {
        $tagIns = ZCRMTag::getInstance("3477060331001"); // To get tag instance
        $response = $tagIns->delete(); // to delete the tags
        echo "Data:".$response->getData()."\n";
        echo "Message".$response->getMessage()."\n";
        echo "Status".$response->getStatus()."\n";
        echo "HTTP".$response->getHttpStatusCode()."\n";
        print_r($response->getResponseJSON())."\n";
    }
    
    public  function merge()
    {
        $tagmerge = ZCRMTag::getInstance("34770335002");
        $tag= ZCRMTag::getInstance("347700335001");
        $response = $tag->merge($tagmerge);
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        $tag = $response->getData();
        echo $tag->getCreatedTime()."\n";
        echo $tag->getModifiedTime()."\n";
        if( $tag->getModifiedBy())
        {
            $user= $tag->getModifiedBy();
            echo $user->getId()."\n";
            echo $user->getName()."\n";
        }
        echo $tag->getId()."\n";
        if( $tag->getCreatedBy())
        {
            $user = $tag->getCreatedBy();
            echo $user->getId()."\n";
            echo $user->getName()."\n";
        }
    }
    
    public function updateTag()
    {
        $tag = ZCRMTag::getInstance("3470335001", "test1"); // to get the tag instance
        $tag->setModuleApiName("Leads"); // to set the tag name
        $response = $tag->update(); // to update the tags
        echo "HTTP Status Code:" . $response->getHttpStatusCode()."\n"; // To get http response code
        echo "Status:" . $response->getStatus()."\n"; // To get response status
        echo "Message:" . $response->getMessage()."\n"; // To get response message
        echo "Code:" . $response->getCode()."\n"; // To get status code
        echo "Details:" . json_encode($response->getDetails())."\n";
        $tag = $response->getData();
        echo $tag->getCreatedTime()."\n";
        echo $tag->getModifiedTime()."\n";
        echo $tag->getName()."\n";
        if( $tag->getModifiedBy())
        {
            $user= $tag->getModifiedBy();
            echo $user->getId()."\n";
            echo $user->getName()."\n";
        }
        echo $tag->getId()."\n";
        if( $tag->getCreatedBy())
        {
            $user = $tag->getCreatedBy();
            echo $user->getId()."\n";
            echo $user->getName()."\n";
        }
    }
}
$obj = new TAGAPI();
$obj->getTags();
// $obj->getTagCount();
// $obj->createTags();
// $obj->updateTags();
// $obj->addTagsToRecords();
// $obj->removeTagsFromRecords();
// $obj->addTags();
// $obj->removeTags();
// $obj->delete();
// $obj->merge();
// $obj->updateTag();
