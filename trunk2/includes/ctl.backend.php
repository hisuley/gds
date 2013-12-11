<?php

/**
 * ECMALL: ��̨����������
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: ctl.backend.php 5343 2008-07-29 10:00:46Z Liupeng $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

require_once(ROOT_PATH. '/includes/ctl.base.php');
require_once(ROOT_PATH. '/includes/models/mod.adminuser.php');

class ControllerBackend extends ControllerBase
{
    /* private attributes */
    var $logger     = true;
    var $log_item   = 0;

    /* ������֧�ֲ��� */

    /**
     *  ���԰�����·��
     *
     *  @access
     */

    var $_lang_folder = '/languages/%s/admin/';

    /**
     *  �������԰�
     *
     *  @access
     */

    var $_common_lang = array('common');

    /**
     *  ʹ���ĸ�ģ������
     *  Ĭ��Ϊʹ�ò��ɱ任����ģ������template
     *  ��Ҫʹ�ÿɱ任����ģ�������뽫��ֵ��Ϊuse_theme
     *  @access
     */
    var $_use_which_template = 'use_template';
    var $_message_template_dir = '';

    /* public functions */
    function __construct($act)
    {
        $this->ControllerBackend($act);
    }

    function ControllerBackend($act)
    {
        /* ��ȡCOOKIE�д洢�ĵ�¼��Ϣ,ʵ���Զ���¼ */
        if (!isset($_SESSION['admin_id']))
        {
            $auth_string = '';
            if ($auth_string)
            {
                include_once(ROOT_PATH . '/includes/models/mod.adminuser.php');
                list($user_id, $password) = explode("\t", $auth_string);
                $user = new AdminUser(0, 0);
                $act = $user->local_login($user_id, $password) ? 'welcome' : 'login';
            }
        }
        else
        {
            /* �ж�Ȩ�� */
            include_once(ROOT_PATH . '/includes/models/mod.adminuser.php');
            $admin_mod = new AdminUser($_SESSION['admin_id'], $_SESSION['store_id']);
            if (!$admin_mod->check_priv(APPLICATION, $act))
            {
                $this->show_warning('not_allow_operate');
                return false;
            }
            /* ����״̬���ж� */
            if ($_SESSION['store_id'] && $_GET['act'] != 'logout')
            {
                include_once(ROOT_PATH . '/includes/models/mod.store.php');
                $store_mod = new Store($_SESSION['store_id']);
                $store_info = $store_mod->get_info();
                if ($store_info['start_time'] > gmtime() || ($store_info['end_time'] > 0 && $store_info['end_time'] < gmtime()))
                {
                    $this->show_warning('store_time_illegal', 'goto_logout', 'admin.php?app=profile&act=logout');
                    return false;
                }
                if (empty($store_info['is_open']))
                {
                    $this->show_warning('store_closed', 'goto_logout', 'admin.php?app=profile&act=logout');
                    return false;
                }
            }
        }

        $this->log_oprate($act); // ��¼���ò���
        /* ���� */
        parent::ControllerBase($act);
    }

    /**
     * ����ģ�岢��ʾ
     *
     * @author  wj
     * @param   string  $template_file
     * @param   string  $template_dir
     *
     * @return  void
     */
    function display($template_file, $template_dir = '')
    {
        if (strpos($template_file, '.html') === FALSE)
        {
            $template_file .= '.html';
        }
        $this->_init_template();
        /* ����Դģ��·�� */
        $this->set_template_path('/' . $template_dir, NULL, TRUE);

        /* ��ظ�ֵ */
        $this->assign('store_id',   isset($_SESSION['store_id']) ? $_SESSION['store_id'] : 0);
        $this->assign('charset',    CHARSET);
        $this->assign('ecm_ver',    VERSION);
        $this->assign('lang',       $this->lang());
        $this->_assign_query_info();

        $template_dir = empty($template_dir) ? $template_dir : $template_dir . '/';

        $template_file = 'admin/templates/' . $template_dir . $template_file;

        /* send mail*/
        if (defined('SEND_MAIL'))
        {
            $send_mail_code = '<script type="text/javascript" src="index.php?app=mail&t=' . time()  . '" ></script>';
            $this->assign('send_mail_code', $send_mail_code);
        }
        /* ��� */
        parent::display($template_file);
    }

    /**
     * ͨ��ajax��ʽ�޸�ʵ������Ϣ
     *
     * @param  string   $cls
     * @param  array    $get
     * @param  string   $msg_failed
     *
     * @return  bool
     */
    function _modify($cls, $get, $msg_failed='')
    {
        $idx = intval($get['id']);
        $col = trim($get['column']);
        $val = trim($get['value']);

        $obj = new $cls($idx, $_SESSION['store_id']);
        $arr = array($col=>$val);

        if ($obj->update($arr))
        {
            $this->log_item = $idx;
            $retval = empty($obj->err) ? '' : $obj->err;
            $this->json_result($retval);
            return;
        }
        else
        {
            $msg_failed = empty($obj->err) ? $msg_failed : $obj->err;
            $this->json_error($msg_failed);
            return;
        }
    }

    /* private functions */
    /**
     * ʵ����ģ�����
     *
     * @return  void
     */
    function config_template()
    {
        /* λ�ò��ɵ��� */
        parent::config_template();

        /* ����ģ���ļ�����Ŀ¼ */
        if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0)
        {
            $this->_template->cache_dir     = ROOT_PATH . '/temp/caches/store/admin';
            $this->_template->compile_dir   = ROOT_PATH . '/temp/compiled/store/admin';
        }
        else
        {
            $this->_template->cache_dir     = ROOT_PATH . '/temp/caches/mall/admin';
            $this->_template->compile_dir   = ROOT_PATH . '/temp/compiled/mall/admin';
        }
        $this->_template->template_dir  = ROOT_PATH. '/admin/templates';
    }

    /**
     * destory this object
     *
     * @author  wj
     * @return  void
     */
    function destory()
    {
        if ($this->logger === true)
        {
            include_once(ROOT_PATH . '/includes/manager/mng.admin_logs.php');
            $mng = new AdminLogManager($_SESSION['store_id']);
            $mng->add(addslashes($_SESSION['admin_name']), APPLICATION, $this->_action, $this->log_item);
        }
        $clean_action = array('add','drop','edit','update','conf', 'modify', 'set_related', 'unset_related', 'change_status'); //��Ҫ�������Ĳ���
        if (in_array($this->_action, $clean_action))
        {
            $this->clean_cache(); //�������
        }
    }

    function log_oprate($act)
    {
        if ($_SESSION['store_id'] === "0")
        {
            include(ROOT_PATH.'/admin/mall/inc.menu.php');
        }
        else
        {
            include(ROOT_PATH.'/admin/store/inc.menu.php');
        }
        foreach ($menu_data AS $group)
        {
            foreach ($group AS $key=>$menu)
            {
                if (APPLICATION == $menu['app'] && $act == $menu['act'])
                {
                    $user = new AdminUser($_SESSION['admin_id']);
                    $user->update_nav($key, $menu);

                    break;
                }
            }
        }
    }

    function clean_cache()
    {
        //�����ݸı�Ҫ������ļ�
        $cache_dirs = array(ROOT_PATH . '/temp/caches', ROOT_PATH . '/temp/query_caches');
        foreach ($cache_dirs as $cache_dir)
        {
            $d = @dir($cache_dir);
            if($d)
            {
                while (false !== ($entry = $d->read()))
                {
                    if($entry!='.' && $entry!='..' && $entry != '.svn' && $entry != 'index.html')
                    {
                       $entry = $cache_dir.'/'.$entry;
                       ecm_rmdir($entry);
                    }
                }
                $d->close();
             }
        }
    }

    /**
     * ���ָ����������
     *
     * @author  weberliu
     * @param   string  $key
     * @return  string|array
     */
    function lang($key='')
    {
        if (!Language::is_loaded($this->_common_lang))
        {
            /* ���ع������԰� */
            $this->_load_common_lang();
        }

        if (defined("APPLICATION") && !Language::is_loaded(APPLICATION))
        {
            /* ����Ӧ�ö�Ӧ�����԰� */
            $this->_load_app_lang();
        }

        return parent::lang($key);
    }

    /**
     * ���༭������Ʒ�����ϴ�������
     *
     * @author  wj
     * @param   void
     * @retuan  boolen
     */
    function has_uploaded_file()
    {
        $result = false;
        if (!empty($_FILES))
        {
            foreach ($_FILES as $key=>$val)
            {
                if ((strncmp($key, 'editor_upload_file', 18) == 0) && isset($val['size']) && $val['size'] > 0)
                {
                    //�༭���ļ�
                    $result = true;
                    break;
                }
                elseif($key=='size')
                {
                    if (is_array($val))
                    {
                        //�����ƷͼƬ
                        foreach ($val as $v)
                        {
                            if ($v > 0)
                            {
                                $result = true;
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * �������ļ��Ƿ񳬹�����
     * @param   int     $store_id   ����id
     * @return  string
     */
    function check_store_file_count($store_id)
    {
        $result = '';
        include_once(ROOT_PATH . '/includes/models/mod.store.php');
        $new_store = new Store($store_id);
        $info = $new_store->get_info();

        if ($info['file_limit'] > 0)
        {
            //����ļ������Ƿ񳬳�
            include_once(ROOT_PATH . '/includes/manager/mng.file.php');
            $file_count = FileManager::get_store_file_count($_SESSION['store_id']);
            if ($file_count >= $info['file_limit'])
            {
                $result = $this->str_format('over_file_count', $file_count, $info['file_limit']);
            }
        }

        return $result;
    }
};


class MessageBase extends ControllerBackend {};

?>