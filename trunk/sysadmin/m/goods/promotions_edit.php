<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_promotions.php");

//引入语言包
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("promotions_add");
if(!$right){
	header('location:m.php?app=error');
	exit;
}
//数据表定义区
$t_goods = $tablePreStr."goods";
$t_goods_promotions = $tablePreStr."goods_promotions";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$id = intval(get_args('id'));
if(!$id) {exit($a_langpackage->a_error);}

$sql = "SELECT goods_id,goods_name FROM `$t_goods`";
$goods = $dbo->getRs($sql);
$info = get_promotions_row($dbo, $t_goods_promotions, $id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script type='text/javascript' src='../servtools/date/WdatePicker.js'></script>
<style>
td span {color:red;}
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management;?> &gt;&gt; <?php echo $a_langpackage->a_goods_promotions_edit; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_goods_promotions_edit; ?> </span><span class="right" style="margin-right:15px;"><a href="m.php?app=goods_promotions_list" style="float:right;"><?php echo $a_langpackage->a_goods_promotions_list; ?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=goods_promotions_edit" method="post" onsubmit="return checkform();">
		<table class="form-table">
		  <tbody>
                        <tr>
				<td><?php echo $a_langpackage->a_goods; ?>：</td>
				<td><select name="goods_id">
					<option value="0"><?php echo $a_langpackage->a_goods_select; ?></option>
					<?php foreach($goods as $value) {?>
					<option value="<?php echo $value['goods_id']; ?>" <?php if($value['goods_id']==$info['goods_id']){ echo "selected";} ?>><?php echo $value['goods_name']; ?></option>
					<?php }?>
				</select></td>
			</tr>
			<tr>
				<td width="100px;"><?php echo $a_langpackage->a_goods_promotions_price; ?>：</td>
				<td><input class="small-text" type="text" name="promote_price" value="<?php echo $info['promote_price']; ?>" /> <span>*</span></td>
			</tr>
                        <tr>
				<td valign="top"><?php echo $a_langpackage->a_goods_promotions_detail; ?>：</td>
                                <td><textarea name="content" cols="45" rows="5"><?php echo $info['content']; ?></textarea></td>
			</tr>
                        <tr>
				<td><?php echo $a_langpackage->a_goods_promotions_start_time; ?>：</td>
				<td><input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $info['start_time']; ?>" /></td>
			</tr>
                        <tr>
				<td><?php echo $a_langpackage->a_goods_promotions_end_time; ?>：</td>
				<td><input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"  value="<?php echo $info['end_time']; ?>"/></td>
			</tr>
                        <tr>
				<td><?php echo $a_langpackage->a_inspire; ?>：</td>
				<td><input type="radio" name="is_enabled" value="1" <?php if($info['is_enabled']==1){echo 'checked';} ?>><?php echo $a_langpackage->a_yes; ?> <input type="radio" name="is_enabled" value="0" <?php if($info['is_enabled']==0){echo 'checked';} ?>> <?php echo $a_langpackage->a_no; ?></td>
			</tr>
			
			<tr>
				<td colspan="2"><input type="hidden" name="id" value="<?php echo $id; ?>">
				<span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_goods_promotions_edit; ?>" /></span>
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
	var promote_price = document.getElementsByName('promote_price')[0];
	if(promote_price.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_promote_price_notnone; ?>",'0');
		return false;
	}
        var start_time = document.getElementsByName('start_time')[0];
	if(start_time.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_promote_start_time_notnone; ?>",'0');
		return false;
	}
        var end_time = document.getElementsByName('end_time')[0];
	if(end_time.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_promote_end_time_notnone; ?>",'0');
		return false;
	}
        if(end_time.value < start_time.value){
            ShowMessageBox("<?php echo $a_langpackage->a_promote_time_false; ?>",'0');
            return false;
        }
	return true;
}
</script>
</body>
</html>