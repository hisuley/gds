<?php

//语言包引入
$m_langpackage=new moduleslp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_order_goods = $tablePreStr."order_goods";
$t_user = $tablePreStr."users";
$order_id = intval(get_args('order_id'));
$mark_read = intval(get_args('mark_read'));
$mark_as_paid = get_args('mark_as_paid');
if($mark_as_paid == 1){
    $sql_update = "UPDATE $t_order_info SET pay_status = 1 WHERE order_id = ".$order_id;
    $dbo->exeUpdate($sql_update);
    $message = "验票成功！";
}elseif($mark_as_paid == 2){
    $sql_update = "UPDATE $t_order_info SET pay_status = 0 WHERE order_id = ".$order_id;
    $dbo->exeUpdate($sql_update);
    $message = "操作成功！该票已经设置为未验票！";
}

$sql_order = "SELECT * FROM $t_order_info WHERE order_id = ".$order_id;
$result = $dbo->getRow($sql_order);
$sql_goods = "SELECT * FROM $t_order_goods WHERE order_id = ".$order_id;
$order_goods = $dbo->getRs($sql_goods);
$sql_username = "SELECT user_name FROM $t_user WHERE user_id = ".$result['user_id'];
$userContainer = $dbo->getCol($sql_username);
//print_r($userContainer);
$user = !empty($userContainer[0]) ? $userContainer[0] : '';
if($mark_read == 1){
    $sql = "UPDATE $t_order_info SET is_barcode_read = 1 where order_id = ".$order_id;
    $dbo->exeUpdate($sql);
}
?>
<style>
    form{font-size:2em;margin-top:20px;text-align: center;}
    form input[type='submit']{padding-top:0.5em;padding-bottom:0.5em;width:100%;font-size:2em}
    h1{font-size: 1.2em;width:100%;display: block}
    table {
        overflow:hidden;
        border:1px solid #d3d3d3;
        background:#fefefe;
        width:100%;
        font-size:2.5em;
        margin:1% 0px auto 0;
        -moz-border-radius:5px; /* FF1+ */
        -webkit-border-radius:5px; /* Saf3-4 */
        border-radius:5px;
        -moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    }

    th, td {padding:15px 10px 10px; text-align:center; }

    th {text-shadow: 1px 1px 1px #fff; background:#e8eaeb;}

    td {border-top:1px solid #e0e0e0; border-right:1px solid #e0e0e0;}

    tr.odd-row td {background:#f6f6f6;}

    td.first, th.first {text-align:left}

    td.last {border-right:none;}

    /*
    Background gradients are completely unnecessary but a neat effect.
    */

    td {
        background: -moz-linear-gradient(100% 25% 90deg, #fefefe, #f9f9f9);
        background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f9f9f9), to(#fefefe));
    }

    tr.odd-row td {
        background: -moz-linear-gradient(100% 25% 90deg, #f6f6f6, #f1f1f1);
        background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f1f1f1), to(#f6f6f6));
    }

    th {
        background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
        background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#ededed), to(#e8eaeb));
    }
    a.button{display: inline-block;
        float: right;
        text-decoration: none;
        margin-top: -85px;
        margin-right: 30px;
        background-color: green;
        color:white;
        border-radius: 10px;
        padding-left:10px;
        padding-right:10px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    a.button:hover{
        background: #990000;
    }
</style>

<table>
    <tr><td colspan="2"><h1>桂林目的地营销系统二维码扫描</h1><a  class="button" href="<?php echo $SYSINFO['web']."do.php?act=user_readbarcode&order_id=".$order_id; ?>">刷新</a></td></tr>

    <?php if(!empty($message)){ ?>
        <tr style="color:green;">
            <td colspan="2"><?php echo $message; ?></td>
        </tr>
    <?php } ?>

    <tr>
        <th>订单号：</th>
        <td><?php echo $order_id; ?></td>
    </tr>

<tr>
    <th>总金额：</th>
    <td>
        <?php
        echo $result[order_amount];
        ?>
    </td>
</tr>
    <tr>
        <th>下单日期：</th>
        <td>
            <?php
            echo $result[order_time];
            ?>
        </td>
    </tr>
    <tr>
        <th>订购商品：</th>
        <td><?php
            foreach($order_goods as $v){
                echo $v['goods_name']."(￥".$v['goods_price']."）\n";
            }
            ?></td>
    </tr>
    <tr>
        <th>订购人：</th>
        <td>
            <?php echo $user; ?>
        </td>
        </tr><tr>
        <th>支付情况：</th>
        <td>
            <?php
            if($result[pay_status] == 1){
                echo "已支付";
            }else{
                echo "未支付";
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>二维码验证：</th>
        <td>
            <?php
            if($result[is_barcode_read] == 1){
                echo "已扫描";
            }else{
                echo "未扫描";
            }
            ?>
        </td>
    </tr>

</table>
<?php
if($result[pay_status] == 1){
    ?>
    <form method="post" action="<?php echo $SYSINFO['web']."do.php?act=user_readbarcode&order_id=".$order_id; ?>">
        <input type="hidden" name="mark_as_paid" value="2"/>
        <input type="submit" value="撤销验票" style="background-color:red;color:white;"/>
    </form>
<?php
}else{
    ?>
    <form method="post" action="<?php echo $SYSINFO['web']."do.php?act=user_readbarcode&order_id=".$order_id; ?>">
        <input type="hidden" name="mark_as_paid" value="1"/>
        <input type="submit" value="验票" style="background-color:#99DD00;color:white"/>
    </form>
<?php
}
?>