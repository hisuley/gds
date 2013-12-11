<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/SearchLocationZoneCityLandmark.php');//加载SearchLocationZoneCityLandmark接口的封装类
include_once(ABSPATH."include/urlRewrite.php");//加载URL伪静态处理
include_once (ABSPATH."include/url_HotelControl.php");//加载酒店URL路径控制

$CheckInDate=getDateYMD('-');
$CheckOutDate=getDateYMD_addDay('-','7');
$p1=$cityID;
$p2=urlencode("$CheckInDate,$CheckOutDate");

$hotelSearchUrl=new HotelUrlControl($p1, $p2, "", "", "", "...", "", "", "1,5", "list");
$searchUrl=$hotelSearchUrl->returnUrl;
$searchUrl=getNewUrl($searchUrl,$SiteUrlRewriter);


//示例http://127.0.0.1:8888/DEMO/demo_SearchLocationZoneCityLandmark.php?city=2,%E4%B8%8A%E6%B5%B7

//构造请求
$SearchLocationZoneCityLandmark=new get_SearchLocationZoneCityLandmark();
$cityID=$_GET['city'];
$cityArr=explode(",",$cityID);
$SearchLocationZoneCityLandmark->City=$cityArr[0];
$SearchLocationZoneCityLandmark->Type='1,2,3';
$SearchLocationZoneCityLandmark->SearchLandmarkType='1,2,3';


$SearchLocationZoneCityLandmark->main();
$returnCommentXML=$SearchLocationZoneCityLandmark->ResponseXML;//返回的数据是一个XML

$SearchLocationZoneCityLandmarkResponseXML=$returnCommentXML->SearchLocationZoneCityLandmarkResponse;

//行政区
$LocationName=array();
if(!empty($SearchLocationZoneCityLandmarkResponseXML->LocationDetails->LocationDetail)){
	foreach ($SearchLocationZoneCityLandmarkResponseXML->LocationDetails->LocationDetail as  $v ){
		$p3=urlencode($v->Location.",".$v->LocationName."-,-,");
		$url=str_replace("...",$p3,$searchUrl);
		$LocationName[]=$v->LocationName."@".$url;
		
	}
}
//商业区
$ZoneName=array();
if(!empty($SearchLocationZoneCityLandmarkResponseXML->ZoneDetails->ZoneDetail)){
	foreach ($SearchLocationZoneCityLandmarkResponseXML->ZoneDetails->ZoneDetail as  $v ){
		$p3=urlencode(",-".$v->Zone.",".$v->ZoneName."-,");
		$url=str_replace("...",$p3,$searchUrl);
		$ZoneName[]=$v->ZoneName."@".$url;
	}
}

//景点
$LandmarkName=array();
if(!empty($SearchLocationZoneCityLandmarkResponseXML->CityLandmarkAttractionsDetails->CityLandmarkDetail)){
	foreach ($SearchLocationZoneCityLandmarkResponseXML->CityLandmarkAttractionsDetails->CityLandmarkDetail as  $v ){
		$p3=urlencode(",-,-".$v->LandmarkID.",".$v->LandmarkName);
		$url=str_replace("...",$p3,$searchUrl);
		$LandmarkName[]=$v->LandmarkName."@".$url;
	}
}

echo "<h3>景点</h3>";
if($LandmarkName){	
	foreach ($LandmarkName as $value) {
		$detailArr=explode('@', $value);
		echo "<a href='".$detailArr[1]."' title='".$detailArr[0]."'>".$detailArr[0]."</a>&nbsp;&nbsp;";	
	}	
}

echo "<h3>行政区</h3>";
if($LocationName){	
	foreach ($LocationName as $value) {
		$detailArr=explode('@', $value);
		echo "<a href='".$detailArr[1]."' title='".$detailArr[0]."'>".$detailArr[0]."</a>&nbsp;&nbsp;";	
	}	
}

echo "<h3>商业区</h3>";
if($ZoneName){	
	foreach ($ZoneName as $value) {
		$detailArr=explode('@', $value);
		echo "<a href='".$detailArr[1]."' title='".$detailArr[0]."'>".$detailArr[0]."</a>&nbsp;&nbsp;";	
	}	
}

//print_r($LandmarkName);die;




?>