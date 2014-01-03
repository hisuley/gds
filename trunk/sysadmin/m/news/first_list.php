<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_news.php");

//引入语言包
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("news_show");
$cat_id = intval(get_args('id'));
$orderby = short_check(get_args('orderby'));
if ($cat_id){
	if(!$right){
		header('location:m.php?app=error');
	}
}
//数据表定义区
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_article` where is_audit=0";
if($cat_id) {
	$sql .= " and cat_id='$cat_id' ";
}
if($orderby) {
	$sql .= " order by $orderby";
}else {
    $sql .= " order by add_time desc";
}
$result = $dbo->fetch_page($sql,13);
$cat_info = get_news_cat_list($dbo,$t_article_cat);
//新闻分类
$sql_cat = "select * from `$t_article_cat` order by cat_id asc,sort_order asc";
$cat_list = $dbo->getRs($sql_cat);
$cat_dg = get_dg_category($cat_list);
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
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_content;?> &gt;&gt; <a href=""><?php echo $a_langpackage->a_news_first_list; ?></a></div>
        <hr />
        <div class="seachbox">
        <div class="content2">
        	<form action="m.php?app=news_first_list" name="searchForm" method="get">
            	<table class="form-table">
	            	<tbody>
	            	<tr>
	                   	<td width="240px">
	                   		<img src="skin/images/icon_search.gif" border="0" alt="SEARCH" />
	                   		<?php echo $a_langpackage->a_news_category; ?>：
	                   		<select name="id">
								<option value="0"><?php echo $a_langpackage->a_select_news_category; ?></option>
								<?php foreach($cat_dg as $value) { ?>
								<option value="<?php echo $value['cat_id']; ?>" <?php if($cat_id==$value['cat_id']){echo "selected";} ?> ><?php echo $value['str_pad'];?><?php echo $value['cat_name'];?></option>
								<?php } ?>
							</select>
	                   	</td>
	                   	<td><input type="hidden" name="app" value="news_first_list"><input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_serach;?>" /></td>
	                </tr>
                </tbody>
            </table>
           </form>
        </div>
    </div>
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_news_first_list; ?></span></h3>
    <div class="content2">
		<form action="a.php?act=news_del" name="form1" id="form1" method="post">
		<input type="hidden" id="show_right" value="<?php echo $right;?>">
		<table class="list_table"  style="table-layout:fixed;">
        	<thead>
			<tr style="text-align:center">
				<th width="40px">ID <a href="m.php?app=news_first_list&orderby=article_id">↑</a></th>
				<th align="left" width="150px"><?php echo $a_langpackage->a_news_title; ?> <a href="m.php?app=news_first_list&orderby=title">↑</a></th>
				<th align="left" width="110px"><?php echo $a_langpackage->a_news_category; ?> <a href="m.php?app=news_first_list&orderby=cat_id">↑</a></th>
				<th width="40px"><?php echo $a_langpackage->a_news_alinks; ?></th>
				<th width="300px" align="left"><?php echo $a_langpackage->a_news_links_url; ?></th>
				<th width="36px"><?php echo $a_langpackage->a_show; ?></th>
				<th width="189px"><?php echo $a_langpackage->a_add_time; ?></th>
                                <th width="60px"><?php echo $a_langpackage->a_title_desc; ?> <a href="m.php?app=news_first_list&orderby=short_order">↑</a></th>
				<th width="80px"><?php echo $a_langpackage->a_audit_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style="text-align:center">
				<td><?php echo $value['article_id'];?></td>
				<td class="limit" align="left">
					<?php if($value['is_blod'] && $value['tag_color']) { ?>
						<span><a href="m.php?app=news_edit&id=<?php echo $value['article_id'];?>" style="color:<?php echo $value['tag_color'];?>"><b><?php echo $value['title'];?></b></a></span>
					<?php } else if($value['is_blod']) { ?>
						<span><a href="m.php?app=news_edit&id=<?php echo $value['article_id'];?>"><b><?php echo $value['title'];?></b></a></span>
					<?php } else if($value['tag_color']) { ?>
						<span><a href="m.php?app=news_edit&id=<?php echo $value['article_id'];?>" style="color:<?php echo $value['tag_color'];?>"><?php echo $value['title'];?></a></span>
					<?php }else {?>
						<span><a href="m.php?app=news_edit&id=<?php echo $value['article_id'];?>"><?php echo $value['title'];?></a></span>
					<?php } ?>
				</td>
				<td align="left"><a href="m.php?app=news_list&id=<?php echo $value['cat_id'];?>"><?php echo $cat_info[$value['cat_id']]['cat_name'];?></a></td>
				<?php echo $value['is_link'] ? '<td class="center green">'.$a_langpackage->a_yes.'</td>' : '<td class="center red">'.$a_langpackage->a_no.'</td>';?>
				<td align="left"><?php echo $value['link_url'];?></td>
				<td>
					<?php if($value['is_show']) { ?>
					<img src="../skin/default/images/yes.gif" onclick="toggle_show(this,'<?php echo $value['article_id']; ?>')" />
					<?php } else { ?>
					<img src="../skin/default/images/no.gif" onclick="toggle_show(this,'<?php echo $value['article_id']; ?>')" />
					<?php } ?>
				</td>
				<td><?php echo $value['add_time'];?></td>
                                <td><div onclick="edit(this,<?php echo $value['article_id'];?>,'divlink<?php echo $value['article_id'];?>','a.php?act=updateAjax','tablename=article&colname=short_order&idname=article_id&idvalue=<?php echo $value['article_id'];?>&logcontent=修改新闻标题排序&colvalue=',5);"><?php echo $value['short_order'];?></div>
				<div style="displya:none";></div></td>
				<td>
					<a href="a.php?act=news_audit&audit=1&id=<?php echo $value['article_id'];?>"><?php echo $a_langpackage->a_news_audit_true; ?></a><br />
					<a href="m.php?app=news_audit_false&audit=2&id=<?php echo $value['article_id'];?>"><?php echo $a_langpackage->a_news_audit_false; ?></a>
				</td>
			</tr>
			<?php }?>
			<?php } else { ?>
			<tr>
				<td colspan="8" class="center"><?php echo $a_langpackage->a_nonews_list; ?>!</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="8" class="center"><?php include("m/page.php"); ?></td>
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
function toggle_show(obj,id) {
	var rights=document.getElementById("show_right").value;
	if(rights != '0'){
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
	}else{
		ShowMessageBox("<?php echo $a_langpackage->a_privilege_mess;?>",'0');
		location.href="m.php?app=error";
	}
}
//-->
</script>
</body>
</html>