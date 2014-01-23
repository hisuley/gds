<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$i_langpackage=new indexlp;

require_once("foundation/asystem_info.php");

/* GET */
$user_id = intval(get_args('uid'));
$email_check_code = get_args('ucode');

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_users = $tablePreStr."users";

if($user_id && $email_check_code) {
	$sql = "select email_check_code,email_check from `$t_users` where user_id='$user_id'";
	$row = $dbo->getRow($sql);
	if($row['email_check']) {
		echo '<script language="JavaScript">alert("'.$i_langpackage->i_email_check.'"); location.href="modules.php"</script>';
		exit;
	}else{
		if($row['email_check_code'] == $email_check_code){
			/* 数据库操作 */
			dbtarget('w',$dbServs);
			$dbo=new dbex();

			$sql = "update `$t_users` set email_check=1 where user_id='$user_id'";
			$dbo->exeUpdate($sql);
            if(isset($SYSINFO['email_points']) && $SYSINFO['email_points'] > 0 && !empty($user_id)){
                if(!isset($t_user_point)){
                    $t_user_point = $tablePreStr."user_point";
                }
                if(!isset($t_users)){
                    $t_users = $tablePreStr."users";
                }
                require_once("foundation/module_account.php");
                require_once("foundation/module_users.php");
                $user_detail = get_user_info($dbo,$t_users,$user_id);
                $total_points_temp = $user_detail['user_integral']+$SYSINFO['email_points'];
                $user_integral = array(
                    'user_id' => $user_id,
                    'admin_user' => 'system',
                    'point' => $SYSINFO['email_points'],
                    'add_time' => date("Y-m-d H:i:s", strtotime('now')),
                    'admin_note' => '自动赠送积分',
                    'process_type' => 1,
                );
                $user_info = array(
                    'user_integral' => $total_points_temp
                );
                insert_account_info($dbo,$t_user_point,$user_integral);
                update_account($dbo,$t_users, $user_info, $user_id);
            }
			echo '<script language="JavaScript">alert("'.$i_langpackage->i_pass_check.'"); location.href="modules.php"</script>';
			exit;
		}else{
			echo '<script language="JavaScript">alert("'.$i_langpackage->i_again_send.'"); location.href="modules.php?app=send_code"</script>';
			exit;
		}
	}
} else {
	echo '<script language="JavaScript">alert("'.$i_langpackage->i_check_url_error.'"); location.href="modules.php?app=reg2"</script>';
	exit;
}
?>