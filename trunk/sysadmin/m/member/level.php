<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("../foundation/module_users.php");
//引入语言包
$a_langpackage = new adminlp;

//数据表定义区
$t_user_level = $tablePreStr . "user_level";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$sql = "select * from `$t_user_level`";

$result = $dbo->fetch_page($sql, 13);

$right_array = array(
    "user_level_edit" => "0",
    "user_level_del" => "0",
);
foreach ($right_array as $key => $value) {
    $right_array[$key] = check_rights($key);
}
// require ("a/updateJsAjax.php");
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
    <?php include("a/updateJsAjax.php"); ?>
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
    </style>
</head>
<body>
<div id="maincontent">

    <?php include("messagebox.php"); ?>
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?>
            &gt;&gt; <?php echo $a_langpackage->a_m_member_oprate; ?>
            &gt;&gt; <?php echo $a_langpackage->a_m_user_level_list ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_m_user_level_list ?></span><span class="right"
                                                                                                 style="margin-right:15px;"><a
                        href="m.php?app=member_level_add"
                        style="float: right;"><?php echo $a_langpackage->a_user_level_add ?></a></span></h3>

            <div class="content2">
                <form action="a.php?act=member_rank_del" method="post">
                    <table class="list_table">
                        <thead>
                        <tr style="text-align:center;">
                            <th width="20px" class="center"><input type="checkbox" onclick="checkall(this,'rank_id[]');"
                                                                   value=''/></th>
                            <th width="30px"><?php echo $a_langpackage->a_ID ?></th>
                            <th width="90px" align="left"><?php echo $a_langpackage->a_user_level_name ?></th>
                            <th width="120px"><?php echo $a_langpackage->a_user_level_points ?></th>
                            <th width="120px"><?php echo $a_langpackage->a_shop_time ?></th>
                            <th width="120px"><?php echo $a_langpackage->a_operate ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($result['result']) {
                        foreach ($result['result'] as $value) {
                        ?>
                        <tr style="text-align:center;">
                            <td><input type="checkbox" name="level_id[]" value="<?php echo $value['level_id']; ?>"/>
                            </td>
                            <td><?php echo $value['level_id']; ?></td>
                            <td align="left">
                                <div
                                    onclick="edit(this,<?php echo $value['level_id']; ?>,'divlink<?php echo $value['level_id']; ?>','a.php?act=updateAjax','tablename=user_level&colname=level_name&idname=level_id&idvalue=<?php echo $value['level_id']; ?>&logcontent=修改会员等级名称&colvalue=',20);"><?php echo $value['level_name']; ?></div>
                                <div style="displya:none"
                                ;>
            </div>
            </td>
            <td><?php echo $value['pointBegin']; ?> ～ <?php echo $value['pointEnd']; ?></td>
            <td><?php echo $value['level_created']; ?></td>
            <td class="center">
                <a href="m.php?app=member_level_edit&id=<?php echo $value['level_id']; ?>"><?php echo $a_langpackage->a_update ?></a>
                <a href="a.php?act=member_level_del&id=<?php echo $value['level_id']; ?>"
                   onclick="return confirm('<?php echo $a_langpackage->a_message_del ?>');"><?php echo $a_langpackage->a_delete ?></a>
            </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="6"><span class="button-container"><input class="regular-button" type="submit" name=""
                                                                      onclick="return delcheck();"
                                                                      value="<?php echo $a_langpackage->a_batch_del ?>"/></span>
                </td>
            </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="6"><?php echo $a_langpackage->a_no_list; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="6" class="center"><?php include("m/page.php"); ?></td>
            </tr>
            </tbody>
            </table>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    var inputs = document.getElementsByTagName("input");

    function delcheck() {
        var checked = false;
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked == true) {
                checked = true;
                if (confirm('<?php echo $a_langpackage->a_exe_message; ?>')) {
                    break;
                } else {
                    return false;
                    break;
                }
            }
        }
        if (!checked) {
            ShowMessageBox("请至少选择一个会员等级！", '0');
            return false;
        }
        return true;
    }
</script>
</body>
</html>