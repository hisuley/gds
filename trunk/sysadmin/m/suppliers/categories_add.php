<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require("../foundation/module_shop_category.php");
require("../foundation/module_brand.php");

//引入语言包
$a_langpackage = new adminlp;
//权限管理
$right = check_rights("categories_add");
if (!$right) {
    header('location:m.php?app=error');
    exit;
}
//数据表定义区
$t_shop_categories = $tablePreStr . "shop_categories";
$t_brand = $tablePreStr . "brand";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

/* 处理系统分类 */
$sql_category = "select * from `$t_shop_categories` order by sort_order asc,cat_id asc";
$result_category = $dbo->getRs($sql_category);

$category_dg = get_dg_category($result_category);

$info = array(
    'cat_name' => '',
    'parent_id' => 0,
    'sort_order' => 0,
    'commission_ratio' => ''
);
$sql = "SELECT * FROM $t_brand ";
$brand_list = $dbo->getRs($sql);
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
            &gt;&gt; <?php echo $a_langpackage->a_category_add; ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_category_add; ?> </span><span class="right"
                                                                                              style="margin-right:15px;"><a
                        href="m.php?app=suppliers_categories_list"
                        style="float:right;"><?php echo $a_langpackage->a_suppliers_list; ?></a></span></h3>

            <div class="content2">
                <form action="a.php?act=suppliers_categories_add" method="post" onsubmit="return checkform();">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td width="60px;"><?php echo $a_langpackage->a_parent_category; ?>：</td>
                            <td><select name="parent_id">
                                    <option value="0"><?php echo $a_langpackage->a_top_category; ?></option>
                                    <?php foreach ($category_dg as $value) { ?>
                                        <option
                                            value="<?php echo $value['cat_id']; ?>" <?php if ($value['cat_id'] == $info['parent_id']) echo "selected"; ?>><?php echo $value['str_pad']; ?><?php echo $value['cat_name']; ?></option>
                                    <?php } ?>
                                </select>&nbsp;&nbsp;&nbsp;(<?php echo $a_langpackage->a_five_category; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_category_name; ?>：</td>
                            <td><input class="small-text" type="text" name="cat_name"
                                       value="<?php echo $info['cat_name']; ?>"/> <span>*</span></td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_category_sort; ?>：</td>
                            <td><input class="small-text" type="text" name="sort_order"
                                       value="<?php echo $info['sort_order']; ?>" style="width:60px"/> <span>*</span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_suppliers_commission_ratio; ?>：</td>
                            <td><input class="small-text" type="text" name="commission_ratio"
                                       value="<?php echo $info['commission_ratio']; ?>" style="width:60px"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="button-container"><input class="regular-button" type="submit" name="submit"
                                                                      value="<?php echo $a_langpackage->a_category_add; ?>"/></span>
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
        var cat_name = document.getElementsByName('cat_name')[0];
        if (cat_name.value == '') {
            ShowMessageBox("<?php echo $a_langpackage->a_category_name_notnone; ?>", '0');
            return false;
        }
        return true;
    }
</script>
</body>
</html>