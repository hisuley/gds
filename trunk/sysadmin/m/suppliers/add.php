<?php
if(!$IWEB_SHOP_IN){
	die('Hacking attempt');
}

require_once("../foundation/module_users.php");
require("../foundation/module_areas.php");
require("../foundation/module_shop_category.php");
//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_user_rank = $tablePreStr."user_rank";
$t_areas = $tablePreStr."areas";
$t_shop_categories = $tablePreStr."shop_categories";

$uid = intval(get_args('id'));

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

$userrank = get_userrank_list($dbo,$t_user_rank);

/* 初始化shopinfo */
$shop_info = array(
	'shop_name'		=> '',
	'shop_country'	=> 1,
	'shop_province'	=> 0,
	'shop_city'		=> 0,
	'shop_district'	=> 0,
	'shop_address'	=> '',
	'shop_images'	=> '',
	'shop_template'	=> 'default',
	'shop_intro'	=> '',
	'shop_management' => ''
);

$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,0);
$areas_info = get_areas_info($dbo,$t_areas);

$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/default_small.gif',
	'bigimgurl' => '../skin/default/images/default.gif',
	'tpltag' => 'default',
	'tplname' => $a_langpackage->a_default_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/green_small.gif',
	'bigimgurl' => '../skin/default/images/green.gif',
	'tpltag' => 'green',
	'tplname' => $a_langpackage->a_green_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/blue_small.gif',
	'bigimgurl' => '../skin/default/images/blue.gif',
	'tpltag' => 'blue',
	'tplname' => $a_langpackage->a_blue_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/red_small.gif',
	'bigimgurl' => '../skin/default/images/red.gif',
	'tpltag' => 'red',
	'tplname' => $a_langpackage->a_red_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/purple_small.gif',
	'bigimgurl' => '../skin/default/images/purple.gif',
	'tpltag' => 'purple',
	'tplname' => $a_langpackage->a_purple_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/gray_small.gif',
	'bigimgurl' => '../skin/default/images/gray.gif',
	'tpltag' => 'gray',
	'tplname' => $a_langpackage->a_gray_template
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span { color:red; }
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_suppliers_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_suppliers_add; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_suppliers_add; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=suppliers_list"><?php echo $a_langpackage->a_suppliers_list; ?></a></span></h3>
    <div class="content2">
		<form method="post" action="a.php?act=suppliers_add" name="form_suppliers_add" onsubmit="return check_form(this)" enctype="multipart/form-data">
                    <table class="list_table" style="float:left; width:48%; margin-right:4%">
                        <thead>
                                <tr>
                                        <th colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_suppliers_memeber_reg;?></th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr>
                                    <td align="right"><?php echo $a_langpackage->a_memeber_name;?>：</td>
                                    <td><input type="text" name="user_name" style="width:200px;" /> <span>*</span></td>
                            </tr>
                            <tr>
                                    <td align="right"><?php echo $a_langpackage->a_memeber_email;?>：</td>
                                    <td><input type="text" name="user_email" style="width:200px;" /><span>*</span></td>
                            </tr>
                            <tr>
                                    <td align="right"><?php echo $a_langpackage->a_user_password;?>：</td>
                                    <td><input type="password" name="user_passwd" style="width:200px;" /><span>*</span>数字或英文，6-16位</td>
                            </tr>
                            <tr>
                                    <td align="right"><?php echo $a_langpackage->a_user_rank;?>：</td>
                                    <td><select name="rank_id">
                                    <?php foreach($userrank as $value) { ?>
                                            <option value="<?php echo $value['rank_id'];?>" <?php if($value['rank_id']==$user_info['rank_id']) echo "selected"; ?>><?php echo $value['rank_name']; ?></option>
                                    <?php }?>
                                    </select></td>
                            </tr>
                            <tr>
                                    <td align="right"><?php echo $a_langpackage->a_email_check;?>：</td>
                                    <td><input type="checkbox" name="email_check" value="1" /><?php echo $a_langpackage->a_user_pass_verify;?></td>
                            </tr>
                        </tbody>
                </table>
		<table class="list_table" style="float:left; width:48%;">
                    <thead>
                            <tr>
                                    <th colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_suppliers_legal_person;?></th>
                            </tr>
                    </thead>
                    <tbody>
			<tr>
				<td width="140px;" align="right"><?php echo $a_langpackage->a_companyname; ?>：</td>
				<td><input type="text" name="company_name" maxlength="200" style="width:200px" /><span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_person_name; ?>：</td>
				<td><input type="text" name="person_name" maxlength="200" style="width:200px" /><span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_credit_type; ?>：</td>
				<td><select name="credit_type">
					<option value="身份证">身份证</option>
					<option value="军官证">军官证</option>
					</select> <span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_credit_num; ?>：</td>
				<td><input type="text" name="credit_num" maxlength="200" style="width:200px" /><span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_attach; ?>：</td>
				<td><input type="file" name="attach[]" /> <span class="red">*</span>支持的文件格式（jpg,gif,png）</td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_companyarea; ?>：</td>
				<td><input type="text" name="company_area" maxlength="200" style="width:200px" /></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_company_address; ?>：</td>
				<td><input type="text" name="company_address" maxlength="200" style="width:300px" /> <span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_zipcode; ?>：</td>
				<td><input type="text" name="zipcode" maxlength="10" style="width:100px" /> <span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_mobile_code; ?>：</td>
				<td><input type="text" name="mobile" maxlength="20" style="width:200px" /> <span class="red">*</span></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_telphone_code; ?>：</td>
				<td><input type="text" name="telphone" maxlength="20" style="width:200px" /> <span class="red">*</span></td>
			</tr>
                    </tbody>
		</table>
                    <table class="list_table" style="clear:both; border:0px; padding:0px; margin:0px;">
                        <thead>
                                <tr>
                                        <th colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_suppliers_shop;?></th>
                                </tr>
                        </thead>
                        <tbody>
                                <tr>
                                        <td width="140px;" align="right"><?php echo $a_langpackage->a_shopname; ?>：</td>
                                        <td><input type="text" name="shop_name"
                                                value="<?php echo $shop_info['shop_name']; ?>" style="width: 250px;"
                                                maxlength="50" /><span class="red">*</span></td>
                                </tr>
                                <tr>
                                        <td align="right"><?php echo $a_langpackage->a_categories_parent; ?>：</td>
                                        <td><span id="shop_country"> <select name="categories_parent"
                                                onchange="categorieschanged(this.value)">
                                                <option value='0'><?php echo $a_langpackage->a_selecttype; ?></option>
                                                                <?php 
                                                                foreach ($shop_categories_parent as $v){
                                                                ?>
                                                                <option value="<?php echo $v['cat_id']; ?>"><?php echo $v['cat_name']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                        </select></span> <span id="shop_categories"> </span><span
                                                class="red">*</span></td>
                                </tr>
                                <tr>
                                        <td align="right"><?php echo $a_langpackage->a_shop_country; ?>：</td>
                                        <td>		<span id="shop_country">
                                                                        <select name="country"	onchange="areachanged(this.value,0);">
                                                                                <option value='0'><?php echo $a_langpackage->a_selectcount; ?></option>
                                                                                <?php 
                                                                                foreach ($areas_info[0] as $v){
                                                                                ?>
                                                                                <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_country']){echo 'selected';}?>>
                                                                                        <?php echo $v['area_name']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                        </span> 
                                                                        <span id="shop_province">
                                                                        <?php 
                                                                        if($shop_info['shop_country']){
                                                                                ?>
                                                                                <select name="province" onchange="areachanged(this.value,1);">
                                                                                        <option value='0'><?php echo $a_langpackage->a_select_province; ?></option>
                                                                                        <?php 
                                                                                        foreach ($areas_info[1] as $v){
                                                                                        ?>
                                                                                        <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_province']){echo 'selected';}?>>
                                                                                                <?php echo $v['area_name']; ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                </select>
                                                                                <?php 
                                                                        }
                                                                        ?>
                                                                        </span>
                                                                        <span id="shop_city">
                                                                        <?php 
                                                                        if($shop_info['shop_province']){
                                                                                ?>
                                                                                <select name="city" onchange="areachanged(this.value,2);">
                                                                                        <option value='0'><?php echo $a_langpackage->a_select_city; ?></option>
                                                                                        <?php 
                                                                                        foreach ($areas_info[2] as $v){
                                                                                                if($v['parent_id'] == $shop_info['shop_province']){
                                                                                        ?>
                                                                                        <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_city']){echo 'selected';}?>>
                                                                                                <?php echo $v['area_name']; ?></option>
                                                                                        <?php
                                                                                                }
                                                                                        }
                                                                                        ?>
                                                                                </select>
                                                                                <?php 
                                                                        }
                                                                                ?>
                                                                        </span>
                                                                        <span id="shop_district">
                                                                        <?php 
                                                                        if($shop_info['shop_city']){
                                                                                ?>
                                                                                <select name="district">
                                                                                        <option value='0'><?php echo $a_langpackage->a_select_dir; ?></option>
                                                                                        <?php 
                                                                                        foreach($areas_info[3] as $v){
                                                                                                if($v['parent_id'] == $shop_info['shop_city']){
                                                                                                        ?>
                                                                                                        <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_district']){echo 'selected';}?>>
                                                                                                                <?php echo $v['area_name']; ?></option>
                                                                                                        <?php 
                                                                                                }
                                                                                        }
                                                                                        ?>
                                                                        </select>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                        </span> <span class="red">*</span></td>
                                </tr>
                                <tr>
                                        <td align="right"><?php echo $a_langpackage->a_shop_address; ?>：</td>
                                        <td><input type="text" name="shop_address"
                                                value="<?php echo $shop_info['shop_address']; ?>"
                                                style="width: 250px;" maxlength="200" /> <span class="red">*</span></td>
                                </tr>

                                <tr>
                                        <td align="right"><?php echo $a_langpackage->a_shop_management; ?>：</td>
                                        <td><input type="text" name="shop_management"
                                                value="<?php echo $shop_info['shop_management']; ?>"
                                                style="width: 250px;" maxlength="200" /> <span class="red">*</span></td>
                                </tr>
                                <tr>
                                        <td align="right"><?php echo $a_langpackage->a_shop_template; ?>：</td>
                                        <td class="templageimg">
                                                        <?php 
                                                        foreach($shoptemplate_arr as $v){
                                                                ?>
                                                                <span><img src="<?php echo $v['imgurl']; ?>" width="95"	alt="<?php echo $v['tplname']; ?>"	onclick="wshowimg('<?php echo $v['bigimgurl']; ?>')" onmouseover="imgmover(this)" onmouseout="imgmout(this)" onerror="this.src='../skin/default/images/nopic.gif'" /><br />	<input type="radio" name="shop_template"	value="<?php echo $v['tpltag']; ?>"	<?php if($shop_info['shop_template']==$v['tpltag']){echo 'checked';}?> /> <?php echo $v['tplname']; ?></span> 
                                                        <?php
                                                        }
                                                        ?>
                                                        </td>
                                </tr>
                                <tr>
                                        <td align="right"><?php echo $a_langpackage->a_shop_intro; ?>：</td>
                                        <td><textarea name="shop_intro" id="shop_intro" cols="75" rows="15"><?php echo $shop_info['shop_intro']; ?></textarea></td>
                                </tr>
                                <tr>
                                        <td colspan="2" align="center"><span class="button-container"><input class="regular-button" type="submit" name="btn_submit" value="<?php echo $a_langpackage->a_suppliers_add; ?>"  /></span></td>
                                </tr>
                        </tbody>    
                </table>
		</form>
	  </div>
	 </div>
   </div>
</div>
<div id="showimg" style="display:none; width:408px; text-align:center; border:5px solid #F6A248; position:absolute; padding:4px; background:#fff; top:200px;"><img id="imgsrc" src="skin/default/images/shop_template_default_big.gif" width="400" /></div>
<div style="width:0px; height:0px; overflow:hidden;"><input type="input" id="hiddeninput" onblur="whideimg()" /></div>
</body>
</html>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript" type="text/javascript">
var utype = '';
function areachanged(value,type){
	utype = type;
	if(value > 0) {
		ajax("a.php?act=ajax_areas","POST","value="+value+"&type="+type);
	} else {
		if(type==2) {
			hide("shop_district");
		} else if(type==1) {
			hide("shop_district");
			hide("shop_city");
		} else if(type==0) {
			hide("shop_district");
			hide("shop_city");
			hide("shop_province");
		}
	}
}
function categorieschanged(value){
	if(value > 0) {
		ajax("a.php?act=ajax_categori","POST","value="+value,function(return_text){
			return_text = return_text.replace(/[\n\r]/g,"");
			document.getElementById("shop_categories").innerHTML = return_text;
			show("shop_categories");
		});
	}
}

function ajaxCallback (return_text){
	return_text = return_text.replace(/[\n\r]/g,"");
	if(return_text==""){
		alert("<?php echo $a_langpackage->a_select_again; ?>");
	} else {
		if(utype==0) {
			document.getElementById("shop_province").innerHTML = return_text;
			show("shop_province");
			hide("shop_city");
			hide("shop_district");
		} else if(utype==1) {
			document.getElementById("shop_city").innerHTML = return_text;
			show("shop_city");
			hide("shop_district");
		} else if(utype==2) {
			show("shop_district");
			document.getElementById("shop_district").innerHTML = return_text;
			
		}
	}
}
function hide(id) {
	document.getElementById(id).style.display = 'none';
}
function show(id) {
	document.getElementById(id).style.display = '';
}
function check_form(obj){
        var user_name_reg = /^(\w+)$/;
        if(obj.user_name.value=='') {
                ShowMessageBox("会员名称不能为空!",'0');
                return false;
        }
        if(!obj.user_name.value.match(user_name_reg)) {
                ShowMessageBox("会员名称格式不正确！",'0');
                return false;
        }
        var user_email_reg = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/; 
        if(obj.user_email.value=='') {
                ShowMessageBox("电子邮箱不能为空！",'0');
                return false;
        }
        if(!obj.user_email.value.match(user_email_reg)) {
                ShowMessageBox("电子邮箱格式不正确！",'0');
                return false;
        }
        if(obj.user_passwd.value=="" || obj.user_passwd.value.length<6 || obj.user_passwd.value.length>16){
                ShowMessageBox("密码输入不正确！",'0');
                return false;
        }
        if(obj.company_name.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_complay; ?>","0")
                obj.company_name.focus();
                return false;
        }
        if(obj.person_name.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_person; ?>","0")
                return false;
        }
        if(obj.credit_num.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_card; ?>","0")
                return false;
        }
        if(isNaN(obj.credit_num.value.substr(0,obj.credit_num.value.length-1))){
                ShowMessageBox("<?php echo $a_langpackage->a_check_truecard; ?>","0")
                return false;
        }
        if(obj.company_address.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_address; ?>","0")
                return false;
        }
        if(obj.zipcode.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_postcode; ?>","0")
                return false;
        }
        if(isNaN(obj.zipcode.value)){
                ShowMessageBox("<?php echo $a_langpackage->a_check_postcodeisnum; ?>","0")
                return false;
        }
        if(obj.mobile.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_mobile; ?>","0")
                return false;
        }
        if(isNaN(obj.mobile.value)){
                ShowMessageBox("<?php echo $a_langpackage->a_check_mobileisnum; ?>","0")
                return false;
        }
        if(obj.telphone.value==''){
                ShowMessageBox("<?php echo $a_langpackage->a_check_phone; ?>","0")
                return false;
        }
        if(isNaN(obj.telphone.value)){
                ShowMessageBox("<?php echo $a_langpackage->a_check_phoneisnum; ?>","0")
                return false;
        }
        
        var shop_name = document.getElementsByName("shop_name")[0];
	var shop_address = document.getElementsByName("shop_address")[0];
	var shop_management = document.getElementsByName("shop_management")[0];
	if(obj.shop_name.value=='') {
		alert("<?php echo $a_langpackage->a_shopname_notnone; ?>");
		shop_name.focus();
		return false;
	} else if(document.getElementsByName("country")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_countrypl; ?>");
		return false;
	} else if(document.getElementsByName("province")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_provincepl; ?>");
		return false;
	} else if(document.getElementsByName("city")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_citypl; ?>");
		return false;
	} else if(document.getElementsByName("district")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_districtpl; ?>");
		return false;
	} else if(obj.shop_address.value=='') {
		alert("<?php echo $a_langpackage->a_address_notnone; ?>");
		shop_address.focus();
		return false;
	} else if(obj.shop_management.value=='') {
		alert("<?php echo $a_langpackage->a_shopmanagement_notnone; ?>");
		shop_management.focus();
		return false;
	}
        return true;
}
function imgmover(obj) {
        obj.style.border = '2px solid #E38016';
}

function imgmout(obj) {
	obj.style.border = '2px solid #eee';
}

function wshowimg(v) {
	var width = document.body.clientWidth;
	var showimg = document.getElementById("showimg");
	var imgsrc = document.getElementById("imgsrc");

	var left = "100";
	if(width) {
		left = (width-400)/2;
	}
	showimg.style.left = left+"px";
	showimg.style.display = '';
	imgsrc.src = v;
	document.getElementById("hiddeninput").focus();
}

function whideimg() {
	var showimg = document.getElementById("showimg");
	showimg.style.display = 'none';
}
</script>