<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Group/GroupProductDetail.php'); //加载GroupProductDetail这个接口的封装类

//构造请求
$Groupdetail = new get_GroupProductDetail();
$Groupdetail->ProductID = $_GET["groupid"];
$Groupdetail->main();
$returnXML = $Groupdetail->ResponseXML;


//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
// echo  json_encode($returnXML);
$Groupdeatails = $returnXML->GroupProductInfoResponse;
$HotelPicture = $Groupdeatails->PictureInfoEntity; //图片

if ($HotelPicture != null && $HotelPicture != "") {
    foreach ($HotelPicture->GroupProductImageEntity as $pics) {
        $imgList = <<<BEGIN
<img width="272" height="114" src="$pics->Picture" /><br/>$pics->Title
<br/>
BEGIN;
        echo $imgList;
    }
}
echo "类型" . $Groupdeatails->ItemType . "&nbsp;&nbsp;名称" . $Groupdeatails->HotelName . "&nbsp;&nbsp;" . $Groupdeatails->StartTime . "~" . $Groupdeatails->EndTime;
echo "<br/>现价:" . $Groupdeatails->Price . "&nbsp;&nbsp;原价:" . $Groupdeatails->ProductPrice . "&nbsp;&nbsp;" . $Groupdeatails->Rate . "折";
echo "<br/>" . $Groupdeatails->Description;
echo "<br/>" . $Groupdeatails->HotelDescription;
?>