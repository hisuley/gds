<?php
error_reporting(0);
/* ----------------------------------------------------------------------- *\
   PHP-�������ķִ� (SCWS) ver 3.1 (2006)
   
   1. ��� GBK�������
   2. ���ڴ�Ƶ�ʵ�����������, ˫���ݴ�Ƶȡ�ϸ�֮�ַ�
   3. ��ѡ��������ʶ�� (*)
   4. �ʵ������ϵ���������һ������, �ṩ gdbm/cdb/xdb �ȸ�ʽ, Լ 26 ���
   5. ��л֯�������ṩ���ղ�����Ĵʵ乩�ο�
   6. �����÷�������:

      require '/path/to/PSCWS3.class.php';
	  $cws = new PSCWS3('dict/dict.xdb');
	  $rs = $cws->segment($string);
	  print_r($rs);

	  // ������÷�������:
	  ->set_dict($fpath);	// �趨�ʵ�·�� (��׺��Ϊ������)
	  ->set_ignore_mark($trueORfalse);
							// �趨�Ƿ�ɾ������
	  ->set_autodis($trueORflase);
							// �趨�Ƿ��Զ���������ʶ��
	  ->set_debug($trueORfalse);
							// չʾ�дʴ�����Ϣ(echo)
	  ->set_statistics($trueORfalse);
							// �Ƿ����ʻ�ͳ��
	  ->get_statistics();
							// ������������ʹ��, ����ͳ�ƽ������
							// ��Ϊ��, ֵ���ɴ����λ���б���ɵ�����
							
	  ->segment($string, [$callback]);
	  ��� $string ִ�зִ�, $callback ��Ϊ�ص�����, ��ѡ. �������и�õ�
	  ����ɵ�����. ��δ�趨 callback ��ú�����кõĴ���ɵ�����.

	  ���ڱ�����һ����ȫ��������ɲŷ���, ���ı����鰴�д����и��Լ���

   -----------------------------------------------------------------------
   ����: ������(hightman) (MSN: MingL_Mar@msn.com) (php-QQȺ: 17708754)
   ��վ: http://www.ftphp.com/scws
   ʱ��: 2006/03/05
   �޶�: 2008/12/20
   Ŀ��: ѧϰ�о�������, ϣ���кõĽ��鼰��;ϣ���ܽ�һ������.
   ��Ȩ: ��������
   $Id: pscws3.class.php,v 1.1 2008/12/20 12:03:00 hightman Exp $
   -----------------------------------------------------------------------
   �����ַ���ж�, ��λ�� 0x81 ~ 0xfe, ��λ�� 0x40 ~ 0xfe
   ���и�λ 0xa1 ~ 0xa9 �Ƿ����, ���ر��ַ�����Ϊ�Ͼ䴦��
   -----------------------------------------------------------------------
   ����ַ� (ascii < 0x80)
   ��д��ĸ: 0x41 ~ 0x5a
   Сд��ĸ: 0x61 ~ 0x7a
   ���ִ�ȫ: 0x31 ~ 0x39
   �������: 0x2d(-), 0x2e(.)
   -----------------------------------------------------------------------
   ȫ���ַ�
   0xa3 (0xb0 ~ 0xb9) ��ȫ������:  ��~��Ӧ�ñ�������ʶ��
   0xa3 ȫ��Ӣ����ĸ: ������(0xc1 ~ 0xda) �ᣭ��(0xe1 ~ 0xfa)
   0xa3 ���ʷ�: �� (0xad)  ��(0xae)
   -----------------------------------------------------------------------
   ����: PHP 4.1.0 ����߰汾�� PHP5 (���뽨�� --enable-dba --with-[cdb|gdbm])
\* ----------------------------------------------------------------------- */

/**
 * �ʵ����Լ����лس�����ض���
 */

define ('_WORD_ALONE_', 0x4000000); /// �ɴʱ��
define ('_WORD_PART_', 0x8000000); /// �ʸ���
define ('_EAKEY_DICT_', 'ea_dict'); /// ��eaccelerator cache ���µĴʵ�
if (!defined('_CRLF_'))
    define ('_CRLF_', "\r\n");

/**
 * �ʵ���������һ���ļ�
 */
require_once(dirname(__FILE__) . '/dict.class.php');

/**
 * �ִʺ�����
 * �Ƚ����Ӹ�ݱ���ż����� ascii �ַ��гɴ������־�
 */
