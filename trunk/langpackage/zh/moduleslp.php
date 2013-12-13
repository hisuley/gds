<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

class moduleslp{
	/* error message */
	var $m_error_message1 = "您现在是{name}, 只能上传{num}个商品！";
	var $m_error_createshop = "只有申请并通过审核可以创建店铺！";

	var $m_error_messageshow = "错误信息提示";
	var $m_messageshow = "信息提示";
	var $m_error_login = "您还没有登录!";
	/* menu */
	var $m_u_center = "个人中心";
	var $m_u_first = "第一步";
	var $m_u_secound = "第二步";
	var $m_u_third = "第三步";
	var $m_u_fore = "第四步";
	var $m_a_info = "填写店主信息";
	var $m_a_shop_info = "填写店铺信息";
	var $m_a_manager_info = "管理员审核";
	var $m_a_no_request = "权限不足,你现在不能申请商铺!";
	var $m_a_commit_auccess = "已提交成功，请等待审核";
	var $m_a_past_auccess = "你已通过审核，如果菜单没有展开，点击";
	var $m_a_past_fail = "你的店铺未通过审核";
	var $m_a_this = "这里";
	var $m_buyer = "我是买家";
	var $m_buyer_yes = "买家";
	var $m_seller = "我是卖家";
	var $m_my_cart = "我的购物车";
	var $m_my_order = "我的订单";
	var $m_my_favorite = "我的收藏";
	var $m_my_guestbook = "我的留言";
	var $m_shop_category = "店铺商品分类";
	var $m_shop_category_add = "添加商品分类";
	var $m_cart = "购物车";
	var $m_sell = "我要卖";
	var $m_buy = "我要买";
	var $m_logout = "安全退出";
	var $m_add_newgoods = "添加新商品";
	var $m_rc_order = "收到的订单";
	var $m_rc_guestbook = "收到的留言";
	var $m_rc_askprice = "收到的询价";
	var $m_base_setting = "个人设置";
	var $m_profile = "个人信息";
	var $m_save_succes = "保存成功";
	var $m_web_navigation = "网站导航";
	var $m_goods_search ="搜商品";
	var $m_s_company = "搜商家";
	var $m_personal_home ="个人中心首页";
	var $m_current_position ="您当前的位置是：";
	var $m_order_inquiry ="订单查询";

	var $m_createshop_vip = "企业会员才可";
	var $m_shop_view = "店铺预览";
	var $m_payment_setting = "支付方式设置";
	var $m_shoprate_manage = "评价管理";
	var $m_shoprate_frombuyer = "来自买家的评价";
	var $m_shoprate_fromseller = "来自卖家的评价";
	var $m_shoprate_topep = "给他人的评价";
	var $m_remind_setting = "提醒设置";
	var $m_my_remind = "站内消息";
	var $m_userico_setting = "头像设置";
	var $m_open = "开启";
	var $m_open_message = "您确定要关闭商铺吗？关闭商铺的时商铺下的商品同时下架！";
	var $m_lock = "锁定";
	var $m_other_shop_lock = "此商铺已经被锁定";
	var $m_other_shop_close = "此商铺已经被关闭";
	var $m_shop_lock = "您的商铺已经被锁定";
	var $m_goods_shop_locked="此商品的网店已被锁定";
	var $m_email_ver = "邮箱验证";
	var $m_my_groupbuy ="我的团购";
	var $m_groupbuy_list ="团购管理";
	var $m_add_groupbuy ="添加新团购";
	var $m_shop_intro_no_back = "添加成功";
	//user
	var $m_collect_num= "收藏人气";
	var $m_ico_set = "头像设置";
	var $m_user_ico = "用户头像";
	var $m_img_limit = "图片应小于1M，jpg、png或gif格式。建议为100x100像素";
	var $m_youbelocked = "您已被管理员锁定，您将不能登陆，请联系管理员！";
	var $m_payment_cho = "选择支付方式";
	var $m_rem_con= "提醒内容";
	var $m_time_send= "发出时间";
	var $m_rem_fettle= "提醒状态";
	var $m_mark_read= "标为已读";
	var $m_mark_unread ="标为未读";
	var $m_read ="已读";
	var $m_unread ="未读";
	var $m_admin_unread ="管理员";
	var $m_unread_no ="未读留言";
	var $m_unread_kan ="中查看";
	var $m_confirm= "确定要执行此操作吗？";
	var $m_confirm_no= "订购数量小于成团数量，确定要执行此操作吗？";
	var $m_choice= "至少要选择一项！";
	var $m_rem_type= "提醒类型";
	var $m_rem_name= "提醒名称";
	var $m_site_rem= "未读站内消息";
	var $m_inputtrue_username = "请输入正确的用户名";
	var $m_email_reminder ="邮件提醒";
	var $m_complaints ="投诉";
	var $m_refund ="退款";
	var $m_by_complainant ="被投诉人";
	var $m_related_products ="相关商品";
	var $m_of_complaint ="投诉原因";
	var $m_select_complaints_reason ="请选择投诉原因";
	var $m_choose_trade_complaints ="请选择正确的投诉原因，否则您将失去本交易投诉的机会。";
	var $m_complaints_content ="投诉内容";
	var $m_please_enter_complaints ="请输入投诉内容";
	var $m_current ="当前";
	var $m_upto_bytes ="字节,最多500字节";
	var $m_real_evidence_dispute ="请您尽可能提供真实且详细的纠纷描述及证据（包括聊天记录、商品图片及相关链接），这样我们才能在最快的时间里更正确地给您处理投诉。";

