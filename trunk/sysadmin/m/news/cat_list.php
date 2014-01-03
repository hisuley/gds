<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_news.php");

//引入语言包
$a_langpackage=new adminlp;

//$cat_id = intval(get_args('id'));
$orderby = short_check(get_args('orderby'));
//数据表定义区
//$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_article_cat` where 1 ";
$result = $dbo->fetch_page($sql,13);
/* 处理系统分类 */
$sql_cat = "select * from `$t_article_cat`";
if($orderby) {
	$sql_cat .= " order by $orderby";
} else {
    $sql_cat .= " order by cat_id asc,sort_order asc";
}
$result_cat = $dbo->getRs($sql_cat);

$cat_dg = get_dg_category($result_cat);
require ("a/updateJsAjax.php");
//$cat_info = get_news_cat_list($dbo,$t_article_cat);
//print_r($cat_info);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<?php  include("a/updateJsAjax.php");?>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
#divname{float:left; margin:0px;}
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_content;?> &gt;&gt; <?php echo $a_langpackage->a_news_category; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_news_category; ?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=news_catadd"><?php echo $a_langpackage->a_category_add; ?></a></span></h3>
    <div class="content2">

		<form action="a.php?act=news_catdel" name="form1" id="form1" method="post">
		<table class="list_table">
		  <thead>
			<tr style=" text-align:center">
				<th width="30px"><input type="checkbox" onclick="checkall(this,'cat_id[]');" value='' /></th>
				<th width="60px">ID <a href="m.php?app=news_catlist&orderby=cat_id">↑</a></th>
				<th width="" align="left"><?php echo $a_langpackage->a_category_name; ?> <a href="m.php?app=news_catlist&orderby=cat_name">↑</a></th>
				<th width="80px"><?php echo $a_langpackage->a_type; ?></th>
				<th width="60px"><?php echo $a_langpackage->a_sort; ?> <a href="m.php?app=news_catlist&orderby=sort_order">↑</a></th>
				<th width="60px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($cat_dg) {
			foreach($cat_dg as $value) { ?>
			<tr style=" text-align:center">
				<td width="30px"><input type="checkbox" name="cat_id[]" value="<?php echo $value['cat_id'];?>" <?php if($value['parent_id']==-1){echo "disabled"; }?>/></td>
				<td width="30px"><?php echo $value['cat_id'];?></td>
				<td align="left" <?php if(in_array($value['parent_id'],array(0,-1))) {echo 'style="font-weight:bold;"';} ?>>
				<div>
				    <div id="divname"><?php echo $value['str_pad'];?>&nbsp;</div>
				    <div id="divname" onclick="edit(this,<?php echo $value['cat_id'];?>,'divname<?php echo $value['cat_id'];?>','a.php?act=updateAjax','tablename=shop_categories&colname=cat_name&idname=cat_id&idvalue=<?php echo $value['cat_id'];?>&logcontent=<?php echo $a_langpackage->a_edit_category; ?>：&colvalue=',5);"><a href="m.php?app=news_list&id=<?php echo $value['cat_id'];?>"><?php echo $value['cat_name'];?></a></div>
				    <div id="divname" style="display:none"></div>
				</div>
                                 </td>
				<td width="80px"><?php if($value['parent_id']==-1){echo $a_langpackage->a_sys_type;}else{echo $a_langpackage->a_cus_type;}?></td>
				<td width="60px"><div onclick="edit(this,<?php echo $value['cat_id'];?>,'divlink<?php echo $value['cat_id'];?>','a.php?act=updateAjax','tablename=article_cat&colname=sort_order&idname=cat_id&idvalue=<?php echo $value['cat_id'];?>&logcontent=修改新闻分类排序&colvalue=',5);"><?php echo $value['sort_order'];?></div>
				<div style="displya:none";></div></td>
				<td width="60px">
					<a href="m.php?app=news_catedit&id=<?php echo $value['cat_id'];?>"><?php echo $a_langpackage->a_update; ?></a>
					<?php if($value['parent_id']!=-1){?>
					<a href="a.php?act=news_catdel&id=<?php echo $value['cat_id'];?>" onclick="return confirm('<?php echo $a_langpackage->a_del_all_catlist; ?>');"><?php echo $a_langpackage->a_delete; ?></a>
					<?php }?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="6">
					<span class="button-container"><input class="regular-button" type="submit" name=""  onclick="return delcheck();" value="<?php echo $a_langpackage->a_batch_del; ?>" /></span>
				</td>
			</tr>
			<?php } else { ?>
			<tr>
				<td colspan="6" class="center"><?php echo $a_langpackage->a_nonews_list; ?>!</td>
			</tr>
			<?php } ?>
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
function toggle_show(obj,id) {
	var re = /yes/i;
	var src = obj.src;
	var isshow = 1;
	var sss = src.search(re);
	if(sss > 0) {
		isshow = 0;
	}
	ajax("a.php?act=news_isshow_toggle","POST","id="+id+"&s="+isshow,function(data){
		if(data) {
			obj.src = '../skin/default/images/'+data+'.gif';
		}
	});
}
var inputs = document.getElementsByTagName("input");

function delcheck(){
	var checked = false; 
    for (var i = 0; i < inputs.length; i++) 
    { 
    	if (inputs[i].checked == true) 
        {
            checked = true;
            if(confirm('<?php echo $a_langpackage->a_exe_message; ?>')){
            	break; 
                }else{
                	return false;
                	break; 
                    }
        }  
    } 
    if (!checked) 
    { 
        ShowMessageBox("请至少选择一个标题！",'0'); 
        return false; 
    }
    return true;
}
//-->
</script>
</body>
</html>