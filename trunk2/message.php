<?php

/**
 * ECMALL: ���Ժ�����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: message.php 5312 2008-07-23 02:58:46Z Scottye $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class MessageController extends ControllerFrontend
{
    var $_allowed_actions = array('view', 'add');

    /**
     * ���캯��
     */
    function __construct($act)
    {
        $this->MessageController($act);
    }

    function MessageController($act)
    {
        if (empty($act))
        {
            $act = 'view';
        }
        parent::__construct($act);
    }

    function view()
    {
        /* ���� */
        $type = trim($_GET['type']);
        $id   = intval($_GET['id']);
        if ($type == 'seller')
        {
            $cond  = array('seller_id' => $id, 'if_show' => 1, 'goods_id' => 0);
            $title = $this->lang('store_message');
        }
        elseif ($type == 'goods')
        {
            $cond  = array('goods_id' => $id, 'if_show' => 1);
            $title = $this->lang('goods_comment');
        }
        elseif ($type == 'buyer')
        {
            $cond  = array('buyer_id' => $id);
            $title = $this->lang('my_message');
        }
        else
        {
            $this->show_message('Hacking Attempt');

            return;
        }

        /* ȡ������ */
        include_once(ROOT_PATH . '/includes/manager/mng.message.php');
        $msg_mng = new MessageManager(0);
        $msg_list = $msg_mng->get_list($this->get_page(), $cond);
        $this->assign('msg_list', $msg_list);
        $this->assign('msg_title', $title);
        $this->assign('title', $title);

        $this->display('message_list', 'mall');
    }
    /**
     * �������
     *
     * @author  weberliu
     * @return  void
     */
    function add()
    {

        /* ���� */
        $goods_id = empty($_POST['goods_id']) ? 0 : intval($_POST['goods_id']);
        $seller_id = empty($_POST['seller_id']) ? 0 : intval($_POST['seller_id']);
        if ($goods_id)
        {
            include_once(ROOT_PATH . '/includes/models/mod.goods.php');
            $mod_goods = new Goods($goods_id, 0);
            $goods = $mod_goods->get_info();
            if (empty($goods))
            {
                $this->show_message('Hacking Attempt');

                return;
            }
        }

        include_once(ROOT_PATH . '/includes/models/mod.user.php');
        $seller_mod = new User($seller_id);
        $seller = $seller_mod->get_info();
        if (empty($seller))
        {
            $this->show_message('Hacking Attempt');
            return;
        }

        if (empty($_POST['message']))
        {
            $this->show_message('pls_input_message');
            return;
        }

        /* У���û��������֤�� */
        $captcha        = empty($_POST['captcha']) ? '' : trim($_POST['captcha']);
        $need_captcha   = $this->conf('mall_captcha_status');
        $need_captcha   = $need_captcha & 4;

        if ($need_captcha && $_SESSION['captcha'] != base64_encode(strtolower($captcha)))
        {
            $this->show_message($this->lang('captcha_invalid'));
            return;
        }

        $user_sync_login = ''; // �����Ҫ��¼�Ļ�����ͬ����½�Ĵ���

        // ���û�е�¼,��֤�û���������
        if ($_SESSION['user_id'] <= 0)
        {
            $user_name = empty($_POST['user_name']) ? '' : trim($_POST['user_name']);
            $password  = empty($_POST['password']) ? '' : $_POST['password'];
            $user = new User(0, 0);
            $row = $user->login($user_name, $password);
            if ($row['uid'] > 0)
            {
                unset($_SESSION['ERROR_LOGIN']); //�����¼ʧ�ܴ������
                ecm_setcookie('ECM_USERNAME', $row['username']); //��¼��¼�û���
                $user_sync_login = $user->sync_login();

                $_SESSION['timezone'] = $this->conf('mall_time_zone');
            }
            else
            {
                //��¼��¼ʧ�ܴ���
                if (isset($_SESSION['ERROR_LOGIN']))
                {
                    $_SESSION['ERROR_LOGIN'] ++;
                }
                else
                {
                    $_SESSION['ERROR_LOGIN'] = 1;
                }
                if ($row['uid'] == -1)
                {
                    $msg_error_login = 'login_user_no_exists';
                }
                else
                {
                    $msg_error_login = 'login_pass_error';
                }
                $this->show_warning($msg_error_login, 'go_back', 'javascript:history.back()', 'forget_pwd', 'index.php?app=member&act=getpwd');
                return;
            }
        }

        if ($_SESSION['user_id'] == $seller_id)
        {
            /* �������۵ľ��������Լ����˳� */
            $this->show_warning($this->lang('e_post_message_self'). $user_sync_login);
            return;
        }
        else
        {
            /* ���� */
            $data = array(
                'goods_id'      => $goods_id,
                'buyer_id'      => $_SESSION['user_id'],
                'buyer_name'    => addslashes($_SESSION['user_name']),
                'seller_id'     => $seller_id,
                'seller_name'   => addslashes($seller['user_name']),
                'message'       => trim($_POST['message']),
                'add_time'      => gmtime(),
                'reply'         => '',
                'if_show'       => 0,
                'need_send_feed'=> empty($_POST['seed_feed']) ? 0 : 1
            );

            include_once(ROOT_PATH . '/includes/manager/mng.message.php');

            $msg = $this->lang('add_message_ok') . $user_sync_login;
            $mng = new MessageManager(0);
            $mng->add($data);

            if (!empty($_SERVER['HTTP_REFERER']))
            {
                $this->show_message($msg, 'go_back', $_SERVER['HTTP_REFERER']);
            }
            else
            {
                $this->show_message($msg);
            }
        }
    }
}

?>