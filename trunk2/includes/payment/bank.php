<?php

/**
 * ECMall: ���л�ת�ʣ����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: bank.php 5629 2008-08-21 09:33:58Z Garbin $
 */

if (!defined('IN_ECM'))
{
    die('Hacking attempt');
}

Language::load_lang(lang_file('payment/bank'));
/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc']    = 'bank_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '0';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '0';

    /* ���� */
    $modules[$i]['author']  = 'ECMall TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.comsenz.com';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.0';

    /* ֧�ֵĻ��� */
    $modules[$i]['currency'] = 'all';

    /* ������Ϣ */
    $modules[$i]['config']  = array();

    return;
}

include_once(ROOT_PATH . '/includes/models/mod.payment.php');

/**
 * ��
 */
class bank extends Payment
{
    /**
     * �ύ����
     */
    function get_code()
    {
        return '';
    }

    /**
     * ������
     */
    function respond()
    {
        return;
    }
}

?>