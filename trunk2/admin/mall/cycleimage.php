<?php

/**
 * ECMall: 广告位管理控制器
 * ============================================================================
 * 版权所有 (C) 2005-2008 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.comsenz.com
 * ----------------------------------------------------------------------------
 * 这是一个免费开源的软件；这意味着您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * ============================================================================
 * $Id: cycleimage.php 5234 2008-07-14 08:10:58Z Liupeng $
*/

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

include(ROOT_PATH. '/includes/cls.xml.php');
include(ROOT_PATH. '/includes/cls.uploader.php');
include_once(ROOT_PATH . '/includes/cls.validator.php');

class CycleImageController extends ControllerBackend
{
    function __construct($act)
    {
        $this->CycleImageController($act);
    }

    function CycleImageController($act)
    {
        if (empty($act))
        {
            $act = 'view';
        }
        parent::ControllerBackend($act);
    }

    /**
     * 查看轮播图片列表
     *
     * @author  scottye
     * @return  void
     */
    function view()
    {
        $this->logger = false;
        $doc = $this->_get_document();
        $doc =& $doc->firstChild();
        $data = array();

        for ($i = 0; $i < count($doc->children); $i++)
        {
            
            $tmp = array_merge($doc->children[$i]->attributes, $doc->children[$i]->toArray());
            $tmp['link'] = urldecode($tmp['link']);
            $data[] = $tmp;
        }

        $this->assign('data', $data);
        $this->assign('cycleimage_stats',  $this->str_format('cycleimage_stats', count($data)));
        $this->display('cycle_image.view.html', 'mall');
    }


    /**
     * 获取XML文档
     *
     * @author  scottye
     * @return  void
     */
    function _get_document()
    {
        /* 从数据库读取 */
        $xml = new XmlLib_xmlParser();
        $content = "<?xml version=\"1.0\" encoding=\"".$encoding."\" ?>\n";
        $str = $this->conf('mall_cycle_image');
        if (empty($str))
        {
            $str = "<data><channel></channel></data>";
        }
        $xml->loadFromString($content . $str);

        $doc = $xml->getDocument();

        return $doc;
    }

    /**
     * 生成ID
     *
     * @author  scottye
     * @return  void
     */
    function _create_id()
    {
        $doc = $this->_get_document();
        $doc =& $doc->firstChild();
        $id = 0;
        for ($i = 0; $i < count($doc->children); $i++)
        {
            if (intval($doc->children[$i]->attributes['id']) > $id)
            {
                $id = intval($doc->children[$i]->attributes['id']);
            }
        }

        return ($id + 1);
    }

