<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once ('../SDK.config.php');//配置文件加载--必须加载这个文件
include_once (ABSPATH.'sdk/API/Hotel/D_GetBrandCityRequest.php');//加载D_GetBrandCityRequest接口的封装类
include_once(ABSPATH."include/urlRewrite.php");//加载URL伪静态处理

//include (ABSPATH.'site/module/brand_logic.php');

//构造请求
$D_GetBrandCityRequest=new get_D_GetBrandCityRequest();
$D_GetBrandCityRequest->BrandID=$_GET['BrandID'];
$D_GetBrandCityRequest->main();
$returnCommentXML=$D_GetBrandCityRequest->ResponseXML;//返回的数据是一个XML

$brandEntity=getBrandInfo($_GET['BrandID']);

if ($brandEntity){
	$brandCnNameVaule=$brandEntity['BrandCNName'];//品牌的名称
	$city=hotelCityDistribution($_GET['BrandID'], $brandCnNameVaule,$returnCommentXML);

	echo "（共".$city['count']."家）<br>";	
	echo "国内城市<br>";
	foreach ($city['inner'] as $v){
		echo $v['CityName'].$brandCnNameVaule."酒店预定<br>";
	}
	echo "国外城市<br>";
	foreach ($city['out'] as $v){
		echo $v['CityName'].$brandCnNameVaule."酒店预定<br>";
	}
	
	
	
}

function getBrandInfo($brand){
	if (file_exists('../appData/brandDescription.xml')){
		$xml=simplexml_load_file('../appData/brandDescription.xml');
		//var_dump($xml);
		$brandlist=$xml->BrandInfo;
		foreach ($brandlist as $v){
			if($v->Brand==$brand){
				$brandEntity=array('Brand'=>$v->Brand,'BrandName'=>$v->BrandName,'BrandCNName'=>$v->BrandCNName,'BrandLevel'=>$v->BrandLevel,'SeoFlag'=>$v->SeoFlag,'GroupName'=>$v->GroupName,'Description'=>$v->Description);
				return $brandEntity;
			}
		}
	}
	return null;
}



?>