	var $m_go_buy="继续购物";
	var $m_check_out="现在结账";
	/* goods */
	var $m_add_goods = "添加商品";
	var $m_goods_list = "商品管理";
	var $m_edit_goods = "修改商品";
	var $m_goods_name = "商品名称";
	var $m_goods_category = "商品分类";
	var $m_select_cateogry = "选择分类";
	var $m_goods_price = "商品价格";
	var $m_goods_pricezero = "商品价格等于0时即为面议";
	var $m_transport_price = "运费";
	var $m_goods_intro = "商品介绍";
    var $m_apply_refund="申请退款";
    var $m_already_valuation="已评价";
    var $m_already_complain="已投诉";

    var $m_wholesale_price = "批发价格";
	var $m_wholesale = "批发说明";
	var $m_goods_number = "库存量";
	var $m_keyword = "关键字";
	var $m_on_sale = "上架";
	var $m_view_status = "打勾表示允许查看，否则不允许查看。";
	var $m_add_recommend = "加入推荐";
	var $m_goodsname_notnone = "商品名称不能为空！";
	var $m_select_categorypl = "请选择分类！";
	var $m_goods_keyword = "商品名称关键字";
	var $m_search_goods = "搜索商品";

	var $m_image_upload = "图片上传";
	var $m_upload_tolimit = "大小限制为1M,建议像素小于600*400";
	var $m_sure_delgoods = "确定要删除这商品吗？";
	var $m_nogoods_list = "没有产品列表！";
	var $m_nogoods = "没有商品！";
	var $m_input_numpl = "请输入数字";
	var $m_back_goodslist = "返回商品列表";
	var $m_goods_image = "商品图片";
	var $m_sure_delimg = "您确实要删除该图片吗？";
	var $m_not_uploadimg = "您还没有上传图片！";
	var $m_set_img = "设为首图";
	var $m_is_img = "已是首图";
	var $m_img_desc = "图片描述";
	var $m_upload_file = "上传文件";
	var $m_update_goodsimg = "更新商品图片";
	var $m_goods_attr = "商品属性";
	var $m_goods_type = "商品类型";
	var $m_goodsimg_updatesuccess = "商品图片更新成功！";
	var $m_addgoods_success = "添加新商品成功！";
	var $m_goodsupdate_success = "商品属性更新成功！";
	var $m_addgoods_fail = "添加新商品失败";
	var $m_delgoods_success = "删除商品成功！";
	var $m_delgoods_fail = "删除商品失败";
	var $m_editgoods_success = "修改商品成功！";
	var $m_editgoods_fail = "修改商品失败";
	var $m_fgoodsimg_setsuccess = "首图设置成功！";
	var $m_fgoodsimg_setfail = "首图设置失败，请重试！";
	var $m_dontbuy_youself = "不能购买自己的商品！";
	var $m_custom_categories = "自定义分类";
	var $m_undefinition = "未定义";
	var $m_goods_photo = "相册";
	var $m_goods_ushelves = "批量下架";
	var $m_goods_dshelves = "批量上架";
	var $m_over_setnum = "已超出您可以设置的数量限制！";
	var $m_showgoods_photo = "商品图片";
	var $m_categoryname_notnone = "分类名称不能为空！";
	var $m_set_num = "您最多可以设置";
	var $m_num_much = "过多设置无效";
	var $m_add_cat = "添加自定义分类";
	var $m_add = "增加";
	var $m_csv_export = "CSV导出";
	var $m_csv_import = "CSV导入";
	var $m_not_csv ="只能选择CSV文件";
	var $m_no_chose_goods="请选择要导出的商品";
	var $m_no_csv_name="请输入要导出的文件名";
	var $m_no_csv_import="请选择要导入的文件";
	var $m_csv_name = "导出的文件名";
	var $m_all_goods ="全部商品";
	var $m_export_code ="导出编码";
	var $m_file_encoding ="文件的编码";
    var $m_csv_prompt ="目前仅支持本站导出的csv文件";
//	var $m_goods_photo = "相册";	/* favorite */
	var $m_favorite = "收藏夹";
	var $m_suredel_favorite = "确定要删除这条收藏吗？";
	var $m_is_transport_template="选择运费模板";
	var $m_add_transport_template="新增运费模板";
	var $m_edit_transport_template="修改运费模板";
	var $m_list_transport_template="运费模板列表";
	var $m_transport_name="模板名称";
	var $m_transport_name_message="请输入运费模板的名称";
	var $m_transport_description="模板描述";
	var $m_transport_description_message="请输入模板的描述";
	var $m_transport_cont="配置运费地区";
	var $m_choose_transport_type="请选择运送方式";
	var $m_choose_transport_type_message="(提示：除指定地区外，其余地区的运费采用“默认运费”)";
	var $m_transport_template_frist="默认运费：";
	var $m_transport_template_second="每超过一件需要增加运费：";
	var $m_shure="确定";
	var $m_eidt_transport_template="修改运费模板";
	var $m_goods_brand="商品品牌";

	/* password */
	var $m_find_password = "找回密码";
	var $m_edit_password = "修改密码";
	var $m_new_password = "新　密码";
	var $m_re_password = "确认密码";
	var $m_password_notnone = "新密码不能为空！";
	var $m_ppassword_notnone = "密码不能为空";
	var $m_oldpassword_notnone = "原始密码不能为空！";
	var $m_password_notsame = "新密码与确认密码不一致！";
	var $m_password_same = "原始密码和新密码一样，请重设新密码！";
	var $m_old_password = "原始密码";
	var $m_editpassword_success = "密码修改成功";
	var $m_editpassword_fail = "密码修改失败";
	var $m_oprate_fail = "操作失败，请重新修改";
	var $m_oldpassword_notture = "原始密码不正确";
	var $m_change_mail = "更换邮箱";

