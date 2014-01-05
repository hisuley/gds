<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//require("../foundation/module_refund.php");
//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_refund_info = $tablePreStr."refund_list";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$order_id = short_check(get_args('order_id'));
$start_time = get_args('start_time');
$end_time = get_args('end_time');
$orderby = short_check(get_args('orderby'));

$sql = "select * from `$t_refund_info` where 1";
//权限管理
$right=check_rights("order_search");

if($order_id) {
	if(!$right){
		header('location:m.php?app=error');
		exit;
	}else {
		$sql .= " and order_id like '%$order_id%'";
	}
}

if($start_time) {
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and operator_date >= '$start_time' ";
	}
}
if($end_time) {
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and operator_date  <= '$end_time' ";
	}
}
if($orderby) {
	$sql .= " order by $orderby";
} else {
        $sql .= " order by operator_date desc;";
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
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <a href=""><?php echo $a_langpackage->a_m_order_mengament;?></a> &gt;&gt; <a href=""><?php echo $a_langpackage->a_refund_list;?></a></div>
        <hr />
	<div class="seachbox">
        <div class="content2">
        	<form action="m.php?app=order_refund_list" name="searchForm" method="get">
            <table class="form-table">
            	<tbody>
            	<tr>
                   	<td width="2px" style="padding:0 0 0 5px"><span style="margin:1px 0px 0px 0px; float:left; color: #000" > <img src="skin/images/icon_search.gif" border="0" alt="SEARCH" /> </span></td>
                    <td><?php echo $a_langpackage->a_orderID;?>：
                   		<input class="small-text" type="text" name="order_id" value="<?php echo $order_id; ?>" style="width:120px" />
                                <?php echo $a_langpackage->a_operator_date;?>：
						<input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" /><?php echo $a_langpackage->a_to;?>
						
						
						<input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"  value="<?php echo $end_time;?>"/>
                                               　<input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_serach;?>" />
						<input type="hidden" name="app" value="order_refund_list">
					</td>
                  </tr>
                </tbody>
            </table>
           </form>
        </div>
    </div>
	<div class="infobox">
	<h3><?php echo $a_langpackage->a_refund_list;?><span class="right" style="margin-right:15px;"><a href="m.php?app=order_refund_export"><?php echo $a_langpackage->a_refund_export;?></a></span></h3>
    <div class="content2">
		<table class="list_table">
			<thead>
			<tr style=" text-align:center">
                                <th width="15px"><a href="m.php?app=order_refund_list&orderby=refund_id">ID</a></th>
				<th width="100px"><a href="m.php?app=order_refund_list&orderby=order_id"><?php echo $a_langpackage->a_orderID;?></a></th>
				<th width="90px"><a href="m.php?app=order_refund_list&orderby=refund_way"><?php echo $a_langpackage->a_refund_way;?></a></th>
				<th width="120px"><?php echo $a_langpackage->a_refund_account;?></th>
				<th width="40px"><?php echo $a_langpackage->a_refund_money;?></th>
				<th width="60px"><?php echo $a_langpackage->a_memeber_name;?></th>
				<th width="45px"><?php echo $a_langpackage->a_operator;?></th>
                                <th width="80px"><?php echo $a_langpackage->a_operator_date;?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style=" text-align:center">
                                <td><?php echo $value['refund_id'];?></td>
				<td><?php echo $value['order_id'];?></td>
				<td><?php echo $value['refund_way'];?></td>
				<td><?php echo $value['refund_account'];?></td></td>
				<td><?php echo $value['refund_money'];?><br />
				<td><?php echo $value['user_name'];?><br /></td>
				<td><?php echo $value['operator'];?><br /></td>
                                <td><?php echo $value['operator_date'];?><br /></td>
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