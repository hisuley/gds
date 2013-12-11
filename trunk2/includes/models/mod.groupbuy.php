<?php

/**
 * ECMALL: �Ź��ʵ����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: mod.groupbuy.php 2783 2008-05-07 08:07:50Z Liupeng $
 */

require_once(ROOT_PATH. '/includes/models/mod.activity.php');
class GroupBuy extends Activity
{
    var $_act_id = 0;

    /**
     *  ���캯��
     *  @params $store_id, $goods_list
     *  @return
     */
    function __construct($act_id=0, $store_id=0)
    {
        $this->GroupBuy($act_id, $store_id);
    }

    function GroupBuy($act_id=0, $store_id=0)
    {
        $this->_act_id = $act_id;

        parent::__construct(ACT_GROUPBUY, $act_id, $store_id);
    }

    /**
     *  ��ȡ�Ź��Ѳμ������͹�������
     *  @params void
     *  @return array
     */
    function get_total_info()
    {
        $sql = "SELECT SUM(number) as goods_num, COUNT(user_id) AS actor_num ".
               " FROM `ecm_group_buy` WHERE act_id = '{$this->_act_id}'";

        $data = $GLOBALS['db']->getRow($sql);

        if (empty($data['goods_num'])) $data['goods_num'] = 0;

        return $data;
    }

    /**
     * ɾ���Ź��
     */
    function drop()
    {
        $sql = "DELETE FROM `ecm_goods_activity` WHERE act_id = '{$this->_act_id}' AND act_type='" . ACT_GROUPBUY . "'";
        if ($this->_store_id > 0)
        {
            $sql .= " AND store_id='{$this->_store_id}'";
        }
        $GLOBALS['db']->query($sql);
        if ($GLOBALS['db']->affected_rows())
        {
            $sql = "DELETE FROM `ecm_group_buy` WHERE act_id='{$this->_act_id}'";
            $GLOBALS['db']->query($sql);
        }
    }
}

?>