	/* profile */
	var $m_edit_profile = "修改个人信息";
	var $m_truename = "真实姓名";
	var $m_birthday = "出生日期";
	var $m_gender = "性别";
	var $m_marry = "婚烟";
	var $m_mobile = "手机";
	var $m_telphone = "电话";
	var $m_stayarea = "所在地区";
	var $m_select_categories = "选择分类";
	var $m_select_country = "选择国家";
	var $m_select_province = "选择省份";
	var $m_select_city = "选择城市";
	var $m_select_district = "选择地区";
	var $m_address = "详细地址";
	var $m_zipcode = "邮政编码";
	var $m_useremail_notnonoe = "用户Email帐户不能为空！";
	var $m_inputtrue_useremail = "请输入合法的用户Email帐户！";
	var $m_verifycode_error = "验证码错误!";
	var $m_usernot_exi = "用户不存在!请确认您输入的是Email帐户!";
	var $m_inputerror_emailpassword = "您输入的Email帐户或密码错误!";
	var $m_username_notnone = "用户名不能为空!";
	var $m_usernameoremail_exied = "您的用户名或邮箱已存在!";
	var $m_truename_nonone = "真实姓名不能为空!";
	var $m_register_fail = "注册失败请重试!";
	var $m_sendagain_viewyoumail = "已重新发送，请查看您注册时的邮箱！";
	var $m_username_isexied = "用户名已存在！";	/* guestbook */
	var $m_guestbook_list = "留言信息列表";
	var $m_company_name = "公司名称";
	var $m_guestbook_content = "留言内容";
	var $m_suredel_guestbook = "确定要删除这条留言吗？";
	var $m_other_contact = "其它联系";

	/* askprice */
	var $m_askprice_list = "询价信息列表";
	var $m_name = "姓名";
	var $m_email = "邮箱";
	var $m_askprice_content = "询价内容";
	var $m_suredel_askprice = "确定要删除这条询价信息吗？";

	/* ucategory */
	var $m_add_ucategory = "添加商铺分类";
	var $m_edit_ucategory = "修改商铺分类";
	var $m_ucategory = "商铺自定义分类";
	var $m_category_name = "分类名称";
	var $m_parent_cat = "上级分类";
	var $m_top_cat = "顶级分类";
	var $m_number_unit = "数量单位";
	var $m_nocat_addnow = "您还没有添加分类，现在要添加吗？";
	var $m_add_subcategory = "添加子分类";
	var $m_remark_edit = "注：带灰色背景的可直接点击修改;";
	var $m_input_num= "请输入数字！";
	var $m_sure_delcat= "您确定要删除此分类及其下头的所有子分类吗？";
	var $m_ucategory_notnone = "店铺分类名称不能为空！";

	/* shop */
	var $m_create_shop = "创建店铺";
	var $m_create_request = "申请开店";
	var $m_edit_shop = "修改店铺";
	var $m_shop_name = "店铺名称";
	var $m_shop_categories = "店铺分类";
	var $m_shop_info = "店铺设置";
	var $m_shop_management = "经营范围";
	var $m_select_template = "选择模板";
	var $m_shop_intro = "店铺简介";
	var $m_shop_introimg = "店铺简介图片";
	var $m_shop_introimg_msg = "建议大小:200X200,不修改请留空！";
	var $m_shop_logoimg = "店铺LOGO图片";
	var $m_shop_logoimg_msg = "建议大小:200X100,不修改请留空！";
	var $m_shop_bannerimg = "店铺头上大图片";
	var $m_shop_bannerimg_msg = "建议大小:960X150,不修改请留空！";
	var $m_shopname_notnone = "店铺名称不能为空！";
	var $m_shopname_overflow = "店铺名称不能超过50字符！";
	var $m_select_categoriespl = "请选择分类！";
	var $m_select_countrypl = "请选择国家！";
	var $m_select_provincepl = "请选择省份！";
	var $m_select_citypl = "请选择城市！";
	var $m_select_districtpl = "请选择地区！";
	var $m_address_notnone = "详细地址不能为空！";
	var $m_shopmanagement_notnone = "主要经营范围不能为空！";
	var $m_createshop_now = "您还没有申请开店，现在要<a href='modules.php?app=shop_request' style='color:#1E88C0'>申请</a>吗？";
	var $m_shopcatname_notnone = "店铺分类名称不能为空";
	var $m_shopcreate_success = "店铺创建成功！";
	var $m_shopcreate_fail = "店铺创建失败！";
	var $m_post_app = "提交申请";
	var $m_comment = "评论";
	var $m_commentators = "评论人";
	var $m_commentate = "解释";
	var $m_evaluate_con = "评价内容";
	var $m_evaluate_time = "评价时间";
	var $m_my_commentate = "我要解释";
	var $m_commentate_con = "解释内容";
	var $m_send = "提交";
	var $m_commentate_null = "解释内容不能为空！";
	var $m_my_appraise = "我要评价";
	var $m_appraise_grade = "评价等级";
	var $m_appraise_grade_sell = "请选择评价等级";
	var $m_appraiser = "被评价人";
	var $m_surface ="平邮";
	var $m_express_delivery ="快递";
	var $m_in_template_name ="请填写模板名称";
	var $m_in_template_description ="请填写模板描述";
	var $m_choose_shipping_method ="至少选择一种运送方式";
	var $m_set_shipping_cost ="设置默认配送费用";
	var $m_open_map ="点击打开地图，设置我的位置";
	var $m_domain ="二级域名";

