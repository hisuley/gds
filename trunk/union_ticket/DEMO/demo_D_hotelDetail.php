<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelDetail.php'); //加载D_HotelDetail这个接口的封装类
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelCommentList.php'); //加载D_HotelCommentList这个接口的封装类
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//构造请求
$getDHotelDetail = new get_D_HotelDetail();
$getDHotelDetail->CheckInDate = $_GET["CheckInDate"];
$getDHotelDetail->CheckOutDate = $_GET["CheckOutDate"];
$getDHotelDetail->CityID = $_GET["CityID"];
$getDHotelDetail->HotelID = $_GET["HotelID"];
$getDHotelDetail->main(); //执行方法
$returnXML = $getDHotelDetail->ResponseXML; //返回的数据是一个XML

//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//print_r ($returnXML);
if ($returnXML != null && $returnXML->DomesticHotelProductDetail != null) {
    $xmlProductDetail = $returnXML->DomesticHotelProductDetail;

    echo "酒店名称：" . $xmlProductDetail->HotelName . "<br/>";

    //显示子房型数据
    echo "<br/>打印出酒店子房型数据<br/>";
    echo $getDHotelDetail->getSubRoomList($xmlProductDetail);
    //显示子房型数据

    $getHotelCommentList = new get_D_HotelComment();
    $getHotelCommentList->EffectYear = 1;
    $getHotelCommentList->HotelID = $getDHotelDetail->HotelID;
    $getHotelCommentList->RequestType = "H";
    $getHotelCommentList->main();
    $returnCommentXML = $getHotelCommentList->ResponseXML->DomesticHotelCommentList->DomesticHotelCommentDataList;
    //echo json_encode($returnCommentXML);
    //用循环的方式将评论打印出来
    echo "<br/>打印出酒店的评论<br/>";
    $getHotelCommentList->getHotelCommentList($returnCommentXML);
}

?>