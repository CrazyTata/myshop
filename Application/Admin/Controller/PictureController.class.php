<?php
namespace Admin\Controller;
//use Think\Controller;
class PictureController extends CommonController {
    public function showlist(){
        $goods_id = I('get.goods_id');
//        dump($goods_id);
        $goods = D('Goods');
        $picture = D('Picture');
        if(IS_POST){
            //图片是否上传成功
            $res = $picture->addPics($goods_id);
            if($res){
                $this->success('成功',U('Goods/showlist'));
            }else{
                $this->error('失败');
            }
        }else{
            $picInfo = $picture->where(array('pic_goods_id'=>$goods_id))->select();
            $goodsInfo = $goods->find($goods_id);
            $this->assign('goodsInfo',$goodsInfo);
            $this->assign('picInfo',$picInfo);
            $this->display();
        }

    }

    public function del(){
        $picture = D('Picture');
        $pic_id = I('post.pic_id');
        $picture->delPics($pic_id);
    }
   
}