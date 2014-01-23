<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_users.php");
//引入语言包
$a_langpackage=new adminlp;
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
</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_member_oprate;?> &gt;&gt; <?php echo $a_langpackage->a_user_level_add?></div>
    <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_user_level_add?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=member_level_list" style="float: right;"><?php echo $a_langpackage->a_m_user_level_list?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=member_level_add" method="post" onsubmit="return checkForm();" enctype="multipart/form-data">
		<table class="form-table">
		  <tbody>
			<tr>
				<td style="width:85px;"><?php echo $a_langpackage->a_user_level_name?>：</td>
				<td><input class="small-text" type="text" name="level_name" > <span>*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_user_level_points?>：</td>
				<td>
                                    <input class="small-text" type="text" name="pointBegin"  style="width:40px"> ～ <input class="small-text" type="text" name="pointEnd"  style="width:40px"> <span>*</span>
				</td>
			</tr>
                         <tr>
				<td style="width:85px;"><?php echo $a_langpackage->a_user_price_img?>：</td>
				<td><input type="file" name="price_img[]" ></td>
			</tr>
                         <tr>
				<td style="width:85px;"><?php echo $a_langpackage->a_user_head_img?>：</td>
				<td><input type="file" name="head_img[]" ></td>
			</tr>
			<tr>
				<td colspan="2">
					<span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_user_level_add?>" /></span>
				</td>
			</tr>
		  </tbody>
		</table>
		</form>
	   </div>
	 </div>
   </div>
</div>
</body>
</html>
<script type="text/javascript">
function checkForm() {
	var level_name = document.getElementsByName("level_name")[0];
        var pointBegin = document.getElementsByName("pointBegin")[0];
        var pointEnd = document.getElementsByName("pointEnd")[0];
	if(level_name.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_level_name_notnone; ?>",'0');
		level_name.focus();
		return false;
	} 
        if(pointBegin.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_level_pointBegin_notnone; ?>",'0');
		pointBegin.focus();
		return false;
	}
        if(pointEnd.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_level_pointEnd_notnone; ?>",'0');
		pointEnd.focus();
		return false;
	}
	return true;
}
</script>