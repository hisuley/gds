<?php
/**
 * Created by PhpStorm.
 * User: suley
 * Date: 1/9/14
 * Time: 4:38 PM
 */


require("foundation/nusoap/nusoap.php");

$url="http://121.52.221.108/websend/MmsService?WSDL";
$type= "WSDL";
$charset="utf-8";
$param=array(
    'sName'=> "guilin",//手机号
    'sPwd'=> "123456",
    'start'=> "0", //用户名
    'end'=> "1"
);

$client = new nusoap_client($url,$type);
if($err = $client->getError()) exit($err);
$client->soap_defencoding = $charset;
$client->decode_utf8 = false;
$client->xml_encoding = $charset;
$result = $client->call("GetMmsList",$param,'','',false,true);
print_r($result);
?>
