<?php
/*Çë°´ÕÕÄúµÄÊµ¼ÊÇé¿öÅäÖÃÒÔÏÂ¸÷²ÎÊý*/

//Ë½Ô¿ÎÄ¼þ£¬ÔÚCHINAPAYÉêÇëÉÌ»§ºÅÊ±»ñÈ¡£¬ÇëÏàÓ¦ÐÞ¸Ä´Ë´¦£¬¿ÉÌîÏà¶ÔÂ·¾¶£¬ÏÂÍ¬
<<<<<<< HEAD
define("PRI_KEY", "MerPrK_808080060492208_20120604133310.key");

//Tourism Dept.
//define("PRI_KEY", "MerPrK_808080520108369_20120315111326.key");
//¹«Ô¿ÎÄ¼þ£¬Ê¾ÀýÖÐÒÑ¾­°üº¬
//define("PUB_KEY", "PgPubk.key");
//
define("PUB_KEY", "PgPubk_2.key");
=======
define("PRI_KEY", "MerPrK_808080520108369_20120315111326.key");
//¹«Ô¿ÎÄ¼þ£¬Ê¾ÀýÖÐÒÑ¾­°üº¬
define("PUB_KEY", "PgPubk.key");
>>>>>>> remotes/origin/master

/*ÈçÄúÒÑÓÐÉú²úÃÜÔ¿£¬ÇëÐÞ¸ÄÒÔÏÂÅäÖÃ£¬Ä¬ÈÏÎª²âÊÔ»·¾³*/

//Ö§¸¶ÇëÇóµØÖ·(²âÊÔ)
//define("REQ_URL_PAY","http://payment-test.ChinaPay.com/pay/TransGet");
//Ö§¸¶ÇëÇóµØÖ·(Éú²ú)
<<<<<<< HEAD

define("REQ_URL_PAY","http://payment-test.ChinaPay.com/pay/TransGet");

//Offical
//define("REQ_URL_PAY","http://payment.ChinaPay.com/pay/TransGet");
=======

define("REQ_URL_PAY", "http://payment.ChinaPay.com/pay/TransGet");
>>>>>>> remotes/origin/master

//define("REQ_URL_PAY","http://payment-test.ChinaPay.com/pay/TransGet");

//²éÑ¯ÇëÇóµØÖ·(²âÊÔ)
//define("REQ_URL_QRY","http://payment-test.chinapay.com/QueryWeb/processQuery.jsp");
//²éÑ¯ÇëÇóµØÖ·(Éú²ú)
<<<<<<< HEAD
define("REQ_URL_QRY","http://console.chinapay.com/QueryWeb/processQuery.jsp");
=======
define("REQ_URL_QRY", "http://console.chinapay.com/QueryWeb/processQuery.jsp");
>>>>>>> remotes/origin/master

//ÍË¿îÇëÇóµØÖ·(²âÊÔ)
//define("REQ_URL_REF","http://payment-test.chinapay.com/refund/SingleRefund.jsp");
//ÍË¿îÇëÇóµØÖ·(Éú²ú)
<<<<<<< HEAD
define("REQ_URL_REF","https://bak.chinapay.com/refund/SingleRefund.jsp");

function getcwdOL(){
    $total = $_SERVER[PHP_SELF];
    $file = explode("/", $total);
    $file = $file[sizeof($file)-1];
    return substr($total, 0, strlen($total)-strlen($file)-1);
}

function getSiteUrl(){
    $host = $_SERVER[SERVER_NAME];
    $port = ($_SERVER[SERVER_PORT]=="80")?"":":$_SERVER[SERVER_PORT]";
    return "http://" . $host . $port . getcwdOL();
}

function traceLog($file, $log){
    $f = fopen($file, 'a');
    if($f){
=======
define("REQ_URL_REF", "https://bak.chinapay.com/refund/SingleRefund.jsp");

function getcwdOL()
{
    $total = $_SERVER[PHP_SELF];
    $file = explode("/", $total);
    $file = $file[sizeof($file) - 1];
    return substr($total, 0, strlen($total) - strlen($file) - 1);
}

function getSiteUrl()
{
    $host = $_SERVER[SERVER_NAME];
    $port = ($_SERVER[SERVER_PORT] == "80") ? "" : ":$_SERVER[SERVER_PORT]";
    return "http://" . $host . $port . getcwdOL();
}

function traceLog($file, $log)
{
    $f = fopen($file, 'a');
    if ($f) {
>>>>>>> remotes/origin/master
        fwrite($f, date('Y-m-d H:i:s') . " => $log\n");
        fclose($f);
    }
}

$site_url = getSiteUrl();
/**
 * Curl版本
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_curl('http://facebook.cn/restServer.php',$post_string);
 */
<<<<<<< HEAD
function request_by_curl($remote_server,$post_string){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$remote_server);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
=======
function request_by_curl($remote_server, $post_string)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
>>>>>>> remotes/origin/master
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
<<<<<<< HEAD
/*
*格式化交易金额，以分位单位的12位数字。
*/
function formatamount($amount){
    if($amount){
        if(!strstr($amount, ".")){
            $amount = $amount.".00";
        }
        $amount = str_replace(".", "", $amount);
        $temp = $amount;
        for($i=0; $i< 12 - strlen($amount); $i++){
=======

/*
*格式化交易金额，以分位单位的12位数字。
*/
function formatamount($amount)
{
    if ($amount) {
        if (!strstr($amount, ".")) {
            $amount = $amount . ".00";
        }
        $amount = str_replace(".", "", $amount);
        $temp = $amount;
        for ($i = 0; $i < 12 - strlen($amount); $i++) {
>>>>>>> remotes/origin/master
            $temp = "0" . $temp;
        }
        return $temp;
    }
}
<<<<<<< HEAD
=======

>>>>>>> remotes/origin/master
?>