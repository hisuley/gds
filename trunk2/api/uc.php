<?php

/**
 * ECMALL: 与uc的接口
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * -------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: member.php 1704 2008-03-27 05:25:18Z zhaoxiongfei $
 */

define('UC_VERSION', '1.0.0');      //UCenter 版本标识

define('API_DELETEUSER', 1);        //用户删除 API 接口开关
define('API_GETTAG', 1);        //获取标签 API 接口开关
define('API_SYNLOGIN', 1);      //同步登录 API 接口开关
define('API_SYNLOGOUT', 1);     //同步登出 API 接口开关
define('API_UPDATEPW', 1);      //更改用户密码 开关
define('API_UPDATEBADWORDS', 1);    //更新关键字列表 开关
define('API_UPDATEHOSTS', 1);       //更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);        //更新应用列表 开关
define('API_UPDATECLIENT', 1);      //更新客户端缓存 开关
define('API_UPDATECREDIT', 1);      //更新用户积分 开关
define('API_GETCREDITSETTINGS', 1); //向 UCenter 提供积分设置 开关
define('API_UPDATECREDITSETTINGS', 1);  //更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

error_reporting(0);

define('IN_ECM', true);
define('ROOT_PATH', substr(dirname(__FILE__), 0, -4));
define('UC_CLIENT_ROOT', ROOT_PATH.'/uc_client');

require(ROOT_PATH. '/includes/models/mod.base.php');
require(ROOT_PATH. '/includes/manager/mng.base.php');
require(ROOT_PATH. '/includes/ctl.frontend.php'); // 包含控制器基类
require(ROOT_PATH. '/includes/inc.init.php');

$code = $_GET['code'];
parse_str(authcode($code, 'DECODE', UC_KEY), $get);

if(time() - $get['time'] > 3600) {
    exit('Authracation has expiried');
}
if(empty($get)) {
    exit('Invalid Request');
}
$action = $get['action'];
$get['id'] = $_GET['name'];
$timestamp = time();

