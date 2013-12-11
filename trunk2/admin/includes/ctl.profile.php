<?php

/**
 * ECMALL: 管理中心个人资料管理
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: ctl.profile.php 4736 2008-06-23 03:32:53Z Weberliu $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class ProfileController extends ControllerBackend
{
    function __construct($act)
    {
        $this->ProfileController($act);
    }

    function ProfileController($act)
    {
        if (empty($act))
        {
            $act = 'login';
        }
        parent::__construct($act);
    }
    /**
     * 管理员登录界面
     *
     * @return  void
     */
    function login()
    {
        $need_captcha = $this->conf('mall_captcha_status') & 8;
        if (defined('IS_AJAX') && IS_AJAX)
        {
            $this->json_error('missing_session');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->logger = false;
            include_once(ROOT_PATH. '/includes/cls.image.php');

            $this->assign('captcha', $need_captcha);
            $this->display('profile.login.html');
        }
        else
        {
            $username = trim($_POST['username']);
            if (empty($username) || empty($_POST['password']))
            {
                $this->show_warning('login_empty');
                return;
            }
            else
            {
                if (! empty($_SESSION['captcha']) && $need_captcha && base64_encode(trim(strtolower($_POST['captcha']))) != $_SESSION['captcha'])
                {
                    $this->show_warning('incorrect_captcha');
                    return;
                }
                else
                {
                    $user = new AdminUser(0, 0);
                    $user->login($username, $_POST['password']);

                    if (empty($user->err))
                    {
                        $msg = $this->str_format('login_successfully', $username) . $user->sync_login();

                        $this->show_message($msg, 'enter_control_panel', 'admin.php');
                        return;
                    }
                    else
                    {
                        $this->show_warning($user->err);
                        return;
                    }
                }
            }
        }

        return;
    }
    /**
     * 管理员登出
     *
     * @return  void
     */
    function logout()
    {
        UserBase::logout();

        $this->redirect('admin.php');

        return;
        //$this->redirect('admin.php');
    }
    /**
     * 获得管理员的详细信息
     *
     * @return  void
     */
    function get_info()
    {
        static $user_info = null;

        if ($user_info === null)
        {
            $user_info = parent::get_info();
        }

        return $user_info;
    }

    /**
     *
     *
     *  @access public
     *  @params none
     *  @return void
     */
    function welcome()
    {
         $this->redirect('admin.php');
    }

    /**
     * 生成验证码图片
     *
     * @return  void
     */
    function captcha()
    {
        $this->logger = false;
        include_once(ROOT_PATH. '/includes/cls.captcha.php');
        $word = UserBase::generate_code();
        $_SESSION['captcha'] = base64_encode($word);

        $code = new Captcha();
        $code->code = $word;
        $code->width = 80;
        $code->height = 18;
        $code->display();
    }

};
?>