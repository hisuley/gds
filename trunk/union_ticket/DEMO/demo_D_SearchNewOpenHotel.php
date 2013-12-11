<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/D_SearchNewOpenHotel.php');//加载D_SearchNewOpenHotel接口的封装类
include_once(ABSPATH."include/urlRewrite.php");//加载URL伪静态处理

include_once (ABSPATH.'sdk/API/Hotel/D_HotelSearch.php');//加载D_HotelSearch这个接口的封装类
include_once (ABSPATH."include/url_HotelControl.php");//加载酒店URL路径控制

//构造请求
$D_SearchNewOpenHotel=new get_D_SearchNewOpenHotel();
$D_SearchNewOpenHotel->OpenYearDateStart=getDateYMD_addDay('-','-'.$HotelNewOpenTime);
$D_SearchNewOpenHotel->OpenYearDateEnd=getDateYMD('-');
$cityID=$_GET['city'];
$cityArr=explode(",",$cityID);

$D_SearchNewOpenHotel->CityID=$cityArr[0];

$D_SearchNewOpenHotel->main();
$returnCommentXML=$D_SearchNewOpenHotel->ResponseXML;//返回的数据是一个XML

if(!empty($returnCommentXML->DomesticNewOpenHotelResponse->NewOpenHotelList->DomesticNewOpenHotelDetail)){
	$OpenYearArr=array();//酒店ID以及对应的最新开业时间
	echo "最新开业酒店数据：<br>";
	foreach ($returnCommentXML->DomesticNewOpenHotelResponse->NewOpenHotelList->DomesticNewOpenHotelDetail as  $v ){
		$hotelId=$v->HotelID;
		$OpenYear=utf_substr(str_replace('T',' ',$v->OpenYear),10);
		
		$hotelName=$v->HotelName;
		$CityID=$D_SearchNewOpenHotel->CityID;
		$CheckInDate=getDateYMD('-');//获取今天
		$CheckOutDate=getDateYMD_addDay('-',TuanEndDate_Distance);//"2012-08-04";
		$hotelurl="demo_D_hotelDetail.php?HotelID=".$v->HotelID."&CityID=".$CityID."&CheckInDate=".$CheckInDate."&CheckOutDate=".$CheckOutDate;
		$hotelurl=getNewUrl($hotelurl);//做伪静态
		
		echo "<a href='".$hotelurl."'>".$hotelName."(".$OpenYear.")</a><br>";
	
		
		
		
		//$HotelNewOpenList=$HotelNewOpenList?$HotelNewOpenList.",".$hotelId:$hotelId;
		//$OpenYearArr["$hotelId"]=$OpenYear;
	}
}




?>