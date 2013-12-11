<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/D_HotelOrderList.php');//加载D_HotelOrderList这个接口的封装类
include_once (ABSPATH.'sdk/API/Hotel/OTA_UserUniqueID.php');//加载OTA_UserUniqueID这个接口的封装类

//获取到当前的联盟用户的用户ID对应的携程UID
$OTA_User=new get_OTA_UserUniqueID();
$OTA_User->UID=Allianceid_Uid;//在config.php中定义
$returnUID=$OTA_User->getUniqueUID();
//echo $returnUID;
//构造请求
$D_hotelOrderList=new get_D_HotelOrderList();
$D_hotelOrderList->CheckInDate="2012-06-10";
$D_hotelOrderList->CheckInName="";//陈海睿
$D_hotelOrderList->CheckOutDate="2012-08-11";
$D_hotelOrderList->OrderIDs="";//100069972,100069974,100069984";
$D_hotelOrderList->OrderRange=0;
$D_hotelOrderList->OrderStatus=0;
$D_hotelOrderList->Reservation=0;
$D_hotelOrderList->UserID=$returnUID;
$D_hotelOrderList->UserIP=GetIP();
$D_hotelOrderList->main();
$returnXML=$D_hotelOrderList->ResponseXML;

//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
$i=1;
$returnXMLDataForList=$returnXML ->DomesticHotelOrderListForList->OrderDetailList;
if($returnXMLDataForList!=null){
foreach($returnXMLDataForList->DomesticHotelOrderDetailForList as $v)
{
  echo "<a href='demo_D_hotelOrderDetail.php?orderid=$v->OrderId' target='_self'>OrderId:".$v->OrderId."</a>&nbsp;&nbsp;入住人:".$v->ClientName."&nbsp;&nbsp;".$v->CityName."&nbsp;&nbsp;酒店名称:".$v->HotelName.$v->PriceShowInfo.$v->OrderStatus."&nbsp;&nbsp;<a href='demo_OTA_Cancel.php?orderid=$v->OrderId' target='_blank'>取消该订单</a>";
  echo "<br/>......................................................................................................<br/>";
}
}
?>