<?php

/**
 *
 * 获取指定用户名对应的携程UserUniqueID
 * @author cltang
 *
 */
class get_OTA_UserUniqueID
{
    /**
     * 外部用户的用户名，必须填写
     */
    var $UID = "";
    /**
     *返回体
     */
    var $ResponseXML = "";

    /**
     * 构造请求体
     */
    private function getRequestXML()
    {
        /*
         * 从config.php中获取系统的联盟信息(只读)
         */
        $AllianceID = Allianceid;
        $SID = Sid;
        $KEYS = SiteKey;
        $RequestType = "OTA_UserUniqueID";
        //构造权限头部
        $headerRight = getRightString($AllianceID, $SID, $KEYS, $RequestType);
        $UIDs = "";
        if ($this->UID != "") {
            $UIDs = <<<BEGIN
<UidKey>$this->UID</UidKey>
BEGIN;
        }
        $paravalues = <<<BEGIN
<?xml version="1.0"?>
<Request>
<Header $headerRight/>
<UserRequest>$UIDs<AllianceID>$AllianceID</AllianceID><SID>$SID</SID></UserRequest>
</Request>
BEGIN;
        return $paravalues;
    }

    /**
     *
     * 调用直接查询用户携程UserUniqueID的接口
     */
    function main()
    {
        try {
            $requestXML = $this->getRequestXML();
            //echo $requestXML;
            $commonRequestDo = new commonRequest(); //常用数据请求
            $commonRequestDo->requestURL = OTA_UserUniqueID_Url;
            $commonRequestDo->requestXML = $requestXML;
            $commonRequestDo->requestType = System_RequestType; //取config中的配置
            $commonRequestDo->doRequest();
            // $returnXML=$commonRequestDo->responseXML;
            //echo json_encode($commonRequestDo->responseXML);
            $this->ResponseXML = getXMLFromReturnString($commonRequestDo->responseXML);
        } catch (Exception $e) {
            $this->ResponseXML = null;
        }
    }

    /**
     *
     * 获取用户的UserUniqueID
     * @param unknown_type $returnCommentXML
     */
    function getUniqueUID()
    {
        $this->main();
        $ResponseXML = $this->ResponseXML;
        $coutw = null;
        if ($ResponseXML != null) {
            $coutw = $ResponseXML->UserResponse->UniqueUID;
        }
        return $coutw;
    }
}