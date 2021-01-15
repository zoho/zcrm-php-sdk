<?php
namespace zcrmsdk\crm\api\handler;

use zcrmsdk\crm\api\APIRequest;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMTrashRecord;
use zcrmsdk\crm\exception\APIExceptionHandler;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\utility\APIConstants;

class massentityapihandler extends apihandler
{

    private $module = null;

    public function __construct($moduleinstance)
    {
        $this->module = $moduleinstance;
    }

    public static function getinstance($moduleinstance)
    {
        return new massentityapihandler($moduleinstance);
    }

    public function createrecords($records, $trigger,$lar_id,$process)
    {
        if (sizeof($records) > 100) {
            throw new zcrmexception(apiconstants::API_MAX_RECORDS_MSG, apiconstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlpath = $this->module->getapiname();
            $this->requestmethod = apiconstants::REQUEST_METHOD_POST;
            $this->addheader("content-type", "application/json");
            $requestbodyobj = array();
            $dataarray = array();
            foreach ($records as $record) {
                if ($record->getentityid() == null) {
                    array_push($dataarray, entityapihandler::getinstance($record)->getzcrmrecordasjson());
                } else {
                    throw new zcrmexception("entity id must be null for create operation.", apiconstants::RESPONSECODE_BAD_REQUEST);
                }
            }
            $requestbodyobj["data"] = $dataarray;
            if ($trigger !== null && is_array($trigger)) {
                $requestbodyobj["trigger"] = $trigger;
            }
            if ($lar_id !== null) {
                $requestbodyobj["lar_id"] = $lar_id;
            }
            if($process !== null && is_array($process) ){
                $requestbodyobj["process"] =$process;
            }

            $this->requestbody = $requestbodyobj;

            // fire request
            $bulkapiresponse = apirequest::getinstance($this)->getbulkapiresponse();
            $createdrecords = array();
            $responses = $bulkapiresponse->getentityresponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityresins = $responses[$i];
                if (apiconstants::status_success === $entityresins->getstatus()) {
                    $responsedata = $entityresins->getresponsejson();
                    $recorddetails = $responsedata["details"];
                    $newrecord = $records[$i];
                    entityapihandler::getinstance($newrecord)->setrecordproperties($recorddetails);
                    array_push($createdrecords, $newrecord);
                    $entityresins->setdata($newrecord);
                } else {
                    $entityresins->setdata(null);
                }
            }
            $bulkapiresponse->setdata($createdrecords);
            return $bulkapiresponse;
        } catch (zcrmexception $e) {
            throw $e;
        }
    }

    public function upsertrecords($records, $trigger,$lar_id,$duplicate_check_fields,$process)
    {
        if (sizeof($records) > 100) {
            throw new zcrmexception(apiconstants::API_MAX_RECORDS_MSG, apiconstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlpath = $this->module->getapiname() . "/upsert";
            $this->requestmethod = apiconstants::REQUEST_METHOD_POST;
            $this->addheader("content-type", "application/json");
            if($duplicate_check_fields!=null)
                $this->addparam("duplicate_check_fields", implode(",", $duplicate_check_fields)); // converts array to string with specified seperator
            $requestbodyobj = array();
            $dataarray = array();
            foreach ($records as $record)
            {
                $recordjson=entityapihandler::getinstance($record)->getzcrmrecordasjson();
                if($record->getentityid()!=null)
                {
                    $recordjson['id']=$record->getentityid();
                }
                array_push($dataarray,$recordjson);
            }
            $requestbodyobj["data"] = $dataarray;
            if ($trigger !== null && is_array($trigger)) {
                $requestbodyobj["trigger"] = $trigger;
            }
            if ($lar_id !== null) {
                $requestbodyobj["lar_id"] = $lar_id;
            }
            if($process !== null && is_array($process) ){
                $requestbodyobj["process"] =$process;
            }
            $this->requestbody = $requestbodyobj;

            // fire request
            $bulkapiresponse = apirequest::getinstance($this)->getbulkapiresponse();
            $upsertrecords = array();
            $responses = $bulkapiresponse->getentityresponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityresins = $responses[$i];
                if (apiconstants::STATUS_SUCCESS === $entityresins->getstatus()) {
                    $responsedata = $entityresins->getresponsejson();
                    $recorddetails = $responsedata["details"];
                    $newrecord = $records[$i];
                    entityapihandler::getinstance($newrecord)->setrecordproperties($recorddetails);
                    array_push($upsertrecords, $newrecord);
                    $entityresins->setdata($newrecord);
                } else {
                    $entityresins->setdata(null);
                }
            }
            $bulkapiresponse->setdata($upsertrecords);
            return $bulkapiresponse;
        } catch (zcrmexception $e) {
            throw $e;
        }
    }