class PSCWS3
{
    var $_dict; // �ʵ䵵��ѯ����
    var $_ignore_mark; // �Ƿ�ɾȥ�־��� (default: true)
    var $_foreign_chars; // ����������������
    var $_surname_chars; // ������������
    var $_surname2_chars; // �������б�
    var $_noname_chars; // �����������ֵ���
    var $_mb_alpha_chars; // ˫�ֽڵ���ĸ�б�
    var $_mb_num1_chars; // ˫�ֽ������б�1
    var $_sb_alpha_chars;
    var $_sb_num_chars;
    var $_cur_sen_buf;
    var $_cur_sen_len;
    var $_autodis;
    var $_debug;
    var $_do_stats;
    var $_statistics; // hightman.060330: ÿ��ͳ��
    var $_cur_sen_off; // hightman.060330: ͳ��ר��, ��ǰ��ƫ����

    // ���캯��, ��ʼ��������
    function PSCWS3($dictfile = '')
    {
        $this->_ignore_mark = false;
        $this->_debug = false;
        $this->_autodis = false;
        $this->_do_stats = false;

        $this->_foreign_chars = "������������˹���Ͷ�ķ����������ղ�����ѽ����ɲ��ɷ򸣺��տ���";
        $this->_foreign_chars .= "����̹ʷ�����Ƕ�������̩���������ֽ�ɭ�»��ߴ��յ���ά����";
        $this->_foreign_chars .= "�����¸�����ī�縥���������ȸ�������ŵ����������ӿƴ�����";
        $this->_foreign_chars .= "������Ī���������¬ʲ��Ħ�����ݺ������ǵϿ�������ɣ���ɲ���";
        $this->_foreign_chars .= "л�����弰ϣ��³ƥ����ӡ�Ű�Ŭ�Ҵ��۷���ͼ���������Ƚ�ݸ�Үɳ";
        $this->_foreign_chars .= "ѷ������";

        $this->_surname_chars = "�������װ������ϱ߱�ز��̲�᯲��³ɳ̳ٳ��ҳ�";
        $this->_surname_chars .= "�����޴����˵ҵ󶡶��Ŷ˶η�������쳷ѷ�����Ǹ�";
        $this->_surname_chars .= "�߸깢�����������ȹŹ˹ٹعܹ���º̺κغպ����";
        $this->_surname_chars .= "���ƻ���ͼ��ּ��彪����������ӿ��¿տ׿���������";
        $this->_surname_chars .= "��������������������������������������������¡��¥¦¬��³";
        $this->_surname_chars .= "½·����������������éë÷������������ĪĲ������ţťũ����";
        $this->_surname_chars .= "����Ƥ��ƽ������������Ǯǿ���������������ȨȽ����������";
        $this->_surname_chars .= "��������ɳ������������ʢʯʷ����˹������̷̸ۢ��������";
        $this->_surname_chars .= "��١����Ϳ������ΣΤκ��ε������������������ϰ����ϯ��";
        $this->_surname_chars .= "������л��������������Ѧ��������������������ҦҶ����������";
        $this->_surname_chars .= "ӦӢ���������������������ξԪԬ���������ղտ����������";
        $this->_surname_chars .= "֣����������ףׯ׿��������";

        $this->_surname2_chars = "���� ���� �ʸ� Ľ�� ŷ�� ���� ˾�� ˾�� ˾ͽ �̨ ��� ";
        $this->_noname_chars = "��˵���ں��Ǳ����������н��������Ϊ��û��";

        $this->_mb_alpha_chars = "�������������������������������";
        $this->_mb_alpha_chars .= "���£ãģţƣǣȣɣʣˣ̣ͣΣϣУѣңӣԣգ֣ףأ٣�";
        $this->_mb_num1_chars .= "��������������������";

        $this->_sb_alpha_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ._-";
        $this->_sb_num_chars = "0123456789.";

        if ('' !== $dictfile)
            $this->set_dict($dictfile);
    }

    // FOR PHP5
    function __construct($dictfile = '')
    {
        $this->PSCWS3($dictfile);
    }

    function __destruct()
    {
    }

    // �趨�ʵ� (��ݺ�׺��ȷ������)
    function set_dict($fpath)
    {
        $this->_dict = new PSCWS23_Dict($fpath);
    }

    // �趨 _ignore_mark ����
    function set_ignore_mark($set)
    {
        if (is_bool($set))
            $this->_ignore_mark = $set;
    }

    // �趨����ʶ��������
    function set_autodis($set)
    {
        if (is_bool($set))
            $this->_autodis = $set;
    }

    // �趨��ʾ debug ��Ϣ
    function set_debug($set)
    {
        if (is_bool($set))
            $this->_debug = $set;
    }