	/* honor */
	var $m_shop_honor = "店铺资质荣誉";
	var $m_suredel_honor = "您确实要删除该资质荣誉吗？";
	var $m_update_image = "更新图片";
	var $m_honor_updatesuccess = "资质荣誉更新成功！";

	/* news */	var $m_shopnews_manage = "店铺资讯管理";
	var $m_add_shopnews = "添加店铺资讯";

	/* notice */
	var $m_shop_notice = "店铺公告";
	var $m_edit_shopnotice = "修改店铺公告";

	/*团购*/
	var $m_group_list = "团购列表";
	var $m_group_name = "团购名称";
	var $m_group_status = "活动状态";
	var $m_start_time = "起止时间";
	var $m_order_num = "订购数/成团数";
	var $m_order = "下订单";
	var $m_ing = "进行中";
	var $m_no_published = "未发布";
	var $m_published = "发布";
	var $m_end = "已完成";
	var $m_sta_time = "开始时间";
	var $m_end_time = "结束时间";
	var $m_group_shows ="团购说明";
	var $m_select_products ="选择商品";
	var $m_products_name ="产品名称";
	var $m_products_sort ="产品分类";
	var $m_select ="搜索";
	var $m_search_above ="请先从上面搜索";
	var $m_group_number ="成团件数";
	var $m_group_price ="团购价格";
	var $m_group_submit ="提交";
	var $m_group_no_name ="团购名称不能为空！";
	var $m_sta_no_time ="开始时间不能为空！";
	var $m_end_no_time ="结束时间不能为空！";
	var $m_products_no_name ="商品名称不能为空！";
	var $m_group_no_number ="成团件数不能为空！";
	var $m_group_no_price ="团购价格不能为空！";
	var $m_group_no_one_num ="单人限购数量不能为空！";
	var $m_group_no_all_num ="团购总限购数量不能为空！";
	var $m_group_one_num = "单人限购数量";
	var $m_group_all_num = "团购总限购数量";
	var $m_group_no_purchase = "为零表示不限购";
	var $m_group_purchase = "为零表示团购总数量为库存上限";
	var $m_group_add ="添加团购";
	var $m_from ="从";
	var $m_to ="至";
	var $m_de ="的";
	var $m_order_group ="订单";
	var $m_order_status ="订购情况";
	var $m_event_title="活动名称";
	var $m_group_user_name ="用户名";
	var $m_group_contact ="联系人";
	var $m_group_tel ="联系电话";
	var $m_group_quantity ="订购数量";
	var $m_group_buy = "团购";
	var $m_group_refund ="要求退款";
	var $m_payment_message ="支付留言";
	var $m_my_group_buy_orders ="我的团购订单";
	var $m_shop_close = "商铺已关闭，无法上架";
	var $m_shop_pass = "商铺正在审核中";

	/* order */
	var $m_buy_num = "购买数量";
	var $m_ccbuy = "购买";
	var $m_sure_delcartgoods = "确定要删除这商品在购物车吗？";
	var $m_order_nomoregoods = "库存中已没有这么多商品，前重新购买！";
	var $m_goods_info = "商品信息";
	var $m_order_getsting = "收货信息";
	var $m_order_thisbuyprice = "这次购物需要支付的总价";
	var $m_contact = "联系人";
	var $m_sureaddress_rcgoods = "请确认以上的收货信息，以确保能够收到商品！";
	var $m_sure_postorder = "确认提交订单";
	var $m_order_message = "订单附言";
	var $m_post_order = "提交订单";
	var $m_order_success = "订单成功";
	var $m_postsuccess_rempayid = "您的订单已提交成功，请记住您的订单号";
	var $m_back_myorder = "返回我的订单";
	var $m_recver_order = "收到的订单";
	var $m_order_info = "订单详情";
	var $m_order_editprice = "修改价格";
	var $m_order_time = "下订单时间";
	var $m_pay_time = "支付时间";
	var $m_shipping_time = "发货时间";
	var $m_receive_time = "收货时间";
	var $m_sure_thisorder = "要确认该订单吗？";
	var $m_sure_cancelthisorder = "确定要取消该订单吗？";
	var $m_cancelorder = "取消订单";
	var $m_sure_ordernow = "确认订单";
	var $m_ordernow_add = "设置收货人地址";
	var $m_add_list= "存储到收货地址列表";
	var $m_order_not_end=" 已下订单或团购没有结束";
	var $m_sure_shippingnow = "确认发货";
	var $m_iwant_pay = "我要支付";
	var $m_order_consignee="收货人";
	var $m_your_payid = "您的订单号";
	var $m_order_amount = "总价格";
	var $m_transport_info="物流信息";
	var $m_addres_info ="收货信息";
	var $m_view_orderinfo = "查看订单详情";
	//var $m_order_cancel = "订单状态异常";
	var $m_order_dell = "该订单已删除";
	var $m_order_combuy = "已完成购买";
	var $m_order_cancel = "已取消";
	var $m_order_nosure = "未确认";
	var $m_order_sure = "已确认";
	var $m_order_payed = "已支付";
	var $m_order_nopayed = "待付款";
	var $m_order_transported = "已发货";
	var $m_order_pay_info ="支付信息";
	var $m_order_notransported = "待发货";
	var $m_order_notransported_to = "未发货订单";
	var $m_order_notransported_no = "订单已收款但未发货";
	var $m_pay = "付款";
	var $m_sure_thisgoodsreceive = "您购买的商品确认已收到？";
	var $m_sure_receive = "确认收货";
	var $m_noex_thisorder = "不存在此订单！";
	var $m_order_becheck = "您已确认该订单！";
	var $m_order_becheckfail = "该订单确认失败";
	var $m_sure_shippingnowfail = "确认发货失败";
	var $m_price_editfail = "价格修改失败";
	var $m_order_notcancel = "此订单已完成不能取消";
	var $m_order_becanceled = "此订单已成功取消";
	var $m_order_becanceledfail = "此订单取消失败";
	var $m_sureyou_receive = "您已确认收货！";
	var $m_sureyou_receivefail = "确认收货失败";
	var $m_cartnotthis_goods = "购物车里不存在此商品！";
	var $m_cartgoods_delsuceess = "购物车商品删除成功";
	var $m_cartgoods_delfail = "购物车商品删除失败";
	var $m_order_fail = "订单失败";
	var $m_view_orderinfo2 = "查看详情";
	var $m_order_poststing = "发货信息";
	var $m_shipping_name = "物流公司名称";
	var $m_shipping_name_no = "请输入物流公司名称";
	var $m_shipping_no = "物流发货单号";
	var $m_shipping_no_no = "请输入物流发货单号";
	var $m_shipping_type = "发货运输类型";
	var $m_shipping_type_no = "请输入发货运输类型";
	var $m_alipay_tradeno = "支付订单号";
	var $m_ask_service = "申请客服介入";

