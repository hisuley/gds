<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelHotSale.php'); //加载D_HotelHotSale封装类-带有分页
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//构造请求
$D_HotelHotSale = new get_D_HotelHotSale();

$cityID = $_GET['city'];
$cityArr = explode(",", $cityID);
$D_HotelHotSale->City = $cityArr[0];
$D_HotelHotSale->SumType = 'D';
$D_HotelHotSale->ProcessDate = getDateYMD('-');
$D_HotelHotSale->SearchNumber = '10';

$D_HotelHotSale->main();
$returnCommentXML = $D_HotelHotSale->ResponseXML; //返回的数据是一个XML

if (!empty($returnCommentXML->SearchHotSaleHotelResponse->SearchHotSaleHotelList->SearchHotSaleHotel)) {
    foreach ($returnCommentXML->SearchHotSaleHotelResponse->SearchHotSaleHotelList->SearchHotSaleHotel as $v) {
        $hotelId = $v->HotelID;
        $HotelList = $HotelList ? $HotelList . "," . $hotelId : $hotelId;
    }
}

//构造请求
$D_HotelSearch = new get_D_HotelSearch();
$D_HotelSearch->CheckInDate = getDateYMD('-'); //获取今天
$D_HotelSearch->CheckOutDate = getDateYMD_addDay('-', TuanEndDate_Distance); //"2012-08-04";
$D_HotelSearch->CityID = $cityArr['0'];
$D_HotelSearch->HotelList = $HotelList;
$D_HotelSearch->PageSize = "10";
$D_HotelSearch->main();
$returnXML = $D_HotelSearch->ResponseXML; //返回的数据是一个XML
//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
$i = 1;
$returnXMLDataForList = $returnXML->DomesticHotelList->HotelDataList;
if ($returnXMLDataForList != null) {
    echo "今日热卖酒店" . "<br>";
    foreach ($returnXMLDataForList->DomesticHotelDataForList as $v) {
        $hotelurl = "demo_D_hotelDetail.php?HotelID=" . $v->HotelID . "&CityID=" . $D_HotelSearch->CityID . "&CheckInDate=" . $D_HotelSearch->CheckInDate . "&CheckOutDate=" . $D_HotelSearch->CheckOutDate;
        $hotelurl = getNewUrl($hotelurl); //做伪静态
        echo "第&nbsp;&nbsp;" . $i . "&nbsp;&nbsp;家酒店名称：" . $v->HotelName . "&nbsp;&nbsp;<a href='$hotelurl' target='_self'>查看详情</a><br/>";
        $i = $i + 1;
    }
}





?>