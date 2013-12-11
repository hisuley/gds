<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/OTA_Cancel.php');//加载OTA_Cancel这个接口的封装类
include_once (ABSPATH.'sdk/API/Hotel/OTA_UserUniqueID.php');//加载OTA_UserUniqueID这个接口的封装类

//获取到当前的联盟用户的用户ID对应的携程UID
$OTA_User=new get_OTA_UserUniqueID();
$OTA_User->UID=Allianceid_Uid;//在config.php中定义
$returnUID=$OTA_User->getUniqueUID();
//构造请求
$OTA_Cancel=new set_OTA_OrderCancel();
$OTA_Cancel->OrderId=$_GET["orderid"];
$OTA_Cancel->ReasonText="不想要了";
$OTA_Cancel->UID=$returnUID;
$OTA_Cancel->main();
$returnXML=$OTA_Cancel->ResponseXML;
echo json_encode($returnXML);
?>