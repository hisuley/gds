<?php
/*
***********************************************
*$ID:
*$NAME:
*$AUTHOR:E.T.Wei
*DATE:Wed Mar 24 14:33:23 CST 2010
***********************************************
*/
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//文件引入
require("foundation/module_goods.php");
require("foundation/module_shop.php");
//引入语言包
$m_langpackage = new moduleslp;
//数据表定义区
$goods_table = $tablePreStr . "goods";
$img_table = $tablePreStr . "goods_gallery";
$t_shop_info = $tablePreStr . "shop_info";
//读写分类定义方法
$dbo = new dbex;
dbtarget("w", $dbServs);
$row = get_shop_info($dbo, $t_shop_info, $shop_id);
$goods_num = $row['goods_num'];
//取得上传的csv文件
$res = fopen($_FILES['filename']['tmp_name'], "r");
$shop_id = intval(get_args("shop_id"));
while ($arr2 = fgetcsv($res, 50000)) {
    $arr[] = $arr2;
}
$arrobj = new arrayiconv();
if (short_check(get_args("chast")) == 'utf-8') {

} else {
    $arr = $arrobj->Conversion($arr, short_check(get_args("chast")), "utf-8");
}
array_shift($arr); //删除第一行
$cupload = new upload(); //文件上传处理
$errstr = "";
foreach ($arr as $k => $value) {
    $str_arr = $value;
    //下载远程图片到本地
//		print_r($str_arr);
    $imginfo['img_original'] = "";
    $imginfo['img_original'] = GrabImage(end($str_arr));
    if (empty($imginfo['img_original']) || !isset($imginfo['img_original'])) {
        $imginfo['img_original'] = 'skin/' . $SYSINFO['templates'] . '/images/nopic_big.gif';
    }
    //取得后缀名
    $ext = strtolower(strrchr($imginfo['img_original'], '.'));
    $new_filename = date("Ymdhis") . mt_rand(10, 99) . $ext;
    $goods_thumb = "uploadfiles/goods/" . date("Y") . "/" . date("m") . "/" . date("d") . "/thumb_" . $new_filename;
    $goods_img = "uploadfiles/goods/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . $new_filename;
    //生成图片
    $cupload->create_thumb($imginfo['img_original'], $goods_thumb, $SYSINFO['width1'], $SYSINFO['height1']);
    $cupload->create_thumb($imginfo['img_original'], $goods_img, $SYSINFO['width2'], $SYSINFO['height2']);
    $info['shop_id'] = $shop_id;
    $info['goods_name'] = $str_arr[2];
    $info['cat_id'] = $str_arr[3];
    $info['ucat_id'] = $str_arr[4];
    $info['brand_id'] = $str_arr[5];
    $info['type_id'] = $str_arr[6];
    $info['goods_intro'] = $str_arr[7];
    $info['goods_wholesale'] = $str_arr[8];
    $info['goods_number'] = $str_arr[9];
    $info['goods_price'] = $str_arr[10];
    $info['transport_price'] = $str_arr[11];
    $info['keyword'] = str_ireplace("-", ",", $str_arr[12]);
    $info['is_delete'] = $str_arr[13];
    $info['is_best'] = $str_arr[14];
    $info['is_new'] = $str_arr[15];
    $info['is_hot'] = $str_arr[16];
    $info['is_promote'] = $str_arr[17];
    $info['is_on_sale'] = $str_arr[18];
    $info['is_set_image'] = $str_arr[19];
    $info['goods_thumb'] = $goods_thumb;
    $info['pv'] = $str_arr[21];
    $info['favpv'] = $str_arr[22];
    $info['sort_order'] = $str_arr[23];
    $info['add_time'] = !empty($str_arr[24]) ? $str_arr[24] : date("Y-m-d H:i:s");
    $info['last_update_time'] = !empty($str_arr[25]) ? $str_arr[25] : date("Y-m-d H:i:s");
    $info['lock_flg'] = $str_arr[26];
    $goods_id = $dbo->createbyarr($info, $goods_table);
    $imginfo['goods_id'] = $goods_id;
    $imginfo['thumb_url'] = $goods_thumb;
    $imginfo['img_url'] = $goods_img;
    $img_id = $dbo->createbyarr($imginfo, $img_table);
    if ($goods_id == 0 || $img_id == 0) {
        $errstr .= ($k + 1) . ",";
    }

    $goods_num = $goods_num + 1;
    $sql = "update $t_shop_info set goods_num=$goods_num where shop_id=$shop_id";
    $dbo->exeUpdate($sql);
}
$errstr = substr($errstr, 0, -1);
if (empty($errstr)) {
    action_return(1, $m_langpackage->m_import_succ . "！", "modules.php?app=goods_list");
} else {
    action_return(1, $m_langpackage->m_di . $errstr . $m_langpackage->m_import_fail, "modules.php?app=goods_list");
}
function GrabImage($url, $filename = "")
{
    $m_langpackage1 = new moduleslp;
    if ($url == "") {
        return false;
        exit;
    }
    if ($filename == "") {
        $typearr = array("jpg", "gif", "png");
        $ext = strtolower(substr(strrchr($url, '.'), 1, 10));
        if (!in_array($ext, $typearr)) {
            echo $m_langpackage1->m_file_type_error;
            return false;
        }
        $filename = md5(uniqid(mt_rand(), true)) . substr(microtime(), 2, 8) . "." . $ext;
    }
    ob_start();
    if (@readfile($url)) {
        $img = ob_get_contents();
    } else {
        echo $m_langpackage1->m_download_error;
        return false;
        exit;
    }
    ob_end_clean();
    $size = strlen($img);
    if ($size < 1) {
        return false;
        exit();
    }
    $dir = "uploadfiles/goods/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
    mkdirs($dir);
    if (!is_dir($dir)) {
        $i = 0;
        echo $dir;
        exit;
        while (!@mkdir($dir, 0776)) {
            if (is_dir($dir)) break;
            $i++;
            if (mkdir($dir . str_repeat("/..", $i), 0776)) ;
            $i = 0;
        }
    }
    $fp2 = fopen($dir . $filename, "a");
    if ($fp2) {
        fwrite($fp2, $img);
        fclose($fp2);
    } else {

    }
    $img_dir = $dir . $filename;
    return $img_dir;
}

function mkdirs($dir)
{
    if (!is_dir($dir)) {
        if (!mkdirs(dirname($dir))) {
            return false;
        }
        if (!mkdir($dir, 0776)) {
            return false;
        }
    }
    return true;
}

class arrayiconv
{
    static protected $in;
    static protected $out;

    /**
     * 静态方法,该方法输入数组并返回数组
     *
     * @param unknown_type $array 输入的数组
     * @param unknown_type $in 输入数组的编码
     * @param unknown_type $out 返回数组的编码
     * @return unknown 返回的数组
     */
    static public function Conversion($array, $in, $out)
    {
        self::$in = $in;
        self::$out = $out;
        return self::arraymyicov($array);
    }

    /**
     * 内部方法,循环数组
     *
     * @param unknown_type $array
     * @return unknown
     */
    static private function arraymyicov($array)
    {
        foreach ($array as $key => $value) {
            $key = self::myiconv($key);
            if (!is_array($value)) {
                $value = self::myiconv($value);
            } else {
                $value = self::arraymyicov($value);
            }
            $temparray[$key] = $value;
        }
        return $temparray;
    }

    /**
     * 替换数组编码
     *
     * @param unknown_type $str
     * @return unknown
     */
    static private function myiconv($str)
    {
        return iconv(self::$in, self::$out, $str);
    }
}

?>