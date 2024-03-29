<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
require("foundation/module_gallery.php");
require("foundation/module_img_size.php");
require("foundation/module_shop.php");

//语言包引入
$m_langpackage = new moduleslp;
$s_langpackage = new shoplp;
$dbo = new dbex();
//定义文件表
$t_goods = $tablePreStr . "goods";
$t_goods_attr = $tablePreStr . "goods_attr";
$t_attribute = $tablePreStr . "attribute";
$t_goods_gallery = $tablePreStr . "goods_gallery";
$t_shop_info = $tablePreStr . "shop_info";
@$t_img_size = $tablePreStr . "img_size";
$t_transport_template = $tablePreStr . "goods_transport";
$t_users = $tablePreStr . "users";
$t_category = $tablePreStr . "category";
$post = array(
    'goods_name' => short_check(get_args('goods_name')),
    'cat_id' => intval(get_args('cat_id')),
    'ucat_id' => intval(get_args('ucat_id')),
    'brand_id' => intval(get_args('brand_id')),
    'goods_intro' => big_check(get_args('goods_intro')),
    'goods_wholesale' => big_check(get_args('goods_wholesale')),
    'goods_number' => intval(get_args('goods_number')),
    'keyword' => short_check(get_args('keyword')),
    'goods_price' => floatval(get_args('goods_price')),
    'transport_price' => floatval(get_args('transport_price')),
    'is_on_sale' => intval(get_args('is_on_sale')),
    'is_best' => intval(get_args('is_best')),
    'is_new' => intval(get_args('is_new')),
    'is_hot' => intval(get_args('is_hot')),
    'is_promote' => intval(get_args('is_promote')),
    'type_id' => intval(get_args('type_id')),
    'is_transport_template' => intval(get_args("is_transport_template")),
    'transport_template_id' => intval(get_args("transport_template_id")),
);

$post['last_update_time'] = $ctime->long_time();
$goods_id = intval(get_args('goods_id'));
$filterAttr = array();

//数据库操作
dbtarget('r', $dbServs);
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql = "select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if ($row['locked'] == 1) {
    session_destroy();
    trigger_error($m_langpackage->m_user_locked); //非法操作
}
$goods_attr = get_goods_attr($dbo, $t_goods_attr, $goods_id);
$have_attr = array();
if ($goods_attr) {
    foreach ($goods_attr as $v) {
        $have_attr[$v['attr_id']]['attr_values'] = $v['attr_values'];
        $have_attr[$v['attr_id']]['price'] = $v['price'];
    }
}
if ($post['is_best'] == 1 || $post['is_new'] == 1 || $post['is_hot'] == 1 || $post['is_promote'] == 1) {
    $is_best = 0;
    $is_promote = 0;
    $is_new = 0;
    $is_hot = 0;

    $rs = get_isname_num($dbo, $t_goods, $shop_id);
    foreach ($rs as $val) {
        if ($val['goods_id'] != $goods_id) {
            if ($val['is_best'] == 1) {
                $is_best++;
            }
            if ($val['is_promote'] == 1) {
                $is_promote++;
            }
            if ($val['is_new'] == 1) {
                $is_new++;
            }
            if ($val['is_hot'] == 1) {
                $is_hot++;
            }
        }
    }

    if ($is_best >= $user_privilege[4]) {
        $post['is_best'] = 0;
    }
    if ($is_promote >= $user_privilege[5]) {
        $post['is_promote'] = 0;
    }
    if ($is_new >= $user_privilege[6]) {
        $post['is_new'] = 0;
    }
    if ($is_hot >= $user_privilege[7]) {
        $post['is_hot'] = 0;
    }
}

$post_attr['attr_values'] = get_args('attr');
$post_attr['price'] = get_args('price');
$sql = "select attr_id from `$t_attribute` where attr_name='编号'";
$attr_id = $dbo->getRow($sql);
$sql = "select count(*) from `$t_goods_attr` where attr_values='" . $post_attr['attr_values'][$attr_id['attr_id']] . "' and attr_id ='" . $attr_id['attr_id'] . "' and goods_id <> $goods_id";
$result = $dbo->getRow($sql);
if ($result['count(*)']) {
    action_return(0, $m_langpackage->m_travel_number_repeat, '-1');
}
$filterAttr = filterAttr($have_attr, $post_attr);
/* 图片上传处理 */
$cupload = new upload();
$cupload->set_dir("uploadfiles/goods/", "{y}/{m}/{d}");
$setthumb = array(
    'width' => array($SYSINFO['width1'], $SYSINFO['width2']),
    'height' => array($SYSINFO['height1'], $SYSINFO['height2']),
    'name' => array('thumb', 'm')
);
$cupload->set_thumb($setthumb);
$file = $cupload->execute();

$row = get_shop_info($dbo, $t_shop_info, $shop_id);