    public function updaterecords($records, $trigger,$process)
    {
        if (sizeof($records) > 100) {
            throw new zcrmexception(apiconstants::API_MAX_RECORDS_MSG, apiconstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlpath = $this->module->getapiname();
            $this->requestmethod = apiconstants::REQUEST_METHOD_PUT;
            $this->addheader("content-type", "application/json");
            $requestbodyobj = array();
            $dataarray = array();
            foreach ($records as $record) {
                $recordjson = entityapihandler::getinstance($record)->getzcrmrecordasjson();
                if ($record->getentityid() != null) {
                    $recordjson['id'] = $record->getentityid();
                }
                array_push($dataarray, $recordjson);
            }
            $requestbodyobj["data"] = $dataarray;
            if ($trigger !== null && is_array($trigger)) {
                $requestbodyobj["trigger"] = $trigger;
            }
            if($process !== null && is_array($process) ){
                $requestbodyobj["process"] =$process;
            }

            $this->requestbody = $requestbodyobj;

            // fire request
            $bulkapiresponse = apirequest::getinstance($this)->getbulkapiresponse();
            $upsertrecords = array();
            $responses = $bulkapiresponse->getentityresponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityresins = $responses[$i];
                if (apiconstants::STATUS_SUCCESS === $entityresins->getstatus()) {
                    $responsedata = $entityresins->getresponsejson();
                    $recorddetails = $responsedata["details"];
                    $newrecord = $records[$i];
                    entityapihandler::getinstance($newrecord)->setrecordproperties($recorddetails);
                    array_push($upsertrecords, $newrecord);
                    $entityresins->setdata($newrecord);
                } else {
                    $entityresins->setdata(null);
                }
            }
            $bulkapiresponse->setdata($upsertrecords);
            return $bulkapiresponse;
        } catch (zcrmexception $e) {
            throw $e;
        }
    }

