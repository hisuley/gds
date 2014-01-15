<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require("../foundation/module_distributor.php");

//引入语言包
$a_langpackage = new adminlp;

//权限管理
$right = check_rights("distributor");
if (!$right) {
    header('location:m.php?app=error');
    exit;
}
$right_update = check_rights("distributor_update");
//数据表定义区
$t_distributor = $tablePreStr . "distributor";

$distributor_name = get_args('distributor_name');
$orderby = short_check(get_args('orderby'));
$orderway = short_check(get_args('orderway'));
//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

/* 查询政策通知列表 */
$sql = "select * from `$t_distributor` where 1=1";

if ($distributor_name) {
    //权限管理
    $right = check_rights("shop_search");
    if (!$right) {
        header('location:m.php?app=error');
    }
    $sql .= " and distributor_name like '%$distributor_name%' ";
}
if ($orderby && $orderway) {
    $sql .= " order by $orderby $orderway";
} else {
    $sql .= " order by sort_order";
}
$result = $dbo->getRs($sql);

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

        #divname {
            float: left;
            margin: 0px;
        }
    </style>
</head>
<body>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>"></input>

<div id="maincontent">
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?>
            &gt;&gt; <?php echo $a_langpackage->a_m_suppliers_mengament; ?>
            &gt;&gt;  <?php echo $a_langpackage->a_distributor_management ?></div>
        <hr/>
        <div class="seachbox">
            <div class="content2">
                <form action="m.php?app=distributor_list" name="searchForm" method="get">
                    <table class="form-table" style='font-size:14px;'>
                        <tbody>
                        <tr>
                            <td width="10px">
                                    <span style="margin:1px -5px 0px 0px; float:right; color: #000">
                                            <img src="skin/images/icon_search.gif" border="0" alt="SEARCH"/>
                                    </span>
                            </td>
                            <td>
                                <?php echo $a_langpackage->a_distributor_name; ?>: <input type="text" class="small-text"
                                                                                          name="distributor_name"
                                                                                          value="<?php echo $distributor_name; ?>"
                                                                                          style="width:100px"/>
                                <input type="hidden" name="app" value="distributor_list"/><input class="regular-button"
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
            <h3><span class="left"><?php echo $a_langpackage->a_distributor_list ?></span>
	<span class="right" style="margin-right:15px;"> 
	<a href="m.php?app=distributor_add" style="float:right;"><?php echo $a_langpackage->a_distributor_add; ?></a>
	</span></h3>

            <div class="content2">
                <table class="list_table" style='font-size:12px;'>
                    <thead>
                    <tr style=" text-align:center;">
                        <th width="50px">ID <a
                                href="m.php?app=distributor_list&orderby=distributor_id&orderway=asc">↑</a><a
                                href="m.php?app=distributor_list&orderby=distributor_id&orderway=desc">↓</a></th>
                        <th align="left"><?php echo $a_langpackage->a_distributor_name; ?> <a
                                href="m.php?app=distributor_list&orderby=distributor_name&orderway=asc">↑</a><a
                                href="m.php?app=distributor_list&orderby=distributor_name&orderway=desc">↓</a></th>
                        <th width="65px"><?php echo $a_langpackage->a_show_sort; ?> <a
                                href="m.php?app=distributor_list&orderby=sort_order&orderway=asc">↑</a><a
                                href="m.php?app=distributor_list&orderby=sort_order&orderway=desc">↓</a></th>
                        <th width="115px"><?php echo $a_langpackage->a_operate; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($result) {
                        foreach ($result as $value) {
                            ?>
                            <tr style=" text-align:center;">
                                <td><?php echo $value['distributor_id']; ?>.</td>
                                <td align="left"><?php echo $value['distributor_name']; ?></td>
                                <td>
                                    <div
                                        onclick="editnum(this,<?php echo $value['distributor_id']; ?>,'divorder<?php echo $value['distributor_id']; ?>','a.php?act=updateAjax','tablename=distributor&colname=sort_order&idname=distributor_id&idvalue=<?php echo $value['distributor_id']; ?>&logcontent=<?php echo $a_langpackage->a_distributor_edit; ?>：&colvalue=',2);"><?php echo $value['sort_order']; ?></div>
                                    <div style="display:none"></div>
                                </td>
                                <td>
                                    <a href="m.php?app=distributor_edit&id=<?php echo $value['distributor_id']; ?>"><?php echo $a_langpackage->a_update; ?></a>
                                    <a href="a.php?act=distributor_del&id=<?php echo $value['distributor_id']; ?>"
                                       onclick="return confirm('<?php echo $a_langpackage->a_distributor_del_mess; ?>');"><?php echo $a_langpackage->a_delete; ?></a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5"><?php echo $a_langpackage->a_no_list; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>