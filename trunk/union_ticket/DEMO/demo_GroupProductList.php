<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Group/GroupProductList.php'); //加载GroupProductList这个接口的封装类

//构造请求
$GroupList = new get_GroupProductList();
$GroupList->BeginDate = getDateYMD('-');
$GroupList->City = "上海";
$GroupList->EndDate = getDateYMD_addDay('-', TuanEndDate_Distance);
$GroupList->SortType = 0;
$GroupList->Topcount = 10; //由于团购的API没有分页功能，所以界面上如果要做分页，就需要获取到全部的数据，然后构建分页
$GroupList->Lowprice = 0;
$GroupList->Upperprice = 10000;
$GroupList->main();
$returnXML = $GroupList->ResponseXML;


//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
// echo  json_encode($returnXML);
/*echo  "符合条件的酒店总数为：".$D_HotelSearch->ResponseXML->DomesticHotelList->TotalItems."<br/>";*/
$i = 1;
$returnXMLDataForList = $returnXML->GroupProductListResponse->GroupDataList;
if ($returnXMLDataForList != null) {
    foreach ($returnXMLDataForList->GroupProductListEntity as $v) {
        $groupdetailurl = "demo_GroupProductDetail.php?groupid=" . $v->HotelID;
        echo "<img src='$v->Pictures' width='120'><br/>";
        echo "第&nbsp;&nbsp;" . $i . "&nbsp;&nbsp;个团购名称：" . $v->HotelName . "【" . $v->Name . "】&nbsp;&nbsp;团购类型：" . $v->ItemType . "&nbsp;&nbsp;<a href='$groupdetailurl' target='_self'>查看详情</a><br/>";
        echo "现价:" . $v->Price . "&nbsp;&nbsp;原价:" . $v->ProductPrice . "&nbsp;&nbsp;" . $v->Rate . "折&nbsp;&nbsp;" . $v->StartDate . "~" . $v->EndDate . "&nbsp;&nbsp;已售:" . $v->SaledItemCount . "<a href='$v->Url' target='_blank'>携程地址</a><br/>";
        $i = $i + 1;
    }
}
?>