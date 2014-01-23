<?php
/**
 * Created by Wuxing Internet
 * @author Xiaomo
 * @time 14-1-5
 * @version 1.0
 * @copyright 
 **/
error_reporting(0);
require(dirname(__FILE__). '/pscws3.class.php');
function segmentString($string){
    $string = iconv('UTF-8', 'GBK', $string);
    $pscws = new PSCWS3(dirname(__FILE__) . '/dict/dict.xdb');
    $res = $pscws->segment($string);
    $res = array_map('convertCharset', $res);
    return $res;
}
function convertCharset($string){
    return iconv('GBK', 'UTF-8', $string);
}
function generateString($string,$id){
    $res = segmentString($string);
    $sql = ' ';
    $i = 0;
    foreach($res as $val){
        if($i == 0){
            $sql .= " article_id NOT IN(".$id.") AND title LIKE '%$val%'";
            $i++;
        }else {
            $sql .= " OR article_id NOT IN(".$id.") AND title LIKE '%$val%'";
        }
    }
    
    return $sql;
}
$result = generateString($_GET['keywords']);
echo empty($result) ? '' : $result;