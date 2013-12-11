<?php

/**
 * ECMALL: 团购参与者实体类
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * -------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: mod.groupbuy_actor.php 4816 2008-06-24 06:10:10Z Weberliu $
 */

class GroupBuyActor extends Model
{
    var $_table = '`ecm_group_buy`';
    var $_key = 'log_id';

    /**
     *  获取参与者信息
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