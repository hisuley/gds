<?php

/**
 * ECMALL: �������ÿ�������
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id$
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

include_once(ROOT_PATH . '/includes/manager/mng.region.php');

class RegionController extends ControllerBackend
{
    var $_mng = null;

    function __construct($act)
    {
        $this->RegionController($act);
    }

    function RegionController($act)
    {
        $this->_mng = new RegionManager($_SESSION['store_id']);

        if (empty($act))
        {
            $act = 'view';
        }
        parent::__construct($act);
    }

    /**
     * �鿴�����б�
     *
     * @return  void
     */
    function view()
    {
        $this->logger = false; // ������־

        /* �������ϼ�����id��0��ʾһ������ */
        $pid = empty($_REQUEST['pid']) ? 0 : intval($_REQUEST['pid']);
        $this->assign('pid', $pid);

        /* ȡ�õ����б� */
        $raw_region_list = $this->_mng->get_list($pid);
        $i = 0;
        $region_list = array();
        foreach ($raw_region_list as $region)
        {
            $region_list[floor($i / 3)][] = $region;
            $i++;
        }
        $this->assign('region_list', $region_list);

        /* ���� */
        if ($pid > 0)
        {
            /* ��ǰ�����б���ϼ� */
            $region = $this->_mng->get_region($pid);
            $this->assign('parent', $region);
            $this->assign('manage_disabled', isset($region['parent_id']));
        }

        /* ��ʾģ�� */
        $this->display('region.view.html', 'mall');
    }

    /**
     * ���һ������
     *
     * @return  void
     */
    function add()
    {
        /* ���� */
        $region_name = empty($_POST['region_name']) ? '' : trim($_POST['region_name']);
        $parent_id   = empty($_POST['parent_id']) ? 0 : intval($_POST['parent_id']);

        /* ������ */
        $parent  = $this->_mng->get_region($parent_id);
        if (empty($parent))
        {
            $parent_id = 0;
        }

        if ($region_name == '')
        {
            $this->show_warning('name_is_empty');

            return;
        }

        if ($this->_mng->region_name_exist($region_name, $parent_id))
        {
            $this->show_warning('name_exists');

            return;
        }

        /* ���� */
        $this->log_item = $this->_mng->add($region_name, $parent_id);
        $this->show_message('add_ok', 'go_back', 'admin.php?app=region&act=view&pid=' . $parent_id);
        return;
    }

    /**
     * �޸ĵ������ƣ�ajax��
     *
     * @return  void
     */
    function update()
    {
        /* ���� */
        $region_id   = empty($_GET['region_id']) ? 0 : intval($_GET['region_id']);
        $region_name = empty($_GET['region_name']) ? '' : trim($_GET['region_name']);
        $parent_id   = empty($_GET['parent_id']) ? 0 : intval($_GET['parent_id']);

        /* ��� */
        $region = $this->_mng->get_region($region_id);
        if (empty($region))
        {
            $this->json_error('record_not_exist', $region['region_name']);
            return;
        }
        if ($region_name == '')
        {
            $this->json_error('name_is_empty', $region['region_name']);
            return;
        }
        if ($this->_mng->region_name_exist($region_name, $parent_id, $region_id))
        {
            $this->json_error('name_exists', $region['region_name']);
            return;
        }

        /* ���� */
        $this->_mng->update($region_id, $region_name);
        $this->json_result();
        return;
    }

    /**
     * ɾ������
     *
     * @return void
     */
    function drop()
    {
        /* ���� */
        $region_id = empty($_GET['region_id']) ? 0 : intval($_GET['region_id']);
        $region = $this->_mng->get_region($region_id);
        if (empty($region))
        {
            $this->show_warning('record_not_exist');
            return;
        }

        /* ����Ƿ����¼����� */
        $children = $this->_mng->get_list($region_id);
        if (!empty($children))
        {
            $this->show_warning('region_has_children');
            return;
        }

        /* ɾ�� */
        if ($this->_mng->drop($region_id))
        {
            $this->log_item = $region_id; // ��־
            $this->show_message('drop_ok', 'go_back', 'admin.php?app=region&act=view&pid=' . $region['parent_id']);
            return;
        }
    }
};

?>