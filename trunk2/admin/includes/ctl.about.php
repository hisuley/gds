<?php

/**
 * ECMALL: ��ʾ��������
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: ctl.about.php 4502 2008-06-16 10:56:10Z Weberliu $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class AboutController extends ControllerBackend
{
    function __construct($act)
    {
        $this->AboutController($act);
    }

    function AboutController($act)
    {
        if (empty($act))
        {
            $act = 'view';
        }
        parent::__construct($act);
    }

    /**
     *  ����
     *
     *  @access public
     *  @param  none
     *  @return void
     */
    function view()
    {
        $this->logger = false; //����¼��־
        $this->display('about.html', 'mall');
    }
};
?>