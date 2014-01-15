<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("../foundation/module_users.php");
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage = new adminlp;

//权限管理
$right = check_rights("user_level_edit");
if (!$right) {
    action_return(0, $a_langpackage->a_privilege_mess, 'm.php?app=error');
}
$post['level_name'] = short_check(get_args('level_name'));
$post['pointBegin'] = intval(get_args('pointBegin'));
$post['pointEnd'] = intval(get_args('pointEnd'));
$post['level_created'] = $ctime->long_time();
$level_id = intval(get_args('level_id'));
if (!$level_id) {
    trigger_error($a_langpackage->a_error);
}
/* 图片上传处理 */
$cupload = new upload('jpg|gif|png', 1024, 'price_img');
$cupload->set_dir("../uploadfiles/member_level/", "{y}/{m}/{d}");
$setthumb = array(
    'width' => array($SYSINFO['width1'], $SYSINFO['width2']),
    'height' => array($SYSINFO['height1'], $SYSINFO['height2']),
    'name' => array('thumb', 'm')
);
$cupload->set_thumb($setthumb);
$file = $cupload->execute();
if (count($file)) {
    foreach ($file as $k => $v) {
        if ($v['flag'] == 1) {
            if (!empty($v['dir'])) {
                $post['price_img'] = str_replace('../', '', $v['dir']) . $v['name'];
            }
        }
    }
}
$cupload = new upload('jpg|gif|png', 1024, 'head_img');
$cupload->set_dir("../uploadfiles/member_level/", "{y}/{m}/{d}");
$setthumb = array(
    'width' => array($SYSINFO['width1'], $SYSINFO['width2']),
    'height' => array($SYSINFO['height1'], $SYSINFO['height2']),
    'name' => array('thumb', 'm')
);
$cupload->set_thumb($setthumb);
$file = $cupload->execute();
if (count($file)) {
    foreach ($file as $k => $v) {
        if ($v['flag'] == 1) {
            if (!empty($v['dir'])) {
                $post['head_img'] = str_replace('../', '', $v['dir']) . $v['name'];
            }
        }
    }
}
//数据表定义区
$t_user_level = $tablePreStr . "user_level";
$t_admin_log = $tablePreStr . "admin_log";

//定义写操作
$dbo = new dbex;
dbtarget('w', $dbServs);
$count = check_level_name($dbo, $t_user_level, $post['level_name'], $level_id);
if ($count[0]) {
    action_return(0, $a_langpackage->a_user_level_name_repeat, '-1');
    exit;
}
if (update_userlevel_info($dbo, $t_user_level, $post, $level_id)) {
    admin_log($dbo, $t_admin_log, $a_langpackage->a_user_level_edit . ":" . $level_id); //'管理员级别添加');
    action_return(1, $a_langpackage->a_amend_suc, 'm.php?app=member_level_edit&id=' . $level_id);
} else {
    action_return(0, $a_langpackage->a_amend_lose, '-1');
}
?>