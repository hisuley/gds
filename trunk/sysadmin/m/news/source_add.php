<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("../foundation/module_source.php");

//引入语言包
$a_langpackage = new adminlp;
//数据表定义区
$t_article_cat = $tablePreStr . "article_source";
//定义读操作
$dbo = new dbex;
dbtarget('r', $dbServs);

$info = array(
    'name' => '',
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
            &gt;&gt; <?php echo $a_langpackage->a_news_source_add; ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_news_source_add; ?></span> <span class="right"
                                                                                                 style="margin-right:15px;"><a
                        href="m.php?app=news_source_list"><?php echo $a_langpackage->a_news_source_list; ?></a></span>
            </h3>

            <div class="content2">
                <form action="a.php?act=news_source_add" method="post" onsubmit="return checkForm();">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td td width="100px;"><?php echo $a_langpackage->a_news_source_name; ?>：</td>
                            <td><input class="small-text" type="text" name="name" value="<?php echo $info['name']; ?>"/>
                                <span>*</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="button-container"><input class="regular-button" type="submit" name="submit"
                                                                      value="<?php echo $a_langpackage->a_news_source_add; ?>"/></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
    <!--
    function checkForm() {
        var name = document.getElementsByName("name")[0];

        if (name.value == '') {
            ShowMessageBox("<?php echo $a_langpackage->a_news_title_notnone; ?>", '0');
            return false;
        }
        return true;
    }
    //-->
</script>
</body>
</html>