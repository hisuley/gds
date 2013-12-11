<?php

/**
 * ECMALL: 前台入口程序
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * -------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: index.php 5522 2008-08-14 01:52:08Z Scottye $
 */

define('IN_ECM',        true);
define('ROOT_PATH',     dirname(__FILE__)); //取得ecmall所在的根目录
define('PAGE_STARTED',  (PHP_VERSION >= '5.0.0') ? microtime(true) : microtime());

/* 定义PHP_SELF常量 */
$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'store.php';
}
define('PHP_SELF',  htmlentities($php_self));
define('ROOT_DIR',  substr(PHP_SELF, 0, strrpos(PHP_SELF, '/')));
if (!isset($_SERVER['REQUEST_URI']))
{
    $query_string = isset($_SERVER['argv']) ? $_SERVER['argv'][0] : $_SERVER['QUERY_STRING'];
    $_SERVER['REQUEST_URI'] = PHP_SELF . '?' . $query_string;
}
require(ROOT_PATH. '/includes/models/mod.base.php');
require(ROOT_PATH. '/includes/manager/mng.base.php');
require(ROOT_PATH. '/includes/ctl.frontend.php'); // 包含控制器基类
require(ROOT_PATH. '/includes/inc.init.php');

/* 根据请求的URL中的参数调用相应的对象 */
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']): '';
$app = isset($_REQUEST['app']) ? basename($_REQUEST['app']): 'mall';

if (isset($_REQUEST['app']))
{
    $app = basename($_REQUEST['app']);
}
else
{
    $app = 'mall';
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && count($_GET) == 1)
    {
        $arr = array_keys($_GET);

        if (isset($_GET['store_id']))
        {
            $app = 'store';
        }
        elseif (is_int($arr[0]))
        {
            $app = 'store';
            $_GET['store_id'] = $arr[0];
        }
    }
}

/* 过滤非法的app */
$allowed_app = array('article', 'ads', 'category', 'goods', 'groupbuy', 'groupcheckout', 'mall',
     'member', 'message', 'pm', 'regions', 'respond', 'search', 'shopping', 'store', 'storeapply',
     'storelist', 'alipay', 'mail', 'issue', 'feed');

if (!in_array($app, $allowed_app))
{
    die('Hack Attemping');
}

define('APPLICATION', $app);

$app_file   = ROOT_PATH . '/' . APPLICATION . '.php';
$app_class  = ucfirst(APPLICATION) . 'Controller';

require($app_file);
$controller = new $app_class($act);
$controller->destory();

?>