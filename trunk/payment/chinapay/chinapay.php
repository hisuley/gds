<?php
<<<<<<< HEAD
if(!$IWEB_SHOP_IN) {
=======
if (!$IWEB_SHOP_IN) {
>>>>>>> remotes/origin/master
    die('Hacking attempt');
}

include_once("netpayclient.php");
include_once("netpayclient_config.php");

<<<<<<< HEAD
function get_code($orderinfo,$payinfo){
    // 获取支付配置信息
    global $baseUrl;

    $merid = buildKey(PRI_KEY);
    if(!$merid) {
=======
function get_code($orderinfo, $payinfo)
{
    // 获取支付配置信息

    $payment_info = unserialize($payinfo['pay_config']);
    $partner = $payment_info['partner'];
    $security_code = $payment_info['security_code'];
    $seller_email = $payment_info['seller_email'];
    $_input_charset = "utf-8";
    $sign_type = "MD5";
    $transport = "http";
    $notify_url = $baseUrl . "payrespond.php";
    $return_url = $baseUrl . "payrespond.php";
    $show_url = $orderinfo['show_url'];
    unset($payinfo);
    unset($payment_info);

    $parameter = array(
        "service" => "create_partner_trade_by_buyer",
        "partner" => $partner,
        "return_url" => $baseUrl . "payrespond.php",
        "notify_url" => $baseUrl . "payrespond.php",
        "_input_charset" => $_input_charset,
        "subject" => iconv("UTF-8", "GBK", $orderinfo['payid']),

        "body" => $orderinfo['message'],
        "out_trade_no" => $orderinfo['payid'],
        "price" => $orderinfo['order_amount'],
        "payment_type" => "1",
        "quantity" => "1",

        "logistics_fee" => '0.00',
        "logistics_payment" => 'BUYER_PAY',
        "logistics_type" => 'EXPRESS',

        "show_url" => $show_url,
        "seller_email" => $seller_email
    );


    global $baseUrl;
    $merid = buildKey(PRI_KEY);
    if (!$merid) {
>>>>>>> remotes/origin/master
        echo "无法建立";
        exit;
    }

    $ordid = $orderinfo['payid'];
    $transamt = formatamount($orderinfo['order_amount']);
    //»õ±Ò´úÂë£¬3Î»£¬¾³ÄÚÉÌ»§¹Ì¶¨Îª156£¬±íÊ¾ÈËÃñ±Ò£¬±ØÌî
    $curyid = "156";
    //¶©µ¥ÈÕÆÚ£¬±¾Àý²ÉÓÃµ±Ç°ÈÕÆÚ£¬±ØÌî
    $transdate = date('Ymd');
    //½»Ò×ÀàÐÍ£¬0001 ±íÊ¾Ö§¸¶½»Ò×£¬0002 ±íÊ¾ÍË¿î½»Ò×
    $transtype = "0001";
    //½Ó¿Ú°æ±¾ºÅ£¬¾³ÄÚÖ§¸¶Îª 20070129£¬±ØÌî
    $version = "20070129";
    //Ò³Ãæ·µ»ØµØÖ·(Äú·þÎñÆ÷ÉÏ¿É·ÃÎÊµÄURL)£¬×î³¤80Î»£¬µ±ÓÃ»§Íê³ÉÖ§¸¶ºó£¬ÒøÐÐÒ³Ãæ»á×Ô¶¯Ìø×ªµ½¸ÃÒ³Ãæ£¬²¢POST¶©µ¥½á¹ûÐÅÏ¢£¬¿ÉÑ¡
<<<<<<< HEAD
    $pagereturl = $baseUrl."payrespond.php?is_chinapay=1&pay_id=".$ordid;
    //ºóÌ¨·µ»ØµØÖ·(Äú·þÎñÆ÷ÉÏ¿É·ÃÎÊµÄURL)£¬×î³¤80Î»£¬µ±ÓÃ»§Íê³ÉÖ§¸¶ºó£¬ÎÒ·½·þÎñÆ÷»áPOST¶©µ¥½á¹ûÐÅÏ¢µ½¸ÃÒ³Ãæ£¬±ØÌî
    $bgreturl = $baseUrl."payrespond.php?is_chinapay=1&pay_id=".$ordid;

    /************************
    Ò³Ãæ·µ»ØµØÖ·ºÍºóÌ¨·µ»ØµØÖ·µÄÇø±ð£º
    ºóÌ¨·µ»Ø´ÓÎÒ·½·þÎñÆ÷·¢³ö£¬²»ÊÜÓÃ»§²Ù×÷ºÍä¯ÀÀÆ÷µÄÓ°Ïì£¬´Ó¶ø±£Ö¤½»Ò×½á¹ûµÄËÍ´ï¡£
=======
    $pagereturl = $baseUrl . "payrespond.php?is_chinapay=1&pay_id=" . $ordid;
    //ºóÌ¨·µ»ØµØÖ·(Äú·þÎñÆ÷ÉÏ¿É·ÃÎÊµÄURL)£¬×î³¤80Î»£¬µ±ÓÃ»§Íê³ÉÖ§¸¶ºó£¬ÎÒ·½·þÎñÆ÷»áPOST¶©µ¥½á¹ûÐÅÏ¢µ½¸ÃÒ³Ãæ£¬±ØÌî
    $bgreturl = $baseUrl . "payrespond.php?is_chinapay=1&pay_id=" . $ordid;

    /************************
     * Ò³Ãæ·µ»ØµØÖ·ºÍºóÌ¨·µ»ØµØÖ·µÄÇø±ð£º
     * ºóÌ¨·µ»Ø´ÓÎÒ·½·þÎñÆ÷·¢³ö£¬²»ÊÜÓÃ»§²Ù×÷ºÍä¯ÀÀÆ÷µÄÓ°Ïì£¬´Ó¶ø±£Ö¤½»Ò×½á¹ûµÄËÍ´ï¡£
>>>>>>> remotes/origin/master
     ************************/

    //Ö§¸¶Íø¹ØºÅ£¬4Î»£¬ÉÏÏßÊ±½¨ÒéÁô¿Õ£¬ÒÔÌø×ªµ½ÒøÐÐÁÐ±íÒ³ÃæÓÉÓÃ»§×ÔÓÉÑ¡Ôñ£¬±¾Ê¾ÀýÑ¡ÓÃ0001Å©ÉÌÐÐÍø¹Ø±ãÓÚ²âÊÔ£¬¿ÉÑ¡
    $gateid = "";
    //±¸×¢£¬×î³¤60Î»£¬½»Ò×³É¹¦ºó»áÔ­Ñù·µ»Ø£¬¿ÉÓÃÓÚ¶îÍâµÄ¶©µ¥¸ú×ÙµÈ£¬¿ÉÑ¡
<<<<<<< HEAD
    $priv1 = md5($ordid."feji293h23hr823hdjviubv3uh32ijf9i32jf3f");
=======
    $priv1 = "memo";
>>>>>>> remotes/origin/master

    //°´´ÎÐò×éºÏ¶©µ¥ÐÅÏ¢Îª´ýÇ©Ãû´®
    $plain = $merid . $ordid . $transamt . $curyid . $transdate . $transtype . $priv1;
    //Éú³ÉÇ©ÃûÖµ£¬±ØÌî
    $chkvalue = sign($plain);

<<<<<<< HEAD
    $post_string = 'MerId='.$merid.'&Version='.$version.'&OrdId='.$ordid.'&TransAmt='.$transamt.'&CuryId='.$curyid.'&TransDate='.$transdate.'&TransType='.$transtype.'&BgRetUrl='.$bgreturl.'&PageRetUrl='.$pagereturl.'&GateId='.$gateid.'&Priv1='.$priv1.'&ChkValue='.$chkvalue;
    //$data = request_by_curl(REQ_URL_PAY, $post_string);
    echo '<body onload="sub()">';
    echo '<form action='.REQ_URL_PAY.' method="post" name="form1">';
    echo '<input type="hidden" name="MerId" value='.$merid.' readonly/><br/>';
    echo '<input type="hidden" name="Version" value='.$version.' readonly/><br/>';
    echo '<input type="hidden" name="OrdId" value='.$ordid.' readonly/><br/>';
    echo '<input type="hidden" name="TransAmt" value='.$transamt.' readonly/><br/>';
    echo '<input type="hidden" name="CuryId" value='.$curyid.' readonly/><br/>';
    echo '<input type="hidden" name="TransDate" value='.$transdate.' readonly/><br/>';
    echo '<input type="hidden" name="TransType" value='.$transtype.' readonly/><br/>';
    echo '<input type="hidden" name="BgRetUrl" value='.$bgreturl.' /><br/>';
    echo '<input type="hidden" name="PageRetUrl" value='.$pagereturl.'/><br/>';
    echo '<input type="hidden" name="GateId" value='.$gateid.'/><br/>';
    echo '<input type="hidden" name="Priv1" value='.$priv1.' readonly/><br/>';
    echo '<input type="hidden" name="ChkValue" value='.$chkvalue.' readonly/><br/>';
=======
    $post_string = 'MerId=' . $merid . '&Version=' . $version . '&OrdId=' . $ordid . '&TransAmt=' . $transamt . '&CuryId=' . $curyid . '&TransDate=' . $transdate . '&TransType=' . $transtype . '&BgRetUrl=' . $bgreturl . '&PageRetUrl=' . $pagereturl . '&GateId=' . $gateid . '&Priv1=' . $priv1 . '&ChkValue=' . $chkvalue;
    //$data = request_by_curl(REQ_URL_PAY, $post_string);
    echo '<body onload="sub()">';
    echo '<form action=' . REQ_URL_PAY . ' method="post" name="form1">';
    echo '<input type="hidden" name="MerId" value=' . $merid . ' readonly/><br/>';
    echo '<input type="hidden" name="Version" value=' . $version . ' readonly/><br/>';
    echo '<input type="hidden" name="OrdId" value=' . $ordid . ' readonly/><br/>';
    echo '<input type="hidden" name="TransAmt" value=' . $transamt . ' readonly/><br/>';
    echo '<input type="hidden" name="CuryId" value=' . $curyid . ' readonly/><br/>';
    echo '<input type="hidden" name="TransDate" value=' . $transdate . ' readonly/><br/>';
    echo '<input type="hidden" name="TransType" value=' . $transtype . ' readonly/><br/>';
    echo '<input type="hidden" name="BgRetUrl" value=' . $bgreturl . ' /><br/>';
    echo '<input type="hidden" name="PageRetUrl" value=' . $pagereturl . '/><br/>';
    echo '<input type="hidden" name="GateId" value=' . $gateid . '/><br/>';
    echo '<input type="hidden" name="Priv1" value=' . $priv1 . ' readonly/><br/>';
    echo '<input type="hidden" name="ChkValue" value=' . $chkvalue . ' readonly/><br/>';
>>>>>>> remotes/origin/master
    echo '<input type="submit">';
    echo '</form>';
//echo '</body>';
}

<<<<<<< HEAD
function respond($orderinfo,$payinfo){
    global $baseUrl;
    $merid = get_args('merid');
    $orderno = get_args('orderno');
    $transdate = get_args('transdate');
    $amount = get_args('amount');
    $currencycode = get_args('currencycode');
    $transtype = get_args('transtype');
    $status = get_args('status');
    $checkvalue = get_args('checkvalue');
    $GateId = get_args('GateId');
    $Priv1 = get_args('Priv1');
    /*
    if(verifyTransResponse($merid,$orderno,$amount,$currencycode,$transdate,$transtype,$status,$checkvalue)){
        if($status == 1001){
            if($Priv1 == md5($orderinfo['payid']."feji293h23hr823hdjviubv3uh32ijf9i32jf3f")){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }else{
        return 0;
    }
    */
    return 1;
=======
function respond($orderinfo, $payinfo)
{

    global $baseUrl;
    //获取支付宝的反馈参数
    $dingdan = get_args('out_trade_no'); //获取订单号
    $total_fee = get_args('total_fee'); //获取总价格
    $receive_name = get_args('receive_name'); //获取收货人姓名
    $receive_address = get_args('receive_address'); //获取收货人地址
    $receive_zip = get_args('receive_zip'); //获取收货人邮编
    $receive_phone = get_args('receive_phone'); //获取收货人电话
    $receive_mobile = get_args('receive_mobile'); //获取收货人手机

    $payment_info = unserialize($payinfo['pay_config']);
    $partner = $payment_info['partner'];
    $security_code = $payment_info['security_code'];
    $seller_email = $payment_info['seller_email'];
    $_input_charset = "utf-8";
    $sign_type = "MD5";
    $transport = "http";
    $notify_url = $baseUrl . "payrespond.php";
    $return_url = $baseUrl . "payrespond.php";
    $show_url = $orderinfo['show_url'];
    unset($payinfo);
    unset($payment_info);

    if (isset($_POST['notify_id'])) {

        $alipay = new alipay_notify($partner, $security_code, $sign_type, $_input_charset, $transport);
        $verify_result = $alipay->notify_verify();

    } else {

        $alipay = new alipay_notify($partner, $security_code, $sign_type, $_input_charset, $transport);
        $verify_result = $alipay->return_verify();

    }

    if ($verify_result) { //认证合格

        if (get_args('trade_status') == 'WAIT_SELLER_SEND_GOODS') { //买家付款成功,等待卖家发货

            return 1;

        } else if (get_args('trade_status') == 'WAIT_BUYER_CONFIRM_GOODS') { //卖家已经发货等待买家确认

            return 2;

        } else if (get_args('trade_status') == 'TRADE_FINISHED' || get_args('trade_status') == 'TRADE_SUCCESS') { //交易成功结束

            return 3;

        } else {

            return 0;

        }

    } else {

        return 0;

    }
>>>>>>> remotes/origin/master

}

?>
<script>
    <!--
<<<<<<< HEAD
    function sub(){
        document.form1.submit();
    }
    setTimeout(sub,500);//以毫秒为单位的.1000代表一秒钟.根据你需要修改这个时间.
=======
    function sub() {
        document.form1.submit();
    }
    setTimeout(sub, 500);//以毫秒为单位的.1000代表一秒钟.根据你需要修改这个时间.
>>>>>>> remotes/origin/master
    //-->
</script>