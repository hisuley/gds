<?php

/**
 * ECMALL: ����������ڳ���
 * ============================================================================
 * ��Ȩ���� (C) 2005-2008 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.comsenz.com
 * -------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Id: home.php 5091 2008-07-04 03:00:20Z Garbin $
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

include(ROOT_PATH . '/admin/includes/ctl.home.php');

class HomeController extends HomeBaseController
{
    /* �ÿ�������������ΪMall */
    var $_domain = 'store';
    /**
     * ��ʾ��ӭҳ
     *
     *  @author Garbin
     *  @return  void
     */
    function welcome()
    {
        $this->logger = false; //����¼��־
        include(ROOT_PATH . '/admin/includes/inc.stat.php');
        include_once(ROOT_PATH . '/includes/manager/mng.payment.php');
        include_once(ROOT_PATH . '/includes/manager/mng.shipping.php');
        include_once(ROOT_PATH . '/includes/manager/mng.order.php');

        $order_manager = new OrderManager($_SESSION['store_id']);
        $order_manager->set_conf(array( 'mall_store_repeat_limit' => $this->conf('mall_store_repeat_limit'),
                                        'mall_goods_repeat_limit' => $this->conf('mall_goods_repeat_limit'),
                                        'mall_min_goods_amount'   => $this->conf('mall_min_goods_amount'),
                                        'mall_max_goods_amount'   => $this->conf('mall_max_goods_amount')));

        /* ��14����δȷ���ջ��Ķ����Զ���Ϊȷ��״̬���������14δ�����۵��Զ����� */
        $order_manager->auto_delivered(constant(strtoupper($this->conf('mall_auto_evaluation_value'))));
        $order_manager->auto_evaluation(constant(strtoupper($this->conf('mall_auto_evaluation_value'))));

        /* �ж��Ƿ�������֧����ʽ */
        $payment = new PaymentManager($_SESSION['store_id']);
        $payment_list = $payment->get_installed();
        $is_set_payment = TRUE;
        if (empty($payment_list))
        {
            $is_set_payment = FALSE;
        }

        /* �ж��Ƿ����������ͷ�ʽ */
        $shipping = new ShippingManager($_SESSION['store_id']);
        $shipping_list = $shipping->get_enabled();
        $is_set_shipping = TRUE;
        if ($shipping_list['info']['rec_count'] <= 0)
        {
            $is_set_shipping = FALSE;
        }

        $this->assign('order_query_start_date', date('Y-m-d'));
        $this->assign('order_query_end_date', date('Y-m-d', time() + 3600 * 24));

        /* ��ȡ��Ҫ���ѵ�������� */
        $this->assign('oos_count', get_goods_count('unlimitted', 'oos', $_SESSION['store_id']));
        $this->assign('unevaluated_order_count', get_order_count('unlimitted', 'unevalated', $_SESSION['store_id']));
        $this->assign('wait_for_ship_order_count', get_order_count('unlimitted', 'wait_for_ship', $_SESSION['store_id']));

        /* ��ȡ���ն�̬��������� */
        $this->assign('neworder_count', get_order_count('today', 'new', 'number', $_SESSION['store_id']));
        $this->assign('dealt_order_count', get_order_count('today', 'finish', 'number', $_SESSION['store_id']));

        /* ��ȡͳ����Ϣ��������� */
        $this->assign('finish_order_amount', get_order_count('unlimitted', 'finish', 'amount', $_SESSION['store_id']));
        $this->assign('all_finish_order_count', get_order_count('unlimitted', 'finish', 'number', $_SESSION['store_id']));
        $this->assign('goods_count', get_goods_count('unlimitted', $_SESSION['store_id']));

        $this->assign('is_open', $this->conf('store_status', $_SESSION['store_id']));
        $this->assign('is_set_shipping', $is_set_shipping);
        $this->assign('is_set_payment', $is_set_payment);

        parent::welcome();
    }
};
?>