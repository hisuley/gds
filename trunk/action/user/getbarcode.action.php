<?php

//引入模块公共方法文件
require("foundation/module_barcode.php");
//require("foundation/module_goods.php");
//require("foundation/module_photo.php");

//语言包引入
$order_id = intval($_GET['order_id']);
<<<<<<< HEAD
$address = $SYSINFO['web']."do.php?act=user_readbarcode&order_id=".$order_id."&mark_read=1&sign=".$_GET['sign'];
=======
$address = $SYSINFO['web'] . "do.php?act=user_readbarcode&order_id=" . $order_id . "&mark_read=1";
>>>>>>> remotes/origin/master
$barcodeImage = generateQRfromGoogle($address);
echo $barcodeImage;