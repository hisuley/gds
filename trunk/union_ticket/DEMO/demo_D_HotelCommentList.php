<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelCommentList.php'); //加载D_HotelCommentList这个接口的封装类


$getHotelCommentList = new get_D_HotelComment();
$getHotelCommentList->EffectYear = 1;
$getHotelCommentList->HotelID = $_GET['HotelID'];
$getHotelCommentList->RequestType = "H";
$getHotelCommentList->main();
$returnCommentXML = $getHotelCommentList->ResponseXML->DomesticHotelCommentList->DomesticHotelCommentDataList;
//echo json_encode($returnCommentXML);
//用循环的方式将评论打印出来
echo "<br/>打印出酒店的评论<br/>";
$getHotelCommentList->getHotelCommentList($returnCommentXML);


?>