<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require("../foundation/module_category.php");
require("../foundation/module_brand.php");
$t_category = $tablePreStr . "category";
$t_brand_attr = $tablePreStr . "brand_attr";
//引入语言包
$a_langpackage = new adminlp;

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

$info = array(
    'brand_name' => '',
    'brand_desc' => '',
    'site_url' => '',
    'is_show' => 1
);

$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc";
$result_category = $dbo->getRs($sql_category);
$category_dg = get_dg_category($result_category);
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
            &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management; ?>
            &gt;&gt; <?php echo $a_langpackage->a_brand_add; ?></div>
        <hr/>
        <div class="infobox">
            <h3><span class="left"><?php echo $a_langpackage->a_brand_add; ?></span> <span class="right"
                                                                                           style=" margin-right:15p;"><a
                        href="m.php?app=goods_brand_list"><?php echo $a_langpackage->a_brand_list; ?></a>&nbsp;&nbsp;</span>
            </h3>

            <div class="content2">
                <form action="a.php?act=goods_brand_add" method="post" onsubmit="return checkform();"
                      enctype="multipart/form-data">
                    <table class="form-table">
                        <tr>
                            <td width="63px;"><?php echo $a_langpackage->a_brand_name; ?>：</td>
                            <td><input class="small-text" type="text" name="brand_name"
                                       value="<?php echo $info['brand_name']; ?>"/> <span>*</span></td>
                        </tr>
                        <tr>
                            <td width="63px;"><?php echo $a_langpackage->a_scenic_type; ?>：</td>
                            <td class="attr_class" id="attr_content_type"></td>
                        </tr>
                        <tr>
                            <td width="63px;"><?php echo $a_langpackage->a_scenic_rank; ?>：</td>
                            <td class="attr_class" id="attr_content_rank"></td>
                        </tr>
                        <tr>
                            <td width="63px;"><?php echo $a_langpackage->a_scenic_area; ?>：</td>
                            <td class="attr_class" id="attr_content_area"></td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_brand_desc; ?>：</td>
                            <td><textarea name="brand_desc"
                                          style="width:200px; height:50px;"><?php echo $info['brand_desc']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_brand_siteurl; ?>：</td>
                            <td><input class="small-text" type="text" name="site_url"
                                       value="<?php echo $info['site_url']; ?>"/></td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_brand; ?>logo：</td>
                            <td><input type="file" name="logo[]"/></td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_linke_category ?>：</td>
                            <td>
                                <select name="cat_id[]" id="cat_id" multiple
                                        style="width:190px; height:300px; overflow:auto;">
                                    <?php foreach ($category_dg as $value) { ?>
                                        <option
                                            value="<?php echo $value['cat_id']; ?>"><?php echo $value['str_pad']; ?><?php echo $value['cat_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <span id="ucate_add"><a href="javascript:;"
                                                        onclick="showinput();"><?php echo "添加自定义分类"; ?></a></span>
                            </td>
                        </tr>
                        <tr id="ucate_span" style="display:none;">
                            <td><?php echo $a_langpackage->a_linke_category ?>：</td>
                            <td>
                                <select name="parent_id">
                                    <option value="0"><?php echo $a_langpackage->a_top_category; ?></option>
                                    <?php foreach ($category_dg as $value) { ?>
                                        <option
                                            value="<?php echo $value['cat_id']; ?>"><?php echo $value['str_pad']; ?><?php echo $value['cat_name']; ?></option>
                                    <?php } ?>
                                </select>&nbsp;&nbsp;
                                <?php echo $a_langpackage->a_category_name; ?>：<input type="text" name="name"
                                                                                      class="small-text"/>&nbsp;&nbsp;<input
                                    type="button" value="增加" onclick="addnewucat();"/>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $a_langpackage->a_news_isshow; ?>：</td>
                            <td><input type="checkbox" name="is_show" value="1" <?php if ($info['is_show']) {
                                    echo "checked";
                                } ?> /><?php echo $a_langpackage->a_show; ?> </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="button-container"><input class="regular-button" type="submit" name="submit"
                                                                      value="<?php echo $a_langpackage->a_brand_add; ?>"/></span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script>
    function checkform() {
        var type_name = document.getElementsByName('brand_name')[0];
        var site_url = document.getElementsByName('site_url')[0];
        var checkfiles = new RegExp("((^http)|(^https)|(^ftp)):\/\/(\\w)+\.(\\w)+");
        if (site_url.value != '') {
            if (!checkfiles.test(site_url.value)) {
                ShowMessageBox("<?php echo $a_langpackage->a_brand_site_url_error; ?>", '0');
                return false;
            }
        }
        if (type_name.value == '') {
            ShowMessageBox("<?php echo $a_langpackage->a_brand_name_notnone; ?>", '0');
            return false;
        }
        return true;
    }
    function showinput() {
        var ucate_add = document.getElementById("ucate_add");
        var ucate_span = document.getElementById("ucate_span");
        ucate_add.style.display = 'none';
        ucate_span.style.display = '';
    }

    function addnewucat() {
        var ucat_input = document.getElementsByName("name")[0];
        var parent_id = document.getElementsByName("parent_id")[0];
        var cat_id = document.getElementsByName("cat_id[]")[0];
        v = ucat_input.value;
        if (v == '') {
            alert("<?php echo "请输入分类名称！"; ?>");
            return false;
        } else {
            ajax("a.php?act=brand_add", "POST", "ucat_input=" + v + "&id=" + parent_id.value, function (data) {
                if (data != '0') {
                    var newoption = document.createElement("option");
                    newoption.value = data;
                    newoption.selected = 'selectes';
                    newoption.innerHTML = v;
                    cat_id.appendChild(newoption);
                    alert("<?php echo "添加成功"; ?>");
                    document.getElementsByName("name")[0].value == "";
                } else {
                    alert("<?php echo "添加失败"; ?>");
                }
            }, 'JSON');
            hideinput();
        }
    }
    function hideinput() {
        var ucate_add = document.getElementById("ucate_add");
        var ucate_span = document.getElementById("ucate_span");
        ucate_add.style.display = '';
        ucate_span.style.display = 'none';
    }

    changeAttr('类型');
    changeAttr('级别');
    changeAttr('区域');
    function changeAttr(value) {
        ajax("a.php?act=brand_attr_list", "POST", "v=" + value, function (data) {
            changeAttrTr(data);
        }, 'JSON');
    }

    function changeAttrTr(objvalue) {
        var type = '';
        if (objvalue.attr_name == '类型') {
            type = 'type';
        } else if (objvalue.attr_name == '级别') {
            type = 'rank';
        } else if (objvalue.attr_name == '区域') {
            type = 'area';
        }
        var attr_content = document.getElementById("attr_content_" + type);
        attr_content.innerHTML = '';
        var html = '';
        var temp = '';
        temp = formatFormElement(objvalue.brand_attr_id, objvalue.input_type, objvalue.attr_name, objvalue.attr_values, type);
        html += '<span>' + temp + '</span><div class="clear"></div></div>';

        attr_content.innerHTML = html;

    }
    //属性input类型 0:TEXT,1:SELECT,2:radio,3:checkbox
    function formatFormElement(id, type, name, value, types) {
        var optionValue;
        var cValue = str = '';
        //if(goodsAttr[id]) {
        //cValue = goodsAttr[id];
        //}
        if (type == 0) {
            str = '<input type="text" name="' + types + '" value="' + cValue + '" maxlength="200" />';
        } else if (type == 1 && value != '') {
            optionValue = value.split("\n");
            str = '<select name="' + types + '">';
            str += '<option value="0"><?php echo $a_langpackage->a_please_select; ?>' + name + '</option>';
            for (var i = 0; i < optionValue.length; i++) {
                if (optionValue[i] == cValue) {
                    str += '<option value="' + optionValue[i] + '" selected>' + optionValue[i] + '</option>';
                } else {
                    str += '<option value="' + optionValue[i] + '">' + optionValue[i] + '</option>';
                }
            }
            str += '</select>';
        } else if (type == 2 && value != '') {
            optionValue = value.split("\r\n");
            for (var i = 0; i < optionValue.length; i++) {
                if (optionValue[i] == cValue) {
                    str += '<input type="radio" name="' + types + '" value="' + optionValue[i] + '" checked />' + optionValue[i] + ' ';
                } else {
                    str += '<input type="radio" name="' + types + '" value="' + optionValue[i] + '" />' + optionValue[i] + ' ';
                }
            }
        } else if (type == 3 && value != '') {
            var regv = cValue.replace(/[\r\n]/g, "|");
            if (regv) {
                var re = new RegExp("((" + regv + ")|([^\r\n]+))[\r\n]*", "g");
            } else {
                var re = new RegExp("((iwebshop)|([^\r\n]+))[\r\n]*", "g");
            }
            var str = value.replace(re, "<input type='radio' name='" + types + "' value='$1' checked$3 />$1");
        } else if (type == 4) {
            str = '<textarea name="' + types + '" id="attr_text_area" cols="65" rows="10">' + cValue + '</textarea>';
        }
        return str;
    }
</script>
</body>
</html>