	var $m_welcome_ucenter = "欢迎您来到<span class=\"highlight\">IwebMall</span>用户管理中心！";
	var $m_bubuser_info = "买家信息";
	var $m_babuser_info = "卖家信息";
	var $m_deal_order = "成交的订单";
	var $m_allgoods_num = "商品总数";
	var $m_anum_goods = "个商品";
	var $m_index_myfav = "我的收藏夹";
	var $m_goodskc_w_num = "库存警告商品数(少于5个)";
	var $m_newgoods_re_num = "新品推荐数";
	var $m_bestgoods_re_num = "精品推荐数";
	var $m_hotgoods_re_num = "热销商品数";
	var $m_promotegoods_re_num = "特价商品数";
	var $m_getgoods_address = "收货地址";

	var $m_last_login = "您的上一次登录时间";
	var $m_last_ip = "上次登录 IP";

	var $m_reg_com_user = "申请开店";
	var $m_i_mk_store = "我要开店";
	var $m_shop_help = "商城帮助";

	var $m_view_card = "查看购物车";
	var $m_check_order_info = "确认订单信息";
	var $m_pay_to_alipay = "付款到支付宝";
	var $m_check_get_goods = "确认收货";
	var $m_com_deal = "完成交易";
	var $m_thisorder_cancel = "订单已取消";
	var $m_order_get_back="正在退款";

	var $m_getpackage_address = "收件人地址";
	var $m_getpackage_pop = "收件人";
	var $m_getpackage_area = "所在地";

