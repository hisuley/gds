<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}


require_once("../foundation/module_category.php");
$a_langpackage = new adminlp;

//数据表定义区
$t_attribute = $tablePreStr . "attribute";
$t_category = $tablePreStr . "category";
$t_goods = $tablePreStr . "goods";
$t_shop_info = $tablePreStr . "shop_info";
$t_goods_attr = $tablePreStr . "goods_attr";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);
$cat_ids = get_top_category($dbo, $t_category);
$sql = "select attr_id,cat_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_attribute` where attr_name = '编号' AND cat_id IN(" . implode(',', $cat_ids) . ")";
$result = $dbo->getRs($sql);
$arrIds = array();
foreach ($result as $v) {
    array_push($arrIds, $v['attr_id']);
}

$sql = "SELECT a.*, b.attr_name, c.goods_name, c.goods_id, d.shop_name FROM $t_goods_attr as a left join $t_attribute as b on a.attr_id = b.attr_id left join $t_goods as c on c.goods_id = a.goods_id left join $t_shop_info as d on d.shop_id = c.shop_id WHERE a.attr_id IN(" . implode(',', $arrIds) . ") ";
$k = short_check(get_args('k'));
if (!empty($k)) {
    $sql .= " AND (a.attr_values LIKE '%$k%' OR c.goods_name LIKE '%$k%')";
}
$orderby = short_check(get_args('orderby'));
$orderway = short_check(get_args('orderway'));
if (!empty($orderby) && !empty($orderway)) {
    $sql .= " ORDER BY " . $orderby . " " . $orderway;
}
$result = $dbo->getRs($sql);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>线路编号管理</title>
    <link rel="stylesheet" type="text/css" href="skin/css/admin.css">
    <link rel="stylesheet" type="text/css" href="skin/css/main.css">
    <input type="hidden" name="attr_add" value="<?php echo $right_array['attr_add']; ?>">
    <input type="hidden" name="attr_append" value="<?php echo $right_array['attr_append']; ?>">
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

        td textarea {
            width: 95%;
            height: 42px;
            font-size: 12px;
        }

        td .inputtext {
            width: 120px;
        }
    </style>
    <script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>

</head>
<body>
<div id="maincontent">
    <?php include("messagebox.php"); ?>
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?>
            &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management; ?>
            &gt;&gt; <?php echo $a_langpackage->a_travel_number_management; ?></div>
        <hr/>
        <div class="infobox">
            <h3><?php echo $a_langpackage->a_attr_list; ?></h3>

            <div class="content2">
                <div class="oprate" style="height:50px;line-height:50px;"><span style="float:left;margin-left:25px;">
                    <form method="get" action="m.php?app=travel_number">
                        关键词：
                        <input type="hidden" name="app" value="travel_number"/>
                        <input type="text" name="k" value="<?php echo $k; ?>"/>
                        <input type="submit" value="搜索"/>
                    </form>

                </div>
                <table class="content" id="attr_table">
                    <thead>
                    <tr>
                        <th width="60px" align='center'>ID <a
                                href="m.php?app=travel_number&orderby=a.goods_attr_id&orderway=asc">↑</a><a
                                href="m.php?app=travel_number&orderby=a.goods_attr_id&orderway=desc">↓</a></th>
                        <th width="80px" align='center'>线路编号 <a
                                href="m.php?app=travel_number&orderby=a.attr_values&orderway=asc">↑</a><a
                                href="m.php?app=travel_number&orderby=a.attr_values&orderway=desc">↓</a></th>

                        <th width="150px" align='center'>商品名称</th>
                        <th width="60px" align='center'>企业</th>

                        <th width="175px" align="center"><?php echo $a_langpackage->a_operate; ?></th>
                    </tr>
                    </thead>
                    <tbody id="attr_tbody">

                    <?php
                    if (!empty($result)) {
                        foreach ($result as $v) {
                            echo "<tr>";
                            echo "<td align='center'>" . $v['goods_attr_id'] . "</td>";
                            echo "<td align='center'>" . $v['attr_values'] . "</td>";
                            echo "<td align='center'>" . $v['goods_name'] . "</td>";
                            echo "<td align='center'>" . $v['shop_name'] . "</td>";
                            echo "<td align='center'>";
                            echo "<a href='" . $SYSINFO['web'] . "goods.php?id=" . $v['goods_id'] . "'>查看</a>";
                            echo "</td>";
                        }
                    }
                    ?>

                    </tbody>
                </table>
                <table class="content">
                    <tr>
                        <td>&nbsp;<?php echo $a_langpackage->a_attr_remark; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>