    public function deleterecords($entityids)
    {
        if (sizeof($entityids) > 100) {
            throw new zcrmexception(apiconstants::API_MAX_RECORDS_MSG, apiconstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $this->urlpath = $this->module->getapiname();
            $this->requestmethod = apiconstants::REQUEST_METHOD_DELETE;
            $this->addheader("content-type", "application/json");
            $this->addparam("ids", implode(",", $entityids)); // converts array to string with specified seperator

            // fire request
            $bulkapiresponse = apirequest::getinstance($this)->getbulkapiresponse();
            $responses = $bulkapiresponse->getentityresponses();

            foreach ($responses as $entityresins) {
                $responsedata = $entityresins->getresponsejson();
                $responsejson = $responsedata["details"];
                $record = zcrmrecord::getinstance($this->module->getapiname(), $responsejson["id"]);
                $entityresins->setdata($record);
            }
            return $bulkapiresponse;
        } catch (zcrmexception $exception) {
            apiexceptionhandler::logexception($exception);
            throw $exception;
        }
    }

    public function getalldeletedrecords($param_map,$header_map)
    {
        return self::getdeletedrecords($param_map,$header_map,"all");
    }

    public function getrecyclebinrecords($param_map,$header_map)
    {
        return self::getdeletedrecords($param_map,$header_map,"recycle");
    }

    public function getpermanentlydeletedrecords($param_map,$header_map)
    {
        return self::getdeletedrecords($param_map,$header_map,"permanent");
    }

    private function getdeletedrecords($param_map,$header_map,$type)
    {
        try {
            $this->urlpath = $this->module->getapiname() . "/deleted";
            $this->requestmethod = apiconstants::REQUEST_METHOD_GET;
            foreach($param_map as $key=>$value){
                if($value!=null)$this->addparam($key,$value);
            }
            foreach($header_map as $key=>$value){
                if($value!=null)$this->addheader($key,$value);
            }
            $this->addheader("content-type", "application/json");
            $this->addparam("type", $type);
            $responseinstance = apirequest::getinstance($this)->getbulkapiresponse();
            $responsejson = $responseinstance->getresponsejson();
            $trashrecords = $responsejson["data"];
            $trashrecordlist = array();
            foreach ($trashrecords as $trashrecord) {
                $trashrecordinstance = zcrmtrashrecord::getinstance($trashrecord['type'], $trashrecord['id']);
                self::settrashrecordproperties($trashrecordinstance, $trashrecord);
                array_push($trashrecordlist, $trashrecordinstance);
            }

            $responseinstance->setdata($trashrecordlist);

            return $responseinstance;
        } catch (zcrmexception $exception) {
            apiexceptionhandler::logexception($exception);
            throw $exception;
        }
    }

    public function settrashrecordproperties($trashrecordinstance, $recordproperties)
    {
        if ($recordproperties['display_name'] != null) {
            $trashrecordinstance->setdisplayname($recordproperties['display_name']);
        }
        if ($recordproperties['created_by'] != null) {
            $createdby = $recordproperties['created_by'];
            $createdby_user = zcrmuser::getinstance($createdby['id'], $createdby['name']);
            $trashrecordinstance->setcreatedby($createdby_user);
        }
        if ($recordproperties['deleted_by'] != null) {
            $deletedby = $recordproperties['deleted_by'];
            $deletedby_user = zcrmuser::getinstance($deletedby['id'], $deletedby['name']);
            $trashrecordinstance->setdeletedby($deletedby_user);
        }
        $trashrecordinstance->setdeletedtime($recordproperties['deleted_time']);
    }

    public function getrecords($param_map,$header_map)
    {
        try {
            $this->urlpath = $this->module->getapiname();
            $this->requestmethod = apiconstants::REQUEST_METHOD_GET;
            foreach ($param_map as $key => $value) {
                if($value!==null)$this->addparam($key, $value);
            }
            foreach ($header_map as $key => $value) {
                if($value!==null)$this->addheader($key, $value);
            }
            $this->addheader("content-type", "application/json");
            $responseinstance = apirequest::getinstance($this)->getbulkapiresponse();
            $responsejson = $responseinstance->getresponsejson();
            $records = $responsejson["data"];
            $recordslist = array();
            foreach ($records as $record) {
                $recordinstance = zcrmrecord::getinstance($this->module->getapiname(), $record["id"]);
                entityapihandler::getinstance($recordinstance)->setrecordproperties($record);
                array_push($recordslist, $recordinstance);
            }

            $responseinstance->setdata($recordslist);

            return $responseinstance;
        } catch (zcrmexception $exception) {
            apiexceptionhandler::logexception($exception);
            throw $exception;
        }
    }

    public function searchrecords($param_map,$type,$search_value)
    {
        try {
            $this->urlpath = $this->module->getapiname() . "/search";
            $this->requestmethod = apiconstants::REQUEST_METHOD_GET;
            $exclusion_array = ["word","phone","email","criteria"];
            foreach($exclusion_array as $exclusion){
                if(array_key_exists($exclusion, $param_map)){
                    unset($param_map[$exclusion]);
                }
            }
            foreach ($param_map as $key => $value) {
                if($value!==null)$this->addparam($key, $value);
            }
            $this->addparam($type, $search_value);
            $this->addheader("content-type", "application/json");
            $responseinstance = apirequest::getinstance($this)->getbulkapiresponse();
            $responsejson = $responseinstance->getresponsejson();
            $records = $responsejson["data"];
            $recordslist = array();
            foreach ($records as $record) {
                $recordinstance = zcrmrecord::getinstance($this->module->getapiname(), $record["id"]);
                entityapihandler::getinstance($recordinstance)->setrecordproperties($record);
                array_push($recordslist, $recordinstance);
            }

            $responseinstance->setdata($recordslist);

            return $responseinstance;
        } catch (zcrmexception $exception) {
            apiexceptionhandler::logexception($exception);
            throw $exception;
        }
    }

    public function massupdaterecords($idlist, $apiname, $value)
    {
        if (sizeof($idlist) > 100) {
            throw new zcrmexception(apiconstants::API_MAX_RECORDS_MSG, apiconstants::RESPONSECODE_BAD_REQUEST);
        }
        try {
            $inputjson = self::constructjsonformassupdate($idlist, $apiname, $value);
            $this->urlpath = $this->module->getapiname();
            $this->requestmethod = apiconstants::REQUEST_METHOD_PUT;
            $this->addheader("content-type", "application/json");
            $this->requestbody = $inputjson;
            $this->apikey = 'data';
            $bulkapiresponse = apirequest::getinstance($this)->getbulkapiresponse();

            $updatedrecords = array();
            $responses = $bulkapiresponse->getentityresponses();
            $size = sizeof($responses);
            for ($i = 0; $i < $size; $i ++) {
                $entityresins = $responses[$i];
                if (apiconstants::STATUS_SUCCESS === $entityresins->getstatus()) {
                    $responsedata = $entityresins->getresponsejson();
                    $recordjson = $responsedata["details"];

                    $updatedrecord = zcrmrecord::getinstance($this->module->getapiname(), $recordjson["id"]);
                    entityapihandler::getinstance($updatedrecord)->setrecordproperties($recordjson);
                    array_push($updatedrecords, $updatedrecord);
                    $entityresins->setdata($updatedrecord);
                } else {
                    $entityresins->setdata(null);
                }
            }
            $bulkapiresponse->setdata($updatedrecords);

            return $bulkapiresponse;
        } catch (zcrmexception $exception) {
            apiexceptionhandler::logexception($exception);
            throw $exception;
        }
    }

    public function constructjsonformassupdate($idlist, $apiname, $value)
    {
        $massupdatearray = array();
        foreach ($idlist as $id) {
            $updatejson = array();
            $updatejson["id"] = "" . $id;
            $updatejson[$apiname] = $value;
            array_push($massupdatearray, $updatejson);
        }

        return array(
            "data" => $massupdatearray
        );
    }
}
