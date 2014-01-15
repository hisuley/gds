<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("../foundation/module_source.php");

//引入语言包
$a_langpackage = new adminlp;

//定义读操作
dbtarget('r', $dbServs);
$dbo = new dbex;

//数据表定义区
$t_article_source = $tablePreStr . "article_source";

$source_id = intval(get_args('id'));
if (!$source_id) {
    trigger_error($a_langpackage->a_error);
}

$row = get_source_info($dbo, $t_article_source, $source_id);

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
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_content; ?>
            &gt;&gt; <?php echo $a_langpackage->a_news_source_edit; ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_news_source_edit; ?></span> <span class="right"
                                                                                                  style="margin-right:15px;"><a
                        href="m.php?app=news_source_list"><?php echo $a_langpackage->a_news_source_list; ?></a></span>
            </h3>

            <div class="content2">
                <form action="a.php?act=news_source_edit" method="post" onsubmit="return checkForm();">
                    <table class="form-table">
                        <input type="hidden" name="source_id" value="<?php echo $source_id ?>"/>
                        <tr>
                            <td width="100px"><?php echo $a_langpackage->a_news_source_name; ?>：</td>
                            <td><input class="small-text" type="text" name="name" value="<?php echo $row['name'] ?>"
                                       style="width:200px;"/></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="button-container"><input class="regular-button" type="submit"
                                                                                  name="submit"
                                                                                  value="<?php echo $a_langpackage->a_news_source_edit; ?>"/></span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
    <!--
    function checkForm() {
        var title = document.getElementsByName("name")[0];

        if (title.value == '') {
            ShowMessageBox("<?php echo $a_langpackage->a_news_title_notnone; ?>", '0');
            title.focus();
            return false;
        }
        return true;
    }
    //-->
</script>
</body>
</html>