<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelHotComment.php'); //加载酒店点评接口这个接口的封装类-带有分页
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//构造请求
$D_HotelHotComment = new get_D_HotelHotComment();

$HotelIDs = $_GET["Hotel"]; //
if (strpos($HotelIDs, ",") >= 0) {
    $HotelArr = explode(",", $HotelIDs);
    foreach ($HotelArr as $val) {
        $Hotelss = <<<BEGIN
			<HotelID>$val</HotelID>
BEGIN;
        $Hotel = $Hotel . $Hotelss;
    }
}
$D_HotelHotComment->HotelIDs = $Hotel; //
$D_HotelHotComment->main();
$returnCommentXML = $D_HotelHotComment->ResponseXML; //返回的数据是一个XML


//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
$TopHotelComment = array();
$i = 0;
if (!empty($returnCommentXML->DomesticHotelHotComment->HotCommentList->DomesticHotCommentInfoEntity)) {
    foreach ($returnCommentXML->DomesticHotelHotComment->HotCommentList->DomesticHotCommentInfoEntity as $v) {

        $TopHotelComment[$i]['Content'] = (string)$v->Content;
        $TopHotelComment[$i]['Title'] = (string)$v->Title;
        $TopHotelComment[$i]['HotelID'] = (string)$v->HotelID;
        $i++;
    }
    $TopHotelCommentNums = count($TopHotelComment);

    foreach ($TopHotelComment as $v) {
        $titleArr = explode('＂', $v['Title']);
        $HotelName = $titleArr['1'];

        echo $HotelName . "：&nbsp" . $v['Content'] . "<br>";
    }


}



?>