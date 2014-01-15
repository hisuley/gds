<?php
/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
include_once('../SDK.config.php'); //配置文件加载--必须加载这个文件
include_once(ABSPATH . 'sdk/API/Hotel/D_HotelCommentListPage.php'); //加载酒店点评接口这个接口的封装类-带有分页
include_once(ABSPATH . "include/urlRewrite.php"); //加载URL伪静态处理

//构造请求
$D_HotelCommentWithPage = new get_D_HotelCommentWithPage();
$D_HotelCommentWithPage->HotelID = $_GET['HotelID'];
$D_HotelCommentWithPage->PageNo = 1;
$D_HotelCommentWithPage->PageSize = 10;
$D_HotelCommentWithPage->main();
$returnCommentXML = $D_HotelCommentWithPage->ResponseXML; //返回的数据是一个XML
//可以将返回的数据直接用json转换一下，打印出来，方便查看节点名称和数据
//echo  json_encode($returnXML);
echo "符合条件的评论总数为：" . $returnCommentXML->DomesticHotelCommentPageList->RecordCount . "<br/>";
$i = 1;
$HotelCommentItems = $returnCommentXML->DomesticHotelCommentPageList->HotelCommentItems;
if ($HotelCommentItems != null) {
    foreach ($HotelCommentItems->DomesticHotelCommentPage as $v) {
        echo "第&nbsp;&nbsp;" . $i . "&nbsp;&nbsp;条评论：" . $v->Content . "&nbsp;&nbsp;<br/>";
        $i = $i + 1;
    }
}
?>