if ($action == 'test')
{

    exit(API_RETURN_SUCCEED);

}
elseif($action == 'deleteuser')
{

    !API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

    include_once(ROOT_PATH . '/includes/models/mod.user.php');
    $get['ids'] = str_replace("'", '', $get['ids']);
    $uids = explode(',', $get['ids']);
    foreach ($uids as $uid)
    {
        $user_mod = new User($uid);
        $user_mod->drop();
    }
    exit(API_RETURN_SUCCEED);

}
elseif($action == 'renameuser')
{

    !API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

    include_once(ROOT_PATH . '/includes/models/mod.user.php');
    $uid = $get['uid'];
    $usernamenew = $get['newusername'];
    $user_mod = new User($uid);
    $user_mod->re_user_name($usernamenew);

    exit(API_RETURN_SUCCEED);

}
elseif($action == 'gettag')
{

    !API_GETTAG && exit(API_RETURN_FORBIDDEN);

    include_once(ROOT_PATH . '/includes/manager/mng.goods.php');
    $name = trim($get['id']);
    if(empty($name) || !preg_match('/^([\x7f-\xff_-]|\w|\s)+$/', $name) || strlen($name) > 20) {
        exit(API_RETURN_FAILED);
    }
    $goods_mng = new GoodsManager();
    $goods_list = $goods_mng->get_list(1, array('tag_words' => $name), 10);
    $res_list = array();
    if (is_array($goods_list['data']))
    {
        foreach ($goods_list['data'] as $val)
        {
            $res_list[] = array(
                    'goods_name'    => $val['goods_name'],
                    'uid'           => $val['store_id'],
                    'username'      => $val['store_name'],
                    'dateline'      => $val['add_time'],
                    'url'           => site_url() . '/index.php?app=goods&id=' . $val['goods_id'],
                    'image'         => site_url() . '/image.php?file_id=' . $val['default_image'] . '&hash_path=' . md5(ECM_KEY . $val['default_image'] . 80 . 80) . '&width=80&height=80',
                    'goods_price'   => $val['store_price'],
                    );
        }
    }

    $return = array($name, $res_list);
    echo uc_serialize($return, 1);

}
elseif($action == 'synlogin' && $_GET['time'] == $get['time'])
{
    !API_SYNLOGIN && exit(API_RETURN_FORBIDDEN);
    include_once(ROOT_PATH . '/includes/models/mod.user.php');
    $uid = $get['uid'];

    $user_info =  uc_call('uc_get_user', array($uid, 1));
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
    ecm_setcookie('ECM_USERNAME', $user_info[1]); //记录登录用户名
    ecm_setcookie('ECM_AUTH', md5($user_info[0] . ECM_KEY . $user_info[1])); //记录验证串
}
elseif($action == 'synlogout' && $_GET['time'] == $get['time'])
{
    !API_SYNLOGOUT && exit(API_RETURN_FORBIDDEN);

    //note 同步登出 API 接口
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
    ecm_setcookie('ECM_ID', '');
    ecm_setcookie('ECM_AUTH', '');
}
elseif($action == 'updatepw')
{
    include_once(ROOT_PATH . '/includes/manger/mng.user.php');
    $user_name = $get['username'];
    $user_mng = new UserManager();
    if ($user_id = $user_mng->get_id_by_name($user_name))
    {
        include_once(ROOT_PATH . '/includes/models/mod.user.php');
        $user_mod = new User($user_id);
        $user_info['password'] = $user_mod->generate_password();
        $user_mod->update($user_info);
    }

    exit(API_RETURN_SUCCEED);
}
elseif($action == 'updatehosts')
{

    !API_UPDATEHOSTS && exit(API_RETURN_FORBIDDEN);

    $post = uc_unserialize(file_get_contents('php://input'));
    $cachefile = UC_CLIENT_ROOT . '/data/cache/hosts.php';
    $fp = fopen($cachefile, 'w');
    $s = "<?php\r\n";
    $s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
    fwrite($fp, $s);
    fclose($fp);
    exit(API_RETURN_SUCCEED);

}
elseif($action == 'updateapps')
{

    !API_UPDATEAPPS && exit(API_RETURN_FORBIDDEN);

    $post = uc_unserialize(file_get_contents('php://input'));
    $UC_API = $post['UC_API'];
    unset($post['UC_API']);
    $cachefile = UC_CLIENT_ROOT .'/data/cache/apps.php';
    $fp = fopen($cachefile, 'w');
    $s = "<?php\r\n";
    $s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
    fwrite($fp, $s);
    fclose($fp);
    if (is_writeable(ROOT_PATH . '/data/inc.config.php')) {
        foreach ($post as $appdata)
        {
            if ($appdata['appid'] == UC_APPID)
            {
                $fp = fopen(ROOT_PATH . '/data/inc.config.php', 'r');
                $configfile = fread($fp, filesize(ROOT_PATH . '/data/inc.config.php'));
                $configfile = trim($configfile);
                $configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
                fclose($fp);
                $configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
                $configfile = preg_replace("/define\('UC_IP',\s*'.*?'\);/i", "define('UC_IP', '$appdata[ip]');", $configfile);

                if ($fp = @fopen(ROOT_PATH . '/data/inc.config.php', 'w'))
                {
                    @fwrite($fp, trim($configfile));
                    @fclose($fp);
                }
            }
        }
    }
    exit(API_RETURN_SUCCEED);
}
elseif($action == 'updateclient')
{

    !API_UPDATECLIENT && exit(API_RETURN_FORBIDDEN);

    $post = uc_unserialize(file_get_contents('php://input'));
    $cachefile = UC_CLIENT_ROOT .'/data/cache/settings.php';
    $fp = fopen($cachefile, 'w');
    $s = "<?php\r\n";
    $s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
    fwrite($fp, $s);
    fclose($fp);
    exit(API_RETURN_SUCCEED);

}
else
{

    exit(API_RETURN_FAILED);

}


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{

    $ckey_length = 4;

    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }

}

?>