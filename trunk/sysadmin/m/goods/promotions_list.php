<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_promotions.php");

//引入语言包
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("promotions");
if (!$right){
	header('location:m.php?app=error');
	exit;
}
$right_update=check_rights("promotions_update");
//数据表定义区
$t_goods_promotions = $tablePreStr."goods_promotions";
$t_goods = $tablePreStr."goods";

$goods_name = get_args('goods_name');
$start_time = get_args('start_time');
$end_time = get_args('end_time');
$orderby = short_check(get_args('orderby'));
$orderway = short_check(get_args('orderway'));
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

/* 查询促销商品列表 */
$sql = "select a.*,b.goods_name from `$t_goods_promotions` as a left join `$t_goods` as b on a.goods_id=b.goods_id where 1=1";

if($goods_name) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}
	$sql .= " and b.goods_name like '%$goods_name%' ";
}
if($start_time) {
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and a.start_time >= '$start_time' ";
	}
}
if($end_time) {
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and a.end_time  <= '$end_time' ";
	}
}
if($orderby && $orderway) {
	$sql .= " order by $orderby $orderway";
}else {
        $sql .= " order by a.id";
}
$result = $dbo->getRs($sql);

require ("a/updateJsAjax.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src='../servtools/date/WdatePicker.js'></script>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
#divname{float:left; margin:0px;}
</style>
</head>
<body>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>" ></input>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management;?> &gt;&gt;  <?php echo $a_langpackage->a_m_goods_promotions_management ?></div>
        <hr />
        <div class="seachbox">
            <div class="content2">
                    <form action="m.php?app=goods_promotions_list" name="searchForm" method="get">
                <table class="form-table" style='font-size:14px;'>
                    <tbody>
                    <tr>
                            <td width="10px">
                                    <span style="margin:1px -5px 0px 0px; float:right; color: #000" >
                                            <img src="skin/images/icon_search.gif" border="0" alt="SEARCH" />
                                    </span>
                            </td>
                        <td>
                            <?php echo $a_langpackage->a_goods_promotions_name;?>: <input type="text" class="small-text" name="policy_title" value="<?php echo $policy_title; ?>" style="width:100px" />
                             <?php echo $a_langpackage->a_goods_promotions_time;?>：
                            <input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" /> <?php echo $a_langpackage->a_to;?>

                            <input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"  value="<?php echo $end_time;?>"/>
                             <input type="hidden" name="app" value="goods_promotions_list" /><input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_serach;?>" />
                        </td>
                    </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_goods_promotions_list ?></span>
	<span class="right" style="margin-right:15px;"> 
	<a href="m.php?app=goods_promotions_add" style="float:right;"><?php echo $a_langpackage->a_goods_promotions_add; ?></a>
	</span></h3>
    <div class="content2">
		<table class="list_table" style='font-size:12px;'>
			<thead>
			<tr style=" text-align:center;">
				<th width="50px">ID <a href="m.php?app=goods_promotions_list&orderby=a.id&orderway=asc">↑</a><a href="m.php?app=goods_promotions_list&orderby=a.id&orderway=desc">↓</a></th>
				<th align="left"><?php echo $a_langpackage->a_goods_name; ?></th>
                                <th width="125px"><?php echo $a_langpackage->a_goods_promotions_start_time; ?></th>
                                <th width="125px"><?php echo $a_langpackage->a_goods_promotions_end_time; ?></th>
				<th width="65px"><?php echo $a_langpackage->a_goods_promotions_price; ?> <a href="m.php?app=goods_promotions_list&orderby=a.promote_price&orderway=asc">↑</a><a href="m.php?app=goods_promotions_list&orderby=a.promote_price&orderway=desc">↓</a></th>
                                <th width="40px">启用</th>
				                <th width="40px">状态</th>
                <th width="115px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result) {
			foreach($result as $value) { ?>
			<tr style=" text-align:center;">
				<td><?php echo $value['id'];?>.</td>
				<td align="left"><?php echo $value['goods_name'];?></td>
                                <td><?php echo $value['start_time'];?></td>
                                <td><?php echo $value['end_time'];?></td>
                                <td><div onclick="editnum(this,<?php echo $value['id'];?>,'divorder<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=goods_promotions&colname=promote_price&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=<?php echo $a_langpackage->a_goods_promotions_price_edit; ?>：&colvalue=',8);"><?php echo $value['promote_price'];?></div>
				    <div style="display:none"></div>
				</td>
                                <td><?php

                                    if($value['is_enabled'])
                                    {
                                        echo "<span class='green'>".$a_langpackage->a_enable_yes."</span>";
                                    }else{
                                        echo "<span class='red'>".$a_langpackage->a_enable_no."</span>";
                                    }?></td>
                    <td>
                        <?php
                        $start_time = strtotime($value['start_time']);
                        $end_time = strtotime($value['end_time']);
                        $now_time = strtotime('now');
                        if($start_time > $now_time){
                            echo "未开始";
                        }elseif($start_time <= $now_time && $end_time >= $now_time){
                            echo "应用中";
                        }elseif($end_time < $now_time){
                            echo "已过期";
                        }
                        ?>
                    </td>
				<td>
					<a href="m.php?app=goods_promotions_edit&id=<?php echo $value['id'];?>"><?php echo $a_langpackage->a_update; ?></a>
					<a href="a.php?act=goods_promotions_del&id=<?php echo $value['id'];?>" onclick="return confirm('<?php echo $a_langpackage->a_goods_promotions_del_mess; ?>');"><?php echo $a_langpackage->a_delete; ?></a>
				</td>
			</tr>
			<?php }} else { ?>
			<tr>
				<td colspan="7"><?php echo $a_langpackage->a_no_list; ?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	  </div>
	 </div>
	</div>
</div>
</body>
</html>