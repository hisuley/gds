<?php
/**
 * ECMall: ��̬���ݺ�����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: lib.insert.php 5625 2008-08-21 06:13:33Z Wj $
 */


/**
 * ��ȡ���λ���
 *
 * @access  public
 *
 * @return  string
 */
function insert_ads($par)
{
    if (!class_exists(AdPosition))
    {
        require_once(ROOT_PATH . '/includes/models/mod.ad_position.php');
    }

    $adp = new AdPosition($par['id']);

    return $adp->get_ads($par['template']->edit_mode);
}

/**
 * ����ģ���е�{nocache}
 *
 * @author wj
 * @param  string $param
 * @return string
 */
function insert_nocache($param)
{   
    error_reporting(E_ALL ^ E_NOTICE);
    $str = $param['template']->_eval(stripslashes($param['_template']));
    error_reporting($param['template']->_errorlevel);
    return $str;
}

?>