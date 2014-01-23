<?php
header('Content-type: text/html; charset=gbk');
include_once("netpayclient_config.php");
?>
    <title>�˿�Ӧ��</title>
    <h1>�˿�Ӧ��</h1>
<?php
//���� netpayclient ���
include_once("netpayclient.php");

//���빫Կ�ļ�
$flag = buildKey(PUB_KEY);
if (!$flag) {
    echo "���빫Կ�ļ�ʧ�ܣ�";
    exit;
}

//ȡ���˿�Ӧ���еĸ���ֵ
$merid = $_REQUEST["MerID"];
$orderno = $_REQUEST["OrderId"];
$refundamount = $_REQUEST["RefundAmout"];
$currencycode = $_REQUEST["currencycode"];
$processdate = $_REQUEST["ProcessDate"];
$sendtime = $_REQUEST["SendTime"];
$transtype = $_REQUEST["TransType"];
$status = $_REQUEST["Status"];
$checkvalue = $_REQUEST["CheckValue"];
$priv1 = $_REQUEST["Priv1"];

$plain = $merid . $processdate . $transtype . $orderno . $refundamount . $status . $priv1;
//��ʾ���������¼�ļ���־������������Ƿ��յ�Ӧ��
traceLog("refund.log", $plain);

$flag = verify($plain, $checkvalue);
if ($flag) {
    //��֤ǩ��ɹ���
    echo "<h4>��֤ǩ��ɹ�</h4>";
    if ($status == '3') {
        //�˿����
        echo "<h3>�˿�ɹ�</h3>";
        //������Լ���Ҫ������߼�д�����


    } else {
        echo "<h3>�˿�ʧ��</h3>";
    }
} else {
    echo "<h4>��֤ǩ��ʧ�ܣ�</h4>";
}

?>