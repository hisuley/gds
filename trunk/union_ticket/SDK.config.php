<?php
error_reporting(1);
//定义本系统的相对路径根部
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}
$isSiteConfigPHP = false;
if ($isSiteConfigPHP) {
} else {
//预置的联盟信息，如果site.config.php中没有配置联盟信息，则用默认的（PHPSDK预置有联盟信息）
//定义分销联盟的AID
    if (!defined('Allianceid')) {
        define('Allianceid', '8257');
    }
//定义分销联盟的SID
    if (!defined('Sid')) {
        define('Sid', '178016');
    }
//定义分销联盟的key
    if (!defined('SiteKey')) {
        define('SiteKey', 'C9644F2F-1B13-4BED-8871-963E6195D592'); //abcDFG645354
    }

//预置的联盟信息，如果site.config.php中没有配置联盟信息，则用默认的（PHPSDK预置有联盟信息）
}
$ServiceUrlCtripOpenAPI = "http://openapi.ctrip.com";

//定义获取“检查并生成外部UserUniqueID”的URL
if (!defined('OTA_UserUniqueID_Url')) {
    define('OTA_UserUniqueID_Url', $ServiceUrlCtripOpenAPI . '/hotel/OTA_UserUniqueID.asmx');
}

//定义获取订单取消的URL
if (!defined('OTA_OrderCancel_Url')) {
    define('OTA_OrderCancel_Url', $ServiceUrlCtripOpenAPI . '/hotel/OTA_Cancel.asmx');
}

//定义国内机票查询接口的URL
if (!defined('OTA_FlightSearch_Url')) {
    define('OTA_FlightSearch_Url', $ServiceUrlCtripOpenAPI . '/Flight/DomesticFlight/OTA_FlightSearch.asmx');
}
//定义测试接口地址
if (!defined('OTA_Ping_Url')) {
    define('OTA_Ping_Url', $ServiceUrlCtripOpenAPI . '/Hotel/OTA_Ping.asmx');
}


//定义本系统的对于API2.0采用的请求模式：httpRequest/soap(如果PHP的服务器上没有开启支持SOAP的功能，则用httpRequest)
if (!defined('System_RequestType')) {
    define('System_RequestType', 'httpRequest'); //soap  httpRequest
}

//添加分销权限控制类
include_once(ABSPATH . 'Common/rightControl.php');
//添加请求控制类（http请求还是soap请求）
include_once(ABSPATH . 'Common/commonRequestData.php');
//工具类
include_once(ABSPATH . 'Common/toolExt.php');
//http请求模式类
include_once(ABSPATH . 'Common/httpRequestData.php');
//soap请求模式类
include_once(ABSPATH . 'Common/soapData.php');
//http请求的类
include_once(ABSPATH . 'Common/HttpRequest.php');
//工具类
include_once(ABSPATH . 'Common/getDate.php');
//解析酒店API2.0返回的字符串为XML
include_once(ABSPATH . 'Common/RequestDomXml.php');
?>