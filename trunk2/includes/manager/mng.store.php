<?php

/**
 * ECMALL: ���̹�����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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
     * ��õ����б�
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
     * ��÷��������ļ�¼����
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
     * ����һ������
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
     * ��������ѡ���ĵ���
     *
     * @author  weberliu
     * @param   string      $type   ���������� set_recommend, set_certified, set_open
     * @param   string      $in     ���̵�ID��ʹ�ö��ŷָ�
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
     * ���ݸ����ĵ������ƻ�õ��̵�ID
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
     * ���ָ��ID�ĵ����Ƿ����
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
     * ������ѯ����
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