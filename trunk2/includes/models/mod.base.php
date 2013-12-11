<?php

/**
 * ECMALL: ʵ��������
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: mod.base.php 2783 2008-05-07 08:07:50Z Liupeng $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class Model
{
    var $_id        = 0;
    var $_table     = '';
    var $_key       = '';
    var $_store_id  = 0;
    var $err        = null;

    /**
     * ���캯��
     */
    function __construct($id, $store_id=0)
    {
        $this->Model($id, $store_id);
    }

    function Model($id, $store_id=0)
    {
        $this->_id          = intval($id);
        $this->_store_id    = intval($store_id);
    }

    /**
     * ȡ����Ϣ
     *
     * @return array
     */
    function get_info()
    {
        if (!$this->_check())
        {
            return false;
        }

        $sql = "SELECT * FROM " . $this->_table .
                " WHERE " . $this->_key . " = '" . $this->_id . "' ";
        if ($this->_store_id > 0)
        {
            $sql .= "AND store_id = '" . $this->_store_id . "'";
        }

        return $GLOBALS['db']->getRow($sql);
    }

    /**
     * ���¶��������
     * ���ô˺�����ǰ���� get_info() ��Ϊ��
     *
     * @return  int
     */
    function update($arr)
    {
        $where = $this->_key . " = '" . $this->_id . "'";

        if ($this->_store_id > 0)
        {
            $where .= "AND store_id = '" . $this->_store_id . "'";
        }

        return $GLOBALS['db']->autoExecute($this->_table, $arr, 'UPDATE', $where);
    }

    /**
     * ɾ������
     * ���ô˺�����ǰ���� get_info() ��Ϊ��
     *
     * @return  bool
     */
    function drop()
    {
        $sql = "DELETE FROM " .$this->_table. " WHERE " .$this->_key. " = '" .$this->_id. "'";

        if ($this->_store_id > 0)
        {
            $sql .= "AND store_id = '" . $this->_store_id . "'";
        }

        return $GLOBALS['db']->query($sql);
    }

    /**
     * �������
     *
     * @return  bool
     */
    function _check()
    {
        if (empty($this->_table))
        {
            $this->err = 'Table name is not defined';
            return false;
        }

        if (empty($this->_key))
        {
            $this->err = 'Key is not defined';
            return false;
        }

        if ($this->_id <= 0)
        {
            $this->err = 'Id is not defined';
            return false;
        }

        return true;
    }
}
?>