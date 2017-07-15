<?php
/**
 * Created by PhpStorm.
 * User: MoganWang
 * Date: 2017/6/18
 * Time: 18:34
 */
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
    protected $pk = 'goods_id';
    protected $fileds = array('goods_id','goods_name','goods_price','goods_vip_price','goods_num','goods_weight','goods_introduce'
    ,'goods_logo','goods_small_logo','goods_cate_id','goods_brand_id','goods_add_time','goods_upd_time','goods_sale_time','goods_is_del');
    protected $_map = array(
        'name' => 'goods_name',
        'price' => 'goods_price',
        'vip' => 'goods_vip_price',
        'num' => 'goods_num',
        'weight' => 'goods_weight',
        'introduce' => 'goods_introduce',
        'del' => 'goods_is_del'
    );
    protected $_validata = array(
        array('goods_name','require','商品名称不能为空',1,'regex',3),
        array('goods_price','currency','商品价格格式不正确',1,'regex',3)
    );
    protected $_auto = array(
        array('goods_add_time','time',1,'function'),
        array('goods_upd_time','time',3,'function')
    );
    public function addGoods($logo){
        $data = $this->create('',1);
        if(!$data){
            return $this->getError();
        }else{
            $data = array_merge($data,$logo);
            $res = $this->add($data);
            if($res){
                return $res;
            }else{
                return false;
            }
        }
    }
    public function delGoods($goods_id){
        $res_del = $this->where(array('goods_id'=>$goods_id))->find();
        if($res_del['goods_is_del'] =='下架'){
            $status = '上架';
        }else{
            $status = '下架';
        }
        $data = array(
            'goods_is_del' => $status
        );
        $res = $this->where(array('goods_id'=>$goods_id))->save($data);
        if($res){
            echo $status;
        }else{
            echo 0;
        }
    }
    public function updGoods($goods_id,$logo=''){
        $data = $this->create();
        if(!$data){
            return $this->getError();
        }else{
            if(!empty($logo)){
                $data = array_merge($data,$logo);
            }
            $res = $this->where(array('goods_id'=>$goods_id))->save($data);
            if($res){
                return true;
            }else{
                return false;
            }
        }
    }
}