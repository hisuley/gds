<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require('foundation/asession.php');
require('configuration.php');
require('includes.php');
require("foundation/fstring.php");
$notCheckArray = array('user_forgot', 'reg', 'reg2', 'reg3', 'forgot', 'forgot2', 'forgot3', 'email_verify', 'send_code', 'contrast', 'chanage_email');
if (!in_array(get_args('app'), $notCheckArray)) {
    /* modules 公共信息处理 */
    require 'foundation/alogin_cookie.php';
    $user_id = get_sess_user_id();
    $shop_id = get_sess_shop_id();
    $user_name = get_sess_user_name();
    $email_check = get_sess_email_check();
    $privilege = get_sess_privilege();
    /* 判断用户是否登陆 */
    if (!$user_id) {
        $outuserid = get_args('outuserid') ? get_args('outuserid') : '0';
        $url = urlencode($_SERVER['REQUEST_URI']);

        echo "<script>location.href='login.php?outuserid=$outuserid&url=$url'</script>";
        exit;
    }
    // 判断是否通过Email验证
    if (!$email_check) {
        //echo '<script language="JavaScript">location.href="modules.php?app=reg2"</script>';
        //exit;
    }

    $user_privilege = '';
    if ($privilege) {
        $user_privilege = unserialize($privilege);

    }


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
}

//当前可访问的应用工具
$appArray = array(
    'start' => 'modules/start.php',
    'message' => 'modules/message.php',
    'chanage_email' => 'modules/chanage_email.php',

    'user_profile' => 'modules/user/profile.php',
    'user_passwd' => 'modules/user/passwd.php',
    'user_forgot' => 'modules/user/forgot.php',
    'user_safe' => 'modules/user/safe.php',
    'user_ico' => 'modules/user/ico.php',

    'user_cart' => 'modules/user/cart.php',
    'user_my_order' => 'modules/user/my_order.php',
    'user_favorite' => 'modules/user/favorite.php',
    'user_comment' => 'modules/user/comment.php',
    'user_guestbook' => 'modules/user/guestbook.php',
    'user_account_add' => 'modules/user/account_add.php',
    'user_account_minus' => 'modules/user/account_minus.php',
    'user_account_today' => 'modules/user/account_today.php',
    'user_point' => 'modules/user/point.php',
    'user_point_today' => 'modules/user/point_today.php',
    'user_order' => 'modules/user/order.php',
    'user_order_adress' => 'modules/user/order_adress.php',
    'user_order_groupbuy' => 'modules/user/order_groupbuy.php',
    'user_order_view' => 'modules/user/order_view.php',
    'user_order_success' => 'modules/user/order_success.php',
    'user_address' => 'modules/user/address.php',
    'user_payment_message' => 'modules/user/payment_message.php',
    'user_remind' => 'modules/user/remind.php',
    'user_remind_info' => 'modules/user/remind_info.php',
    'user_group' => 'modules/user/group.php',
    'user_complaint' => 'modules/user/complaint.php',
    'user_plugin' => 'modules/user/plugin.php',
    'user_rss' => 'modules/user/rss.php',
    //维权
    'user_protect_rights' => 'modules/user/protect_rights.php',

    'shop_create_notice' => 'modules/shop/create_notice.php',
    'shop_create' => 'modules/shop/create.php',
    'shop_info' => 'modules/shop/info.php',
    'shop_honor' => 'modules/shop/honor.php',
    'shop_notice' => 'modules/shop/notice.php',
    'shop_category' => 'modules/shop/category.php',
    'shop_category_add' => 'modules/shop/category_add.php',
    'shop_category_edit' => 'modules/shop/category_edit.php',
    'shop_onsale' => 'modules/shop/onsale.php',
    'shop_notonsale' => 'modules/shop/notonsale.php',
    'shop_guestbook' => 'modules/shop/guestbook.php',
    'shop_askprice' => 'modules/shop/askprice.php',
    'shop_my_order' => 'modules/shop/my_order.php',
    'shop_order_view' => 'modules/shop/order_view.php',
    'shop_payment' => 'modules/shop/payment.php',
    'shop_payment_edit' => 'modules/shop/payment_edit.php',
    'shop_payment_add' => 'modules/shop/payment_add.php',
    'shop_request' => 'modules/shop/request.php',
    'shop_seller_r' => 'modules/shop/seller_reply.php',
    'shop_rate' => 'modules/shop/rate.php',
    'shop_rate_r' => 'modules/shop/rate_reply.php',
    'shop_credit_add' => 'modules/shop/credit_add.php',
    'shop_askprice_r' => 'modules/shop/askprice_reply.php',
    //退款
    'shop_back_money' => 'modules/shop/back_money.php',
    //维权
    'shop_protect_rights' => 'modules/shop/protect_rights.php',
    //确定收款
    'shop_sure_recevi' => 'modules/shop/sure_recevi.php',
    //收款单
    'shop_receiv_list' => 'modules/shop/receiv_list.php',
    //退款单
    'shop_refund_list' => 'modules/shop/refund_list.php',
    //发货单
    'shop_shipping_list' => 'modules/shop/shipping_list.php',
    //收款单导出
    'shop_receiv_export' => 'modules/shop/receiv_export.php',
    //发货单导出
    'shop_shipping_export' => 'modules/shop/shipping_export.php',
    //查看发货单
    'shop_shipping_view' => 'modules/shop/shipping_view.php',
    //打印发货单
    'shop_shipping_print' => 'modules/shop/shipping_print.php',

    'goods_list' => 'modules/goods/list.php',
    'goods_add' => 'modules/goods/add.php',
    'goods_edit' => 'modules/goods/edit.php',
    'goods_type' => 'modules/goods/type.php',
    'goods_gallery' => 'modules/goods/gallery.php',
    'csv_export' => 'modules/goods/csv_export.php',
    'csv_import' => 'modules/goods/csv_import.php',
    'goods_csv_taobao' => 'modules/goods/csv_taobao.php',
    'add_transport_template' => 'modules/goods/add_transport_template.php',
    'edit_transport_template' => 'modules/goods/edit_transport_template.php',
    'contrast' => 'modules/goods/contrast.php',

    'groupbuy_list' => 'modules/groupbuy/list.php',
    'groupbuy_add' => 'modules/groupbuy/add.php',
    'groupbuy_login' => 'modules/groupbuy/login.php',

    'promote_list' => 'modules/promote/list.php',
    'promote_add' => 'modules/promote/add.php',
    'promote_login' => 'modules/promote/login.php',

    'reg' => 'modules/reg/register.php',
    'reg2' => 'modules/reg/register2.php',
    'reg3' => 'modules/reg/register3.php',
    'forgot' => 'modules/reg/forgot.php',
    'forgot2' => 'modules/reg/forgot2.php',
    'forgot3' => 'modules/reg/forgot3.php',
    'email_verify' => 'modules/reg/email_verify.php',
    'send_code' => 'modules/reg/send_code.php',
    'upload_form' => 'modules/pubtools/upload.form.php',

    'set_username' => 'modules/reg/set_username.php',
    'shop_message' => 'shop/shopMessage.php',
    'user_group_order_address' => 'modules/user/group_order_address.php',
    'csv_taobao_img' => 'modules/goods/csv_taobao_img.php',

    'shop_delivery_add' => 'modules/shop/delivery_add.php',
    'user_photo_view' => 'modules/user/photo_view.php',
);
if (!isset($_GET['app'])) {
    $_GET['app'] = "start";
}
$appId = getAppId();
$apptarget = $appArray[$appId];
if (isset($apptarget)) {
    require($apptarget);
} else {
    echo 'no pages!';
}
?>