//数据库操作
dbtarget('w', $dbServs);
$img_size[8] = '';
$img_size_k = "";
$img_size = unserialize(get_sess_privilege());
if (isset($img_size[8])) {
    $img_size_k = $img_size[8] * 1024 * 1024;
}
if ($row['count_imgsize'] > $img_size_k) {
    action_return(0, $m_langpackage->m_img_prompt . $img_size[8] . $m_langpackage->m_img_prompt2, '-1');
} else
    if ($file) {
        $insert_array = array();
        foreach ($file as $k => $v) {
            if ($v['flag'] == 1) {
                $insert_array[$k]['img_url'] = $v['dir'] . $v['m'];
                $insert_array[$k]['thumb_url'] = $v['dir'] . $v['thumb'];
                $insert_array[$k]['img_original'] = $v['dir'] . $v['name'];
                $insert_array[$k]['is_set'] = '1';
                $post['goods_thumb'] = $v['dir'] . $v['thumb'];
                $post['is_set_image'] = '1';

                $post1[$k]['uid'] = $user_id;
                $post1[$k]['img_size'] = $v['size'];
                $post1[$k]['upl_time'] = $ctime->long_time();
                $post1[$k]['img_url'] = str_replace($webRoot, "", $v['dir']) . $v['name'];
            }
        }
        dbtarget('w', $dbServs);

        img_size($dbo, $t_img_size, $post1, $t_shop_info, $row['count_imgsize'], $shop_id);
    }
////商品分类表，每个商品分类下面有多少商品
$sql = "select * from $t_goods where goods_id=$goods_id";
$row = $dbo->getRow($sql);
if (update_goods_info($dbo, $t_goods, $post, $goods_id, $shop_id)) {
    update_default_transportprice($dbo, $t_goods, $t_transport_template, $goods_id);

    ////如果修改后的商品分类和原来的商品分类不一样，则将原来的减一，新的加一
    if ($row['cat_id'] != $post['cat_id']) {
        //先将相应的分类中的商品数量删除
        $flag = true;
        $preid = $row['cat_id'];
        while ($flag) {
            $sql = "update $t_category set goods_num=goods_num-1 where cat_id=$preid";
            $dbo->exeUpdate($sql);
            $sql1 = "select * from $t_category where cat_id=$preid";
            $arry = $dbo->getRow($sql1);
            if ($arry['parent_id'] != 0) {
                $preid = $arry['parent_id'];
            } else {
                $flag = false;
            }
        }
        //再将相应的分类中的商品数量增加
        $flag = true;
        $preid = $post['cat_id'];
        while ($flag) {
            $sql = "update $t_category set goods_num=goods_num+1 where cat_id=$preid";
            $dbo->exeUpdate($sql);
            $sql1 = "select * from $t_category where cat_id=$preid";
            $arry = $dbo->getRow($sql1);
            if ($arry['parent_id'] != 0) {
                $preid = $arry['parent_id'];
            } else {
                $flag = false;
            }
        }
    }

    if (isset($filterAttr['insert'])) {
        insert_goods_attr($dbo, $t_goods_attr, $filterAttr['insert'], $goods_id);
    }

    if (isset($filterAttr['update'])) {
        update_goods_attr($dbo, $t_goods_attr, $filterAttr['update'], $goods_id);
    }

    if (isset($filterAttr['delete'])) {
        delete_goods_attr($dbo, $t_goods_attr, $filterAttr['delete'], $goods_id);
    }

    if ($file) { // 如果需要更新图片
        unset_gallery_setimg($dbo, $t_goods_gallery, $goods_id);
        insert_gallery_info($dbo, $t_goods_gallery, $goods_id, $insert_array);
    }

    action_return(1, $m_langpackage->m_editgoods_success, "modules.php?app=goods_edit&id=" . $goods_id);
} else {
    action_return(0, $m_langpackage->m_editgoods_fail, '-1');
}
exit;

// 通过现有的属性与提交上来的属性进行比较
// 取得 需要更新，删除，添加的属性
function filterAttr($haveArray, $postArray)
{
    $array = array();
    foreach ($haveArray as $key => $value) {
        if ($postArray['attr_values'][$key]) {
            if ($postArray['attr_values'][$key] != $value['attr_values'] || $postArray['price'][$key] != $value['price']) {
                if (is_array($postArray['price'][$key])) {
                    foreach ($postArray['price'][$key] as $k => $v) {
                        $postArray['price'][$key][$k] = intval($v);
                        for ($i = count($postArray['attr_values'][$key]), $j = count($postArray['price'][$key]); $i <= $j; $i++) {
                            unset($postArray['price'][$key][$i]);
                        }
                    }
                } else {
                    $postArray['price'][$key] = intval($val);
                }
                $array['update'][$key]['attr_values'] = $postArray['attr_values'][$key];
                $array['update'][$key]['price'] = $postArray['price'][$key];
            }
            unset($postArray['attr_values'][$key]);
            unset($postArray['price'][$key]);
        } else {
            $array['delete'][$key]['attr_values'] = $value['attr_values'];
            $array['delete'][$key]['price'] = $value['price'];
        }
    }
    $array['insert'] = $postArray;
    return $array;
}

?>