    // hightman.060429: �Ƿ���ͳ��
    function set_statistics($set)
    {
        if (is_bool($set))
            $this->_do_stats = $set;
    }

    // �����ϴ�ͳ�� (�Ƿ���Ҫ�ӿ���?)
    function &get_statistics()
    {
        return $this->_statistics;
    }

    // ����ͳ��
    function _put_statistics($word, $off)
    {
        if (!isset($this->_statistics[$word])) {
            $this->_statistics[$word] = array('times' => 1, 'poses' => array($off));
        } else {
            $this->_statistics[$word]['times']++;
            $this->_statistics[$word]['poses'][] = $off;
        }
    }

    // ����Ӣ�Ļ����ַ��и�ɴ�
    function &segment($str, $cb = '')
    {
        $len = strlen($str);
        $ret = array();
        $qtr = '';
        if (!empty($cb) && !function_exists($cb)) $cb = '';

        // ͳ�ƿ�ʼ
        if ($this->_do_stats)
            $this->_statistics = array();

        for ($i = 0; $i < $len; $i++) {
            $char = $str[$i];
            $ord = ord($char);

            // �Ǻ��ָ�λ�� (��: ����ַ�, ��0x7f, 0x80)
            if ($ord < 0x81) {
                // ����շֺõľ���
                if (!empty($qtr)) {
                    $tmp = $this->_gbk_segment($qtr);
                    if (empty($cb)) $ret = array_merge($ret, $tmp);
                    else call_user_func($cb, $tmp);
                    $qtr = '';
                }

                $this->_cur_sen_off = $i;

                // �������ĸ, ��������ĸΪֹ
                if ($this->_is_alpha($char, true)) {
                    for (; ;) {
                        $j = $i + 1;
                        if ($j >= $len)
                            break;

                        $char2 = $str{$j};
                        if (!$this->_is_alpha($char2))
                            break;

                        $char .= $char2;
                        $i++;
                    }
                } // ���������, ����������Ϊֹ
                else if ($this->_is_num($char, true)) {
                    for (; ;) {
                        $j = $i + 1;
                        if ($j >= $len)
                            break;

                        $char2 = $str{$j};

                        if (!$this->_is_num($char2))
                            break;

                        $char .= $char2;
                        $i++;
                    }
                } // ���� \t\r �� ' '(�ո�)
                else if ($ord === 0x0d || $ord === 0x20 || $ord === 0x09)
                    $char = '';
                else if ($ord !== 0x0a && $this->_ignore_mark)
                    $char = '';

                // ���·ǿս��
                if (strlen($char) > 0) {
                    if (empty($cb)) array_push($ret, $char);
                    else call_user_func($cb, array($char));

                    if ($this->_do_stats && strlen($char) > 1)
                        $this->_put_statistics($char, $this->_cur_sen_off);
                }
            } // ������
            else if ($i < ($len - 1)) {
                $i++;
                $char .= $str[$i];

                // �Ƿ�Ϊ������з���
                if ($ord > 0xa0 && $ord < 0xb0) {
                    // ����շֺõľ���
                    if (!empty($qtr)) {
                        $tmp = $this->_gbk_segment($qtr);
                        if (empty($cb)) $ret = array_merge($ret, $tmp);
                        else call_user_func($cb, $tmp);
                        $qtr = '';
                    }

                    $this->_cur_sen_off = $i - 1;

                    // ˫�ֽ�(��ĸ|����)�ر���
                    if ($ord === 0xa3) {
                        if (strpos($this->_mb_num1_chars, $char) !== false) {
                            for (; ;) {
                                if ($i > ($len - 2))
                                    break;

                                $char2 = substr($str, $i + 1, 2);
                                if (strpos($this->_mb_num1_chars, $char2) === false)
                                    break;

                                $char .= $char2;
                                $i += 2;
                            }
                        } else if (strpos($this->_mb_alpha_chars, $char) !== false) {
                            for (; ;) {
                                if ($i > ($len - 2))
                                    break;

                                $char2 = substr($str, $i + 1, 2);
                                if (strpos($this->_mb_alpha_chars, $char2) === false)
                                    break;

                                $char .= $char2;
                                $i += 2;
                            }
                        } else {
                            $ord = 0xa4; // ����Ϊ�� != 0xa3
                        }
                    }

                    // �����Ҫ���о��ű�������
                    if ($ord === 0xa3 || !$this->_ignore_mark) {
                        if (empty($cb)) array_push($ret, $char);
                        else call_user_func($cb, array($char));

                        if (strlen($char) > 2 && $this->_do_stats)
                            $this->_put_statistics($char, $this->_cur_sen_off);
                    }
                } else {
                    if (empty($qtr))
                        $this->_cur_sen_off = $i - 1;
                    $qtr .= $char;
                }
            }
        }

        // �������������� (��������ʡ�����ж� $iֵ)
        if (!empty($qtr)) {
            $tmp = $this->_gbk_segment($qtr);
            if (empty($cb)) $ret = array_merge($ret, $tmp);
            else call_user_func($cb, $tmp);
        }

        // ������
        return (empty($cb) ? $ret : true);
    }

