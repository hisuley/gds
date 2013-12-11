<?php

/**
 * ECMALL: 店铺实体类
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: mod.store.php 5088 2008-07-04 02:34:44Z Garbin $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class Store extends Model
{
    /**
     * 构造函数
     */
    function __construct($store_id)
    {
        $this->Store($store_id);
    }

    function Store($store_id)
    {
        $this->_table = '`ecm_store`';
        $this->_key   = 'store_id';
        parent::Model($store_id);
    }

    /**
     * 取得店铺信息
     *
     * @return  array
     */
    function get_info()
    {
        $sql = "SELECT s.*, u.user_name, u.email FROM $this->_table AS s ".
                "LEFT JOIN `ecm_users` AS u ON u.user_id=s.store_id ".
                "WHERE s.$this->_key='$this->_id'";

        $res = $GLOBALS['db']->getRow($sql);

        return $res;
    }
    /**
     * 删除店铺，禁用该功能
     *
     * @return  void
     */
    function drop()
    {
        return;
    }
    /**
     * 更新店铺下的商品总数
     *
     * @param  int  $num
     *
     * @return  void
     */
    function update_goods_count($num)
    {
        $arr = array('goods_count', "goods_count+($num)");

        return $this->update($arr);
    }
    /**
     * 更新店铺下的订单总数
     *
     * @param  int  $num
     *
     * @return  void
     */
    function update_order_count($num)
    {
        $sql = "UPDATE {$this->_table} SET order_count = order_count + ($num) WHERE store_id = {$this->_id}";
        $GLOBALS['db']->query($sql);

        return $GLOBALS['db']->affected_rows();
    }

}
?>