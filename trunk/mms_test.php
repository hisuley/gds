<?php
/**
 * Created by Suley.
 * @author: suley<dearsuley@gmail.com>
 * @date: 1/23/14
 * @time: 6:48 PM
 */

$IWEB_SHOP_IN = true;
require_once('foundation/module_barcode.php');
require_once('foundation/mms_sender.php');

$address = "do.php?act=user_readbarcode&order_id=1111&mark_read=1";
$barcodeFile = generateQRfromGoogleRaw($address);
$QR = imagecreatefrompng($barcodeFile);
//header('Content-type: image/jpg');
$filename = 'uploadfiles/qr/'.rand('000000000000000000', '99999999999999999999999')."_qr.jpg";
imagejpeg($QR, $filename);
$mmsSender = new mms_sender(15295889169);
$mmsSender->addFrame(2, $filename, 'jpg');
$result = $mmsSender->send();
imagedestroy($QR);
//print_r($result);
?>