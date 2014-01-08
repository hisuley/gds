<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_users.php");
require_once("../foundation/module_areas.php");
//引入语言包
$a_langpackage=new adminlp;

$user_id = intval(get_args('id'));
if(!$user_id) {
	trigger_error($a_langpackage->a_error);
}

//数据表定义区
$t_users = $tablePreStr."users";
$t_user_info = $tablePreStr."user_info";
$t_user_rank = $tablePreStr."user_rank";
$t_areas = $tablePreStr."areas";
$t_user_account = $tablePreStr."user_account";
$t_user_point = $tablePreStr."user_point";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql="select a.user_id,a.user_email,a.user_name,a.user_passwd,a.user_ico,a.reg_time,a.last_login_time,a.last_ip,a.email_check,a.rank_id,a.user_money,a.user_integral,a.user_integral_surplus,b.user_truename,b.user_gender,b.user_mobile,b.user_telphone,b.user_country,b.user_province,b.user_city,user_district,b.user_zipcode,b.user_address,b.user_birthday,b.user_qq,b.user_msn,b.user_skype,b.user_notes,c.admin_note as amount_notes,d.admin_note as point_notes
from `$t_users` a left join `$t_user_info` b on a.user_id=b.user_id left join `$t_user_account` c on a.user_id=c.user_id left join `$t_user_point` d on a.user_id=d.user_id where a.user_id='$user_id'";
$user_info = $dbo->getRow($sql);
//$user_info = get_user_info($dbo,$t_users,$user_id);

$areas = get_areas_kv($dbo,$t_areas);

$userrank = get_userrank_list($dbo,$t_user_rank);
// 用户生日
if($user_info['user_birthday']) {
	$Y = substr($user_info['user_birthday'],0,4);
	$M = substr($user_info['user_birthday'],5,2);
	$D = substr($user_info['user_birthday'],8,2);
} else {
	$Y = $M = $D = 0;
}
// 用户所选国家， 如果没选默认为1（中国）
$user_info['user_country'] = $user_info['user_country'] ? $user_info['user_country'] : 1;
$areas_info = get_areas_info($dbo,$t_areas);

if($user_info['user_gender']==0) { $user_gender0='checked'; } else { $user_gender0=''; }
if($user_info['user_gender']==1) { $user_gender1='checked'; } else { $user_gender1=''; }
if($user_info['user_gender']==2) { $user_gender2='checked'; } else { $user_gender2=''; }

if($user_info['user_marry']==0) { $user_marry0='checked'; } else { $user_marry0=''; }
if($user_info['user_marry']==1) { $user_marry1='checked'; } else { $user_marry1=''; }
if($user_info['user_marry']==2) { $user_marry2='checked'; } else { $user_marry2=''; }

