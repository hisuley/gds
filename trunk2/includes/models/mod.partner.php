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
 * $Id: mod.partner.php 5141 2008-07-08 03:08:57Z zhaoxiongfei $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class Partner extends Model
{
    /**
     * ���캯��
     */
    function __construct($id, $store_id = 0)
    {
        $this->Partner($id, $store_id);
    }

    function Partner($id, $store_id = 0)
    {
        $this->_table = '`ecm_partner`';
        $this->_key   = 'partner_id';
        $this->_id    = $id;
        $this->_store_id = $store_id;
    }

    function update($data)
    {
        $info = $this->get_info();

        if ($data['partner_logo'] && is_file($info['partner_logo']))
        {
            unlink($info['partner_logo']);
        }

        return parent::update($data);
    }

    /**
     * @ɾ����¼
     * @author redstone
     *
     * @return void
     */
    function drop()
    {
        $info = $this->get_info();
        if ($info['partner_logo'] && is_file($info['partner_logo']) && is_writable($info['partner_logo']))
        {
            unlink($info['partner_logo']);
        }
        parent::drop();
    }
}
?>