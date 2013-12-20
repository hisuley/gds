<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_account_info = $tablePreStr."user_account";
$t_users = $tablePreStr."users";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$start_time = get_args('start_time');
$end_time = get_args('end_time');

$sql = "select a.id,a.admin_user,a.amount,a.add_time,a.paid_time,a.admin_note,a.user_note,a.process_type,a.payment,a.is_paid,b.user_name from `$t_account_info` a left join `$t_users` b on a.user_id = b.user_id where 1";
//权限管理
$right=check_rights("order_search");

if($start_time) {
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and a.add_time >= '$start_time' ";
	}
}
if($end_time) {
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and a.add_time  <= '$end_time' ";
	}
}

$result = $dbo->fetch_page($sql,13);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<script type='text/javascript' src='../servtools/date/WdatePicker.js'></script>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
.black {color:#cccccc;}
</style>
</head>
<body>
<div id="maincontent">
 <?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <a href=""><?php echo $a_langpackage->a_m_order_mengament;?></a> &gt;&gt; <a href=""><?php echo $a_langpackage->a_account_list;?></a></div>
        <hr />
	<div class="seachbox">
        <div class="content2">
        	<form action="m.php?app=order_account" name="searchForm" method="get">
            <table class="form-table">
            	<tbody>
            	<tr>
                   	<td width="2px" style="padding:0 0 0 5px"><span style="margin:1px 0px 0px 0px; float:left; color: #000" > <img src="skin/images/icon_search.gif" border="0" alt="SEARCH" /> </span></td>
                    <td>
                                <?php echo $a_langpackage->a_shop_time;?>：
						<input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" /><?php echo $a_langpackage->a_to;?>
						
						
						<input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"  value="<?php echo $end_time;?>"/>
                                               　<input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_serach;?>" />
						<input type="hidden" name="app" value="order_account">
					</td>
                  </tr>
                </tbody>
            </table>
           </form>
        </div>
    </div>
	<div class="infobox">
	<h3><?php echo $a_langpackage->a_account_list;?></h3>
    <div class="content2">
		<table class="list_table">
			<thead>
			<tr style=" text-align:center">
				<th width="5px"><input type="checkbox" onclick="checkall(this,'id[]');" /></th>
				<th width="10px" align="left">ID</th>
				<th width="100"><?php echo $a_langpackage->a_memeber_name;?>/<?php echo $a_langpackage->a_words_beizhu;?></th>
				<th width="100px"><?php echo $a_langpackage->a_admin_name;?>/<?php echo $a_langpackage->a_words_beizhu;?></th>
				<th width="30px"><?php echo $a_langpackage->a_amount;?></th>
				<th width="80px"><?php echo $a_langpackage->a_account_addtime;?>/<?php echo $a_langpackage->a_account_edittime;?></th>
				<th width="50px"><?php echo $a_langpackage->a_process_type;?></th>
				<th width="30px"><?php echo $a_langpackage->a_payment_type;?></th>
                                <th width="30px"><?php echo $a_langpackage->a_account_ispaid;?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style=" text-align:center">
				<td><input type="checkbox" name="id[]" value="<?php echo $value['id'];?>" /></td>
                                <td align="left"><?php echo $value['id'];?></td>
				<td><?php echo $value['user_name'];?><br /><?php echo $value['user_note'];?></td>
				<td><?php echo $value['admin_user'];?><br /><?php echo $value['admin_note'];?></td>
				<td><?php echo $value['amount'];?></td>
                                <td><?php echo $value['add_time'];?><br /><?php echo $value['paid_time'];?></td>
				<td><?php if($value['process_type']==0){
                                        echo "<span class='red'>".$a_langpackage->a_account_prepay."</span><br />";
                                    } elseif($value['process_type']==1) {
                                        echo "<span class='red'>".$a_langpackage->a_account_refund."</span><br />";
                                    }elseif($value['process_type']==2) {
                                        echo "<span class='red'>".$a_langpackage->a_account_branktype."</span><br />";
                                    }?>
				</td>
                                <td><?php echo $value['payment'];?></td>
				<td>
                                    <?php if($value['is_paid']==0){
                                        echo "<span class='red'>".$a_langpackage->a_unpayed."</span><br />";
                                    } else {
                                        echo "<span class='black'>".$a_langpackage->a_payed."</span><br />";
                                    }?>
				</td>
			</tr>
			<?php }} else { ?>
			<tr>
				<td colspan="11"><?php echo $a_langpackage->a_no_list;?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="11"><?php include("m/page.php"); ?></td>
			</tr>
			</tbody>
		</table>
		</div>
	  </div>
	</div>
</div>
</body>
</html>