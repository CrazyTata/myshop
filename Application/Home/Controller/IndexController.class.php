<?php
namespace Home\Controller;
class IndexController extends CommonController {
    public function index(){
        $this->display();
    }
    public function showlist(){
        $level = I('get.level');
        $cate_id = I('get.cate_id');
        //分类列表页跳转到详情页
        $model = D();
        if($level == 2){
            $sql = "select * from sp_goods where goods_cate_id =".$cate_id;
        }else if($level == 1){
            $sql = "select * from sp_goods where goods_cate_id in (select cate_id from sp_cate where cate_pid = ".$cate_id.")";
        }else{
            $sql = "select * from sp_goods where goods_cate_id in (select cate_id from sp_cate where cate_pid in (select cate_id from sp_cate where cate_pid = ".$cate_id."))";
        }
        $goodsInfo = $model->query($sql);
        $this->assign('goodsInfo',$goodsInfo);
        $this->display();
    }
    public function detail(){
        $goods_id = I('get.goods_id');
        //商品详情
        $goodsInfo = D('Goods')->where('goods_id='.$goods_id)->find();
        //商品相册
        $picInfo   = D('Picture')->where('pic_goods_id='.$goods_id)->select();
        //商品属性
        $attrInfo = D('Goodsattr')->alias('g')
            ->field('g.ga_attr_values,a.attr_name')
            ->join('left join sp_attribute a on g.ga_attr_id = a.attr_id')
            ->where('g.ga_goods_id ='.$goods_id)
            ->select();
        $attrInfo1 = D('Goodsattr')->alias('g')
            ->field('g.ga_attr_values,a.attr_name')
            ->join('left join sp_attribute a on g.ga_attr_id = a.attr_id')
            ->where("a.attr_type='单选' and g.ga_goods_id =".$goods_id)
            ->select();
        foreach ($attrInfo1 as $k=>$vo){
            $attrInfo1[$k]['ga_attr_values'] = explode(',',$vo['ga_attr_values']);
        }
        $this->assign('attrInfo',$attrInfo);
        $this->assign('attrInfo1',$attrInfo1);
        $this->assign('picInfo',$picInfo);
        $this->assign('goodsInfo',$goodsInfo);
        $this->display();
    }



}