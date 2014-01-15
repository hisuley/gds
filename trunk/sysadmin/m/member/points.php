<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require("../foundation/asystem_info.php");
require("../foundation/module_setting.php");
//引入语言包
$a_langpackage = new adminlp;

$t_settings = $tablePreStr . "settings";

/*数据处理 */
dbtarget('r', $dbServs);
$dbo = new dbex;

$sql = "select * from `$t_settings`";
$result = $dbo->getRs($sql);
if ($result) {
    foreach ($result as $v) {
        $SYSINFO[$v['variable']] = $v['value'];
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href="skin/css/admin.css">
    <link rel="stylesheet" type="text/css" href="skin/css/main.css">
    <style type="text/css">
        td span {
            color: red;
        }

    </style>
</head>
<div id="maincontent">
    <?php include("messagebox.php"); ?>
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?>
            &gt;&gt; <?php echo $a_langpackage->a_m_member_oprate; ?> &gt;&gt; <a
                href=""><?php echo $a_langpackage->a_m_member_points_set; ?></a></div>
        <hr/>
        <div class="infobox">
            <form action="a.php?act=member_points_update" method="post">
                <h3><?php echo $a_langpackage->a_m_member_points_set; ?></h3>

                <div class="content2">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th><?php echo $a_langpackage->a_registered_presented_integral; ?>：</th>
                            <td><input class="small-text" type="text" name="sysinfo[reg_points]"
                                       value="<?php echo $SYSINFO['reg_points']; ?>"
                                       style="width:200px;"/><?php echo $a_langpackage->a_give_specified_points; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $a_langpackage->a_perfect_information_presented_integral; ?>：</th>
                            <td><input class="small-text" type="text" name="sysinfo[info_points]"
                                       value="<?php echo $SYSINFO['info_points']; ?>"
                                       style="width:200px;"/><?php echo $a_langpackage->a_give_specified_points; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $a_langpackage->a_binding_email_presented_integral; ?>：</th>
                            <td><input class="small-text" type="text" name="sysinfo[email_points]"
                                       value="<?php echo $SYSINFO['email_points']; ?>"
                                       style="width:200px;"/><?php echo $a_langpackage->a_give_specified_points; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $a_langpackage->a_binding_phone_presented_integral; ?>：</th>
                            <td><input class="small-text" type="text" name="sysinfo[phone_points]"
                                       value="<?php echo $SYSINFO['phone_points']; ?>"
                                       style="width:200px;"/><?php echo $a_langpackage->a_give_specified_points; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $a_langpackage->a_integral_rmb_rate; ?>：</th>
                            <td><input type="text" class="small-text" name="sysinfo[points_rate]"
                                       value="<?php echo $SYSINFO['points_rate']; ?>" style="width:35px;"/> ：<input
                                    type="text" class="small-text" name="sysinfo[rmb_rate]"
                                    value="<?php echo $SYSINFO['rmb_rate']; ?>"
                                    style="width:35px;"/>（<?php echo $a_langpackage->a_integral_rmb_rate_mess; ?>）
                            </td>
                        </tr>
                        <tr>
                            <th>积分使用时间段：</th>
                            <td><input type="text" class="small-text" name="sysinfo[points_rate_start]"
                                       value="<?php echo $SYSINFO['points_rate_start']; ?>" style="width:100px;"/> 至
                                <input type="text" class="small-text" name="sysinfo[points_rate_end]"
                                       value="<?php echo $SYSINFO['points_rate_end']; ?>" style="width:100px;"/>（留空则为不限制）
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th></th>
                            <td><span class="button-container"><input type="submit" class="regular-button" name="submit"
                                                                      value="<?php echo $a_langpackage->a_update_points_set; ?>"/></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            </form>
        </div>
    </div>
</div>

</div>
</body>
</html>