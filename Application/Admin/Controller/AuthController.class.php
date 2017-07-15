<?php
namespace Admin\Controller;
//use Think\Controller;
class AuthController extends CommonController {
    public function showlist(){
        $authInfo = D('Auth')->select();
        $authInfo = getAuthTree($authInfo);
        $this->assign('authInfo',$authInfo);
        $this->display();
    }
    public function add(){
        $auth = D('Auth');
        if(IS_POST){
            $data = $auth->create();
            if($auth->add($data)){
                $this->success('添加成功',U('Auth/showlist'));
            }else{
                $this->error('添加失败');
            }

        }else{
            $auth_id = 0;
            $auth = D('Auth');
            $authInfo = $auth->where('auth_pid=' . $auth_id)->select();
            $this->assign('authInfo', $authInfo);
            $this->display();
        }
    }

}