<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Ticket/D_FlightSearch.php'); //加载D_HotelSearch这个接口的封装类
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//构造请求
$ticket = new get_D_FlightSearch();
$requestXML = $ticket->main();
$returnXML = $ticket->ResponseXML; //返回的数据是一个XML

//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
foreach ($returnXML->FlightSearchResponse->FlightRoutes->DomesticFlightRoute->FlightsList->DomesticFlightData as $value) {
    print_r($value);
}
print_r($returnXML);
print_r($returnXML->FlightSearchResponse->FlightRoutes->DomesticFlightRoute->FlightsList->DomesticFlightData);
print_r((string)$returnXML->FlightSearchResponse->FlightRoutes->DomesticFlightRoute->FlightsList->DomesticFlightData->DepartCityCode);
?>