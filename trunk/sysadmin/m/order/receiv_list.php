<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
//require("../foundation/module_receiv.php");
//引入语言包
$a_langpackage = new adminlp;
//数据表定义区
$t_receiv_info = $tablePreStr . "receiv_list";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$payid = short_check(get_args('payid'));
$start_time = get_args('start_time');
$end_time = get_args('end_time');
$orderby = short_check(get_args('orderby'));
$orderway = short_check(get_args('orderway'));

$sql = "select * from `$t_receiv_info` where 1";
//权限管理
$right = check_rights("order_search");

if ($payid) {
    if (!$right) {
        header('location:m.php?app=error');
        exit;
    } else {
        $sql .= " and payid like '%$payid%'";
    }
}

if ($start_time) {
    if (!$right) {
        header('Location: m.php?app=error');
    } else {
        $sql .= " and receiv_date >= '$start_time' ";
    }
}
if ($end_time) {
    if (!$right) {
        header('Location: m.php?app=error');
    } else {
        $sql .= " and receiv_date  <= '$end_time' ";
    }
}
if ($orderby && $orderway) {
    $sql .= " order by $orderby $orderway";
} else {
    $sql .= " order by receiv_date desc;";
}
$result = $dbo->fetch_page($sql, 13);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href="skin/css/admin.css">
    <link rel="stylesheet" type="text/css" href="skin/css/main.css">
    <script type='text/javascript' src="skin/js/jy.js"></script>
    <script type='text/javascript' src='../servtools/date/WdatePicker.js'></script>
    <style>
        td span {
            color: red;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        .black {
            color: #cccccc;
        }
    </style>
</head>
<body>
<div id="maincontent">
    <?php include("messagebox.php"); ?>
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <a
                href=""><?php echo $a_langpackage->a_m_order_mengament; ?></a> &gt;&gt; <a
                href=""><?php echo $a_langpackage->a_receiv_list; ?></a></div>
        <hr/>
        <div class="seachbox">
            <div class="content2">
                <form action="m.php?app=order_receiv_list" name="searchForm" method="get">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td width="2px" style="padding:0 0 0 5px"><span
                                    style="margin:1px 0px 0px 0px; float:left; color: #000"> <img
                                        src="skin/images/icon_search.gif" border="0" alt="SEARCH"/> </span></td>
                            <td><?php echo $a_langpackage->a_receiv_payid; ?>：
                                <input class="small-text" type="text" name="payid" value="<?php echo $payid; ?>"
                                       style="width:120px"/>
                                <?php echo $a_langpackage->a_receiv_date; ?>：
                                <input class="Wdate" type="text" name="start_time" id="start_time"
                                       onFocus="WdatePicker({isShowClear:false,readOnly:true})"
                                       value="<?php echo $start_time; ?>"/><?php echo $a_langpackage->a_to; ?>


                                <input class="Wdate" type="text" name="end_time" id="end_time"
                                       onFocus="WdatePicker({isShowClear:false,readOnly:true})"
                                       value="<?php echo $end_time; ?>"/>
                                　<input class="regular-button" type="submit"
                                        value="<?php echo $a_langpackage->a_serach; ?>"/>
                                <input type="hidden" name="app" value="order_receiv_list">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="infobox">
            <h3><?php echo $a_langpackage->a_receiv_list; ?><span class="right" style="margin-right:15px;"><a
                        href="m.php?app=order_receiv_export"><?php echo $a_langpackage->a_receiv_export; ?></a></span>
            </h3>

            <div class="content2">
                <table class="list_table">
                    <thead>
                    <tr style=" text-align:center">
                        <th width="40px">ID <a href="m.php?app=order_receiv_list&orderby=receiv_id&orderway=asc">↑</a><a
                                href="m.php?app=order_receiv_list&orderby=receiv_id&orderway=desc">↓</a></th>
                        <th width="100px"><?php echo $a_langpackage->a_orderID; ?> <a
                                href="m.php?app=order_receiv_list&orderby=order_id&orderway=asc">↑</a><a
                                href="m.php?app=order_receiv_list&orderby=order_id&orderway=desc">↓</a></th>
                        <th width="100px"><?php echo $a_langpackage->a_receiv_payid; ?> <a
                                href="m.php?app=order_receiv_list&orderby=payid&orderway=asc">↑</a><a
                                href="m.php?app=order_receiv_list&orderby=payid&orderway=desc">↓</a></th>
                        <th width="90px"><?php echo $a_langpackage->a_payment_type; ?> <a
                                href="m.php?app=order_receiv_list&orderby=payment_type&orderway=asc">↑</a><a
                                href="m.php?app=order_receiv_list&orderby=payment_type&orderway=desc">↓</a></th>
                        <th width="120px"><?php echo $a_langpackage->a_pay_date; ?></th>
                        <th width="40px"><?php echo $a_langpackage->a_receiver; ?></th>
                        <th width="120px"><?php echo $a_langpackage->a_receiv_date; ?> <a
                                href="m.php?app=order_receiv_list&orderby=receiv_date&orderway=asc">↑</a><a
                                href="m.php?app=order_receiv_list&orderby=receiv_date&orderway=desc">↓</a></th>
                        <th width="150px"><?php echo $a_langpackage->a_receiv_account; ?></th>
                        <th width="60px"><?php echo $a_langpackage->a_receiv_money; ?> <a
                                href="m.php?app=order_receiv_list&orderby=receiv_money&orderway=asc">↑</a><a
                                href="m.php?app=order_receiv_list&orderby=receiv_money&orderway=desc">↓</a></th>
                        <th width="40px"><?php echo $a_langpackage->a_operator; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($result['result']) {
                        foreach ($result['result'] as $value) {
                            ?>
                            <tr style=" text-align:center">
                                <td><?php echo $value['receiv_id']; ?></td>
                                <td><font size="-6"><?php echo $value['order_id']; ?></font></td>
                                <td><font size="-6"><?php echo $value['payid']; ?></font></td>
                                <td><?php echo $value['payment_type']; ?></td>
                                <td><?php echo $value['pay_date']; ?></td>
                                </td>
                                <td><?php echo $value['receiver']; ?><br/>
                                <td><?php echo $value['receiv_date']; ?><br/></td>
                                <td><?php echo $value['receiv_account']; ?><br/></td>
                                <td><?php echo $value['receiv_money']; ?><br/></td>
                                <td><?php echo $value['operator']; ?><br/></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="11"><?php echo $a_langpackage->a_no_list; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="11"><?php include("m/page.php"); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>