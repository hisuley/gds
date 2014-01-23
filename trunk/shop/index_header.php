<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/index_header.html
 * 如果您的模型要进行修改，请修改 models/shop/index_header.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if (!function_exists("tpl_engine")) {
    require("foundation/ftpl_compile.php");
}
if (filemtime("templates/default/shop/index_header.html") > filemtime(__file__) || (file_exists("models/shop/index_header.php") && filemtime("models/shop/index_header.php") > filemtime(__file__))) {
    tpl_engine("default", "shop/index_header.html", 1);
    include(__file__);
} else {
    /* debug模式运行生成代码 结束 */
    ?><?php
    if (!$IWEB_SHOP_IN) {
        trigger_error('Hacking attempt');
    }

    if ($USER['shop_id']) {
        $url = shop_url($USER['shop_id']);
    } else {
        $url = 'modules.php?app=shop_info';
    }
    $search_header_type = short_check(get_args("search_type"));
//引入语言包
    if (!isset($i_langpackage)) {
        $i_langpackage = new indexlp;
    }
    $ksearch = short_check(get_args("k"));
    if ($i_langpackage->i_search_keyword == $ksearch) {
        $ksearch = "";
    }

//数据表定义区
    $t_keywords_count = $tablePreStr . "keywords_count";
    if (!isset($dbo)) {
        /* 数据库操作 */
        dbtarget('r', $dbServs);
        $dbo = new dbex();
    }
    $keyword_sql = "select * from $t_keywords_count order by count desc LIMIT 0,5";
    $keyword_result = $dbo->getRs($keyword_sql);

//获取天气，定时更新
//$weather = file_get_contents('http://m.weather.com.cn/data/101300501.html', 'r');
//$weather = json_decode($weather);
    ?>
    <div class="box_os">
        <div class="os_x"></div>
        <div class="osqq">
            <p><em>(工作日：9:00-18:30)</em></p>

            <p><strong>在线QQ</strong></p>
            <a target="_blank" href="http://wpa.qq.com/msgrd@v=3&uin=1792347823&site=qq&menu=yes"><p id="ico_onlineqq"
                                                                                                     class="qq"></p></a>

            <p><strong>客服电话</strong><span>0773-00000000</span><span>010-00000000</span></p>

            <p><strong>会员卡代理</strong><span>0773-000000-0000</span></p>
        </div>
    </div>
    <div class="onlineService">
        <p class="ico_os"></p>
        <a class="ico_gt" href="javascript:" target="_self" title=""></a>
    </div>
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(document).ready(function () {
            $j('.onlineService .ico_os').click(function () {
                $j('.onlineService').hide();
                $j('.box_os').show();
            });
            $j('.os_x').click(function () {
                $j('.box_os').hide();
                $j('.onlineService').show();
            });
            $boxOsFun = function () {
                var st = $j(document).scrollTop();
                if (!window.XMLHttpRequest) {
                    $j('.box_os').css('top', st + 44);
                    $j('.onlineService').css('top', st + 44);
                }
            };
            $j(window).bind('scroll', $boxOsFun);
            $boxOsFun();

            $j('.acbox .ico_pp').hover(function () {
                    $j(this).stop().animate({height: '52px'}, 'fast');
                }, function () {
                    $j(this).stop().animate({height: '33px'}, 'fast');
                }
            );
            $j('.acbox .ico_gt').hover(function () {
                    $j(this).stop().animate({height: '52px'}, 'fast');
                }, function () {
                    $j(this).stop().animate({height: '33px'}, 'fast');
                }
            );

            $j('.onlineService .ico_pp').hover(function () {
                    $j(this).stop().animate({width: '87px'}, 'fast');
                }, function () {
                    $j(this).stop().animate({width: '39px'}, 'fast');
                }
            );
            $j('.onlineService .ico_gt').hover(function () {
                    $j(this).stop().animate({width: '97px'}, 'fast');
                }, function () {
                    $j(this).stop().animate({width: '39px'}, 'fast');
                }
            );

            $j('.ico_gt').click(function () {
                $j("html, body").animate({scrollTop: 0}, 1);
            })


            //分辨率
            if ($j(window).width() < 1200 || screen.width < 1200) {
                $j('.hydp950,.w_950,.sdmain,.main').css('overflow', 'hidden');
                $j('.top_bg').css({'overflow': 'hidden', 'width': '950px', 'margin': '0 auto'});
                $j('.db_bg2').addClass('db_bg2_s');
                $j('.jstd_c .bg_l,.jstd_c .bg_r').css('display', 'none');
                $j('#js_play .prev').css('left', '0');
                $j('#js_play .next').css('right', '0');
                $j('#videoplay .prev, #videoplay2 .prev').addClass('prev_s');
                $j('#videoplay .next, #videoplay2 .next').addClass('next_s');
            } else {
                $j('.hydp950,.w_950,.sdmain,.main').removeAttr('style');
                $j('.top_bg').removeAttr('style');
                $j('.db_bg2').removeClass('db_bg2_s');
                $j('.jstd_c .bg_l,.jstd_c .bg_r').removeAttr('style');
                $j('#js_play .prev').removeAttr('style');
                $j('#js_play .next').removeAttr('style');
                $j('#videoplay .prev, #videoplay2 .prev').removeClass('prev_s');
                $j('#videoplay .next, #videoplay2 .next').removeClass('next_s');
            }

        });
    </script>

    <!-- 头部菜单 -->
    <div id="header" class="clearfix">
        <div class="site_nav clearfix">
            <p class="login_info"><span><?php echo $i_langpackage->i_welcome; ?><?php echo $SYSINFO['sys_name']; ?>
                    !</span><?php if ($USER['login']) { ?><?php echo $i_langpackage->i_hi; ?>! <?php echo $USER['user_name']; ?>
                    <a href="do.php?act=logout"><?php echo $i_langpackage->i_logout; ?></a><?php } else { ?><a
                    href="login.php"><?php echo $i_langpackage->i_login; ?></a>&nbsp;|&nbsp;<a
                    href="modules.php?app=reg"><?php echo $i_langpackage->i_register_free; ?></a><?php } ?></p>

            <p class="quick_menu">
                <a href="index.php"><?php echo $i_langpackage->i_shop_index; ?></a><a
                    href="modules.php"><?php echo $i_langpackage->i_u_center; ?></a>
                <a class="shop_cart" href="modules.php?app=user_cart"><?php echo $i_langpackage->i_cart; ?></a>
                <a href="modules.php?app=user_favorite"><?php echo $i_langpackage->i_favorite; ?></a>
            </p>
        </div>
        <div class="topMain clearfix">
            <h1 id="logo">
                <?php if ($SYSINFO['sys_logo']) { ?>
                    <a href="index.php">
                        <img src="<?php echo $SYSINFO['sys_logo']; ?>" title="<?php echo $SYSINFO['sys_name']; ?>"
                             style="float:left;width:209px; height:43px;"
                             onerror="this.src='skin/default/images/nopic.gif'"/>
                    </a>
                <?php } else { ?>
                    <a href="index.php"><img src="skin/<?php echo $SYSINFO['templates']; ?>/images/logo.png" title=""
                                             alt="<?php echo $SYSINFO['sys_name']; ?>"/></a>
                <?php } ?>
            </h1>

            <form action="search.php" method="POST" id="search_form">
                <div class="search_panel">
                    <p class="search_sel" onclick="setShow('sel_content');setOnShowPara('sel_content');">
                        <?php if ($search_header_type == $i_langpackage->i_s_company) { ?>
                            <input class="sel_value" id="sel_value" value="<?php echo $i_langpackage->i_s_company; ?>"
                                   name="search_type" type="text"/>
                        <?php } else { ?>
                            <input class="sel_value" id="sel_value"
                                   value="<?php echo $i_langpackage->i_goods_search; ?>" name="search_type"
                                   type="text"/>
                        <?php } ?>
                    </p>
                    <?php if (!$ksearch) { ?>
                        <p class="search_txt"><input name="k" type="text" onblur="inputTxt(this,'set');"
                                                     onfocus="inputTxt(this,'clean');"
                                                     value="<?php echo $i_langpackage->i_search_keyword; ?>"/></p>
                    <?php } else { ?>
                        <p class="search_txt"><input name="k" type="text" onblur="inputTxt(this,'set');"
                                                     onfocus="inputTxt(this,'clean');" style="color:#000000;";
                            value="<?php echo $ksearch; ?>" /></p>
                    <?php } ?>

                    <p class=""><input type="submit" value="搜索" class="search-button"/></p>

                    <p class="hot_keywords">热门关键词：
                        <?php foreach ($keyword_result as $keyword) { ?>
                            <a href="search.php?k=<?php echo $keyword['keywords']; ?>"><?php echo $keyword['keywords']; ?></a>
                        <?php } ?></p>

                    <div id="sel_content" class="sel_list" style="display:none">
                        <ul>
                            <li onclick="document.getElementById('sel_value').value = this.innerHTML"
                                onmouseover="this.className = 'li_hover'"
                                onmouseout="this.className = ''"><?php echo $i_langpackage->i_goods_search; ?></li>
                            <li onclick="document.getElementById('sel_value').value = this.innerHTML"
                                onmouseover="this.className = 'li_hover'"
                                onmouseout="this.className = ''"><?php echo $i_langpackage->i_s_company; ?></li>
                        </ul>
                    </div>
                </div>

            </form>
            <div class="weather_panel clearfix">
                <div class="weather_content">
          <span class="weather_icon">
            <img src=""/>
          小雨 13℃~9℃</span>

                    <p style="text-align:center;">北风小于三级</p>
                </div>
                <div class="contact_content">

                </div>

            </div>
        </div>
    </div>
<<<<<<< HEAD
</div>

<input type="text" name="sel_content_c" id="sel_content_c" size="0" onblur="javascript:timerSetHidden('sel_content',200);" style="top:-100px;position:absolute;width:1px;height:1px;border:0px;background-color:transparent;" value="1">

<div class="header-nav">
  <ul class="nav-list">
    <li><a href="index.php">首页</a></li>
    <li class="sep"></li>
    <li><a href="article_index.php">资讯全览</a>
      <div class="cui_subnav_wrap">
        <div class="cui_sub_nav"><a href="news_list.php?id=11" title="最新资讯">最新资讯</a>|<a href="brand_list.php?id=25" title="桂林景点">桂林景点</a>|<a href="news_list.php?id=13" title="桂林酒店">桂林酒店</a>|<a href="news_list.php?id=14" title="桂林线路">桂林线路</a>|<a href="news_list.php?id=16" title="桂林交通">桂林交通</a>|<a href="news_list.php?id=15" title="桂林美食">桂林美食</a>|<a href="news_list.php?id=17" title="桂林特产">桂林特产</a>|<a href="news_list.php?id=18" title="购在桂林">购在桂林</a>|<a href="news_list.php?id=19" title="夜美桂林">夜美桂林</a>|<a href="news_list.php?id=20" title="节庆活动">节庆活动</a></div>

      </div>
    </li>
    <li class="sep"></li>
    <li><a href="goods_index.php">无忧预订</a>
        <div class="cui_subnav_wrap"><div class="cui_sub_nav"><a href="category.php?id=434" title="国内酒店">景点预订</a>|<a href="ticket.php" title="海外酒店">机票预订</a>|<a href="category.php?id=433" title="惠选酒店">酒店预订</a>|<a href="category.php?id=435" title="机+酒">线路预订</a>|<a href="category.php?id=436" title="团购">商务会议</a></div>
      </div>
    </li>
    <li class="sep"></li>
    <li><a href="promote_index.php">特惠专区</a>
      <div class="cui_subnav_wrap"><div class="cui_sub_nav"><a href="category.php?id=437" title="旅游卡特惠">旅游卡特惠</a>|<a href="groupbuy.php" title="团购乐翻天">团购乐翻天</a>|<a href="promote.php" title="秒杀超值购">秒杀超值购</a>|<a href="news_list.php?id=26" title="优惠全掌握">优惠全掌握</a></div>
      </div>
    </li>
    <li class="sep"></li>
    <li><a href="share_index.php">分享乐园</a>
      <div class="cui_subnav_wrap"><div class="cui_sub_nav"><a href="news_list.php?id=21" title="攻略分享">攻略分享</a>|<a href="news_list.php?id=22" title="美图分享">美图分享</a>|<a href="news_list.php?id=23" title="微博分享">微博分享</a>|<a href="news_list.php?id=24" title="桂林大向导">桂林大向导</a>|<a href="news_list.php?id=25" title="评价汇总">评价汇总</a></div>
      </div>
    </li>
  </ul>
</div>

<script type="text/javascript" src="skin/<?php echo $SYSINFO['templates'];?>/js/common.js"></script><?php } ?>
=======

    <input type="text" name="sel_content_c" id="sel_content_c" size="0"
           onblur="javascript:timerSetHidden('sel_content',200);"
           style="top:-100px;position:absolute;width:1px;height:1px;border:0px;background-color:transparent;" value="1">

    <div class="header-nav">
        <ul class="nav-list">
            <li><a href="index.php">首页</a></li>
            <li class="sep"></li>
            <li><a href="article_index.php">资讯全览</a>

                <div class="cui_subnav_wrap">
                    <div class="cui_sub_nav"><a href="news_list.php?id=11" title="最新资讯">最新资讯</a>|<a
                            href="news_list.php?id=12" title="桂林景点">桂林景点</a>|<a href="news_list.php?id=13" title="桂林酒店">桂林酒店</a>|<a
                            href="news_list.php?id=14" title="桂林线路">桂林线路</a>|<a href="news_list.php?id=16" title="桂林交通">桂林交通</a>|<a
                            href="news_list.php?id=15" title="桂林美食">桂林美食</a>|<a href="news_list.php?id=17" title="桂林特产">桂林特产</a>|<a
                            href="news_list.php?id=18" title="购在桂林">购在桂林</a>|<a href="news_list.php?id=19" title="夜美桂林">夜美桂林</a>|<a
                            href="news_list.php?id=20" title="节庆活动">节庆活动</a></div>

                </div>
            </li>
            <li class="sep"></li>
            <li><a href="goods_index.php">无忧预订</a>

                <div class="cui_subnav_wrap">
                    <div class="cui_sub_nav"><a href="category.php?id=434" title="国内酒店">景点预订</a>|<a href="ticket.php"
                                                                                                    title="海外酒店">机票预订</a>|<a
                            href="category.php?id=433" title="惠选酒店">酒店预订</a>|<a href="category.php?id=435" title="机+酒">线路预订</a>|<a
                            href="category.php?id=436" title="团购">商务会议</a></div>
                </div>
            </li>
            <li class="sep"></li>
            <li><a href="promote_index.php">特惠专区</a>

                <div class="cui_subnav_wrap">
                    <div class="cui_sub_nav"><a href="category.php?id=437" title="旅游卡特惠">旅游卡特惠</a>|<a
                            href="groupbuy.php" title="团购乐翻天">团购乐翻天</a>|<a href="category.php?id=438" title="秒杀超值购">秒杀超值购</a>|<a
                            href="news_list.php?id=26" title="优惠全掌握">优惠全掌握</a></div>
                </div>
            </li>
            <li class="sep"></li>
            <li><a href="share_index.php">分享乐园</a>

                <div class="cui_subnav_wrap">
                    <div class="cui_sub_nav"><a href="news_list.php?id=21" title="攻略分享">攻略分享</a>|<a
                            href="news_list.php?id=22" title="美图分享">美图分享</a>|<a href="news_list.php?id=23" title="微博分享">微博分享</a>|<a
                            href="news_list.php?id=24" title="桂林大向导">桂林大向导</a>|<a href="news_list.php?id=25"
                                                                                  title="评价汇总">评价汇总</a></div>
                </div>
            </li>
        </ul>
    </div>

    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/common.js"></script><?php } ?>
>>>>>>> remotes/origin/master
