<?php

/**
 * ECMALL: ����ʵ����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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
     * ���캯��
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
     * ȡ�õ�����Ϣ
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
     * ɾ�����̣����øù���
     *
     * @return  void
     */
    function drop()
    {
        return;
    }
    /**
     * ���µ����µ���Ʒ����
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
     * ���µ����µĶ�������
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