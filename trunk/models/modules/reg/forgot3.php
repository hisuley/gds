<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("foundation/asystem_info.php");
require("foundation/csmtp.class.php");
require("foundation/emailcheck.php");

$i_langpackage = new indexlp;
$m_langpackage = new moduleslp;
$e_email = new emailCheck;
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

if (get_sess_user_id()) {
    $USER['login'] = 1;
    $USER['user_name'] = get_sess_user_name();
    $USER['user_id'] = get_sess_user_id();
    $USER['user_email'] = get_sess_user_email();
    $USER['shop_id'] = get_sess_shop_id();
} else {
    $USER['login'] = 0;
    $USER['user_name'] = '';
    $USER['user_id'] = '';
    $USER['user_email'] = '';
    $USER['shop_id'] = '';
}

/* POST */
$post['user_email'] = short_check(get_args('user_email'));
if (!$post['user_email']) {
    echo "<a href='modules.php?app=forgot'>" . $m_langpackage->m_mail_null . "</a>";
    exit;
}
if (!$e_email->check_email_address($post['user_email'])) {
    echo "<a href='modules.php?app=forgot'>" . $m_langpackage->m_email_type_notine . "</a>";
    exit;
}
if (strtolower(short_check(get_args('veriCode'))) != strtolower(get_session('verifyCode'))) {
    action_return(1, $m_langpackage->m_verifycode_error, 'modules.php?app=forgot');
}

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

/* 定义文件表 */
$t_users = $tablePreStr . "users";
$t_mailtpl = $tablePreStr . "mailtpl";

$sql = "select user_id,user_name from `$t_users` where user_email='$post[user_email]'";
$row = $dbo->getRow($sql);
$post['user_name'] = $row['user_name'];

if ($row) {
    $sql = "select * from `$t_mailtpl` where tpl_id=1";
    $mail_row = $dbo->getRow($sql);

    $send_time = $ctime->long_time();
    $user_id = $row['user_id'];
    $post['forgot_check_code'] = md5($post['user_name'] . $post['user_email'] . time());
    $forgot_check_code_url = $baseUrl . "modules.php?app=user_forgot&uid=" . $user_id . "&ucode=" . $post['forgot_check_code'];

    $mailtitle = str_replace('{site_name}', $SYSINFO['sys_name'], $mail_row['tpl_title']);
    $mailtitle = iconv('UTF-8', 'GBK', $mailtitle);

    $arr1 = array('{user_name}', '{forgot_check_code_url}', '{send_date}');
    $arr2 = array($post['user_name'], $forgot_check_code_url, $send_time);
    $mailbody = str_replace($arr1, $arr2, $mail_row['tpl_content']);
    $mailbody = iconv('UTF-8', 'GBK', $mailbody);

    $smtp = new smtp($SYSINFO['sys_smtpserver'], $SYSINFO['sys_smtpserverport'], true, $SYSINFO['sys_smtpuser'], $SYSINFO['sys_smtppass']);
    $smtp->sendmail($post['user_email'], $SYSINFO['sys_smtpusermail'], $mailtitle, $mailbody, 'HTML');

    $sql = "update $t_users set forgot_check_code='" . $post['forgot_check_code'] . "' where user_id='$user_id'";
    $dbo->exeUpdate($sql);
}
$nav_selected = '1';
?>