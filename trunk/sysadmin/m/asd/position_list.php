<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入语言包
$a_langpackage = new adminlp;

$right = check_rights("adv_postion_update");

//数据表定义区
$t_asd_position = $tablePreStr . "asd_position";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$sql = "select * from `$t_asd_position`";
$sql .= " order by position_id asc";

$result = $dbo->fetch_page($sql, 13);
require("a/updateJsAjax.php");
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
<input type="hidden" id="update_right" value="<?php echo $right; ?>"></input>

<div id="maincontent">
    <?php include("messagebox.php"); ?>
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?>
            &gt;&gt; <?php echo $a_langpackage->a_promotion_manage; ?> &gt;&gt; <a
                href=""><?php echo $a_langpackage->a_asdposition_list; ?></a></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_asdposition_list; ?></span><span class="right"
                                                                                                 style="margin-right:15px;"> <a
                        href="m.php?app=asd_position_add"
                        style="float:right;"><?php echo $a_langpackage->a_add_asdposition; ?></a></span></h3>

            <div class="content2">
                <form action="a.php?act=asd_position_del" id="form1" method="post">
                    <table class="list_table" style="font-size: 12px;">
                        <thead>
                        <tr style=" text-align:center;">
                            <th width="20px"><input type="checkbox" onclick="checkall(this,'position_id[]');" value=''/>
                            </th>
                            <th width="20px">ID</th>
                            <th width="" align="left"><?php echo $a_langpackage->a_asdposition_name; ?></th>
                            <th width="85px" align="right"><?php echo $a_langpackage->a_asdposition_width; ?></th>
                            <th width=""></th>
                            <th width="85px" align="right"><?php echo $a_langpackage->a_asdposition_height; ?></th>
                            <th width=""></th>
                            <th align="left"><?php echo $a_langpackage->a_asdposition_desc; ?></th>
                            <th width="230px"><?php echo $a_langpackage->a_operate; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($result['result']) {
                            foreach ($result['result'] as $value) {
                                ?>
                                <tr style=" text-align:center;">
                                    <td><input type="checkbox" name="position_id[]"
                                               value="<?php echo $value['position_id']; ?>"/></td>
                                    <td><?php echo $value['position_id']; ?>.</td>
                                    <td align="left"><a
                                            href="m.php?app=asd_position_view&id=<?php echo $value['position_id']; ?>"
                                            target="_blank"><?php echo $value['position_name']; ?></a></td>
                                    <td align="right">
                                        <div
                                            onclick="edit(this,<?php echo $value['position_id']; ?>,'divwidth<?php echo $value['position_id']; ?>','a.php?act=updateAjax','tablename=asd_position&colname=asd_width&idname=position_id&idvalue=<?php echo $value['position_id']; ?>&logcontent=编辑广告位：&colvalue=',3);"><?php echo $value['asd_width']; ?></div>
                                        <div style="display:none"></div>
                                    </td>
                                    <td align="left">px</td>
                                    <td align="right">
                                        <div
                                            onclick="edit(this,<?php echo $value['position_id']; ?>,'divheight<?php echo $value['position_id']; ?>','a.php?act=updateAjax','tablename=asd_position&colname=asd_height&idname=position_id&idvalue=<?php echo $value['position_id']; ?>&logcontent=编辑广告位：&colvalue=',3);"><?php echo $value['asd_height']; ?></div>
                                        <div style="display:none"></div>
                                    </td>
                                    <td align="left">px</td>
                                    <td align="left">
                                        <div
                                            onclick="edit(this,<?php echo $value['position_id']; ?>,'divdesc<?php echo $value['position_id']; ?>','a.php?act=updateAjax','tablename=asd_position&colname=position_desc&idname=position_id&idvalue=<?php echo $value['position_id']; ?>&logcontent=编辑广告位：&colvalue=',8);"><?php echo $value['position_desc']; ?></div>
                                        <div style="display:none"></div>
                                    </td>
                                    <td>
                                        <a href="m.php?app=asd_position_edit&id=<?php echo $value['position_id']; ?>"><?php echo $a_langpackage->a_update; ?></a>
                                        <a href="a.php?act=asd_position_del&id=<?php echo $value['position_id']; ?>"
                                           onclick="return confirm('<?php echo $a_langpackage->a_del_all_positionlist; ?>');"><?php echo $a_langpackage->a_delete; ?></a>
                                        <a href="m.php?app=asd_add&pid=<?php echo $value['position_id']; ?>"><?php echo $a_langpackage->a_add_asd; ?></a>
                                        <a href="m.php?app=asd_position_view&id=<?php echo $value['position_id']; ?>"
                                           target="_blank"><?php echo $a_langpackage->a_view_asd; ?></a>
                                        <a href="m.php?app=asd_getcode&id=<?php echo $value['position_id']; ?>"><?php echo $a_langpackage->a_getjs_code; ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="7">
                                    <span class="button-container"><input class="regular-button" type='submit'
                                                                          onclick="return delcheck();" name=""
                                                                          value="<?php echo $a_langpackage->a_batch_del; ?>"/></span>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="7"><?php include("m/page.php"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="7">&nbsp;<?php echo $a_langpackage->a_asdposition_remark; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
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
            ShowMessageBox("请至少选择一个标题！", '0');
            return false;
        }
        return true;
    }
</script>
</body>
</html>