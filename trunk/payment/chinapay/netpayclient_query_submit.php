<?php
header('Content-type: text/html; charset=gbk');
include_once("netpayclient_config.php");
?>
    <title>���ʲ�ѯ</title>
    <h1>���ʲ�ѯ</h1>
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

//��Ҫ��ѯ�Ķ����ţ�16λ��
$ordid = $_REQUEST["ordid"];
//�������ڣ�8λ��
$transdate = $_REQUEST["transdate"];

if ($transdate == '') $transdate = date('Ymd');

?>
    <form action="" method="get">
        <label>��������</label><br/>
        <input type="text" name="transdate" value="<?php echo $transdate; ?>"><br/>
        <label>������</label><br/>
        <input type="text" name="ordid" value="<?php echo $ordid; ?>"><br/>
        <input type="submit" value="��ѯ">
    </form>
<?
if (($ordid != '') && ($transdate != '')) {
    //�������ͣ��̶�Ϊ֧������ 0001
    $transtype = "0001";
    //�ӿڰ汾�ţ����ʲ�ѯ���̶�Ϊ 20060831������
    $version = "20060831";
    //��ע���60λ����ѡ
    $resv = "memo";

    //��������ϱ�����ϢΪ��ǩ��
    $plain = $merid . $transdate . $ordid . $transtype;
    //���ǩ��ֵ������
    $chkvalue = sign($plain);
    if (!$chkvalue) {
        echo "ǩ��ʧ�ܣ�";
        exit;
    }

    $http = HttpInit();
    $post_data = "MerId=$merid&TransType=$transtype&OrdId=$ordid&TransDate=$transdate&Version=$version&Resv=$resv&ChkValue=$chkvalue";
    $output = HttpPost($http, $post_data, REQ_URL_QRY);

    if ($output) {
        $output = trim(strip_tags($output));

        echo "<h2>��ѯ����</h2>";
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
            $merid = $extracted_data["merid"];
            $orderno = $extracted_data["orderno"];
            $amount = $extracted_data["amount"];
            $currencycode = $extracted_data["currencycode"];
            $transdate = $extracted_data["transdate"];
            $transtype = $extracted_data["transtype"];
            $status = $extracted_data["status"];
            $checkvalue = $extracted_data["checkvalue"];

            $gateid = $extracted_data["GateId"];
            $priv1 = $extracted_data["Priv1"];
        } else {
            $message = $extracted_data["Message"];
        }

        switch ($resp_code) {

            case '111':
                echo "<h3>$message</h3>";
                echo "<h4>��ȷ�����Ƿ����뿪ͨ�˴�ҵ�񣬲��ṩ����ȷ�Ĺ���IP��ַ</h4>";
                break;
            case '307':
                echo "<h3>$message</h3>";
                echo "<h4>����д�Ķ����Ż򶩵���������δ�ܲ�ѯ���ñʶ���</h4>";
                break;
            case '0'  :
                echo "<h3>��ѯ�����ͳɹ�</h3>";

                //��ʼ��֤ǩ�����ȵ��빫Կ�ļ�
                $flag = buildKey(PUB_KEY);
                if (!$flag) {
                    echo "���빫Կ�ļ�ʧ�ܣ�";
                } else {
                    $flag = verifyTransResponse($merid, $orderno, $amount, $currencycode, $transdate, $transtype, $status, $checkvalue);
                    if ($flag) {
                        //��֤ǩ��ɹ���
                        echo "<h4>��֤ǩ��ɹ�</h4>";
                        //������Լ���Ҫ������߼�д������

                    } else {
                        echo "<h4>��֤ǩ��ʧ�ܣ�</h4>";
                    }
                }
                break;
            default   :
                echo "<h3>��ѯ������ʧ��</h3>";
                echo "<h4>����Ľӿ��ĵ���¼��ȷ���������ԭ��</h4>";
                break;

        }
    } else {
        echo "<h3>HTTP ����ʧ�ܣ�</h3>";
    }
    HttpDone($http);
} else {
    echo "<h3>����д�������ںͶ�����</h3>";
}
?>