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
 * $Id: mod.nav.php 3938 2008-05-29 06:25:35Z Liupeng $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

class Nav extends Model
{
    /**
     * ���캯��
     */
    function __construct($nav_id)
    {
        $this->Nav($nav_id);
    }
    function Nav($nav_id)
    {
        $this->_table = '`ecm_nav`';
        $this->_key   = 'nav_id';
        parent::Model($nav_id);
    }

    /**
     * ���µ����˵���
     *
     * @author  liupeng
     * @param   array  $arr �˵�����Ϣ
     * @return  bool
     */
    function update($arr)
    {
        foreach ($arr as $key => $value)
        {
            if ($key == 'nav_name')
            {
                if (empty($value))
                {
                    $this->err = 'nav_name_empty';
                    return false;
                }
               
                if (($id = $this->get_by_name($value)) && $id != $this->_id)
                {
                    $this->err = 'nav_name_duplication';
                    return false;
                }
            }
        }
        return parent::update($arr);
    }

    function get_by_name($name)
    {
        $sql = "SELECT * FROM `ecm_nav` WHERE nav_name='$name'";
        return $GLOBALS['db']->getOne($sql);
    }
}
?>