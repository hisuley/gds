<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("../foundation/asession.php");
require("../configuration.php");
require("../includes.php");
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$i_langpackage=new indexlp;

//数据表定义区
$t_goods = $tablePreStr."goods";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

//获取最新上架的商品
$sql = "select goods_id,goods_name,goods_intro,add_time from `$t_goods` where is_on_sale=1 order by add_time desc";
$result = $dbo->getRs($sql);

$rss = new RSS();
foreach($result as $row){
    $rss->AddItem($row['goods_name'],$baseUrl.'/goods.php?id='.$row['goods_id'],$row['goods_intro'],$row['add_time']);
}

$title = $i_langpackage->i_index." - ".$SYSINFO['sys_title'];
$description = $SYSINFO['sys_description'];
$rss->RSS($title,$baseUrl,$description);
$rss->BuildRSS();
$rss->SaveToFile('rss.xml');
$rss->getFile('rss.xml');

/**
* Class name: RSS
*/
class RSS {

    public $rss_ver = "2.0";
    public $channel_title = '';
    public $channel_link = '';
    public $channel_description = '';
    public $language = 'zh_CN';
    public $copyright = '';
    public $webMaster = '';
    public $pubDate = '';
    public $lastBuildDate = '';
    public $generator = 'RedFox RSS Generator';

    public $content = '';
    public $items = array();

    /**************************************************************************/
    // 函数名: RSS
    // 功能: 构造函数
    // 参数: $title
    // $link
    // $description
    /**************************************************************************/
    function RSS($title, $link, $description) {
        $this->channel_title = $title;
        $this->channel_link = $link;
        $this->channel_description = $description;
        $this->pubDate = Date('Y-m-d H:i:s',time());
        $this->lastBuildDate = Date('Y-m-d H:i:s',time());
    }
    /**************************************************************************/
    // 函数名: AddItem
    // 功能: 添加一个节点
    // 参数: $title
    // $link
    // $description $pubDate
    /**************************************************************************/
    function AddItem($title, $link, $description ,$pubDate) {
        $this->items[] = array('title' => $title ,'link' => $link,'description' => $description,'pubDate' => $pubDate);
    }
    /**************************************************************************/
    // 函数名: BuildRSS
    // 功能: 生成rss xml文件内容
    /**************************************************************************/
    function BuildRSS() {
        $s = "<?xml version='1.0' encoding='utf-8'?>\n<rss version='2.0'>\n";
        // start channel
        $s .= "<channel>\n";
        $s .= "<title><![CDATA[{$this->channel_title}]]></title>\n";
        $s .= "<link><![CDATA[{$this->channel_link}]]></link>\n";
        $s .= "<description><![CDATA[{$this->channel_description}]]></description>\n";
        $s .= "<language>{$this->language}</language>\n";
        if (!empty($this->copyright)) {
            $s .= "<copyright><![CDATA[{$this->copyright}]]></copyright>\n";
        }
        if (!empty($this->webMaster)) {
            $s .= "<webMaster><![CDATA[{$this->webMaster}]]></webMaster>\n";
        }
        if (!empty($this->pubDate)) {
            $s .= "<pubDate>{$this->pubDate}</pubDate>\n";
        }

        if (!empty($this->lastBuildDate)) {
            $s .= "<lastBuildDate>{$this->lastBuildDate}</lastBuildDate>\n";
        }

        if (!empty($this->generator)) {
            $s .= "<generator>{$this->generator}</generator>\n";
        }
        // start items
        for ($i=0;$i<count($this->items);$i++) {
            $s .= "<item>\n";
            $s .= "<title><![CDATA[{$this->items[$i]['title']}]]></title>\n";
            $s .= "<link><![CDATA[{$this->items[$i]['link']}]]></link>\n";
            $s .= "<description><![CDATA[{$this->items[$i]['description']}]]></description>\n";
            $s .= "<pubDate>{$this->items[$i]['pubDate']}</pubDate>\n";          
            $s .= "</item>\n";
        }
        // close channel
        $s .= "</channel>\n</rss>";
        $this->content = $s;
    }
    /**************************************************************************/
    // 函数名: Show
    // 功能: 将产生的rss内容直接打印输出
    /**************************************************************************/
    function Show() {
        if (empty($this->content)) $this->BuildRSS();
        echo($this->content);
    }
    /**************************************************************************/
    // 函数名: SaveToFile
    // 功能: 将产生的rss内容保存到文件
    // 参数: $fname 要保存的文件名
    /**************************************************************************/
    function SaveToFile($fname) {
        $handle = fopen($fname, 'wb');
        if ($handle === false) return false;
        fwrite($handle, $this->content);
        fclose($handle);
    }

    function getFile($fname) {
        $handle = fopen($fname, 'r');
        if ($handle === false) return false;
        while(!feof($handle)){
            echo fgets($handle);
        }
        fclose($handle);
    }
}

