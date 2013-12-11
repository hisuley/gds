<?php

/**
 * ECMALL: 网站后台管理左侧菜单数据
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * -------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Id: inc.privilege.php 5294 2008-07-18 07:58:44Z Weberliu $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

$privilege_item = array
(
    'mall_admin' => array
    (
        array(
            'title' => 'mall_conf',
            'appact' => 'conf|setting,conf|send_test_email',
            ),
        array(
            'title' => 'region_admin',
            'appact' => 'region|view,region|drop,region|modify,region|update,region|add',
            ),
        array(
            'title' => 'order_view',
            'appact' => 'order|view',
            ),
        array(
            'title' => 'user_admin',
            'appact' => 'user|view,user|edit',
            ),
        array(
            'title'  => 'template_edit',
            'appact' => 'template|view,template|edit,template|update_template,template|get_custom_modules,template|get_modules,template|get_ads,template|create_module,template|get_layouts,template|set_layout,template|get_skins,template|get_cate_tree,template|add_module,template|delete_module,template|get_css,template|restore',
            ),
        array(
            'title' => 'mailtemplate',
            'appact' => 'mailtemplate|setting',
            ),
        array(
            'title' => 'appsetting',
            'appact' => 'appsetting|setting',
            ),
        array(
            'title' => 'mall_clean_cache',
            'appact' => 'home|mall_clean_cache',
            ),
    ),
    'store_admin' => array
    (
        array(
            'title' => 'store_admin',
            'appact' => 'store|view,store|add,store|edit,store|drop,store|modify,store|batch,store|get_userlist,store|duplicate_name,store|admin_exists',
            ),
        array(
            'title' => 'store_apply',
            'appact' => 'storeapply|view,storeapply|detail,storeapply|process,storeapply|drop,storeapply|batch',
            ),
    ),
    'adv_admin' => array
    (
        array(
            'title' => 'adv_position_admin',
            'appact' => 'ad_position|view,ad_position|edit,ad_position|drop,ad_position|modify,ad_position|add',
            ),
        array(
            'title' => 'adv_admin',
            'appact' => 'ad|view,ad|edit,ad|add,ad|drop,ad|modify',
            ),
    ),
    'article_admin' => array
    (
        array(
            'title' => 'article_admin',
            'appact' => 'article|add,article|view,article|modify,article|batch,article|edit,article|drop',
            ),
        array(
            'title' => 'builtin_article_admin',
            'appact' => 'builtinarticle|view,builtinarticle|edit,builtinarticle|modify',
        ),
    ),
    'goods_admin' => array
    (
        array(
            'title' => 'category_admin',
            'appact' => 'category|view,category|add,category|edit,category|drop,category|modify',
            ),
        array(
            'title' => 'goods_type',
            'appact' => 'goodstype|view,goodstype|add,goodstype|edit,goodstype|drop,goodstype|modify,goodstype|batch,attribute|view,attribute|edit,attribute|add,attribute|drop,attribute|modify,attribute|batch,attribute|duplicate_name',
            ),
        array(
            'title' => 'brand_admin',
            'appact' => 'brand|view,brand|add,brand|edit,brand|drop,brand|modify,brand|batch,brand|duplicate_name',
            ),
        array(
            'title' => 'goods_admin',
            'appact' => 'goods|view,goods|add,goods|edit,goods|drop,goods|modify,goods|batch,goods|view',
            ),
    ),
    'administrator' => array
    (
        array(
            'title' => 'admin_admin',
            'appact' => 'admin|view,admin|add,admin|edit,admin|drop,admin|modify,admin|batch',
            ),
        array(
            'title' => 'admin_logs',
            'appact' => 'admin|logs,admin|remove_logs',
            ),
    ),
    'mixed_admin' => array
    (
        array(
            'title' => 'nav_admin',
            'appact' => 'nav|view,nav|edit,nav|add,nav|drop,nav|modify,nav|batch',
            ),
        array(
            'title' => 'partner_admin',
            'appact' => 'partner|view,partner|edit,partner|add,partner|drop,partner|modify,partner|batch',
            ),
        array(
            'title' => 'cycleimage_admin',
            'appact' => 'cycleimage|view,cycleimage|edit,cycleimage|add,cycleimage|drop,cycleimage|modify,cycleimage|batch',
            ),
    ),
    'stats_view' => array
    (
        array(
            'title' => 'view_stats',
            'appact'   => 'statistics|guest_stats,statistics|store_order,statistics|sale_list,statistics|sale_order,statistics|user_order,statistics|visit_sold,statistics|view_flow,statistics|view_sale,statistics|view_order',
            ),
    ),

);

?>