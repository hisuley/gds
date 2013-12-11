<?php

/**
 * ECMALL: 显示关于我们
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * -------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
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
     *  关于
     *
     *  @access public
     *  @param  none
     *  @return void
     */
    function view()
    {
        $this->logger = false; //不记录日志
        $this->display('about.html', 'mall');
    }
};
?>