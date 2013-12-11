<?php

/**
 * ECMALL: ÓÃ»§¹ÜÀí³ÌÐò
 * ============================================================================
 * °æÈ¨ËùÓÐ (C) 2005-2008 ¿µÊ¢´´Ïë£¨±±¾©£©¿Æ¼¼ÓÐÏÞ¹«Ë¾£¬²¢±£ÁôËùÓÐÈ¨Àû¡£
 * ÍøÕ¾µØÖ·: http://www.comsenz.com
 * -------------------------------------------------------
 * Õâ²»ÊÇÒ»¸ö×ÔÓÉÈí¼þ£¡ÄúÖ»ÄÜÔÚ²»ÓÃÓÚÉÌÒµÄ¿µÄµÄÇ°ÌáÏÂ¶Ô³ÌÐò´úÂë½øÐÐÐÞ¸ÄºÍÊ¹ÓÃ£»
 * ²»ÔÊÐí¶Ô³ÌÐò´úÂëÒÔÈÎºÎÐÎÊ½ÈÎºÎÄ¿µÄµÄÔÙ·¢²¼¡£
 * ============================================================================
 * $Id: user.php 4024 2008-06-03 02:22:53Z Wj $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

require(ROOT_PATH . '/includes/manager/mng.user.php');
require(ROOT_PATH . '/includes/models/mod.user.php');

class UserController extends ControllerBackend
{
    var $manager = null;

    /**
     * ¹¹Ôìº¯Êý
     *
     * @author  wj
     * @param    string      $act
     * @return  void
     */    
    function __construct($act)
    {
        $this->UserController($act);
    }

    /**
     * ¹¹Ôìº¯Êý
     *
     * @author  wj
     * @param    string      $act
     * @return  void
     */ 
    function UserController($act)
    {
        if (empty($act))
        {
            $act = 'view';
        }

        $this->manager = new UserManager();

        parent::__construct($act);
    }
    /**
     * ²é¿´µêÆÌÁÐ±í
     *
     * @return  void
     */
    function view()
    {
        $this->logger = false;
        $condition = isset($_GET['keywords']) ? array('user_name' => trim($_GET['keywords'])) : array();

        $list = $this->manager->get_list($this->get_page(), $condition);
        $list['data'] = deep_local_date($list['data'], 'last_login', $this->conf('mall_time_format_complete'));

        $this->assign('list',   $list);
        $this->assign('stats',  $this->str_format('user_stats', $list['info']['rec_count'], $list['info']['page_count']));
        $this->display('user.view.html', 'mall');
    }
    /**
     * Ìí¼ÓµêÆÌ
     *
     * @return  void
     */
    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->logger = false; // ²»¼ÇÂ¼ÈÕÖ¾

            $store['goods_limit']   = 0;
            $store['file_limit']    = 0;

            $this->assign('store',          $store);
            $this->build_editor('store_desc', '', '480px', '200px');
            $this->display('store.detail.html', 'mall');
        }
        else
        {
            /* get user id */
            include_once(ROOT_PATH. "/includes/manager/mng.user.php");
            $manager = new UserManager();
            $_POST['user_id'] = $manager->get_id_by_name(trim($_POST['username']));

            if ($_POST['user_id'] <= 0)
            {
                $this->show_warning($this->str_format('user_not_exists', $_POST['username']));
                return;
            }
            elseif (empty($_POST['store_name']) || $this->duplicate_name($_POST['store_name']) > 0)
            {
                $this->show_warning('duplicate_store_name');
                return;
            }
            else
            {
                include_once(ROOT_PATH. "/includes/manager/mng.store.php");
                $res = $this->manager->add($_POST);

                if ($res > 0)
                {
                    $this->log_item = $res;
                    $this->show_message($this->str_format('add_store_successfully', $_POST['store_name']),
                        $this->lang('store_view'), "admin.php?app=user&amp;act=view");
                    return;
                }
            }
        }
    }
    /**
     * Ajax·½Ê½ÐÞ¸Äµê??YÁÏ
     *
     * @return  void
     */
    function modify()
    {
        if (!empty($_GET['id'])) $this->log_item = $_GET['id'];
        $this->_modify("User", $_GET, 'edit_store_failed');
    }
    /**
     * ±à¼­µêÆÌÐÅÏ¢
     *
     * @return  void
     */
    function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->logger = false;
            $id     = intval($_GET['id']);
            $user   = new User($id);
            $info   = $user->get_info();

            if (empty($info))
            {
                $this->show_warning("not_found");
                return;
            }
            else
            {
                $this->assign('user', $info);
                $this->display('user.detail.html', 'mall');
            }
        }
        else
        {
            $post = array();
            $post['user_id']        = intval($_POST['id']);
            $post['sex']            = intval($_POST['sex']);
            $post['msn']            = trim($_POST['msn']);
            $post['qq']             = trim($_POST['qq']);
            $post['office_phone']   = trim($_POST['office_phone']);
            $post['home_phone']     = trim($_POST['home_phone']);
            $post['mobile_phone']   = trim($_POST['mobile_phone']);
            $post['birthday']       = $_POST['birthday'];

            $store  = new User($post['user_id']);
            $res    = $store->update($post);

            if ($res)
            {
                $this->log_item = $post['user_id'];
                $this->show_message('edit_user_successfully', 'back_list', 'admin.php?app=user&amp;act=view', $this->lang('go_back'));
                return;
            }
            else
            {
                $this->show_warning('edit_user_failed');
                return;
            }
        }
    }

    /**
     * ¸ù¾ÝÓÃ»§ÊäÈë»ñµÃÓÃ»§ÁÐ±í
     *
     * @return  void
     */
    function get_userlist()
    {
        $this->logger = false; // ²»¼ÇÂ¼ÈÕÖ¾

        include_once(ROOT_PATH. '/includes/manager/mng.user.php');
        $manager = new UserManager();
        $username = trim($_GET['q']);

        $arr = $manager->get_users_by_name($username);
        if (!empty($arr))
        {
            foreach ($arr AS $val)
            {
                $row[] = array($val['user_name'], $val['user_name'], $val['user_id']);
            }
            $this->json_result($row);
            return;
        }
        else
        {
            $this->json_error();
            return;
        }
    }

    /**
     * ÅÐ¶ÏµêÆÌÃû³ÆÊÇ·ñÖØ¸´
     *
     * @return  void
     */
    function duplicate_name()
    {
        $this->logger = false; // ²»¼ÇÂ¼ÈÕÖ¾
        $store_id   = (isset($_POST['store_id'])) ? intval($_POST['store_id']) : 0;
        $store_name = trim($_POST['store_name']);
        $retval     = $this->manager->get_store_id($store_name);

        if ($retval == 0 || $store_id != $retval)
        {
            $this->json_result();
        }
        else
        {
            $this->json_error('duplicate_store_name');
            return;
        }
    }

};
?>