    // �зִ����ľ��� [���ĺ���]
    function _gbk_segment($sen)
    {
        $this->_cur_sen_buf = & $sen;
        $this->_cur_sen_len = $len = strlen($sen) / 2;

        // step 1: ��ʼ��
        $arch_table = array();
        for ($i = 0; $i < $len; $i++)
            for ($j = 0; $j < $len; $j++)
                $arch_table[$i][$j] = ($i === $j ? 1 : -1);

        // step 2: ��Ѱ����������ʲ��������
        for ($i = 0; $i < $len; $i++) {
            // step 2.0: ����Ҳ�� 2 ������
            if ($len - $i < 2)
                break;

            $try = array(0, 0);

            // step 2.1: ץ����(�����Ҫ�Ļ�)
            if ($this->_autodis)
                $try = $this->_fetch_zhname2($i);

            // step 2.2: ����ץ����
            if (!$try[0])
                $try = $this->_fetch_long($i);

            // step 2.3 ����ץ���ֽ���
            if (!$try[0] && $this->_autodis) {
                $try = $this->_fetch_zhname($i);
                if (!$try[0])
                    $try = $this->_fetch_frname($i);
            }

            // ������
            if ($try[0] >= 2) {
                $j = $i + $try[0] - 1;
                $arch_table[$i][$j] = $try[1] * $try[0];

                // patch: �Ӵʲ�Ҫ���
                if (isset($try[2])) {
                    foreach ($try[2] as $tmp) {
                        $j = $i + $tmp[0] - 1;
                        $arch_table[$i][$j] = $tmp[1] * $tmp[0];
                    }
                }
            }
        }

        // debug info
        if ($this->_debug) {
            $mydog = _CRLF_ . str_repeat('------+', $len + 1) . '------' . _CRLF_;

            echo '������Ϲ�ϵͼ: `' . $sen . '`';
            echo $mydog;

            $head = '(����)|';
            $body = '';
            for ($i = 0; $i < $len; $i++) {
                $head .= sprintf('%6d|', $i);
                $body .= sprintf('%6d|', $i);
                for ($j = 0; $j < $len; $j++) {
                    $body .= sprintf('%6d|', $arch_table[$i][$j]);
                }
                $body .= '      ';
                $body .= $mydog;
            }
            echo $head;
            echo $mydog;
            echo $body;
            flush();
        }

        // step 3: ���Ը��ͼ�������ŷ�ʽ�ִ�, ����˫�������Ա�Ƶ��
        $left_label = array_fill(0, $len, 0);
        $right_label = array_fill(0, $len, 0);
        $left_freq = $right_freq = 0;

        // step 3.1  left => right
        // hightman: ��������->�ҵ�ʱ����м򵥶�����Ƶ���(only2��)
        $i = 0;
        while ($i < $len) {
            $j = $len - 1;
            while ($j >= $i) {
                if ($arch_table[$i][$j] != -1) {
                    // ���� $j �����һ���ʴ�Ƶ
                    $f2 = -1;
                    if ($i < $j) {
                        $k = $len - 1;
                        while ($k > $j) {
                            // �����Ǹ���, �ʲ���鵥��
                            if ($arch_table[$j][$k] != -1) {
                                $f2 = $arch_table[$j][$k];
                                break;
                            }
                            $k--;
                        }
                    }
                    // �������

                    if ($f2 < $arch_table[$i][$j]) {
                        $left_freq += log($arch_table[$i][$j]);
                        break;
                    }
                }
                $j--;
            }

            $left_label[$j] = 1;
            $i = $j + 1;
        }

        // step 3.2 right => left
        $j = $len - 1;
        while ($j >= 0) {
            $i = 0;
            while ($j >= $i) {
                if ($arch_table[$i][$j] != -1) {
                    $right_freq += log($arch_table[$i][$j]);
                    break;
                }
                $i++;
            }

            $right_label[$i] = 1;
            $j = $i - 1;
        }

        // step 3.4 compare left & right
        $ret = array();
        $i = 0;
        if ($left_freq > $right_freq) {
            for ($j = 0; $j < $len; $j++) {
                $ret[$i] .= substr($sen, $j * 2, 2);
                if ($left_label[$j] == 1)
                    $i++;
            }
        } else {
            for ($j = 0; $j < $len; $j++) {
                if ($right_label[$j] == 1)
                    $i++;
                $ret[$i] .= substr($sen, $j * 2, 2);
            }
        }

        // �����Ҫͳ��
        if ($this->_do_stats) {
            foreach ($ret as $tmp) {
                $this->_put_statistics($tmp, $this->_cur_sen_off);
                $this->_cur_sen_off += strlen($tmp);
            }
        }

        return $ret;
    }