	var $m_safe_setting = "安全设置";
	var $m_buy_mk_order = "买家下订单";
	var $m_buyer_pay = "买家付款";
	var $m_check_put_goods = "确认发货";
	var $m_buyer_checkget_goods = "买家确认收货";
	var $m_pls_select_cateogry = "未选择分类";
	var $m_plss_select_cateogry = "请选择分类";
	var $m_edit_cateogry = "编辑分类";
	var $m_goods_new = "全新";
	var $m_goods_notnew = "二手";
	var $m_goods_isnull = "闲置";
	var $m_post = "提 交";
	var $m_more_keyword_exp = "多个关键字，请以空格或逗号进行分割";
	var $m_getgoods_addresslist = "收件人地址列表";
	var $m_dontsave_getgoods_addresslist = "没有保存的收货地址";
	var $m_userother_address = "使用其它收货地址";
	var $m_pl_getgoods_name = "请填写收件人姓名";
	var $m_pl_getgoods_province = "请选择收件人省份";
	var $m_pl_getgoods_city = "请选择收件人城市";
	var $m_pl_getgoods_district = "请选择收件人地区";
	var $m_pl_getgoods_address = "请填写收件人详细地址";
	var $m_pl_getgoods_zipcode = "邮政编码格式不正确";
	var $m_email_type_notine = "您填写的邮箱格式不正确";
	var $m_sorry_p_mselectone = "对不起，电话和手机至少填写一项。";
	var $m_sorry_mobiletype = "对不起，您输入的手机号码错误。";
	var $m_sorry_phonetype = "对不起，您输入的电话号码错误。";
	var $m_addnew_getpackage_address = "新增收货地址";
	var $m_getpackage_name = "收件人姓名";
	var $m_selceted_one = "致少要选择一项，才能进行操作！";
	var $m_manage_sure_del = "本操作不可恢复，确认删除？";
	var $m_pl_del = "批量删除";
	var $m_payment_name = "支付名称";
	var $m_payment_desc = "简介";
	var $m_payment_enable = "启用";
	var $m_payment_config = "配置";
	var $m_payment_delete = "卸载";
	var $m_payment_install = "安 装";
	var $m_payment_suredel = "确认要卸载此支付方式吗？";
	var $m_payment_showuser_pay = "该信息会在用户付款时看到。";
	var $m_hiserver_member = "申请成为企业会员";
	var $m_hiserver_member_suc = "已通过审核，您现在已是企业会员，请重新登陆会员后台！";
	var $m_hiserver_member_wait = "您的企业信息已提交，管理员正在审核中，请等待！";
	var $m_hiserver_member_fail = "审核失败，请详细正确填写以下选项。";
	var $m_request_compayname = "企业名称或个人姓名";
	var $m_request_personname = "法人代表姓名";
	var $m_request_criedtype = "证件类型";
	var $m_request_sfz = "身份证";
	var $m_request_jgz = "军官证";
	var $m_request_criednum = "证件号码";
	var $m_request_operatenum = "营业执照";
	var $m_request_supporttype = "支持的文件格式";
	var $m_request_comaddress = "公司所在地";
	var $m_request_moraddress = "详细通讯地址";
	var $m_request_zip = "邮编";
	var $m_request_mobile = "手机号码";
	var $m_no_write ="未填写";
	var $m_request_phone = "联系电话";
	var $m_request_suc_correctnum = "请详细正确的填写信息，如有错误不能通过审核！";
	var $m_order_goods_info = "商品信息";
	var $m_order_orderinfo = "订单信息";
	var $m_order_shops = "商家";
	var $m_order_payids = "订单号";
	var $m_order_ordertime = "下单时间";
	var $m_order_paytype = "支付方式";
	var $m_evaluate = "评价";
	var $m_clicksure_s = "点击确认发货时，请您也要前往您收款所设的支付中介网站进行确认！";
	var $m_my_write_back = "我的回复";
	var $m_write_back = "回复";
	var $m_look_back = "查看回复";
	var $m_addseller_write_back = "添加卖家回复";
	var $m_iwantto_write_back = "我要回复";
	var $m_write_back_content = "回复内容";
	var $m_post_notnull = "回复内容不能为空！";	//forgot
	var $m_getback_pw = "找回密码";
	var $m_mail_register = "请输入您注册时的邮箱帐号";
	var $m_name_register = "请输入您注册时的用户名";
	var $m_caution_register = "找回密码注意事项：<br />
		1. 找回密码时请正确填写您的邮箱帐号 <br />
		2. 如果您的邮箱填写不正确网站不会给您发送找回密码邮件 <br />
		3. 当您收到找回密码邮件时，按提示操作，便可以对您的帐号进行密码重设";
	var $m_mail_null = "邮件名称不能为空！";
	var $m_name_null = "会员名称不能为空！";
	var $m_caution_app = "<div>您的申请已经成功提交，如果您的资料正确，我们会给您的邮箱发出通知信！</div>
	<div style='font-weight: normal'>请您登录该邮箱，并按信中提示完成找回密码的操作。</div>
	<div style='font-weight: normal'>注意: 如果您连续多次申请找回密码，请以最新收到的通知信为准！</div>";
	var $m_accomplish = "完成";
	var $m_category_exits = "该分类名已经存在!";
	var $m_no_order = "订单不存在!";

	//action
	var $m_upd_suc = "更新成功！";
	var $m_upd_lose = "更新失败！";
	var $m_ico_set_lose = "头像设置失败";
	var $m_put_suc = "提交成功！";
	var $m_put_lose = "提交失败！";
	var $m_adm_suc = "执行成功！";
	var $m_adm_lose = "执行失败！";
	var $m_handle_err = "非法操作！";
	var $m_plug_unin_suc = "支付插件已卸载！";
	var $m_plug_unin_lose = "支付插件卸载失败！";
	var $m_oneself_shop = "不能给自己店铺留言！";
	var $m_mess_suc = "留言成功！";
	var $m_mess_lose = "留言失败！";
	var $m_shopname_null = "店铺分类名称不能为空";
	var $m_upl_lose = "上传失败";
	var $m_not_sure_receiv = "该订单还未确定收货!";
	var $m_ask_protect_suc = "申请维权成功！";
	var $m_ask_protect_fail = "申请维权失败！";
	var $m_not_ask_protect = "没申请维权！";
	var $m_protect_close = "维权已经结束！";
	var $m_protect_suc = "结束维权成功！";
	var $m_protect_fail = "结束维权失败！";
	
	var $m_no_payment = "您还没付款，不能退款！";
	var $m_asked_back_money = "已经申请退款，请稍等！";
	var $m_shop_back_money = "商家已经退款！";
	var $m_no_sure_back_money = "商家还未确认退款！";
	var $m_back_money_suc = "已经退款成功！";
	var $m_back_money_fail = "已经退款失败！";
	var $m_ask_back_money_suc = "申请退款成功！";
	var $m_ask_back_money_fail = "申请退款失败！";

	/* page */
	var $m_page_num = "共{num}条记录";
	var $m_page_first = "首页";
	var $m_page_pre = "上一页";
	var $m_page_next = "下一页";
	var $m_page_last = "尾页";
	var $m_page_now = "当前第{num}页";
	var $m_page_count = "共{num}页";

	/* public */
	var $m_sort = "排序";
	var $m_close = "关闭";
	var $m_manage = "操作";
	var $m_edit = "修改";
	var $m_del = "删除";

	var $m_count = "总计";
	var $m_status = "状态";

	var $m_back_index = "返回首页";
	var $m_back_list = "返回列表";
	var $m_click_editcontent = "点击修改内容";
	var $m_delfail_tryagain = "删除失败，请重试！";
	var $m_select_pl = "请选择";
	var $m_nolist_record = "没有列表信息！";
	var $m_select_again = "请重新选择!";
	var $m_add_time = "添加日期";
	var $m_hi = "您好！";

	var $m_edit_success = "修改成功";
	var $m_edit_fail = "修改失败";
	var $m_del_success = "删除成功";
	var $m_del_fail = "删除失败";
	var $m_add_success = "添加成功";
	var $m_add_fail = "添加失败";