if($user_info['user_ico']){
$userico_arr = explode('/', $user_info['user_ico']);
$userico_arr[count($userico_arr)-1] = "thumb_".$userico_arr[count($userico_arr)-1];
$user_info['user_ico'] = $SYSINFO['web']."/".join("/",$userico_arr);
}else{
    $user_info['user_ico'] = $SYSINFO['web']."uploadfiles/member_ico/default.jpg";
}
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
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_member_oprate;?> &gt;&gt; <?php echo $a_langpackage->a_memeber_view;?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_memeber_view;?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=member_list" style="float: right;"><?php echo $a_langpackage->a_memeber_list;?></a></span></h3>
    <div class="content2"> 
		<form action="a.php?act=member_doview" method="post" enctype="multipart/form-data">
		<table class="list_table" style="float:left; width:32%; margin-right:2%">
		  <tbody>
			<tr>
				<td style="width:100px;" align="right"><?php echo $a_langpackage->a_memeber_name;?>：</td>
				<td><?php echo $user_info['user_name']; ?></td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_memeber_email;?>：</td>
				<td><input class="small-text" type="text" name="user_email" value="<?php echo $user_info['user_email']; ?>" /> <span id="user_email_message"></span></td>
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
				<td align="right"><?php echo $a_langpackage->a_user_password;?>：</td>
				<td><input class="small-text" type="password" name="password" /> <?php echo $a_langpackage->a_user_notupdate;?></td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_memeber_integral;?>：</td>
				<td><input class="small-text" type="text" name="user_integral" value="<?php echo $user_info['user_integral']; ?>" /> </td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_memeber_integral_surplus;?>：</td>
				<td><input class="small-text" type="text" name="user_integral_surplus" value="<?php echo $user_info['user_integral_surplus']; ?>" /> </td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_memeber_money;?>：</td>
				<td><input class="small-text" type="text" name="user_money" value="<?php echo $user_info['user_money']; ?>" /> </td>
			</tr>
			<tr>
				<td align="right"><?php echo $a_langpackage->a_email_check;?>：</td>
				<td><input type="checkbox" name="email_check" value="1" <?php if($user_info['email_check']) {echo 'checked';} ?> /><?php echo $a_langpackage->a_user_pass_verify;?></td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_register_time;?>：</td>
				<td><?php echo $user_info['reg_time']; ?></td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_last_login_time;?>：</td>
				<td><?php echo $user_info['last_login_time']; ?></td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_last_login_IP;?>：</td>
				<td><?php echo $user_info['last_ip']; ?></td>
			</tr>
                        <tr>
                                <td class="right">锁定状态：</td>
                                <td><input type="checkbox" name="locked_status" value="1" <?php if($user_info['locked']) {echo 'checked';} ?> /><?php echo $a_langpackage->a_lock;?></td>
                        </tr>
		  </tbody>
		</table>
                <table class="list_table" style="float:left; width:32%;">
		  <tbody>
                        <tr>
				<td style="width:100px;" align="right"><?php echo $a_langpackage->a_memeber_id;?>：</td>
				<td><?php echo $user_info['user_id']; ?></td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_memeber_realname;?>：</td>
				<td><input class="small-text" type="text" name="user_truename" value="<?php echo $user_info['user_truename']; ?>" /> </td>
			</tr>
                        <tr>
                                <td align="right"><?php echo $a_langpackage->a_memeber_birthday;?>：</td>
                                <td>
                                    <select name="Y">
                                            <option value="0"><?php echo $a_langpackage->a_year;?></option>
                                    <?php  for($i=1950; $i<=date("Y"); $i++){?>
                                            <option value="<?php echo  $i;?>" <?php  if($Y==$i){echo 'selected';}?>><?php echo  $i;?></option>
                                    <?php }?>
                                    </select>
                                    <select name="M">
                                            <option value="0"><?php echo $a_langpackage->a_month2;?></option>
                                    <?php  for($i=1; $i<=12; $i++){?>
                                            <option value="<?php echo  $i;?>" <?php  if($M==$i){echo 'selected';}?>><?php echo  $i;?></option>
                                    <?php }?>
                                    </select>
                                    <select name="D">
                                            <option value="0"><?php echo $a_langpackage->a_date;?></option>
                                    <?php  for($i=1; $i<=31; $i++){?>
                                            <option value="<?php echo  $i;?>" <?php  if($D==$i){echo 'selected';}?>><?php echo  $i;?></option>
                                    <?php }?>
                                    </select>
                                </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $a_langpackage->a_memeber_sex;?>：</td>
                            <td>
                                <input type="radio" name="user_gender" value="0" <?php echo $user_gender0;?> /> <?php echo $a_langpackage->a_memeber_secret;?>
                                <input type="radio" name="user_gender" value="1" <?php echo $user_gender1;?> /> <?php echo $a_langpackage->a_memeber_man;?>
                                <input type="radio" name="user_gender" value="2" <?php echo $user_gender2;?> /> <?php echo $a_langpackage->a_memeber_woman;?>
                            </td>
			</tr>
                        <tr>
                            <td align="right"><?php echo  $a_langpackage->a_memeber_marry;?>：</td>
                            <td>
                                <input type="radio" name="user_marry" value="0" <?php echo $user_marry0;?> /><?php echo  $a_langpackage->a_memeber_secret;?> 
                                <input type="radio" name="user_marry" value="1" <?php echo $user_marry1;?> /><?php echo  $a_langpackage->a_memeber_unmarried;?> 
                                <input type="radio" name="user_marry" value="2" <?php echo $user_marry2;?> /><?php echo  $a_langpackage->a_memeber_married;?></td>
                        
                        </tr>
                        <tr>
                            <td align="right"><?php echo $a_langpackage->a_mobile;?>：</td>
                            <td><input class="small-text" type="text" name="user_mobile" value="<?php echo $user_info['user_mobile']; ?>" maxlength="20" /> </td>
			</tr>
                        <tr>
                            <td align="right"><?php echo $a_langpackage->a_tel;?>：</td>
                            <td><input class="small-text" type="text" name="user_telphone" value="<?php echo $user_info['user_telphone']; ?>" maxlength="20" /> </td>
			</tr>
                        <tr>
                            <td align="right">MSN：</td>
                            <td><input type="text" name="user_msn" value="<?php echo  $user_info['user_msn'];?>"  maxlength="50" /></td>
                        </tr>
                        <tr>
                            <td align="right">QQ：</td>
                            <td><input type="text" name="user_qq" value="<?php echo  $user_info['user_qq'];?>" maxlength="15" /></td>
                        </tr>
                        <tr>
                            <td align="right">Skype：</td>
                            <td><input type="text" name="user_skype" value="<?php echo  $user_info['user_skype'];?>" maxlength="50" /></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $a_langpackage->a_shop_country; ?>：</td>
                            <td><span id="shop_country">
                                    <select name="country" onchange="areachanged(this.value,0);">
                                            <option value='0'><?php echo $a_langpackage->a_selectcount; ?></option>
                                            <?php 
                                                foreach ($areas_info[0] as $v){
                                            ?>
                                                <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$user_info['user_country']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                    </select>
                                    </span> <span id="shop_province">
                                    <?php 
                                        if($user_info['user_province']){
                                    ?>
                                            <select name="province" onchange="areachanged(this.value,1);">
                                                    <option value='0'><?php echo $a_langpackage->a_select_province; ?></option>
                                                    <?php 
                                                        foreach ($areas_info[1] as $v){
                                                    ?>
                                                    <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$user_info['user_province']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
                                                    <?php
                                            }
                                            ?>
                                            </select>
                                            <?php 
                                        }
                                        ?>
                                    </span> <span id="shop_city">
                                    <?php 
                                        if($user_info['user_city']){
                                    ?>
                                    <select name="city" onchange="areachanged(this.value,2);">
                                            <option value='0'><?php echo $a_langpackage->a_select_city; ?></option>
                                            <?php 
                                            foreach ($areas_info[2] as $v){
                                                    if($v['parent_id'] == $user_info['user_province']){
                                            ?>
                                            <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$user_info['user_city']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                    <?php 
                    }
                            ?>
                                    </span> <span id="shop_district">
                                    <?php 
                    if($user_info['user_district']){
                            ?>
                                    <select name="district">
                                            <option value='0'><?php echo $a_langpackage->a_select_dir; ?></option>
                                            <?php 
                                    foreach($areas_info[3] as $v){
                                            if($v['parent_id'] == $user_info['user_city']){
                                                    ?>
                                            <option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$user_info['user_district']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
                                            <?php 
                                            }
                                    }
                                    ?>
                                    </select>
                                    <?php
                    }
                    ?>
                    </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo  $a_langpackage->a_memeber_address;?>：</td>
                            <td><input type="text" name="user_address" value="<?php echo  $user_info['user_address'];?>" style="width:250px;" maxlength="200" /></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo  $a_langpackage->a_memeber_zipcode;?>：</td>
                            <td><input type="text" name="user_zipcode" value="<?php echo  $user_info['user_zipcode'];?>" maxlength="6" /></td>
                        </tr>
			<tr>
				<input type="hidden" name="user_id" value="<?php echo $user_info['user_id'];?>">
				<td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_update_user_info;?>" /></span></td>
			</tr>
		  </tbody>
		</table>
                <table class="list_table" style="float:left; width:32%; margin-right:2%">
		  <tbody>
			<tr>
                            <td colspan="2"><a href="m.php?app=order_alllist&user_id=<?php echo $user_info['user_id'];?>"><?php echo $a_langpackage->a_memeber_orderinfo;?></a></td><td></td>
			</tr>
			<tr>
				<td colspan="2"><a href="m.php?app=order_account&user_id=<?php echo $user_info['user_id'];?>"><?php echo $a_langpackage->a_memeber_account;?></a></td><td></td>
			</tr>
                        <tr>
				<td valign="top"><?php echo $a_langpackage->a_memeber_ico; ?>：</td>
                                <td><input type="file" name="attach[]" /></td>
			</tr>
                        <tr><td></td>
                                <td><img src="<?php echo $user_info['user_ico']; ?>"></td>
			</tr>
                        <tr>
				<td align="right"><?php echo $a_langpackage->a_user_note; ?>：</td>
                                <td><input type="text" class="small-text" name="user_notes" value="<?php echo $user_info['user_notes']; ?>" /></td>
			</tr>
                        <tr>
                            <td align="right"><?php echo $a_langpackage->a_do_amount_note;?>：</td>
                            <td><input class="small-text" type="text" name="amount_notes" values="<?php echo $user_info['amount_notes']; ?>" /> </td>
			</tr>
                        <tr>
                            <td align="right"><?php echo $a_langpackage->a_do_point_note;?>：</td>
                            <td><input class="small-text" type="text" name="point_notes" values="<?php echo $user_info['point_notes']; ?>" /> </td>
			</tr>
		  </tbody>
		</table>
		</form>
	   </div>
	  </div>
	</div>
</div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script>
var user_email_value = '<?php echo $user_info['user_email']; ?>';
var user_email = document.getElementsByName("user_email")[0];
var user_email_message = document.getElementById("user_email_message");
var submit = document.getElementsByName("submit")[0];
var user_email_reg = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
user_email.onblur = function(){
	if(user_email.value=='') {
		user_email_message.innerHTML = '<?php echo $a_langpackage->a_email_null;?>';
		submit.disabled = true;
	} else if(!user_email.value.match(user_email_reg)) {
		user_email_message.innerHTML = '<?php echo $a_langpackage->a_email_error;?>';
		submit.disabled = true;
	} else if(user_email.value!=user_email_value) {
		user_email_message.innerHTML = '<?php echo $a_langpackage->a_email_checking;?>';
		submit.disabled = true;
		ajax("./a.php?act=user_check_useremail","POST","v="+user_email.value,function(data){
			if(data==1) {
				user_email_message.innerHTML = '';
				submit.disabled = false;
			} else {
				user_email_message.innerHTML = '<?php echo $a_langpackage->a_email_used;?>';
				submit.disabled = true;
			}
		});
	} else {
		submit.disabled = false;
	}
}

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
</script>
</body>
</html>