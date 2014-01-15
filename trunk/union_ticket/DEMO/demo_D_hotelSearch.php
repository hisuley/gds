<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelSearch.php'); //加载D_HotelSearch这个接口的封装类
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//构造请求
$D_HotelSearch = new get_D_HotelSearch();
$D_HotelSearch->CheckInDate = getDateYMD('-'); //获取今天
$D_HotelSearch->CheckOutDate = getDateYMD_addDay('-', TuanEndDate_Distance); //"2012-08-04";
$D_HotelSearch->CityID = 2;
$D_HotelSearch->PageNumber = 1;
$D_HotelSearch->PageSize = 10;
$D_HotelSearch->main();
$returnXML = $D_HotelSearch->ResponseXML; //返回的数据是一个XML
//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
echo "符合条件的酒店总数为：" . $D_HotelSearch->ResponseXML->DomesticHotelList->TotalItems . "<br/>";
$i = 1;
$returnXMLDataForList = $returnXML->DomesticHotelList->HotelDataList;
if ($returnXMLDataForList != null) {
    foreach ($returnXMLDataForList->DomesticHotelDataForList as $v) {
        $hotelurl = "demo_D_hotelDetail.php?HotelID=" . $v->HotelID . "&CityID=2&CheckInDate=" . $D_HotelSearch->CheckInDate . "&CheckOutDate=" . $D_HotelSearch->CheckOutDate;
        $hotelurl = getNewUrl($hotelurl); //做伪静态
        echo "第&nbsp;&nbsp;" . $i . "&nbsp;&nbsp;家酒店名称：" . $v->HotelName . "&nbsp;&nbsp;<a href='$hotelurl' target='_self'>查看详情</a><br/>";
        $i = $i + 1;
    }
}
?>