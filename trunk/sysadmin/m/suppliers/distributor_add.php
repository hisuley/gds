<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_distributor.php");

//引入语言包
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("distributor_add");
if(!$right){
	header('location:m.php?app=error');
	exit;
}
//数据表定义区
$t_distributor = $tablePreStr."distributor";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$info = array(
	'distributor_name'		=> '',
	'distributor_intro'		=> '',
	'sort_order'	=> 0
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<style>
td span {color:red;}
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_suppliers_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_distributor_add; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_distributor_add; ?> </span><span class="right" style="margin-right:15px;"><a href="m.php?app=distributor_list" style="float:right;"><?php echo $a_langpackage->a_distributor_list; ?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=distributor_add" method="post" onsubmit="return checkform();">
		<table class="form-table">
		  <tbody>
			<tr>
				<td width="100px;"><?php echo $a_langpackage->a_distributor_name; ?>：</td>
				<td><input class="small-text" type="text" name="distributor_name" value="<?php echo $info['distributor_name']; ?>" /> <span>*</span></td>
			</tr>
                        <tr>
				<td valign="top"><?php echo $a_langpackage->a_distributor_intro; ?>：</td>
                                <td><textarea name="distributor_intro" cols="45" rows="5"><?php echo $info['distributor_intro']; ?></textarea></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_distributor_sort; ?>：</td>
				<td><input class="small-text" type="text" name="sort_order" value="<?php echo $info['sort_order']; ?>" style="width:60px" /></td>
			</tr>
			<tr>
				<td colspan="2">
				<span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_distributor_add; ?>" /></span>
				</td>
			</tr>
		  </tbody>
		</table>
		</form>
	  </div>
	 </div>
	</div>
</div>
<script>
function checkform() {
	var distributor_name = document.getElementsByName('distributor_name')[0];
	if(distributor_name.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_distributor_name_notnone; ?>",'0');
		return false;
	}
	return true;
}
</script>
</body>
</html>