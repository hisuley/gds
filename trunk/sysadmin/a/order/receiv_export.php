<?php
if(!$IWEB_SHOP_IN) {
        die('Hacking attempt');
}
	
//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$receiv_list_table = $tablePreStr."receiv_list";

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

$sql = "SELECT * FROM $receiv_list_table order by receiv_date";
$receiv_list = $dbo->getRs($sql);

header( "Cache-Control: public" );
header( "Pragma: public" );
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=".$file_name);
header('Content-Type:APPLICATION/OCTET-STREAM');
ob_start();
$header_str = iconv("utf-8",$chast,$a_langpackage->a_iconv_receiv);

$file_str="";
foreach ($receiv_list as $value){

        $payid_pos = strpos($value['payid'],",");
        $payment_type_pos = strpos($value['payment_type'],",");
        $receiver_pos = strpos($value['receiver'],",");
        $receiv_account_pos = strpos($value['receiv_account'],",");
        $operator_pos = strpos($value['operator'],",");

    if ($payid_pos === false) {
                $payid = iconv("utf-8",$chast,$value['payid']);
    }else{
        $payid ="\"".iconv("utf-8",$chast,$value['payid'])."\"";
    }

        if ($payment_type_pos === false) {
                $payment_type = iconv("utf-8",$chast,$value['payment_type']);
    }else{
        $payment_type ="\"".iconv("utf-8",$chast,$value['payment_type'])."\"";
    }

        if ($receiver_pos === false) {
                $receiver = iconv("utf-8",$chast,$value['receiver']);
    }else{
        $receiver ="\"".iconv("utf-8",$chast,$value['receiver'])."\"";
    }

        if ($receiv_account_pos === false) {
                $receiv_account = iconv("utf-8",$chast,$value['receiv_account']);
    }else{
        $receiv_account ="\"".iconv("utf-8",$chast,$value['receiv_account'])."\"";
    }

        if ($operator_pos === false) {
                $operator = iconv("utf-8",$chast,$value['operator']);
    }else{
        $operator ="\"".iconv("utf-8",$chast,$value['operator'])."\"";
    }

        $file_str .=$value['receiv_id'].",".$value['order_id'].",".$payid.",".$value['shop_id'].",".$payment_type.",".$value['pay_date'].",".$receiver.",".$value['receiv_date'].",".$receiv_account.",".$value['receiv_money'].",".$operator."\n";
}
ob_end_clean();
echo $header_str;
echo $file_str;
	
?>