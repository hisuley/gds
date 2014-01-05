<?php
/**
 * Created by Wuxing Internet
 * @author Xiaomo
 * @time 14-1-5
 * @version 1.0
 * @copyright 
 **/
require 'pscws3.class.php';
function segmentString($string){
    $string = iconv('UTF-8', 'GBK', $string);
    $pscws = new PSCWS3('./dict/dict.xdb');
    $res = $pscws->segment($string);
    $res = array_map('convertCharset', $res);
    return $res;
}
function convertCharset($string){
    return iconv('GBK', 'UTF-8', $string);
}
function generateString($string){
    $res = segmentString($string);
    $sql = ' WHERE 0';
    foreach($res as $val){
        $sql .= " OR title LIKE %$val%";
    }
    return $sql;
}