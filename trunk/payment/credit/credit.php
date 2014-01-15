<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
function get_code($orderinfo, $payinfo)
{
    // 获取支付配置信息
    global $baseUrl;
    $payment_info = unserialize($payinfo['pay_config']);
    $s_pass = $payment_info['key'];
    $s_srcStr = MD5($s_pass);
    unset($payinfo);
    unset($payment_info);
    header('Location: payrespond.php?credit_id=' . $orderinfo['payid'] . '&srcstr=' . $s_srcStr);
}

function respond($orderinfo, $payinfo)
{

    global $baseUrl;
    global $dbServs;
    $srcstr = get_args('srcstr');
    $payment_info = unserialize($payinfo['pay_config']);
    $r_pass = $payment_info['key'];
    $r_srcstr = MD5($r_pass);
    global $tablePreStr;
    $t_order_info = $tablePreStr . "order_info";
    $userid = get_sess_user_id();
    //print_r($r_srcstr."  <br />".$srcstr);
    dbtarget('r', $dbServs);
    $dbo = new dbex();
    $check_order = "SELECT * FROM `$t_order_info` WHERE `order_id` = " . $orderinfo['order_id'];
    $check_order_result = $dbo->getRow($check_order);
    if ($check_order_result['pay_status'] == 1) {
        return 0;
    }

    if ($r_srcstr == $srcstr) {

        if ($userid) {
            dbtarget('r', $dbServs);
            $dbo = new dbex();

            $t_settings = $tablePreStr . "settings";
            $t_points = $tablePreStr . "user_point";

            $sql = "select * from `$t_settings`";
            $result = $dbo->getRs($sql);
            if ($result) {
                foreach ($result as $v) {
                    $SYSINFO[$v['variable']] = $v['value'];
                }
            }
            $rate = intval($SYSINFO['points_rate'] / $SYSINFO['rmb_rate']);
            if (empty($rate)) {
                print_r($SYSINFO);
                return 0;
            }


            /* 处理系统分类 */
            $t_users = $tablePreStr . "users";
            $sql_users = "select user_integral_surplus from `$t_users` where `user_id` =" . $orderinfo['user_id'] . " limit 1";
            $user_info = $dbo->getRow($sql_users);
            // print_r($user_info);
            if ($userid == $orderinfo['user_id'] && $user_info['user_integral_surplus'] >= ($orderinfo['order_amount'] * $rate)) {

                $result = $user_info['user_integral_surplus'] - ($orderinfo['order_amount'] * $rate);
                dbtarget('w', $dbServs);
                $dbo = new dbex();
                $sql = "UPDATE `$t_users` SET `user_integral_surplus` = " . $result . " WHERE `user_id` =" . $orderinfo['user_id'] . " LIMIT 1";
                //print_r($sql);
                if ($dbo->exeUpdate($sql)) {
                    $sql = "INSERT INTO `$t_points`(user_id, point, add_time, admin_note, process_type) VALUES(" . $orderinfo['user_id'] . ", '" . ($orderinfo['order_amount'] * $rate) . "','" . date('Y-m-d H:i:s', strtotime('now')) . "','消费积分', '2')";
                    //print_r($sql);
                    if ($dbo->exeUpdate($sql)) {
                        return 1;
                    }
                    return 0;
                } else {
                    print_r($sql);
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}

?>