    /**
     * 添加轮播图片
     *
     * @author  liupeng
     * @return  void
     */
    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->logger = false;
            $this->display('cycle_image.detail.html', 'mall');
        }
        else
        {
            $node = new Xmllib_Node('item');
            $node->attributes['id'] = $this->_create_id();

            /* 检查链接地址 */
            if (!Validator::is_url($_POST['link']))
            {
                $this->show_warning('link_invalid');
                return;
            }
            else
            {
                $link_node =& $node->createChild('link');
                $_POST['link'] = urlencode($_POST['link']);
                $link_node->appendChild(XmlLib_Node::createTextNode($_POST['link']));
            }

            /* 处理图片的地址 */
            $path = '';
            if ($_POST['file_radio'] == '1')
            {
                if (($path = $this->upload_image($_FILES['file'])) === false)
                {
                    $this->show_warning($this->err);
                    $this->err = '';
                    return;
                }
            }
            else
            {
                if (($path = $this->image_path($_POST['file'])) === false)
                {
                    $this->show_warning('not_local_url');
                    return;
                }
            }
            $image_node =& $node->createChild('image');
            $image_node->appendChild(XmlLib_Node::createTextNode($path));

            $doc = $this->_get_document();
            $doc =& $doc->firstChild();
            $doc->appendChild($node);

            $this->_save($doc->parent->toString());

            $location = preg_replace('/act=\w+/i', 'act=view', $_SERVER['REQUEST_URI']);
            $this->show_message('add_succeed', 'back_list', $location);
            return;
        }
    }

    /**
     * 编辑轮播图片
     *
     * @author  liupeng
     * @return  void
     */
    function edit()
    {
        if (empty($_REQUEST["id"]))
        {
            $this->redirect("admin.php?app=cycleimage");
        }
        $id = intval($_REQUEST["id"]);
        $this->log_item = $id;
        $doc = $this->_get_document();
        $doc =& $doc->firstChild();
        $node = @$doc->getElementById($id);

        if ($node->attributes['id'] == NULL)
        {
            $this->show_warning('image_not_exist');
            return;
        }

        $node_info = array_merge($node->attributes, $node->toArray());

        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->logger = false;
            $node_info['link'] = urldecode($node_info['link']);
            
            $this->assign('info', $node_info);

            $this->display('cycle_image.detail.html', 'mall');
        }
        else
        {
            /* 处理图片 */
            if ($_POST['file_radio'] == '1')
            {
                if (($path = $this->upload_image($_FILES['file'])) === false)
                {
                    $this->show_warning($this->err);
                    $this->err = '';
                    return;
                }
                else
                {
                    if (strpos($node_info['image'], 'data/images') !== false)
                    {
                        _at('unlink', ROOT_PATH . '/' . $node_info['image']);
                    }
                }
            }
            else
            {
                if (($path = $this->image_path($_POST['file'])) === false)
                {
                    $this->show_warning('not_local_url');

                    return;
                }
            }

            $image_node = $node->children('image');
            $image_node[0]->setNodeValue($path);

            /* 处理链接地址 */
            if (!Validator::is_url($_POST['link']))
            {
                $this->show_warning('link_invalid');
                return;
            }
            else
            {
                $link_node = $node->children('link');
                $link_node[0]->setNodeValue(urlencode($_POST['link']));
            }

            $this->_save($doc->parent->toString());

            $location = preg_replace('/act=\w+/i', 'act=view', $_SERVER['REQUEST_URI']);
            $this->show_message('edit_succeed', 'back_list', $location);

            return;
        }
    }

    /**
     * 删除轮播图片数据
     *
     * @author  scottye
     * @return  void
     */
    function drop()
    {
        if (empty($_GET['id']))
        {
            $this->redirect("admin.php?app=article");
            return;
        }

        $id = $_GET['id'];
        $this->log_item = $id;

        $doc = $this->_get_document();
        $root =& $doc->firstChild();

        $node =& $doc->getElementById($id);

        if ($node == NULL)
        {
            $this->show_warning('image_not_exist');
            return;
        }

        $node_info = array_merge($node->attributes, $node->toArray());

        $root->removeById($id);

        $this->_save($doc->toString());

        if (strpos($node_info['image'], 'data/images') !== false &&
            is_file(ROOT_PATH . '/' . $node_info['image']))
        {
             unlink(ROOT_PATH . '/' . $node_info['image']);
        }

        $location = preg_replace('/act=\w+/i', 'act=view', $_SERVER['REQUEST_URI']);
        $this->show_message('delete_succeed', 'back_list', $location);
        return;
    }

    /**
     * 保存
     *
     * @author  scottye
     * @param   string  $content
     * @return  void
     */
    function _save($content)
    {
        include_once(ROOT_PATH . '/includes/manager/mng.conf.php');
        $mng_conf = new ConfManager(0);
        $mng_conf->set_conf('mall_cycle_image', $content);
    }

    /**
     * 处理图片的url地址，并创建xml节点
     *
     * @author  weberliu
     * @param   string  $file   文件路径
     * @return  string|false
     */
    function image_path($file)
    {
        $site_url = site_url();

        if ((strpos($file, 'http://') !== false || strpos($file, 'https://') !== false) &&
            strpos($file, $site_url) === false)
        {
            return false;
        }
        else
        {
            return str_replace($site_url.'/', '', $file);
        }
    }

    /**
     * 处理上传的图片，并返回路径
     *
     * @author  weberliu
     * @param   array   $uploaded   上传的文件信息的数组
     * @return  string|false
     */
    function upload_image($uploaded)
    {
        $retval = false;
        $uploader = new Uploader('data/images/', 'image', $this->conf('mall_max_file'));

        if (!empty($uploaded['name']))
        {
            if ($uploader->upload_files($uploaded))
            {
                $files = $uploader->success_list;
                $retval = $files[0]['target'];
            }
            else
            {
                $this->err = $uploader->err;
            }
        }
        else
        {
            $this->err = 'not_file';
        }

        return $retval;
    }

};
?>
