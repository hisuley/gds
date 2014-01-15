<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require("../foundation/module_notification_policy.php");

//引入语言包
$a_langpackage = new adminlp;
//权限管理
$right = check_rights("notification_policy_add");
if (!$right) {
    header('location:m.php?app=error');
    exit;
}
//数据表定义区
$t_shop_categories = $tablePreStr . "shop_categories";
$t_shop_request = $tablePreStr . "shop_request";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$sql_cat = "select * from `$t_shop_categories` order by cat_id asc,sort_order asc";
$result_cat = $dbo->getRs($sql_cat);

$cat_dg = get_dg_category($result_cat);

$sql = "SELECT user_id,company_name FROM `$t_shop_request`";
$suppliers = $dbo->getRs($sql);
$info = array(
    'policy_title' => '',
    'policy_content' => '',
    'sort_order' => 0,
    'shop_cat_id' => 0,
    'user_id' => 0,
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href="skin/css/admin.css">
    <link rel="stylesheet" type="text/css" href="skin/css/main.css">
    <script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
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
            &gt;&gt; <?php echo $a_langpackage->a_notification_policy_add; ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_notification_policy_add; ?> </span><span class="right"
                                                                                                         style="margin-right:15px;"><a
                        href="m.php?app=notification_policy_list"
                        style="float:right;"><?php echo $a_langpackage->a_notification_policy_list; ?></a></span></h3>

            <div class="content2">
                <form action="a.php?act=notification_policy_add" method="post" onsubmit="return checkform();">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td width="75px"><?php echo $a_langpackage->a_select_n_category; ?>：</td>
                            <td><select name="shop_cat_id">
                                    <option value="0"><?php echo $a_langpackage->a_select_n_category; ?></option>
                                    <option value="-1"><?php echo $a_langpackage->a_shop_lock_status_all; ?></option>
                                    <?php foreach ($cat_dg as $value) { ?>
                                        <option
                                            value="<?php echo $value['cat_id']; ?>" <?php if ($value['cat_id'] == $info['shop_cat_id']) {
                                            echo "selected";
                                        } ?> ><?php echo $value['str_pad']; ?><?php echo $value['cat_name']; ?></option>
                                    <?php } ?>
                                </select> <span id="position_id_message">*</span></td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_suppliers; ?>：</td>
                            <td><select name="user_id">
                                    <option value="0"><?php echo $a_langpackage->a_suppliers_select; ?></option>
                                    <?php foreach ($suppliers as $value) { ?>
                                        <option
                                            value="<?php echo $value['user_id']; ?>" <?php if ($value['user_id'] == $info['user_id']) {
                                            echo "selected";
                                        } ?> ><?php echo $value['company_name']; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $a_langpackage->a_notification_policy_name; ?>：</td>
                            <td><input class="small-text" type="text" name="policy_title"
                                       value="<?php echo $info['policy_title']; ?>"/> <span>*</span></td>
                        </tr>
                        <tr>
                            <td valign="top"><?php echo $a_langpackage->a_notification_policy_content; ?>：</td>
                            <td><textarea name="policy_content" cols="45"
                                          rows="5"><?php echo $info['policy_content']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_notification_policy_sort; ?>：</td>
                            <td><input class="small-text" type="text" name="sort_order"
                                       value="<?php echo $info['sort_order']; ?>" style="width:60px"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="button-container"><input class="regular-button" type="submit" name="submit"
                                                                      value="<?php echo $a_langpackage->a_notification_policy_add; ?>"/></span>
                            </td>
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
        var policy_title = document.getElementsByName('policy_title')[0];
        if (policy_title.value == '') {
            ShowMessageBox("<?php echo $a_langpackage->a_policy_title_notnone; ?>", '0');
            return false;
        }
        return true;
    }
</script>
</body>
</html>