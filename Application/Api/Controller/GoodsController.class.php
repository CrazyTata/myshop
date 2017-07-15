<?php
namespace Api\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public function getGoods(){
        $arr = array ('wade','kobe','james','ray','answer');
        $salt = "英雄联盟";
        $name = $_GET['name'];
        $password = $_GET['pass'];
        if($salt !== $password){
            die("密码错误");
        }
        if(!in_array($name,$arr)){
            die("对不起,你的用户名没有此操作权限!");
        }

        $nowPage = $_GET['nowPage']; //起始页是第几页
        $page = $_GET['page'];  //每页显示的个数
        if(empty($nowPage) || empty($page)){
            $data = '';
            $code = 0;
            $msg  = '请求显示的页数和显示条数为空';
        }else{
            $goods= D('Goods');
            $total = $goods->count();
            $pages = ceil($total/$page);
            if($nowPage>$pages){
                $data = $goods->limit($pages,$page)->select();
                $code = 1;
                $msg = '请求显示的页数大于总页数,显示最后一页!';
            }
            $firstPage = ($nowPage-1)*$page;
            $data = $goods->limit($firstPage,$page)->select();
            $code = 2;
            $msg = '请求成功!!';
        }
        return json_encode(array('code'=>$code,'data'=>$data,'msg'=>$msg));
    }

}