	var $m_best = "精品";
	var $m_promote = "特价";
	var $m_new = "新品";
	var $m_hot = "热销";

	var $m_yuan = "元";
	var $m_jian = "件";	var $m_price = "价格";
	var $m_year = "年";
	var $m_month = "月";
	var $m_day = "日";
	var $m_secret = "保密";
	var $m_man = "男";
	var $m_woman = "女";
	var $m_unmarried = "未婚";
	var $m_married = "已婚";
	var $m_tiao = "条";
	var $m_yes = "是";
	var $m_no = "否";
	var $m_more ="更多";
	var $m_free_shop ="免费开店";
	var $m_you_have ="您有";
	var $m_short_message ="条短消息";
	var $m_click_view ="点击查看";
	var $m_view ="查看";
	var $m_order_remind ="订单提醒";
	var $m_groupbuy_remind ="团购提醒";
	var $m_pending_payment_order ="待付款的订单，请尽快到";
	var $m_payment_orders_be ="待付款订单";
	var $m_payment_no="未确定的订单";
	var $m_payment_no_to="，请尽快到";
	var $m_in_payment ="中付款";
	var $m_seller_shipped_orders ="订单卖家已发货，等待您的确认，请尽快到";
	var $m_shipped_orders ="已发货订单";
	var $m_order_not_evaluated ="订单还没有评价，请尽快到";
	var $m_completed_orders ="已完成订单";
	var $m_confirmed ="中确认";
	var $m_groupbuy_attended_activities ="个参加的团购活动已完成，请尽快到";
	var $m_purchased ="中购买";
	var $m_group_buy_completed ="已完成的团购";
	var $m_frequently_asked_questions ="常见问题";
	var $m_secure_transaction ="安全交易";
	var $m_purchase_process ="购买流程";
	var $m_how_to_pay ="如何付款";
	var $m_contact_us ="联系我们";
	var $m_cooperation_proposal ="合作提案";
	var $m_site_map ="网站地图";

	var $m_copyright = "版权所有 © 2013 桂林旅游局，并保留所有权利。";
	var $m_isset_payment = "您还没有设置支付方式!";


    var $m_start_time_error="开始时间不能大于结束时间";
    var $m_startend_time_error="开始时间或结束时间不能小于当前时间";
    var $m_start_end_time_error="开始时间和结束时间不能是同一天";
    var $m_timeformat_error="请输入正确的时间格式 如：1999-01-01";
    var $m_goods_store="商品收藏";
    var $m_shop_store="店铺收藏";
    var $m_shop_logo="店铺logo";
    var $m_shop_infomation="店铺信息";
    var $m_forgot_info="此链接已失效";
    var $m_all_select="全选";
    var $m_reverse="反选";
    var $m_change_address="更换地址";
    var $m_confirm_get_address="确认收货地址";
    var $m_confirm_address_error="不能添加新地址，请您去收货地址进行操作！";
    var $m_buy_prompt="买家提醒";
    var $m_sell_prompt="卖家提醒";
    var $m_buy_pingjia="买家评价";
    var $m_yes_no="待确认";
    var $m_yes_pingjia="待评价";
    //goods
    var $m_goods_price_error="商品价格格式不正确";
    var $m_transport_error="运费格式不正确";
    var $m_store_form_error="库存格式不正确";
    var $m_stort_type="运费方式";
    var $m_postage_template="邮费模板费用";
    var $m_stort_expense="运费费用";
    var $m_px="像素";
    var $m_goods_picinfo="图片应小于1M，jpg、png或gif格式。建议为";
    var $m_other_brand="其它品牌";
    var $m_user_upload_pic="使用已上传图片";
    var $m_mygoods_error="自己的商品不能放入购物车";
    var $m_store_mygoods_error="自己的商品不能收藏";

    var $m_page_request_error="页面请求已失效";
    var $m_goods_pk="商品对比";
    var $m_all_category="全部分类";
    var $m_all_remove="全部移除";
    var $m_remove="移除";
    var $m_collect="收藏";
    var $m_pic="图片";
    var $m_move_cart="放入购物车";
    var $m_expense_country="运费(至全国)";
    var $m_money_sign="￥";
    var $m_store_info="此商铺已在您的收藏夹";
    var $m_shop_error="非法操作,店铺不存在";
    var $m_shop_error_login="请您先登陆然后收藏";
    var $m_sys_error="系统错误";
    var $m_import_taobao="导入淘宝csv";
    //reg
    var $m_member_register="会员注册提示";
    var $m_think_register="感谢注册";
    var $m_we="我们向";
    var $m_send_email="发送了激活邮件。";
    var $m_confirm_prompt="请点击里面的确认链接激活账户。";
    var $m_receive_email="没有收到激活邮件？";
    var $m_register_prompt="在垃圾邮件目录里找找，或者";
    var $m_register_prompt1="重发邮件";
    var $m_register_prompt2="注册邮箱是否正确：";
    var $m_register_prompt3="换其它邮箱注册";
    var $m_forget_password="如果你忘记了登录密码";
    var $m_picchar="输入图片中的字符：";
    var $m_change_pic="换一张";
    var $m_email_form="您输入的邮箱格式不正确";
    var $m_code_error="验证码不能为空";
    //shop
    var $m_s_category="商铺分类";
    var $m_default_template="默认模板";
    var $m_green_template="绿色模板";
    var $m_blue_template="蓝色模板";
    var $m_red_template="红色模板";
    var $m_purple_template="紫色模板";
    var $m_gray_template="灰色模板";
    var $m_credit_goods="好";
    var $m_credit_middle="中";
    var $m_credit_bad="差";
    var $m_close_map="点击关闭地图，设置完毕";
    var $m_check_complay="名称不能为空！";
    var $m_check_person="法人代表姓名不能为空！";
    var $m_check_card="证件号码不能为空！";
    var $m_check_truecard="请填写真实的证件号码！";
    var $m_check_address="公司地址不能为空！";
    var $m_check_postcode="邮编不能为空！";
    var $m_check_postcodeisnum="邮编必须是数字！";
    var $m_check_mobile="手机不能为空！";
    var $m_check_mobileisnum="手机必须是数字！";
    var $m_check_phone="电话不能为空！";
    var $m_check_phoneisnum="电话必须是数字！";
	 var $m_car_sum="购物车价格总和为:";

