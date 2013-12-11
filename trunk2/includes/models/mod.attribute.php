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
 * $Id: mod.attribute.php 2895 2008-05-12 05:29:16Z Scottye $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class Attribute extends Model
{
    /**
     * ���캯��
     */
    function __construct($id, $store_id = 0)
    {
        $this->Attribute($id, $store_id);
    }

    function Attribute($id, $store_id = 0)
    {
        $this->_table = '`ecm_attribute`';
        $this->_key   = 'attr_id';
        parent::Model($id, $store_id);
    }

    /**
     * ȡ����Ϣ
     */
    function get_info()
    {
        $sql = "SELECT a.*, gt.type_name " .
                "FROM `ecm_attribute` AS a, `ecm_goods_type` AS gt " .
                "WHERE a.type_id = gt.type_id " .
                "AND a.attr_id = '" . $this->_id . "' ";
        if ($this->_store_id > 0)
        {
            $sql .= "AND gt.store_id = '" . $this->_store_id . "'";
        }

        return $GLOBALS['db']->getRow($sql);
    }

    /**
     * ɾ��
     */
    function drop()
    {
        /* ɾ����Ʒ���� */
        $sql = "DELETE FROM `ecm_goods_attr` WHERE attr_id = '" . $this->_id . "'";
        $GLOBALS['db']->query($sql);

        return parent::drop();
    }
}

?>