<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/D_HotelNearbyInfo.php');//加载D_HotelNearbyInfo这个接口的封装类
include_once(ABSPATH."include/urlRewrite.php");//加载URL伪静态处理

include_once (ABSPATH.'sdk/API/Hotel/D_HotelSearch.php');//加载D_HotelSearch这个接口的封装类
include_once (ABSPATH."include/url_HotelControl.php");//加载酒店URL路径控制


//示例 http://127.0.0.1:8888/DEMO/demo_D_HotelNearbyInfo.php?Hotel=20999&city=32,%E5%B9%BF%E5%B7%9E
//构造请求
$D_HotelNearbyInfo=new get_D_HotelNearbyInfo();
$cityID=$_GET["city"];
$D_HotelNearbyInfo->Hotel=$_GET["Hotel"]; //
$D_HotelNearbyInfo->Distance='5';//此处默认距离为5;
$D_HotelNearbyInfo->HotelNums='6';//周边酒店返回数量
$D_HotelNearbyInfo->IsHotPlace='F';
$D_HotelNearbyInfo->main();
$returnXML=$D_HotelNearbyInfo->ResponseXML;//返回的数据是一个XML

//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
if($returnXML && $returnXML->DomesticHotelNearbyInfoResponse){
	
	
$HotelNearbyFacilityEntityList=array();
if(!empty($returnXML->DomesticHotelNearbyInfoResponse->HotelNearbyFacilityEntityList->DomesticHotelNearbyFacilityEntity)){
	$i=0;
	foreach ($returnXML->DomesticHotelNearbyInfoResponse->HotelNearbyFacilityEntityList->DomesticHotelNearbyFacilityEntity as  $v ){	
		$HotelNearbyFacilityEntityList[$i][(string)$v->Type]=(string)$v->FacilityName;	
		$i++;
	}
}
foreach($HotelNearbyFacilityEntityList as $v){
	foreach ($v as $key=>$value){
		if($NearbyFacilityEntityList[$key])$NearbyFacilityEntityList[$key] =$NearbyFacilityEntityList[$key]."&nbsp;&nbsp;".$value;
		else $NearbyFacilityEntityList[$key] =$value;
	}
}
// 输出酒店周边情况
echo  "酒店周边设施"."<br>";
echo "餐饮：&nbsp".$NearbyFacilityEntityList[1]."<br>";
echo "购物：&nbsp".$NearbyFacilityEntityList[2]."<br>";
echo "娱乐：&nbsp".$NearbyFacilityEntityList[3]."<br>";
echo "大学：&nbsp".$NearbyFacilityEntityList[101]."<br>";
echo "景点：&nbsp".$NearbyFacilityEntityList[102]."<br>";
echo "地铁：&nbsp".$NearbyFacilityEntityList[201]."<hr>";

echo "酒店周边酒店"."<br>";

if(!empty($returnXML->DomesticHotelNearbyInfoResponse->HotelToHotelEntityList->DomesticHotelToHotelEntity)){
	$DistanceArr=array();
	foreach ($returnXML->DomesticHotelNearbyInfoResponse->HotelToHotelEntityList->DomesticHotelToHotelEntity as  $v ){
		$hotelId=$v->HotelIdTo;
		$Distance=(string)$v->Distance;
		$hotelidlist=$hotelidlist?$hotelidlist.",".$hotelId:$hotelId;
		$DistanceArr["$hotelId"]=$Distance;
	
	}
}
$pagesize=count($returnXML->DomesticHotelNearbyInfoResponse->HotelNearbyFacilityEntityList->DomesticHotelNearbyFacilityEntity );

//构造请求
$D_HotelSearch=new get_D_HotelSearch();
$D_HotelSearch->CheckInDate=getDateYMD('-');//获取今天
$D_HotelSearch->CheckOutDate=getDateYMD_addDay('-',TuanEndDate_Distance);//"2012-08-04";
$arrayP1=explode(",",$cityID);

$D_HotelSearch->CityID=$arrayP1['0'];
$D_HotelSearch->HotelList=$hotelidlist;	
$D_HotelSearch->PageSize=$pagesize;
$D_HotelSearch->main();
$returnXML=$D_HotelSearch->ResponseXML;//返回的数据是一个XML
//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
$i=1;
$returnXMLDataForList=$returnXML ->DomesticHotelList->HotelDataList;
if($returnXMLDataForList!=null){
foreach($returnXMLDataForList->DomesticHotelDataForList as $v)
{
	$hotelurl="demo_D_hotelDetail.php?HotelID=".$v->HotelID."&CityID=".$D_HotelSearch->CityID."&CheckInDate=".$D_HotelSearch->CheckInDate."&CheckOutDate=".$D_HotelSearch->CheckOutDate;
    $hotelurl=getNewUrl($hotelurl);//做伪静态
	echo "第&nbsp;&nbsp;".$i."&nbsp;&nbsp;家酒店名称：".$v->HotelName."&nbsp;&nbsp;<a href='$hotelurl' target='_self'>查看详情</a><br/>";
    $i=$i+1;
}
}




}
?>