<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_NewBookingHotel.php'); //加载D_NewBookingHotel接口的封装类
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

include_once(ABSPATH . 'sdk/API/Hotel/D_HotelSearch.php'); //加载D_HotelSearch这个接口的封装类
include_once(ABSPATH . "include/url_HotelControl.php"); //加载酒店URL路径控制

//构造请求
$D_NewBookingHotel = new get_D_NewBookingHotel();
$D_NewBookingHotel->LastHour = '148';
$D_NewBookingHotel->CurPage = '1';
$D_NewBookingHotel->PageCount = '10';
$cityID = $_GET['city'];
$cityArr = explode(",", $cityID);

$D_NewBookingHotel->CityID = $cityArr[0];

$D_NewBookingHotel->main();
$returnCommentXML = $D_NewBookingHotel->ResponseXML; //返回的数据是一个XML

if (!empty($returnCommentXML->DomesticNewBookingHotelResponse->NewBookingHotel->DomesticNewBookingHotelDetail)) {
    $DifTimeArr = array(); //酒店ID以及对应的预定时差
    echo "最新预定酒店数据：<br>";
    foreach ($returnCommentXML->DomesticNewBookingHotelResponse->NewBookingHotel->DomesticNewBookingHotelDetail as $v) {
        $hotelId = $v->HotelID;
        $hotelName = $v->HotelName;
        $CityID = $v->CityID;
        $CheckInDate = getDateYMD('-'); //获取今天
        $CheckOutDate = getDateYMD_addDay('-', TuanEndDate_Distance); //"2012-08-04";
        $hotelurl = "demo_D_hotelDetail.php?HotelID=" . $v->HotelID . "&CityID=" . $CityID . "&CheckInDate=" . $CheckInDate . "&CheckOutDate=" . $CheckOutDate;
        $hotelurl = getNewUrl($hotelurl); //做伪静态
        $DifTime = intval((time() - strtotime($v->LatestBookTime)) / 3600);

        echo "<a href='" . $hotelurl . "'>" . $hotelName . "(" . $DifTime . "小时)</a><br>";

        //	$HotelNewBookingList=$HotelNewBookingList?$HotelNewBookingList.",".$hotelId:$hotelId;
        //$DifTimeArr["$hotelId"]=$DifTime;
    }
}





?>