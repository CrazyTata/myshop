<?php
/**
 * Created by PhpStorm.
 * User: MoganWang
 * Date: 2017/6/18
 * Time: 18:34
 */
namespace Admin\Model;
use Think\Model;
class PictureModel extends Model{
    protected $pk = 'pic_id';
    protected $fileds = array('pic_id','pic_goods_id','pic_ori','pic_big','pic_mid','pic_sma');

    public function addPics($goods_id){
        load('@/img');
        $res = upload_img();
        if(is_string($res)){
            return $res;
        }else{
                //制作大中小图
                foreach($res as $v){
                $config = C('UPLOAD_IMG');
                $image = new \Think\Image();
                $pic_ori = $config['rootPath'].$v['savepath'].$v['savename'];
                $pic_big = $config['rootPath'].$v['savepath'].'big_'.$v['savename'];
                $pic_mid = $config['rootPath'].$v['savepath'].'mid_'.$v['savename'];
                $pic_sma = $config['rootPath'].$v['savepath'].'sma_'.$v['savename'];
                $image->open($pic_ori);
                $image->thumb(800,800);
                $image->save($pic_big);

                $image->thumb(350,350);
                $image->save($pic_mid);

                $image->thumb(50,50);
                $image->save($pic_sma);
                $arr[] = array(
                    'pic_goods_id'=>$goods_id,
                    'pic_ori'=>$pic_ori,
                    'pic_big'=>$pic_big,
                    'pic_mid'=>$pic_mid,
                    'pic_sma'=>$pic_sma
                );
            }
            if($this->addAll($arr)){
                return true;
            }else{
                return false;
            }
        }
    }
    public function delPics($pic_id){
        $path = $this->field('pic_big','pic_mid','pic_sma')->where(array('pic_id'=>$pic_id))->find();
        if($this->delete($pic_id)){
            unlink($path['pic_big']);
            unlink($path['pic_mid']);
            unlink($path['pic_sma']);
            echo 1;
        }else{
            echo 0;
        };

    }
}