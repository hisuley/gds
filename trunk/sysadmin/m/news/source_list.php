<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require("../foundation/module_source.php");

//引入语言包
$a_langpackage = new adminlp;
//权限管理
$right = check_rights("news_source_show");

$name = short_check(get_args('name'));
$source_id = intval(get_args('source_id'));
$orderby = short_check(get_args('orderby'));
$orderway = short_check(get_args('orderway'));
if ($source_id) {
    if (!$right) {
        header('location:m.php?app=error');
    }
}
//数据表定义区
$t_article_source = $tablePreStr . "article_source";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$sql = "select * from `$t_article_source` where 1";

if ($name) {
    if (!$right) {
        header('location:m.php?app=error');
        exit;
    } else {
        $sql .= " and name like '%$name%' ";
    }
}
if ($orderby && $orderway) {
    $sql .= " order by $orderby $orderway";
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
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_content; ?>
            &gt;&gt; <a href=""><?php echo $a_langpackage->a_news_source_management; ?></a></div>
        <hr/>
        <div class="seachbox">
            <div class="content2">
                <form action="m.php?app=news_source_list" name="searchForm" method="get">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td width="240px">
                                <img src="skin/images/icon_search.gif" border="0" alt="SEARCH"/>
                                <?php echo $a_langpackage->a_news_source_name; ?>：
                                <input class="small-text" type="text" name="name" value="<?php echo $name; ?>"/>
                            </td>
                            <td><input type="hidden" name="app" value="news_source_list"><input class="regular-button"
                                                                                                type="submit"
                                                                                                value="<?php echo $a_langpackage->a_serach; ?>"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_news_source_list; ?></span><span class="right"
                                                                                                 style="margin-right:15px;"><a
                        href="m.php?app=news_source_add"><?php echo $a_langpackage->a_news_source_add; ?></a></span>
            </h3>

            <div class="content2">
                <form action="a.php?act=news_source_del" name="form1" id="form1" method="post">
                    <input type="hidden" id="show_right" value="<?php echo $right; ?>">
                    <table class="list_table" style="table-layout:fixed;">
                        <thead>
                        <tr style="text-align:center">
                            <th width="10%"><input type="checkbox" onclick="checkall(this,'source_id[]');" value=''/>
                            </th>
                            <th width="20%" align="left">ID <a
                                    href="m.php?app=news_source_list&orderby=source_id&orderway=asc">↑</a><a
                                    href="m.php?app=news_source_list&orderby=source_id&orderway=desc">↓</a></th>
                            <th align="left" width="50%"><?php echo $a_langpackage->a_news_source_name; ?> <a
                                    href="m.php?app=news_source_list&orderby=name&orderway=asc">↑</a><a
                                    href="m.php?app=news_source_list&orderby=name&orderway=desc">↓</a></th>
                            <th width="20%"><?php echo $a_langpackage->a_operate; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($result['result']) {
                            foreach ($result['result'] as $value) {
                                ?>
                                <tr style="text-align:center">
                                    <td><input type="checkbox" name="source_id[]"
                                               value="<?php echo $value['source_id']; ?>"/></td>
                                    <td align="left"><?php echo $value['source_id']; ?></td>
                                    <td class="limit" align="left">
                                        <span><a
                                                href="m.php?app=news_source_edit&id=<?php echo $value['source_id']; ?>"><?php echo $value['name']; ?></a></span>
                                    </td>
                                    <td>
                                        <a href="m.php?app=news_source_edit&id=<?php echo $value['source_id']; ?>"><?php echo $a_langpackage->a_update; ?></a>
                                        <a href="a.php?act=news_source_del&id=<?php echo $value['source_id']; ?>"
                                           onclick="return confirm('<?php echo $a_langpackage->a_message_del; ?>');"><?php echo $a_langpackage->a_delete; ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="9">
                                    <span class="button-container"><input class="regular-button" type="submit" name=""
                                                                          onclick="return delcheck();"
                                                                          value="<?php echo $a_langpackage->a_batch_del; ?>"/></span>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" class="center"><?php echo $a_langpackage->a_nonews_source_list; ?>!</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="9" class="center"><?php include("m/page.php"); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="color:red; display:none; width:270px; margin:5px auto;" id="ajaxmessageid">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $a_langpackage->a_loading; ?></div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
    <!--
    function toggle_show(obj, id) {
        var rights = document.getElementById("show_right").value;
        if (rights != '0') {
            var re = /yes/i;
            var src = obj.src;
            var isshow = 1;
            var sss = src.search(re);
            if (sss > 0) {
                isshow = 0;
            }
            ajax("a.php?act=news_isshow_toggle", "POST", "id=" + id + "&s=" + isshow, function (data) {
                if (data) {
                    obj.src = '../skin/default/images/' + data + '.gif';
                }
            });
        } else {
            ShowMessageBox("<?php echo $a_langpackage->a_privilege_mess;?>", '0');
            location.href = "m.php?app=error";
        }
    }
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
    //-->
</script>
</body>
</html>