<?php
/* ----------------------------------------------------------------------- *\
   PHP-�������ķִ� (SCWS) ver 3.1/2.1 (ʵ����ʾ)
   
   (v2) ���ڴ�Ƶ�ʵ�����������,
   (v3) ˫���ݴ�Ƶȡ�ϸ�֮�ַ�

   �������汾���÷��� API һ��.
   $Id: demo.php,v 1.2 2008/12/20 12:18:15 hightman Exp $

   -----------------------------------------------------------------------
   ����: ������(hightman) (MSN: MingL_Mar@msn.com) (php-QQȺ: 17708754)
   ��վ: http://www.ftphp.com/scws
   ʱ��: 2006/03/05
   �޶�: 2008/12/20
   Ŀ��: ѧϰ�о�������, ϣ���кõĽ��鼰��;ϣ���ܽ�һ������.
   -----------------------------------------------------------------------
   ����: PHP 4.1.0����߰汾�� PHP5 (���뽨�� --enable-dba --with-[cdb|gdbm])
\* ----------------------------------------------------------------------- */

/**
 * �鿴Դ��Ĳ��� <*.php?source>
 */

$stag = 'source';
$slen = strlen($stag);
if (isset($_SERVER['QUERY_STRING'])
    && !strncmp($_SERVER['QUERY_STRING'], $stag, $slen)
) {
    $qlen = strlen($_SERVER['QUERY_STRING']);
    $files = array('pscws2', 'pscws3', 'dict', 'xdb_r');
    $file = ($qlen > $slen && $qlen < ($slen + count($files))) ? $files[$qlen - $slen] . '.class.php' : __FILE__;
    highlight_file($file);
    exit(0);
}

/**
 * ʵ��ʼ
 */

