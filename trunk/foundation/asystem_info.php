<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

/* 默认配置系统信息 */
$SYSINFO['sys_name'] = 'GDS';
$SYSINFO['sys_title'] = 'GDS';
$SYSINFO['sys_keywords'] = 'GDS';
$SYSINFO['sys_description'] = 'GDS';
$SYSINFO['sys_company'] = '桂林旅游局';
$SYSINFO['sys_copyright'] = 'Copyright © 2013-2013';
$SYSINFO['sys_icp'] = '桂ICP备01000010号';
$SYSINFO['sys_registerinfo'] = '';
$SYSINFO['sys_kftelphone'] = '0531-';
$SYSINFO['sys_kfqq'] = '';
$SYSINFO['email_send'] = 'false';
$SYSINFO['sys_smtpserver'] = 'mail.qq.com';
$SYSINFO['sys_smtpserverport'] = '25';
$SYSINFO['sys_smtpusermail'] = '';
$SYSINFO['sys_smtpuser'] = '';
$SYSINFO['sys_smtppass'] = '';
$SYSINFO['session'] = 'dms_';
$SYSINFO['lp'] = 'zh';
$SYSINFO['web'] = 'http://localhost/gds/';
$SYSINFO['url_r'] = 'false';
$SYSINFO['im_enable'] = 'false';
$SYSINFO['seller_page'] = '10';
$SYSINFO['search_page'] = '10';
$SYSINFO['product_page'] = '10';
$SYSINFO['article_page'] = '10';
$SYSINFO['height1'] = '84';
$SYSINFO['width1'] = '84';
$SYSINFO['height2'] = '300';
$SYSINFO['width2'] = '300';
$SYSINFO['templates'] = 'default';
$SYSINFO['template_mode'] = 'debug';
$SYSINFO['offline'] = 'true';
$SYSINFO['off_info'] = '站点维护中。。。';
$SYSINFO['timezone'] = '8';
$SYSINFO['sys_countjs'] = '';
$SYSINFO['map'] = 'false';
$SYSINFO['map_key'] = '';
$SYSINFO['sys_logo'] = '';
$SYSINFO['sys_domain'] = '0';
$SYSINFO['sys_smtptest'] = '';
$SYSINFO['version'] = 'v1.2';
$SYSINFO['verifycode'] = 'a:4:{i:1;s:1:"0";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"0";}';
$SYSINFO['site_domain'] = '.dms.com';
if (file_exists($webRoot . "/cache/setting.php")) {
    include($webRoot . "/cache/setting.php");
}
?>