    //modules
    var $m_change_email="更换邮箱";
    var $m_register_username="您注册的用户名";
    var $m_register_password="您注册时的密码";
    var $m_new_email="您的新邮箱";
    var $m_fill_email="请填写新邮箱";
    var $m_fill_code="请输入验证码";
    var $m_fill_right="请填写正确的邮箱格式";
    var $m_changeemail_error="已经被锁定或者已经通过邮箱验证";
    var $m_programa="收起栏目/展开栏目";
    var $m_select_goods="请选择您要购买的商品";
    var $m_select_goods_error="本商品不属于同一店铺！";

	 var $m_mima_wei="密码为6至16位！";
    var $m_user_wei="用户名为4至16位！";


    var $m_merge_order="合并所选订单";
    var $m_same_order_error="不属于同一店铺的订单不能合并";
    var $m_select_order="请选择要合并的订单";
    var $m_tow_order="至少两张订单才能合并";
    var $m_merge_prompt="合并后的订单收货信息等将以最新的订单为准，您确定要合并选择的订单吗";

    var $m_enter_info="你输入的信息有误";
    var $m_user_locked="您已经被锁定了";
    var $m_mail_use="邮箱已使用，请更换";
    var $m_mail_send_succ="发送成功";
    var $m_mail_config_error="网站暂时不提供邮件服务";
    var $m_select_user_error="查无此人";
    var $m_search_type="至少选择一种配送方式";
    var $m_img_prompt="您已经上传超过";
    var $m_img_prompt2="M的图片，请清理后继续上传";
    var $m_mail_format="请填写正确的邮箱地址";
    var $m_succ_prompt="发送成功，请进行邮箱验证";
    var $m_del_select="请选择删除选项";
    var $m_no_refund="您使用的是线下交易，请与店铺直接联系";
    var $m_refund_succ="退款成功";
    var $m_zhifubao_vouch="支付宝纯担保";
    var $m_caifutong_soon="财付通即时到帐";
    var $m_caifutong_vouch="财付通中介担保";
    var $m_illegal="非法请求";
    var $m_add_lable="添加商品标签成功";
    var $m_add_lable_fail="很抱歉，添加商品标签失败";
    var $m_download_error="无法下载文件";
    var $m_file_type_error="文件类型不对";
    var $m_import_succ="导入成功";
    var $m_di="第";
    var $m_import_fail="行导入失败";
    var $m_iconv_str="商品ID,店铺ID,商品名称,分类ID,自定义分类ID,品牌ID,属性类型ID,商品描述,批发说明,商品库存,商品价格,商品运费,关键字,是否删除,是否精品,是否新品,是否热销,是否特价,是否上架,是否设置图片,商品缩略图,关注度,被收藏次数,排序,添加时间,最后更新时间,是否锁定,原始图片 \n";
    var $m_paper_upload="证件上传";
    var $m_work_count_error="输入字数超长";
    var $m_num_lack="库存不足，请和店主联系";
    
    var $m_not_del="您不能删除该内容，您没有这个权利！";
    var $m_not_err="您不能进行该操作，您没有这个权利！";
	var $m_appraised="您已评价过，您不能重复评价！";
	var $m_not_appraised="您还没有完成购买，您不能评价！";
	var $m_domain_format_error="域名格式不正确!";
    var $m_order_not="该订单卖家已经确认,您不能取消订单！";
    var $m_favitor_not="您没有收藏过该商品，不能删除！";
    var $m_favitor_close ="店铺已被关闭！";
    var $m_favitor_lock ="店铺已被锁定！";

    var $m_user_yunshu ="用户要求运输方式";
    var $m_user_denglu ="请您先登陆";
	var $m_price_error ="价格格式不正确!";
	
	var $m_rigst_no="不能使用该用户名，因为包含敏感词";
	var $m_shop_no="不能使用该店铺名，因为包含敏感词";
	var $m_shop_intro_no="店铺简介中包含敏感词";
	var $m_shop_intro_back1="请重新输入！";
	var $m_goods_no="不能使用该商品名，因为包含敏感词";
	var $m_goods_intro_no="商品简介中包含敏感词";
	
	var $m_goods_photo_request="商品快照";
	var $m_message_content = "消息内容";
	var $m_message_state = "消息状态";
	
	var $m_iconv_receiv="收款单编号,订单号,支付单号,商铺名称,支付方式,支付日期,收款人,收款日期,收款账户,收款金额,操作者 \n";
	var $m_iconv_shipping = "发货单编号,订单号,支付单号,商铺名称,物流方式,物流公司,快递单号,发货日期,收货人,收货地址,收货人电话,操作人 \n";
	var $m_shop_yes = "该商铺已存在";
}
?>