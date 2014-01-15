<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelOrderDetail.php'); //加载D_HotelOrderDetail这个接口的封装类
include_once(ABSPATH . 'sdk/API/Hotel/OTA_UserUniqueID.php'); //加载OTA_UserUniqueID这个接口的封装类

//获取到当前的联盟用户的用户ID对应的携程UID
$OTA_User = new get_OTA_UserUniqueID();
$OTA_User->UID = Allianceid_Uid; //在config.php中定义
$returnUID = $OTA_User->getUniqueUID();
//构造请求
$D_hotelOrderDetail = new get_D_HotelOrderDetail();
$D_hotelOrderDetail->OrderID = $_GET["orderid"];
$D_hotelOrderDetail->UserID = $returnUID;
$D_hotelOrderDetail->UserIP = GetIP();
$D_hotelOrderDetail->main();
$returnXML = $D_hotelOrderDetail->ResponseXML;


//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
$i = 1;
$v = $returnXML->DomesticHotelOrderDetail;
if ($v != null) {
    echo "OrderId:" . $v->OrderId . "&nbsp;&nbsp;入住人:" . $v->ClientName . "&nbsp;&nbsp;" . $v->CityName . "&nbsp;&nbsp;酒店名称:" . $v->HotelName . $v->PriceShowInfo . $v->OrderStatus;
    echo "<br/>酒店名称：" . $v->RoomName;
    echo "&nbsp;&nbsp;<a href='demo_OTA_Cancel.php?orderid=$v->OrderId' target='_blank'>取消该订单</a>";
}

?>