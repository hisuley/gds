<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_shop_category.php");

//引入语言包
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("shop_categories");
if (!$right){
	header('location:m.php?app=error');
	exit;
}
$right_update=check_rights("cat_update");
//数据表定义区
$t_shop_categories = $tablePreStr."shop_categories";

$cat_name = get_args('cat_name');
$orderby = short_check(get_args('orderby'));
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

/* 处理系统分类 */
$sql_category = "select * from `$t_shop_categories` where 1=1";

if($cat_name) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}
	$sql_category .= " and cat_name like '%$cat_name%' ";
}
if($orderby) {
	$sql_category .= " order by $orderby";
}else {
        $sql_category .= " order by sort_order asc,cat_id asc";
}
$result_category = $dbo->getRs($sql_category);

$category_dg = get_dg_category($result_category);
require ("a/updateJsAjax.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
#divname{float:left; margin:0px;}
</style>
</head>
<body>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>" ></input>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_suppliers_mengament;?> &gt;&gt;  <?php echo $a_langpackage->a_suppliers_categorys ?></div>
        <hr />
        <div class="seachbox">
            <div class="content2">
                    <form action="m.php?app=suppliers_categories_list" name="searchForm" method="get">
                <table class="form-table" style='font-size:14px;'>
                    <tbody>
                    <tr>
                            <td width="10px">
                                    <span style="margin:1px -5px 0px 0px; float:right; color: #000" >
                                            <img src="skin/images/icon_search.gif" border="0" alt="SEARCH" />
                                    </span>
                            </td>
                        <td>
                            <?php echo $a_langpackage->a_category_name;?>: <input type="text" class="small-text" name="cat_name" value="<?php echo $cat_name; ?>" style="width:100px" />
                              <input type="hidden" name="app" value="suppliers_categories_list" /><input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_serach;?>" />
                        </td>
                    </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_suppliers_categorys ?></span>
	<span class="right" style="margin-right:15px;"> 
	
	
	<a href="m.php?app=suppliers_categories_add" style="float:right;"><?php echo $a_langpackage->a_category_add; ?></a>
	
	<a href="m.php?app=suppliers_categories_import" style="float:right;"><?php echo $a_langpackage->a_suppliers_categories_import; ?>&nbsp;&nbsp;</a>
	
	<a href="m.php?app=suppliers_categories_export" style="float:right;"><?php echo $a_langpackage->a_suppliers_categories_export; ?>&nbsp;&nbsp;</a>
	</span></h3>
    <div class="content2">
		<table class="list_table" style='font-size:12px;'>
			<thead>
			<tr style=" text-align:center;">
				<th width="50px"><a href="m.php?app=suppliers_categories_list&orderby=cat_id">ID</a></th>
				<th align="left"><?php echo $a_langpackage->a_category_name; ?></th>
				<th width="65px"><?php echo $a_langpackage->a_shop_num; ?></th>
				<th width="65px"><a href="m.php?app=suppliers_categories_list&orderby=sort_order"><?php echo $a_langpackage->a_show_sort; ?></a></th>
				<th width="115px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($category_dg) {
			foreach($category_dg as $value) { ?>
			<tr style=" text-align:center;">
				<td><?php echo $value['cat_id'];?>.</td>
				<td align="left" <?php if($value['parent_id']=='0') {echo 'style="font-weight:bold;"';} ?>>
				<div>
				    <div id="divname"><?php echo $value['str_pad'];?>&nbsp;</div>
				    <div id="divname" onclick="edit(this,<?php echo $value['cat_id'];?>,'divname<?php echo $value['cat_id'];?>','a.php?act=updateAjax','tablename=shop_categories&colname=cat_name&idname=cat_id&idvalue=<?php echo $value['cat_id'];?>&logcontent=<?php echo $a_langpackage->a_edit_category; ?>：&colvalue=',5);"><?php echo $value['cat_name'];?></div>
				    <div id="divname" style="display:none"></div>
				</div>
				</td>
				<td><?php echo $value['shops_num'];?></td>
				<td><div onclick="editnum(this,<?php echo $value['cat_id'];?>,'divorder<?php echo $value['cat_id'];?>','a.php?act=updateAjax','tablename=shop_categories&colname=sort_order&idname=cat_id&idvalue=<?php echo $value['cat_id'];?>&logcontent=<?php echo $a_langpackage->a_edit_category; ?>：&colvalue=',2);"><?php echo $value['sort_order'];?></div>
				    <div style="display:none"></div>
				</td>
				<td>
					<a href="m.php?app=suppliers_categories_edit&id=<?php echo $value['cat_id'];?>"><?php echo $a_langpackage->a_update; ?></a>
					<a href="a.php?act=suppliers_categories_del&id=<?php echo $value['cat_id'];?>" onclick="return confirm('<?php echo $a_langpackage->a_del_category_prompt; ?>？');"><?php echo $a_langpackage->a_delete; ?></a>
				</td>
			</tr>
			<?php }} else { ?>
			<tr>
				<td colspan="6"><?php echo $a_langpackage->a_no_list; ?></td>
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