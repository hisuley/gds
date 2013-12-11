<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/D_HotelCommentKey.php');//加载D_HotelCommentKey这个接口的封装类
include_once(ABSPATH."include/urlRewrite.php");//加载URL伪静态处理



//示例 http://127.0.0.1:8888/DEMO/demo_D_HotelCommentKey.php?Hotel=20999
//构造请求
$D_HotelCommentKey=new get_D_HotelCommentKey();
$HotelIDs=$_GET["Hotel"]; //
if(strpos($HotelIDs,",")>=0){
	$HotelArr=explode(",",$HotelIDs);
	foreach($HotelArr as $val){
		$Hotelss=<<<BEGIN
			<HotelID>$val</HotelID>
BEGIN;
		$Hotel=$Hotel.$Hotelss;
		}
}

$D_HotelCommentKey->HotelIDs=$Hotel; //
$D_HotelCommentKey->main();
$returnXML=$D_HotelCommentKey->ResponseXML;//返回的数据是一个XML

//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);

if($returnXML && $returnXML->DomesticHotelCommentStaticInfos->HotelCommentStaticInfo->DomesticHotelCommentStaticInfo->KeyWordLists->DomesticHotelCommentKeyWordEntity){
	foreach ($returnXML->DomesticHotelCommentStaticInfos->HotelCommentStaticInfo->DomesticHotelCommentStaticInfo->KeyWordLists->DomesticHotelCommentKeyWordEntity as  $v ){
		if($Keywords) $Keywords=$Keywords."&nbsp;".$v->Keyword;
		else $Keywords=$v->Keyword;
	
	}

	echo "酒店关键字".$Keywords;
	

}
?>