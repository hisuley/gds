<?php

/**
 * ECMALL: �Ź�������ʵ����
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: mod.groupbuy_actor.php 4816 2008-06-24 06:10:10Z Weberliu $
 */

class GroupBuyActor extends Model
{
    var $_table = '`ecm_group_buy`';
    var $_key = 'log_id';

    /**
     *  ��ȡ��������Ϣ
     *
     *  @access public
     *  @param  none
     *  @return array
     */
    function get_info()
    {
        $sql = "SELECT * FROM {$this->_table} WHERE status = 1 AND {$this->_key} = {$this->_id}";

        return $GLOBALS['db']->getRow($sql);
    }
}

?>