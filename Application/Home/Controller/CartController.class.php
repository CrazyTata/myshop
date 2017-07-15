<?php
namespace Home\Controller;
class CartController extends CommonController
{
    public function addCart()
    {
        $cart_data['cart_goods_id'] = I('post.cart_goods_id');
        $cart_data['cart_num'] = I('post.cart_num');
        $cart_data['cart_goods_attr'] = I('post.cart_goods_attr');
        $cart = new \Think\Cart();
        $result = $cart->addCart($cart_data);
        $result_price = $cart->getPrice();
        $result_sum = $cart->getSum();
        $res_arr = array(
            'total_price' => $result_price,
            'total_sum' => $result_sum,
        );
        if ($result) {
            echo json_encode($res_arr);
        } else {
            echo 0;
        }
    }

    //step1
    public function flow1()
    {
        $cart = new \Think\Cart();
        $result_flow = $cart->getFlow();
        $result_price = $cart->getPrice();
        $cartInfo = array();
        foreach ($result_flow as $k => $value) {
            $cartInfo[$k]['goods_small_logo'] = ltrim($value['goods_small_logo'], '.');//商品图片
            $cartInfo[$k]['goods_name'] = $value['goods_name'];//商品名称
            $cartInfo[$k]['cart_goods_attr'] = explode(',', $value['cart_goods_attr']);//商品信息
            $cartInfo[$k]['goods_price'] = $value['goods_price'];//单格
            $cartInfo[$k]['cart_num'] = $value['cart_num'];//数量
            $cartInfo[$k]['total'] = $value['cart_num'] * $value['goods_price'];//小计
            $cartInfo[$k]['cart_id'] = $value['cart_id'];
        }
        $this->assign('cartInfo', $cartInfo);
        $this->assign('result_price', $result_price);
        $this->display();
    }

    //根据cart_id删除一个
    public function delOne()
    {
        $cart = new \Think\Cart();
        $cart_id = I('post.cart_id');
        $res = $cart->delOne($cart_id);
        if ($res) {
            $result_price = $cart->getPrice();
            echo($result_price);
        } else {
            echo 0;
        }
    }

    //step2
    public function flow2()
    {
        if (session('?mem_id')) {
            //省份信息
            $provinceInfo = D('region')->where('level=1')->select();
            $this->assign('provinceInfo', $provinceInfo);
            $cart = new \Think\Cart();
            $result_flow = $cart->getFlow();
            $result_price = $cart->getPrice();
            $cartInfo = array();
            foreach ($result_flow as $k => $value) {
                $cartInfo[$k]['goods_small_logo'] = ltrim($value['goods_small_logo'], '.');//商品图片
                $cartInfo[$k]['goods_name'] = $value['goods_name'];//商品名称
                $cartInfo[$k]['cart_goods_attr'] = explode(',', $value['cart_goods_attr']);//商品信息
                $cartInfo[$k]['goods_price'] = $value['goods_price'];//单格
                $cartInfo[$k]['cart_num'] = $value['cart_num'];//数量
                $cartInfo[$k]['total'] = $value['cart_num'] * $value['goods_price'];//小计
                $cartInfo[$k]['cart_id'] = $value['cart_id'];
            }
            //已有的地址
            $cgnInfo = D('Consignee')->where('cgn_mem_id='.session('mem_id'))->select();
            //默认地址
            $cgnInfo_default = D('Consignee')->where( "cgn_default = '是'")->find();
            $this->assign('cgnInfo',$cgnInfo);
            $this->assign('cgnInfo_default',$cgnInfo_default);
            $this->assign('cartInfo', $cartInfo);
            $this->assign('result_price', $result_price);
            $this->display();
        } else {
            $a = ACTION_NAME;
            $c = CONTROLLER_NAME;
            $this->error('未登录,请登录后再结算!', U('Member/login?ta=' . $a . '&tc=' . $c));
        }
    }

    //step3
    public function flow3()
    {
        $data = I('post.');
        $cart = new \Think\Cart();
        $result_flow = $cart->getFlow();
        $result_price = $cart->getPrice();
        $orderInfo = array();
        $orderInfo['order_mem_id'] = session('mem_id');//会员ID
        $orderInfo['order_number'] = "php06" . date('YmdHis', time()) . rand(1000000000, 9999999999);//订单号
        $orderInfo['order_price'] = $result_price;//总价
        $orderInfo['order_pay'] = $data['order_pay'];//付款方式
        $orderInfo['order_send_way'] = $data['order_send_way'];//配送方式
        $orderInfo['order_title'] = $data['order_title'];//发票抬头
        $orderInfo['order_company'] = $data['order_company'] ? $data['order_company'] : '';//公司
        $orderInfo['order_content'] = $data['order_content'];//内容
        $orderInfo['order_cgn_id'] = $data['order_cgn_id'];//内容
        $orderInfo['order_add_time'] = time();//内容
        $orderInfo['order_upd_time'] = time();//内容
        $order = D('Order');
        $order_id = $order->add($orderInfo);
        if ($order_id) {
            $orderGoodsInfo = array();
            foreach ($result_flow as $k => $value) {
                $orderGoodsInfo[$k]['og_order_id'] = $order_id;//订单ID
                $orderGoodsInfo[$k]['og_goods_id'] = $value['goods_id'];//商品ID
                $orderGoodsInfo[$k]['og_goods_name'] = $value['goods_name'];//商品名称
                $orderGoodsInfo[$k]['og_mem_id'] = session('mem_id');//会员ID
                $orderGoodsInfo[$k]['og_goods_price'] = $value['goods_price'];//商品价格
                $orderGoodsInfo[$k]['og_total_price'] = $value['cart_num'] * $value['goods_price'];//小计
                $orderGoodsInfo[$k]['og_goods_num'] = $value['cart_num'];
            }
            $res_og = D('OrderGoods')->addAll($orderGoodsInfo);
            if (!$res_og) {
                echo "失败222";
            } else {
                $res = $cart->delAll();
                echo "成功!";
            }
        } else {
            echo "失败!";
        }
    }

    public function changeNum()
    {
        $cart_id = I('post.cart_id');
        $cart_num = I('post.num');
        $cart = new \Think\Cart();
        $change_res = $cart->changeNum($cart_id, $cart_num);
        if ($change_res) {
            echo $cart->getPrice();
        } else {
            echo 222;
        }
    }
    public function deal_cgn(){
        $data = I('post.');
        $province_name = D('Region')->where("id=".$data['cgn_prov_id'])->find();
        $city_name = D('Region')->find($data['cgn_city_id']);
        $area_name = D('Region')->find($data['cgn_area_id']);
        $data['cgn_address']= $province_name['area_name'].$city_name['area_name'].$area_name['area_name'].$data['cgn_address'];
        $data['cgn_mem_id'] = session('mem_id');
        $cgn_id = D('Consignee')->add($data);
        if($cgn_id){
            $info = array('id'=>$cgn_id,'address'=>$data['cgn_address']);
            echo json_encode($info);
        }else{
            echo 0;
        }
    }
    public function getarea()
    {
        $parent_id = I('post.parent_id');
        $info = D('region')->where('parent_id='.$parent_id)->select();
        echo json_encode($info);
    }

    public function changeDefault()
    {
        $id = I('post.id');
        $data = array(
            'cgn_default'=>'是'
        );
        $data1 = array(
            'cgn_default'=>'否'
        );
        $res = D('Consignee')->where(array('cgn_id'=>$id))->save($data);
        $res1 = D('Consignee')->where('cgn_id!='.$id)->save($data1);
        if($res1){
            echo 1;
        }else{
            echo 0;
        }
    }


}