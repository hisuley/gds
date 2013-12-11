<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/D_ContractHotel.php');//加载D_ContractHotel接口的封装类
include_once(ABSPATH."include/urlRewrite.php");//加载URL伪静态处理

include_once (ABSPATH.'sdk/API/Hotel/D_HotelSearch.php');//加载D_HotelSearch这个接口的封装类
include_once (ABSPATH."include/url_HotelControl.php");//加载酒店URL路径控制


//示例 http://127.0.0.1:8888/DEMO/demo_D_ContractHotel.php?city=2,%E4%B8%8A%E6%B5%B7
//构造请求
$D_ContractHotel=new get_D_ContractHotel();
$D_ContractHotel->ContractDateStart=getDateYMD_addDay('-','-'.$HotelNewContractTime);
$D_ContractHotel->ContractDateEnd=getDateYMD('-');
$D_ContractHotel->CurPage='1';
$D_ContractHotel->PageCount='12';
$cityID=$_GET['city'];
$cityArr=explode(",",$cityID);

$D_ContractHotel->CityID=$cityArr[0];

$D_ContractHotel->main();
$returnCommentXML=$D_ContractHotel->ResponseXML;//返回的数据是一个XML
if(!empty($returnCommentXML->DomesticContractHotelResponse->ContractDetails->DomesticContractDetail)){
	echo "最新加盟酒店数据：<br>";	
	foreach ($returnCommentXML->DomesticContractHotelResponse->ContractDetails->DomesticContractDetail as  $v ){
			$hotelId=$v->HotelID;
			$hotelName=$v->HotelName;
			$CityID=$D_ContractHotel->CityID;
			$CheckInDate=getDateYMD('-');//获取今天
			$CheckOutDate=getDateYMD_addDay('-',TuanEndDate_Distance);//"2012-08-04";
			$hotelurl="demo_D_hotelDetail.php?HotelID=".$v->HotelID."&CityID=".$CityID."&CheckInDate=".$CheckInDate."&CheckOutDate=".$CheckOutDate;
			$hotelurl=getNewUrl($hotelurl);//做伪静态
			
			echo "<a href='".$hotelurl."'>".$hotelName."</a><br>";
			//$HotelNewContractList=$HotelNewContractList?$HotelNewContractList.",".$hotelId:$hotelId;
		}
}





?>