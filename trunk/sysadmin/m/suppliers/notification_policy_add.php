<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_notification_policy.php");

//引入语言包
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("notification_policy_add");
if(!$right){
	header('location:m.php?app=error');
	exit;
}
//数据表定义区
$t_notification_policy = $tablePreStr."notification_policy";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$info = array(
	'policy_title'		=> '',
	'policy_content'		=> '',
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
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_suppliers_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_notification_policy_add; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_notification_policy_add; ?> </span><span class="right" style="margin-right:15px;"><a href="m.php?app=notification_policy_list" style="float:right;"><?php echo $a_langpackage->a_notification_policy_list; ?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=notification_policy_add" method="post" onsubmit="return checkform();">
		<table class="form-table">
		  <tbody>
			<tr>
				<td width="100px;"><?php echo $a_langpackage->a_notification_policy_name; ?>：</td>
				<td><input class="small-text" type="text" name="policy_title" value="<?php echo $info['policy_title']; ?>" /> <span>*</span></td>
			</tr>
                        <tr>
				<td valign="top"><?php echo $a_langpackage->a_notification_policy_content; ?>：</td>
                                <td><textarea name="policy_content" cols="45" rows="5"><?php echo $info['policy_content']; ?></textarea></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_notification_policy_sort; ?>：</td>
				<td><input class="small-text" type="text" name="sort_order" value="<?php echo $info['sort_order']; ?>" style="width:60px" /></td>
			</tr>
			<tr>
				<td colspan="2">
				<span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_notification_policy_add; ?>" /></span>
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
	var policy_title = document.getElementsByName('policy_title')[0];
	if(policy_title.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_policy_title_notnone; ?>",'0');
		return false;
	}
	return true;
}
</script>
</body>
</html>