// ���Լ���ʵ������ʱ��
function get_microtime()
{
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = get_microtime();

// �ִʽ��֮�ص����� (param: �ֺõĴ���ɵ�����)
function words_cb($ar)
{
    foreach ($ar as $tmp) {
        if ($tmp == "\n") {
            echo $tmp;
            continue;
        }
        echo $tmp . ' ';
    }
    flush();
}

// ʵ��ǰ�Ĳ���ָ�����ȡ
$dict = 'dict/dict.xdb'; // Ĭ�ϲ��� xdb (���������κ�����)
$mydata = NULL; // �������
$version = 3; // ���ð汾
$autodis = false; // �Ƿ�ʶ������
$ignore = false; // �Ƿ���Ա��
$debug = false; // �Ƿ�Ϊ���ģʽ
$stats = false; // �Ƿ�鿴ͳ�ƽ��
$is_cli = (php_sapi_name() == 'cli'); // �Ƿ�Ϊ cli ���л���
$sample_text = <<<__EOF__
�¿��貢���ǡ��޼�����Ψһ����Ȩ�ˣ�һ����Ӱ�������Ȩ���Ӱ��Ƭ�����С�

һ����Ӱ�����߰������ݡ���Ӱ�����ȴ�����Ա����Щ������Ա�����ǵĴ������а�Ȩ�ġ���������Ƭ����Ȩ�������˲��ܶԵ�Ӱ�����������С���ӳ������ͨ���������������Ȳ��ܰѵ�Ӱ�ı��С˵��������������������ʽ���?Ҳ���ܰ�һ������Сʱ���ܷ���ĵ�Ӱ�ı�ɰ��Сʱ���ܷ���Ķ�Ƭ��

����Ȩ�Ͱ�Ȩ���ҹ���ͬһ������Ƿ��ɸ�����Ʒ�����ߵ�ר��Ȩ����νר��Ȩ�����û�о���Ȩ��������ֲ��Ƿ��ɹ涨�����⣬Ҫʹ�������Ʒ���ͱ��뾭��������Ȩ��û����Ȩ������Ȩ��
__EOF__;

// ��ݲ�ͬ�汾�Ļ�����ȡ��������
if ($is_cli) {
    $argc = $_SERVER['argc'];
    for ($i = 1; $i < $argc; $i++) {
        $optarg = $_SERVER['argv'][$i];
        if (!strncmp($optarg, "--", 2)) {
            $cmp = substr($optarg, 2);
            if (!strcasecmp($cmp, "help")) {
                $mydata = NULL;
                break;
            } else if (!strcasecmp($cmp, "autodis"))
                $autodis = true;
            else if (!strcasecmp($cmp, "ignore"))
                $ignore = true;
            else if (!strcasecmp($cmp, "v2"))
                $version = 2;
            else if (!strcasecmp($cmp, "debug"))
                $debug = true;
            else if (!strcasecmp($cmp, "stats"))
                $stats = true;
            else if (!strcasecmp($cmp, "dict")) {
                $i++;
                $dict = $_SERVER['argv'][$i];
            }
        } else if (is_null($mydata)) {
            if (is_file($optarg)) $mydata = @file_get_contents($optarg);
            else $mydata = trim($optarg);
        }
    }
} else {
    // ���ֲ���ѡ��
    $checked_ignore = $checked_autodis = $checked_v2 = '';

    // �Ƿ�ָ���е� 2 ��
    if (isset($_REQUEST['version']) && $_REQUEST['version'] == 2) {
        $version = 2;
        $checked_v2 = ' selected';
    }

    // �Ƿ�ָ��һ���ʵ��ʽ
    $selected_gdbm = $selected_text = $selected_sqlite = '';
    if (isset($_REQUEST['dict'])) {
        if ($_REQUEST['dict'] == 'gdbm') {
            $dict = 'dict/dict.gdbm';
            $selected_gdbm = ' selected';
        } else if ($_REQUEST['dict'] == 'text') {
            $dict = 'dict/dict.txt';
            $selected_text = ' selected';
        } else if ($_REQUEST['dict'] == 'sqlite') {
            $dict = 'dict/dict.sqlite';
            $selected_sqlite = ' selected';
        } else if ($_REQUEST['dict'] == 'cdb') {
            $dict = 'dict/dict.cdb';
            $selected_cdb = ' selected';
        } else {
            $_REQUEST['dict'] = 'xdb';
        }
    }

    // �Ƿ�������ʶ�� (ȱʡ�ر�)
    if (isset($_REQUEST['autodis']) && !strcmp($_REQUEST['autodis'], 'yes')) {
        $autodis = true;
        $checked_autodis = ' checked';
    }

    // �Ƿ��������
    if (isset($_REQUEST['ignore']) && !strcmp($_REQUEST['ignore'], 'yes')) {
        $ignore = true;
        $checked_ignore = ' checked';
    }

    // �Ƿ���debug
    if (isset($_REQUEST['debug']) && !strcmp($_REQUEST['debug'], 'yes')) {
        $debug = true;
        $checked_debug = ' checked';
    }

    // �Ƿ�ͳ�Ʊ�
    if (isset($_REQUEST['stats']) && !strcmp($_REQUEST['stats'], 'yes')) {
        $stats = true;
        $checked_stats = ' checked';
    }

    // �з����
    if (!isset($_REQUEST['mydata']) || empty($_REQUEST['mydata'])) {
        $mydata = $sample_text;
    } else {
        $mydata = & $_REQUEST['mydata'];
        if (get_magic_quotes_gpc())
            $mydata = stripslashes($mydata);
    }
}

// ������� \r\n\t
if (!is_null($mydata))
    $mydata = trim($mydata);

// ʵ��ִʶ���(mydata�ǿ�)
$object = 'PSCWS' . $version;
require(strtolower($object) . '.class.php');

$cws = new $object($dict);
$cws->set_ignore_mark($ignore);
$cws->set_autodis($autodis);
$cws->set_debug($debug);
// hightman.060330: ǿ�п���ͳ��
$cws->set_statistics($stats);

?>
<?php if (!$is_cli) { ?>
<html>
<head>
    <title>PHP �������ķִ�(SCWS) ��<?php echo $version; ?>��������ʾ (by hightman)</title>
    <meta http-equiv="Content-type" content="text/html; charset=gbk">
    <style type="text/css">
        <!--
        td, body {
            background-color: #efefef;
            font-family: tahoma;
            font-size: 14px;
        }

        .demotx {
            font-size: 12px;
            width: 100%;
            height: 100px;
        }

        small {
            font-size: 12px;
        }

        /
        /
        -->
    </style>
</head>
<body>
<h3>
    <font color=red>PHP �������ķִ�(SCWS)</font>
    <font color=blue>��<?php echo $version; ?>��</font> - ������ʾ (by hightman)
</h3>
����: (v2)��ݴ�Ƶ�ʵ���������е�ִ�, (v3)˫���ݴ�Ƶȡ�ϸ�֮�ַ�, �����������ܱ��� (�ʵ��ʽ: xdb/gdbm/cdb/sqlite/text��)
<hr/>

<table width=100% border=0>
    <tr>
        <form method=post>
            <td width=100%>
                <strong>���������ֵ���ύ���Էִ�: </strong> <br/>
                <textarea name=mydata cols=60 rows=8 class=demotx><?php echo $mydata; ?></textarea>
                <small>
                    <input type=checkbox name=autodis value="yes"<?php echo $checked_autodis; ?>> ����ʶ������
                    &nbsp;
                    <input type=checkbox name=ignore value="yes"<?php echo $checked_ignore; ?>> �������
                    &nbsp;
                    <input type=checkbox name=stats value="yes"<?php echo $checked_stats; ?>> <font
                        color=red>ͳ�ƽ��</font>
                    &nbsp;
                    <input type=checkbox name=debug value="yes"<?php echo $checked_debug; ?>> debug
                    &nbsp;
                    <br/>
                    �ʵ��ʽ:
                    <select name=dict size=1>
                        <option value=xdb>XDB</option>
                        <option value=cdb<?php echo $selected_cdb; ?>>CDB</option>
                        <option value=gdbm<?php echo $selected_gdbm; ?>>GDBM</option>
                        <option value=text<?php echo $selected_text; ?>>Text</option>
                        <option value=sqlite<?php echo $selected_sqlite; ?>>SQLite2.x</option>
                    </select>
                    &nbsp;
                    ���Բ��õ�
                    <select name=version size=1 style="color: red; font-weight: bold;">
                        <option value=3>3</option>
                        <option value=2<?php echo $checked_v2; ?>>2</option>
                    </select>
                    ��ִ��㷨
                    &nbsp;&nbsp;
                </small>
                <input type=submit>
            </td>
        </form>
    </tr>
    <tr>
        <td>
            <hr/>
        </td>
    </tr>
    <tr>
        <td width=100%>
            <strong>�ִʽ��(ԭ���ܳ��� <?php echo strlen($mydata); ?> �ַ�) </strong>
            <br/>
            <textarea cols=60 rows=8 class=demotx readonly style="color:#888888;">
                <?php } else { ?>
                _____________________________________________________________________

                PHP�������ķִʳ���(SCWS) - ��<?php echo $version; ?>�� - by hightman
                _____________________________________________________________________
                1.���ڴ�Ƶ�ʵ�����������(v2), ˫���ݴ�Ƶȡ�ϸ�֮�ַ�(v3)
                2.�÷�: <?php echo $_SERVER['argv'][0]; ?> [ѡ��]
                <string
                |file>
                3.ѡ��: --autodis ������ʶ��
                --ignore ������еı����
                --v2 ʹ�õ�2��ִ��㷨(ȱʡ��3��)
                --stats ����ͳ�Ʒִʽ��
                --dict
                <file>ֱ��ָ���ʵ��ļ�, ��׺(.xdb|.cdb|.gdbm|.txt|.sqlite)
                    --help ��ʾ��ҳ�����ļ�
                    4.���: ֱ������ִʽ��, ��֮���Կո�ָ�
                    _____________________________________________________________________

                    <?php } ?>
                    <?php
                    // ִ���з�, �ִʽ������ִ�� words_cb()
                    $cws->segment($mydata, 'words_cb');

                    // �з�ʱ��ͳ��
                    $time_end = get_microtime();
                    $time = $time_end - $time_start;

                    // hightman.060330: �ִʽ���
                    $stat_string = '';
                    if ($stats) {
                        $stat_string .= sprintf("%-16s  %-8s  %s\n", '�ֻ��', '����', '����λ��');
                        $stat_string .= str_repeat('-', 70) . "\n";

                        $list = & $cws->get_statistics();
                        $word_num = 0;
                        foreach ($list as $k => $v) {
                            $stat_string .= sprintf("%-16s  %-8d  %s\n", $k, $v['times'], implode(', ', $v['poses']));
                            $word_num += $v['times'];
                        }

                        $stat_string .= str_repeat('-', 70) . "\n";
                        $stat_string .= sprintf("�ϼ�:%4d ��      %-8d\n", count($list), $word_num);
                    }

                    // ������ʾ���
                    ?>
                    <?php if (!$is_cli) { ?>
            </textarea>
            <small>
                �ִʺ�ʱ: <?php echo $time; ?>��,
                �ʵ�: <?php echo $dict; ?>, ��ѯ����: <?php echo $cws->_dict->query_times; ?>��
            </small>
        </td>
    </tr>
</table>
<hr/>
<pre>
<?php echo $stat_string; ?>
</pre>
<hr/>
<small>
    ע: ��������뼰��شʵ���ѿ�������, ���о�ѧϰ����.
    �μ���ҳ <a href=http://www.ftphp.com/scws target=_blank>http://www.ftphp.com/scws</a>
    ��ֱ�� <a href="?source" target="_blank">�鿴Դ��</a>
</small>
</body>
</html>
<?php } else if (!empty($mydata)) { ?>

    _____________________________________________________________________
    �ܳ�: <?php echo strlen($mydata); ?>�ַ�, ��ʱ: <?php echo $time; ?>��, ��ʴ���: <?php echo $cws->_dict->query_times; ?>��, �ʵ�: <?php echo $dict; ?>

    <?php echo $stat_string;
} ?>
