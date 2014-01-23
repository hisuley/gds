<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelBrandList.php'); //加载D_HotelBrandList接口的封装类
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//示例http://127.0.0.1:8888/DEMO/demo_D_HotelBrandList.php?city=2,%E4%B8%8A%E6%B5%B7

//构造请求
$D_ContractHotel = new get_D_HotelBrandList();
$cityID = $_GET['city'];
$cityArr = explode(",", $cityID);
$D_ContractHotel->CityID = $cityArr[0];
$D_ContractHotel->main();
$returnCommentXML = $D_ContractHotel->ResponseXML; //返回的数据是一个XML


$brandImageUrl = "http://pic.ctrip.com/hotels110127/brandimage/";
//$xml=simplexml_load_string($responseXml);	
$hbes = $returnCommentXML->GetHotelBrandResponse->HotelBrandEntityList->HotelBrandEntity;
if (!empty($hbes)) {
    $groupIds[] = 0;
    $brandList;
    foreach ($hbes as $v) {
        $groupId = (int)$v->MgrGroup;
        //echo $groupId."<br/><br/>";
        if (in_array($groupId, $groupIds)) {
            $brandList[$groupId]['Brands'][] = array('Brand' => (string)$v->Brand, 'BrandName' => (string)$v->BrandName, 'BrandCNName' => (string)$v->BrandCNName, 'Pinyin' => (string)$v->Pinyin, 'Image' => $brandImageUrl . (string)$v->Brand . 'a.jpg');
        } else {
            $groupIds[] = $groupId;

            $brandList[$groupId] = array('GroupName' => (string)$v->GroupName);
            $brandList[$groupId]['Brands'][] = array('Brand' => (string)$v->Brand, 'BrandName' => (string)$v->BrandName, 'BrandCNName' => (string)$v->BrandCNName, 'Pinyin' => (string)$v->Pinyin, 'Image' => $brandImageUrl . (string)$v->Brand . 'a.jpg');
        }
    }
    foreach ($brandList as $v) {
        echo "<h3>" . $v['GroupName'] . "</h3>";
        foreach ($v['Brands'] as $brand) {
            $brandUrlInfo = getNewUrl($UnionSite_domainName . "/DEMO/demo_D_GetBrandCityRequest.php?BrandID=" . $brand['Brand'], $SiteUrlRewriter); //到品牌的详细页面，品牌的分布

            echo "<a href='" . $brandUrlInfo . "' title='" . $brand['BrandCNName'] . "' >" . $brand['BrandCNName'] . "</a>&nbsp;&nbsp;";

        }

    }


}

?>