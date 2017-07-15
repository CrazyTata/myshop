<?php
namespace Admin\Controller;
//use Think\Controller;
class GoodsController extends CommonController {
    public function showlist(){
        $goods = D('Goods');
        $goodsInfo = $goods->select();
        $this->assign('goodsInfo',$goodsInfo);
        $this->display();
    }
    public function add(){
        //图片上传
        if(IS_POST){
            if($_FILES['logo']['error'] == 0){
                //调用上传图片函数
                load('@/img');
                $res = upload_img();
                if(is_string($res)){
                    echo $res;
                }else{
                    //调用制作的小图函数
                    $goods_logo = C('UPLOAD_IMG')['rootPath'].$res['logo']['savepath'].$res['logo']['savename'];
                    $goods_small_logo = thumb_img($res['logo']);
                    $goods_logos = array(
                        'goods_logo' => $goods_logo,
                        'goods_small_logo' => $goods_small_logo
                    );
                }
            }
            $goods = D('Goods');
            if(!empty($goods_logos)){
                $res = $goods->addGoods($goods_logos);
            }else{
                $res = $goods->addGoods();
            }
            if(is_numeric($res)){
                $arr = array();
                $attr = D('Goodsattr');
                $attrData = I('post.attr_value');
                foreach ($attrData as $k => $v){
                    $arr[] = array(
                        'ga_goods_id'=> $res,
                        'ga_attr_id' => $k,
                        'ga_attr_values' =>implode(',',$v)
                    );
                }
                $attr->addAll($arr);
                $this->success('添加成功',U('Goods/showlist'));
            }else if(is_string($res)){
                $this->error($res,U('Goods/add'));
            }else{
                $this->error('添加失败',U('Goods/add'));
            }
        }else{
            $cate_id = 0;
            $cate = D('Cate');
            $cateInfo = $cate->where('cate_pid='.$cate_id)->select();
                $this->assign('cateInfo', $cateInfo);
                $this->display();
        }
    }
    //专门处理分类表的信息,三级联动
    public function getCate($cate_id){
        $cate = D('Cate');
        $cateInfo = $cate->where('cate_pid=' . $cate_id)->select();
        echo json_encode($cateInfo);
    }
    //专门处理属性表的信息
    public function getAttr($cate_id){
        $attr = D('Attribute');
        $attrInfo = $attr->where('attr_cate_id='.$cate_id)->select();
        echo json_encode($attrInfo);
    }
    public function upd(){
        $goods_id = I('get.goods_id');
        $goods = D('Goods');
        if(IS_POST){
            if($_FILES['logo']['error'] == 0){
                load('@/img');
                $res = upload_img();
                if(is_string($res)){
                    $this->error($res,U('Goods/upd?goods_id='.$goods_id));
                }else{
                    $goods_small_logo = thumb_img($res['logo']);
                    $goods_logo = C('UPLOAD_IMG')['rootPath'].$res['logo']['savepath'].$res['logo']['savename'];
                    $upload_result = array(
                        'goods_logo'=>$goods_logo,
                        'goods_small_logo' =>$goods_small_logo
                    );
                }
            }
            if($upload_result){
                $result = $goods->updGoods($goods_id,$upload_result);
            }else{
                $result = $goods->updGoods($goods_id);
            }
            if(is_string($result)){
                $this->error($ressult,U('Goods/upd?goods_id='.$goods_id));
            }else if($result){
                $this->success('修改成功',U('showlist'));
            }else{
                $this->error('修改失败',U('Goods/upd?goods_id='.$goods_id));
            }
        }else{

            $goodsInfo = $goods->find($goods_id);
            $this->assign('goodsInfo',$goodsInfo);
            $this->display();
        }
    }
    public function del(){
        $goods = D('Goods');
        $goods_id = I('post.goods_id');
//        echo $goods_id;
        $goods->delGoods($goods_id);
    }
    public function text(){
        echo salt(123);
    }
   
}