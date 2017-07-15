<?php
/**
 * Created by PhpStorm.
 * User: MoganWang
 * Date: 2017/6/19
 * Time: 12:54
 */
//处理上传图片
function upload_img (){
    $config =   C('UPLOAD_IMG');
    $upload =   new Think\Upload($config);
    $res = $upload->upload();
    if(!$res){
        return $upload->getError();
    }else{
        return $res;
    }
}
//制作缩略图
function thumb_img($img_arr){
    $image = new Think\Image();
    $path_big = C('UPLOAD_IMG')['rootPath'].$img_arr['savepath'].$img_arr['savename'];
    $path_sma = C('UPLOAD_IMG')['rootPath'].$img_arr['savepath'].'sma_'.$img_arr['savename'];
    $image->open($path_big);
    $image->thumb(400,400);
    $image->save($path_sma);
    return $path_sma;


}