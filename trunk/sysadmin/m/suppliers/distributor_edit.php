<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require("../foundation/module_distributor.php");

//引入语言包
$a_langpackage = new adminlp;
//权限管理
$right = check_rights("notification_policy_edit");
if (!$right) {
    header('location:m.php?app=error');
    exit;
}
//数据表定义区
$t_distributor = $tablePreStr . "distributor";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$distributor_id = intval(get_args('id'));
if (!$distributor_id) {
    exit($a_langpackage->a_error);
}

/* 政策通知数据 */
$info = get_distributor_row($dbo, $t_distributor, $distributor_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href="skin/css/admin.css">
    <link rel="stylesheet" type="text/css" href="skin/css/main.css">
    <style>
        td span {
            color: red;
        }
    </style>
</head>
<body>
<div id="maincontent">
    <?php include("messagebox.php"); ?>
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?>
            &gt;&gt; <?php echo $a_langpackage->a_m_suppliers_mengament; ?>
            &gt;&gt; <?php echo $a_langpackage->a_distributor_edit; ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_distributor_edit; ?></span><span class="right"
                                                                                                 style="margin-right:15px;"><a
                        href="m.php?app=distributor_list"><?php echo $a_langpackage->a_distributor_list; ?></a></span>
            </h3>

            <div class="content2">
                <form action="a.php?act=distributor_edit" method="post" onsubmit="return checkform();">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td width="100px"><?php echo $a_langpackage->a_distributor_name; ?>：</td>
                            <td><input type="text" class="small-text" name="distributor_name"
                                       value="<?php echo $info['distributor_name']; ?>"/> <span>*</span></td>
                        </tr>
                        <tr>
                            <td valign="top"><?php echo $a_langpackage->a_distributor_intro; ?>：</td>
                            <td><textarea name="distributor_intro" cols="45"
                                          rows="5"><?php echo $info['distributor_intro']; ?></textarea> <span>*</span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_distributor_sort; ?>：</td>
                            <td><input type="text" class="small-text" name="sort_order"
                                       value="<?php echo $info['sort_order']; ?>" style="width:60px;"/> <span>*</span>
                            </td>
                        </tr>
                        <tr>
                            <input type="hidden" name="distributor_id" value="<?php echo $distributor_id; ?>">
                            <td colspan="2"><input type="submit" class="regular-button" name="submit"
                                                   value="<?php echo $a_langpackage->a_distributor_edit; ?>"/></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function checkform() {
        var distributor_name = document.getElementsByName('distributor_name')[0];
        if (distributor_name.value == '') {
            ShowMessageBox("<?php echo $a_langpackage->a_distributor_name_notnone; ?>", '0');
            return false;
        }
        return true;
    }
</script>
</body>
</html>