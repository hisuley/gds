<?php
header('Content-type: text/html; charset=gbk');
include_once("netpayclient_config.php");
?>
<title>֧��Ӧ��</title>
<h1>֧��Ӧ��</h1>
<?php
//���� netpayclient ���
include_once("netpayclient.php");

//���빫Կ�ļ�
$flag = buildKey(PUB_KEY);
if (!$flag) {
    echo "���빫Կ�ļ�ʧ�ܣ�";
    exit;
}

//��ȡ����Ӧ��ĸ���ֵ
$merid = $_REQUEST["merid"];
$orderno = $_REQUEST["orderno"];
$transdate = $_REQUEST["transdate"];
$amount = $_REQUEST["amount"];
$currencycode = $_REQUEST["currencycode"];
$transtype = $_REQUEST["transtype"];
$status = $_REQUEST["status"];
$checkvalue = $_REQUEST["checkvalue"];
$gateId = $_REQUEST["GateId"];
$priv1 = $_REQUEST["Priv1"];

echo "�̻���: [$merid]<br/>";
echo "������: [$orderno]<br/>";
echo "��������: [$transdate]<br/>";
echo "�������: [$amount]<br/>";
echo "���Ҵ���: [$currencycode]<br/>";
echo "��������: [$transtype]<br/>";
echo "����״̬: [$status]<br/>";
echo "��غ�: [$gateId]<br/>";
echo "��ע: [$priv1]<br/>";
echo "ǩ��ֵ: [$checkvalue]<br/>";
echo "===============================<br/>";

//��֤ǩ��ֵ��true ��ʾ��֤ͨ��
$flag = verifyTransResponse($merid, $orderno, $amount, $currencycode, $transdate, $transtype, $status, $checkvalue);
if (!flag) {
    echo "<h2>��֤ǩ��ʧ�ܣ�</h2>";
    exit;
}
echo "<h2>��֤ǩ��ɹ���</h2>";
//����״̬Ϊ1001��ʾ���׳ɹ�������Ϊ��������翨�������
if ($status == '1001') {
    echo "<h3>���׳ɹ���</h3>";
    //��Ĵ����߼���д������������ݿ�ȡ�
    //ע�⣺��������ύʱͬʱ��д��ҳ�淵�ص�ַ�ͺ�̨���ص�ַ���ҵ�ַ��ͬ��������������һ����ݿ��ѯ�ж϶���״̬���Է�ֹ�ظ�����ñʶ���

} else {
    echo "<h3>����ʧ�ܣ�</h3>";
}


?>
<h5><a href="netpayclient_query_submit.php?transdate=<?php echo $transdate; ?>&ordid=<?php echo $orderno; ?>"
       target="_blank">��ѯ�ñʶ���</a></h5>

<h5>
    <a href="netpayclient_refund_submit.php?priv1=<?php echo date('YmdHis'); ?>&transdate=<?php echo $transdate; ?>&ordid=<?php echo $orderno; ?>&refundamount=<?php echo $amount; ?>&transtype=0002"
       target="_blank">����ȫ���˿�</a></h5>