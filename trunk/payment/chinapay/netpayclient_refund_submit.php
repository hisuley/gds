<?php
header('Content-type: text/html; charset=gbk');
include_once("netpayclient_config.php");
?>
    <title>�����˿�</title>
    <h1>�����˿�</h1>
<?php
//���� netpayclient ���
include_once("netpayclient.php");
//���� CURL ����⣬�ÿ��� chinapay �ṩ��������ʹ�� curl ���� HTTP ����
include_once("lib_curl.php");

//����˽Կ�ļ�, ����ֵ��Ϊ����̻��ţ�����15λ
$merid = buildKey(PRI_KEY);
if (!$merid) {
    echo "����˽Կ�ļ�ʧ�ܣ�";
    exit;
}

//��Ҫ��ѯ�Ķ����ţ�16λ��������
$ordid = $_REQUEST["ordid"];
//�������ڣ�8λ��������
$transdate = $_REQUEST["transdate"];
//�˿������С��ԭʼ���׽�12λ����������0������
$refundamount = $_REQUEST["refundamount"];
//�������ͣ�4λ�����˴���ʾ�˿ʽ 0002 Ϊȫ���˿0102 Ϊ�����˿����
$transtype = $_REQUEST["transtype"];
//��ע���˿�ʱ�����˿���ˮ�ţ�һ���ڲ����ظ����40λ������˴�ʹ�õ�ǰʱ�����������ʾ
$priv1 = date('YmdHis');

if ($transdate == '') $transdate = date('Ymd');

if ($refundamount == '') $refundamount = padstr('1', 12);

if ($transtype == '') $transtype = '0002';

?>
    <form action="" method="get">
        <label>�˿���ˮ</label><br/>
        <input type="text" name="priv1" value="<?php echo $priv1; ?>"><br/>
        <label>��������</label><br/>
        <input type="text" name="transdate" value="<?php echo $transdate; ?>"><br/>
        <label>������</label><br/>
        <input type="text" name="ordid" value="<?php echo $ordid; ?>"><br/>
        <label>�˿���</label><br/>
        <input type="text" name="refundamount" value="<?php echo $refundamount; ?>"><br/>
        <label>�˿ʽ</label><br/>
        <select name="transtype">
            <option value="0002">�״�ȫ���˿�</option>
            <option value="0012">����ȫ���˿�</option>
            <option value="0102">�״β����˿�</option>
            <option value="0112">���β����˿�</option>
        </select>
        <input type="submit" value="�˿�">
    </form>
<?
if (($ordid != '') && ($transdate != '') && ($refundamount != '')) {
    //�ӿڰ汾�ţ������˿�̶�Ϊ 20070129������
    $version = "20070129";
    //�˿�ص�ַ���˿��ύ���辭���˹���˴��?����T+2�պ���ɣ���ʱ�ҷ���������POST�˿���õ�ַ
    $returnurl = "$site_url/netpayclient_refund_feedback.php";

    //��������ϱ�����ϢΪ��ǩ��
    $plain = $merid . $transdate . $transtype . $ordid . $refundamount . $priv1;
    //���ǩ��ֵ������
    $chkvalue = sign($plain);
    if (!$chkvalue) {
        echo "ǩ��ʧ�ܣ�";
        exit;
    }

    //����ύ��ַΪ ,�������Կ����ע���޸�

    $http = HttpInit();
    $post_data = "MerID=$merid&TransType=$transtype&OrderId=$ordid&RefundAmount=$refundamount&TransDate=$transdate&Version=$version&ReturnURL=$returnurl&Priv1=$priv1&ChkValue=$chkvalue";
    $output = HttpPost($http, $post_data, REQ_URL_REF);

    if ($output) {
        $output = trim(strip_tags($output));

        echo "<h2>�˿��</h2>";
        echo htmlspecialchars($output) . "<br/>";
        echo "=================================<br/>";
        //��ʼ�������
        $datas = explode("&", $output);
        $extracted_data = array();
        foreach ($datas as $data) {
            echo "$data<br/>";
            $name_value = explode('=', $data);
            if (count($name_value) == 2) {
                $extracted_data[$name_value[0]] = $name_value[1];
            }
        }

        echo "=================================<br/>";

        $resp_code = $extracted_data["ResponseCode"];
        if ($resp_code == '0') {
            $merid = $extracted_data["MerID"];
            $orderno = $extracted_data["OrderId"];
            $refundamount = $extracted_data["RefundAmout"];
            $currencycode = $extracted_data["currencycode"];
            $processdate = $extracted_data["ProcessDate"];
            $sendtime = $extracted_data["SendTime"];
            $transtype = $extracted_data["TransType"];
            $status = $extracted_data["Status"];
            $checkvalue = $extracted_data["CheckValue"];
            $priv1 = $extracted_data["Priv1"];
        } else {
            $message = $extracted_data["Message"];
        }

        switch ($resp_code) {

            case '111':
                echo "<h3>$message</h3>";
                echo "<h4>��ȷ�����Ƿ����뿪ͨ�˴�ҵ�񣬲��ṩ����ȷ�Ĺ���IP��ַ</h4>";
                break;
            case '0'  :
                echo "<h3>�˿������ͳɹ�</h3>";

                //��ʼ��֤ǩ�����ȵ��빫Կ�ļ�
                $flag = buildKey(PUB_KEY);
                if (!$flag) {
                    echo "���빫Կ�ļ�ʧ�ܣ�";
                } else {
                    $plain = $merid . $processdate . $transtype . $orderno . $refundamount . $status . $priv1;
                    $flag = verify($plain, $checkvalue);
                    if ($flag) {
                        //��֤ǩ��ɹ���
                        echo "<h4>��֤ǩ��ɹ�</h4>";
                        if ($status == '1') {
                            //chinapay �����˿�����ɹ��������˹���˽׶�
                            echo "<h3>�˿��ύ�ɹ�</h3>";
                            //������Լ���Ҫ������߼�д������


                        }

                    } else {
                        echo "<h4>��֤ǩ��ʧ�ܣ�</h4>";
                    }
                }
                break;
            default   :
                echo "<h3>�˿�������ʧ��</h3>";
                echo "<h4>����Ľӿ��ĵ���¼��ȷ���������ԭ��</h4>";
                break;

        }
    } else {
        echo "<h3>HTTP ����ʧ�ܣ�</h3>";
    }
    HttpDone($http);
} else {
    echo "<h3>����д�����ţ��˿���ȱ�����</h3>";
}
?>