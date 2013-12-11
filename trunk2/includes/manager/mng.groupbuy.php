<?php

/**
 * ECMall: :�Ź��������
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: mng.groupbuy.php 2783 2008-05-07 08:07:50Z Liupeng $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

include(ROOT_PATH. '/includes/manager/mng.activity.php');

class GroupBuyManager extends ActivityManager
{
    function __construct($store_id=0)
    {
        $this->GroupBuyManager($store_id);
    }

    function GroupBuyManager($store_id=0)
    {
        parent::__construct(ACT_GROUPBUY, $store_id);
    }
    
    function get_list($page, $condition=array(), $pagesize = 0)
    {
        $list = parent::get_list($page, $condition, $pagesize);        
        //����չ��Ϣ�����л�
        $func = create_function('&$arr', '$arr[\'ext\']=unserialize($arr[\'ext_info\']);');
        array_walk($list['data'], $func);
        
        return $list;
        
    }
};
?>