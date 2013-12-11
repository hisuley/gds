<?php

/**
 * ECMALL: ��������ҳ��
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: storeapply.php 5614 2008-08-20 07:25:13Z Wj $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class StoreApplyController extends ControllerFrontend
{
    var $_allowed_actions = array('apply', 'check_store_name');
    function __construct($act)
    {
        $this->StoreApplyController($act);
    }
    function StoreApplyController ($act)
    {
        if (empty($act))
        {
            $act = 'apply';
        }
        parent::__construct($act);
    }

    /**
     * ���뿪��
     *
     * @author  wj
     */
    function apply()
    {
        if (!$this->conf('mall_storeapply'))
        {
            $this->show_warning('storeapply_deny');
            return;
        }
        include_once(ROOT_PATH . '/includes/manager/mng.storeapply.php');

        $manager = new StoreApplyManager();

        if (empty($_SESSION['user_id']))
        {
            $this->redirect("index.php?app=member&act=login&ret_url=" . urlencode("index.php?app=storeapply&just_login"));
        }

        /* ����û��Ƿ��Ѿ����� */
        if ($_SESSION['admin_store'] >= 0)
        {
            if (isset($_GET['just_login']))
            {
                /* ����Ǹյ�¼����ת����ҳ */
                $this->redirect("index.php");
            }
            else
            {
                $this->show_warning('u_cannt_setup_shop');
                return;
            }
        }

        /* �����û��Ƿ��Ѿ��ύ��δ��������� */
        if (($num = $manager->get_count(array('user_id'=>$_SESSION['user_id'], 'status'=>APPLY_RAW))) > 0)
        {
            $this->show_warning('u_had_applied', 'back_home', 'index.php');
        }
        else
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                /* ���뿪��Ľ��� */
                $this->display('mc_storeapply', 'mall');
            }
            else
            {
                $id = $manager->add($this->filter($_POST));

                $this->show_message('apply_setup_shop_success', 'back_home', 'index.php');
            }
        }
    }

    /**
     * �����������Ƿ����
     *
     * @author  weberliu
     * @return  void
     */
    function check_store_name()
    {
        include_once(ROOT_PATH . '/includes/manager/mng.store.php');
        $manager = new StoreManager();
        $id = $manager->get_store_id($_POST['store_name']);

        if ($id === 0)
        {
            $this->json_result();
        }
        else
        {
            $this->json_error('store_exists');
        }
    }

    /**
     * �����ύ������
     *
     * @author  weberliu
     * @param   array       $post   POST�ύ������
     * @return  array
     */
    function filter($post)
    {
        $arr = array();
        $arr['owner_name']      = trim($post['owner_name']);
        $arr['owner_idcard']    = trim($post['owner_idcard']);
        $arr['owner_phone']     = trim($post['owner_phone']);
        $arr['owner_address']   = trim($post['owner_address']);
        $arr['owner_zipcode']   = trim($post['owner_zipcode']);
        $arr['apply_reason']    = trim($post['apply_reason']);
        $arr['store_name']      = trim($post['store_name']);
        $arr['store_location']  = trim($post['store_location']);
        $arr['user_id']         = $_SESSION['user_id'];

        return $arr;
    }

};

?>