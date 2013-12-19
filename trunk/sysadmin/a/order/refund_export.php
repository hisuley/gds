<?php
if(!$IWEB_SHOP_IN) {
        die('Hacking attempt');
}
	
//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$refund_list_table = $tablePreStr."refund_list";

//读写分类定义方法
$dbo = new dbex;
dbtarget("r",$dbServs);

$chast = 'gbk';
$file_name = get_args("filename");
if (empty($file_name)) {
        $file_name=date("YmdHis");
}
$file_name .=".csv";
$file_name =iconv("utf-8",$chast,$file_name);

$sql = "SELECT * FROM $refund_list_table order by operator_date";
$receiv_list = $dbo->getRs($sql);

header( "Cache-Control: public" );
header( "Pragma: public" );
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=".$file_name);
header('Content-Type:APPLICATION/OCTET-STREAM');
ob_start();
$header_str = iconv("utf-8",$chast,$a_langpackage->a_iconv_refund);

$file_str="";
foreach ($receiv_list as $value){

        $order_id_pos = strpos($value['order_id'],",");
        $refund_way_pos = strpos($value['refund_way'],",");
        $user_name_pos = strpos($value['user_name'],",");
        $refund_account_pos = strpos($value['refund_account'],",");
        $operator_pos = strpos($value['operator'],",");

    if ($order_id_pos === false) {
                $order_id = iconv("utf-8",$chast,$value['order_id']);
    }else{
        $order_id ="\"".iconv("utf-8",$chast,$value['order_id'])."\"";
    }

        if ($refund_way_pos === false) {
                $refund_way = iconv("utf-8",$chast,$value['refund_way']);
    }else{
        $refund_way ="\"".iconv("utf-8",$chast,$value['refund_way'])."\"";
    }

        if ($user_name_pos === false) {
                $user_name = iconv("utf-8",$chast,$value['user_name']);
    }else{
        $user_name ="\"".iconv("utf-8",$chast,$value['user_name'])."\"";
    }

        if ($refund_account_pos === false) {
                $refund_account = iconv("utf-8",$chast,$value['refund_account']);
    }else{
        $refund_account ="\"".iconv("utf-8",$chast,$value['refund_account'])."\"";
    }

        if ($operator_pos === false) {
                $operator = iconv("utf-8",$chast,$value['operator']);
    }else{
        $operator ="\"".iconv("utf-8",$chast,$value['operator'])."\"";
    }

        $file_str .=$value['refund_id'].",".$order_id.",".$value['shop_id'].",".$refund_way.",".$user_name.",".$refund_account.",".$value['refund_money'].",".$operator.",".$value['operator_date']."\n";
}
ob_end_clean();
echo $header_str;
echo $file_str;
	
?>