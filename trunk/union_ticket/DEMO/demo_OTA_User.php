<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/OTA_UserUniqueID.php'); //加载D_HotelSearch这个接口的封装类

//构造请求
$OTA_User = new get_OTA_UserUniqueID();
$OTA_User->UID = "wwwwww";
$returnXML = $OTA_User->getUniqueUID();
echo $returnXML;
?>