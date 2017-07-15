<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function login(){
        if(IS_POST){
            $username = I('post.username');
            $password = I('post.password');
            $res = D('Manager')->checkLogin($username,$password);
            if(is_string($res)){
                $this->error($res,U('Index/login'));
            }else{
                $this->success('登录成功',U('Main/index'));
            }
        }else{

            $this->display();
        }
    }
}