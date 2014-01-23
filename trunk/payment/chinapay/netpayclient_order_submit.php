<?php
header('Content-type: text/html; charset=gbk');
include_once("netpayclient_config.php");
?>
<title>֧������</title>
<?php
//���� netpayclient ���
include_once("netpayclient.php");

//����˽Կ�ļ�, ����ֵ��Ϊ����̻��ţ�����15λ
$merid = buildKey(PRI_KEY);
if (!$merid) {
    echo "����˽Կ�ļ�ʧ�ܣ�";
    exit;
}

//��ɶ����ţ�����16λ������������ϣ�һ���ڲ������ظ���������õ�ǰʱ���������
$ordid = "00" . date('YmdHis');
//����������12λ���Է�Ϊ��λ��������0������
$transamt = padstr('1', 12);
//���Ҵ��룬3λ�������̻��̶�Ϊ156����ʾ����ң�����
$curyid = "156";
//�������ڣ�������õ�ǰ���ڣ�����
$transdate = date('Ymd');
//�������ͣ�0001 ��ʾ֧�����ף�0002 ��ʾ�˿��
$transtype = "0001";
//�ӿڰ汾�ţ�����֧��Ϊ 20070129������
$version = "20070129";
//ҳ�淵�ص�ַ(��������Ͽɷ��ʵ�URL)���80λ�����û����֧��������ҳ����Զ���ת����ҳ�棬��POST���������Ϣ����ѡ
$pagereturl = "$site_url/netpayclient_order_feedback.php";
//��̨���ص�ַ(��������Ͽɷ��ʵ�URL)���80λ�����û����֧�����ҷ���������POST���������Ϣ����ҳ�棬����
$bgreturl = "$site_url/netpayclient_order_feedback.php";

/************************
 * ҳ�淵�ص�ַ�ͺ�̨���ص�ַ�����
 * ��̨���ش��ҷ������������������û��������������Ӱ�죬�Ӷ�֤���׽����ʹ
 ************************/

//֧����غţ�4λ������ʱ�������գ�����ת�������б�ҳ�����û�����ѡ�񣬱�ʾ��ѡ��0001ũ������ر��ڲ��ԣ���ѡ
$gateid = "0001";
//��ע���60λ�����׳ɹ����ԭ��أ������ڶ���Ķ������ٵȣ���ѡ
$priv1 = "memo";

//��������϶�����ϢΪ��ǩ��
$plain = $merid . $ordid . $transamt . $curyid . $transdate . $transtype . $priv1;
//���ǩ��ֵ������
$chkvalue = sign($plain);
if (!$chkvalue) {
    echo "ǩ��ʧ�ܣ�";
    exit;
}
?>
<h1>֧������</h1>
<h3>֧�����Է���</h3>
<h4>�����֧������ť����ת��ũ�������֧��ҳ������뿨�ܺ���֤�뼴�����֧������������ʱ��ѡ�񡰼��̡�</h4>
<h5>���ţ�[1234567890000000000]</h5>
<h5>���룺[000000]</h5>
<h5><a href="javascript:window.location.reload()">ˢ�±�ҳ�Ըı䶩����</a></h5>


<form action="<?php echo REQ_URL_PAY; ?>" method="post" target="_blank">
    <label>�̻���</label><br/>
    <input type="text" name="MerId" value="<?php echo $merid; ?>" readonly/><br/>
    <label>֧���汾��</label><br/>
    <input type="text" name="Version" value="<?php echo $version; ?>" readonly/><br/>
    <label>������</label><br/>
    <input type="text" name="OrdId" value="<?php echo $ordid; ?>" readonly/><br/>
    <label>�������</label><br/>
    <input type="text" name="TransAmt" value="<?php echo $transamt; ?>" readonly/><br/>
    <label>���Ҵ���</label><br/>
    <input type="text" name="CuryId" value="<?php echo $curyid; ?>" readonly/><br/>
    <label>��������</label><br/>
    <input type="text" name="TransDate" value="<?php echo $transdate; ?>" readonly/><br/>
    <label>��������</label><br/>
    <input type="text" name="TransType" value="<?php echo $transtype; ?>" readonly/><br/>
    <label>��̨���ص�ַ</label><br/>
    <input type="text" name="BgRetUrl" value="<?php echo $bgreturl; ?>"/><br/>
    <label>ҳ�淵�ص�ַ</label><br/>
    <input type="text" name="PageRetUrl" value="<?php echo $pagereturl; ?>"/><br/>
    <label>��غ�</label><br/>
    <input type="text" name="GateId" value="<?php echo $gateid; ?>"/><br/>
    <label>��ע</label><br/>
    <input type="text" name="Priv1" value="<?php echo $priv1; ?>" readonly/><br/>
    <label>ǩ��ֵ</label><br/>
    <input type="text" name="ChkValue" value="<?php echo $chkvalue; ?>" readonly/><br/>
    <input type="submit" value="֧��">
</form>