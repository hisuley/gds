<?php

/**
 * ECMall: ����������
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: cod.php 5629 2008-08-21 09:33:58Z Garbin $
 */

if (!defined('IN_ECM'))
{
    die('Hacking attempt');
}

include_once(ROOT_PATH . '/includes/models/mod.payment.php');

/* �������԰� */
Language::load_lang(lang_file('payment/cod'));

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc']    = 'cod_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '1';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '0';

    /* ֧�����ã������;��� */
    $modules[$i]['pay_fee'] = '0';

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

/**
 * ��
 */
class cod
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
    function response()
    {
        return;
    }
}

?>