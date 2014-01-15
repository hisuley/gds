<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
//酒店可订性检查接口
include_once(ABSPATH . 'sdk/API/Hotel/OTA_HotelAvail.php'); //加载OTA_HotelAvail这个接口的封装类
//构造请求
$OTA_HotelAvail = new set_OTA_HotelAvail();
$OTA_HotelAvail->GuestCount = '2';
$OTA_HotelAvail->IsPerRoom = "true";
$OTA_HotelAvail->RoomCount = '2';
$OTA_HotelAvail->LastCheckInTime = getDateYMD_addDay('-', '3') . "T00:00:00.000+08:00";
$OTA_HotelAvail->CheckOutTime = getDateYMD_addDay('-', '7') . "T00:00:00.000+08:00";
$OTA_HotelAvail->CheckInTime = getDateYMD_addDay('-', '3') . "T00:00:00.000+08:00";
$OTA_HotelAvail->HotelRoomCode = '30405';
$OTA_HotelAvail->HotelCode = "22108";
$OTA_HotelAvail->main();

$returnXML = $OTA_HotelAvail->ResponseXML;

print_r($returnXML);


?>