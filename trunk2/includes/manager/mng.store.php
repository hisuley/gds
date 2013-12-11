<?php

/**
 * ECMALL: 店铺管理类
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * -------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: mng.store.php 5553 2008-08-15 08:25:14Z Scottye $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class StoreManager extends Manager
{
    function __construct()
    {
        $this->StoreManager();
    }

    function StoreManager()
    {
    }

    /**
     * 获得店铺列表
     *
     * @return  array
     */
    function get_list($page, $condition, $pagesize = 0)
    {
        $arg = $this->query_params($page, $condition, 'add_time', $pagesize);
        $arg['where'] = str_replace('store_id', 's.store_id', $arg['where']);

        $sql = "SELECT s.*, u.user_name, u.seller_credit ".
                "FROM `ecm_store` AS s LEFT JOIN `ecm_users` AS u ON s.store_id = u.user_id " .
                "WHERE " .$arg['where']. " ORDER BY $arg[sort] $arg[order] LIMIT $arg[start], $arg[number]";
        $res = $GLOBALS['db']->getAll($sql);

        return array('data' => $res, 'info' => $arg['info']);
    }

    /**
     * 获得符合条件的记录总数
     *
     * @param   array   $condition
     *
     * @return  int
     */
    function get_count($condition)
    {
        $where  = $this->_make_condition($condition);
        $sql    = "SELECT COUNT(*) FROM `ecm_store` WHERE $where";
        $count  = $GLOBALS['db']->getOne($sql);

        return $count;
    }
    /**
     * 新增一个店铺
     *
     * @param  array    $post
     *
     * @return  int
     */
    function add($post)
    {
        $post['add_time']   = gmtime();
        $post['is_open']    = 1;

        $res = $GLOBALS['db']->autoExecute('`ecm_store`', $post);
        $store_id = 0;

        if ($res)
        {
            $store_id = $post['store_id'];
            include_once(ROOT_PATH . '/includes/manager/mng.conf.php');
            $mng_conf = new ConfManager($store_id);
            $mng_conf->clone_conf();

            include_once(ROOT_PATH . '/includes/models/mod.user.php');
            $mod_user = new User($store_id);
            $user_info = $mod_user->get_info();

            $mng_conf->set_conf('store_title', $post['store_name']);
        }
        return $store_id;
    }

    /**
     * 批量操作选定的店铺
     *
     * @author  weberliu
     * @param   string      $type   操作的类型 set_recommend, set_certified, set_open
     * @param   string      $in     店铺的ID，使用逗号分隔
     * @return  bool
     */
    function batch($type, $in)
    {
        switch ($type)
        {
            case 'set_recommend':
                $handler = "is_recommend=1-is_recommend";
            break;
            case 'set_certified':
                $handler = "is_certified=1-is_certified";
            break;
            case 'set_open':
                $handler = "is_open=1-is_open";
            break;
            default:
                $this->err = 'Unknow batch processor';
                return false;
        }

        if (preg_match('/^[\d,]+$/', $in))
        {
            $sql = "UPDATE `ecm_store` SET $handler WHERE store_id " .db_create_in($in);
            return $GLOBALS['db']->query($sql);
        }
        else
        {
            return false;
        }
    }

    /**
     * 根据给定的店铺名称获得店铺的ID
     *
     * @author  liupeng
     * @return  int
     */
    function get_store_id($name)
    {
        $sql = "SELECT store_id FROM `ecm_store` WHERE store_name='$name'";
        $res = $GLOBALS['db']->getOne($sql);

        $rev = ($res) ? $res : 0;

        return $rev;
    }

    /**
     * 检查指定ID的店铺是否存在
     *
     * @param   $int    $store_id
     *
     * @return  bool
     */
    function exists($store_id)
    {
        $sql = "SELECT COUNT(*) FROM `ecm_store` WHERE store_id='$store_id'";
        return ($GLOBALS['db']->getOne($sql) != 0);
    }

    /**
     * 创建查询条件
     *
     * @author  scottye
     * @param   array   $condition
     * @return  string
     */
    function _make_condition($condition)
    {
        $where = parent::_make_condition($condition);

        if (!empty($condition['is_recommend']))
        {
            $where .= " AND is_recommend=1";
        }

        if (!empty($condition['is_certified']))
        {
            $where .= " AND is_certified=1";
        }

        if (!empty($condition['keywords']))
        {
            $where .= " AND store_name LIKE '%$condition[keywords]%'";
        }
        if (!empty($condition['store_ids']))
        {
            $where .= " AND store_id " . db_create_in($condition['store_ids']);
        }

        if (!empty($condition['hot']))
        {
            $where .= " AND order_count > 0";
        }

        if (isset($condition['store_is_open']))
        {
            $where .= ' AND is_open = 1 ';
        }
        else
        {
            $where .= ' AND is_open IN (0, 1) ';
        }

        return $where;
    }

};
?>