    // �ӵ�ǰ������ƫ�� [$off] ��λ��ȡ�����, ����(length, frequency)
    function _fetch_long($off)
    {
        $ret = array(0, 0);

        $wlen = 2;
        while (($off + $wlen) <= $this->_cur_sen_len) {
            $w = substr($this->_cur_sen_buf, $off * 2, $wlen * 2);
            $r = $this->_dict->find($w);

            if ($r < 0)
                break;

            if ($r & _WORD_ALONE_) {
                $freq = $r & ~(_WORD_ALONE_ | _WORD_PART_);
                if ($ret[0] > 0) {
                    if (!isset($ret[2]))
                        $ret[2] = array();
                    $ret[2][] = array($ret[0], $ret[1]);
                }
                $ret[0] = $wlen;
                $ret[1] = $freq;
            }

            if (!($r & _WORD_PART_))
                break;

            $wlen++;
        }
        return $ret;
    }

    // �ӵ�ǰ������ƫ�� [$off] ��λ��ȡ����������
    function _fetch_zhname2($off)
    {
        $ret = array(0, 1);
        if (($off + 2) < $this->_cur_sen_len) {
            $s2 = substr($this->_cur_sen_buf, $off * 2, 4) . ' ';
            if (($p = strpos($this->_surname2_chars, $s2)) !== false) {
                $ret[0] = 2;
                $off += 2;
                $n = 0;

                do {
                    if ($off >= $this->_cur_sen_len)
                        break;

                    $zh = substr($this->_cur_sen_buf, $off * 2, 2);
                    if (($p = strpos($this->_noname_chars, $zh)) !== false
                        && !($p & 0x01)
                    )
                        break;

                    $off++;
                    $ret[0]++;
                } while (++$n < 2);
            }
        }
        return $ret;
    }

    // �ӵ�ǰ������ƫ�� [$off] ��λ��ȡ������2~3����
    function _fetch_zhname($off)
    {
        $ret = array(0, 1);
        if (($off + 1) < $this->_cur_sen_len) {
            $s1 = substr($this->_cur_sen_buf, $off * 2, 2);
            if (($p = strpos($this->_surname_chars, $s1)) !== false
                && !($p & 0x01)
            ) {
                $ret[0]++;
                $off++;
                $n = 0;

                do {
                    if ($off >= $this->_cur_sen_len)
                        break;

                    $zh = substr($this->_cur_sen_buf, $off * 2, 2);
                    if (($p = strpos($this->_noname_chars, $zh)) !== false
                        && !($p & 0x01)
                    )
                        break;

                    $off++;
                    $ret[0]++;
                } while (++$n < 2);
            }
        }

        if ($ret[0] <= 1)
            $ret[0] = 0;

        return $ret;
    }

    // �ӵ�ǰ������ƫ�� [$off] ��λ��ȡ�����ܵ���������
    function _fetch_frname($off)
    {
        $ret = array(0, 1);
        do {
            if ($off >= $this->_cur_sen_len)
                break;

            $zh = substr($this->_cur_sen_buf, $off * 2, 2);

            if (($p = strpos($this->_mb_foreign_chars, $zh)) === false
                || ($p & 0x01)
            )
                break;

            $off++;
            $ret[0]++;
        } while (1);

        if ($ret[0] <= 1)
            $ret[0] = 0;

        return $ret;
    }

    // �ж��ַ��Ƿ�Ϊ��ĸ(������)[a-z._-]
    function _is_alpha($char, $strict = false)
    {
        $p = strpos($this->_sb_alpha_chars, $char);

        if ($strict)
            return ($p !== false && $p < 52);

        return ($p !== false);
    }

    // �ж��ַ��Ƿ�Ϊ���� [0-9.]
    function _is_num($char, $strict = false)
    {
        $p = strpos($this->_sb_num_chars, $char);

        if ($strict)
            return ($p !== false && $p < 10);

        return ($p !== false);
    }
}

?>