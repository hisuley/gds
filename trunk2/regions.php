<?php

/**
 * ECMALL: ����ѡ��
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: regions.php 5311 2008-07-23 02:54:12Z Garbin $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

include_once(ROOT_PATH . '/includes/manager/mng.region.php');

class RegionsController extends ControllerFrontend
{
    var $_mng = null;
    var $_allowed_actions = array('load', 'get', 'get_all_regions');

    /**
     * ���캯��
     */
    function __construct($act)
    {
        $this->RegionsController($act);
    }

    function RegionsController($act)
    {
        $this->_mng = new RegionManager(0);
        !method_exists($this, $act) && $act = 'load';
        parent::ControllerFrontend($act);
    }

    function load()
    {
        $this->logger = false; // ������־

        /* ���� */
        $pid   = empty($_GET['parent']) ? 0 : intval($_GET['parent']);
        $level = empty($_GET['level']) ?  0 : intval($_GET['level']);

        /* ȡ�õ��� */
        $arr = array(
            'regions' => ($pid > 0 || $level == 1) ? $this->_mng->get_list($pid) : array(),
            'level'   => $level
        );

        /* ���� */
        $this->json_result($arr);
        return;
    }

    /**
     *  ��ȡ��������
     *
     *  @access
     *  @param
     *  @return
     */

    function get()
    {
        $this->logger = false;
        $regions = $this->_mng->get_all();
        $js_data = 'Regions = ' . ecm_json_encode($regions) . ';';
        echo $js_data;
    }

    function get_all_regions()
    {
        $parent_ids = trim($_GET['parent_ids']);
        $parents = explode(',', $parent_ids);
        foreach ($parents as $_k => $_v)
        {
            if (!$_v)
            {
                unset($parents[$_k]);
            }
        }
        $all = $this->_mng->get_list_with_childrens($parents);

        $this->json_result($all);
        return;
    }
}

?>