<?php
namespace Admin\Controller;
//use Think\Controller;
class MainController extends CommonController {
    public function index(){
        $this->display();
    }
    public function left(){
        $mg_roleid = session('mg_roleid');
        if(session('mg_name') === "Admin"){
            $roleInfoA = D('Auth') -> where(array('auth_pid'=>0,'auth_is_show'=>1))->select();
            $roleInfoB = D('Auth') -> where(array('auth_pid'=>array('neq',0),'auth_is_show'=>1))->select();
        }else{
            $role_auth_ids = D('Role')->where(array('role_id'=>$mg_roleid))->find();
            $authIds = $role_auth_ids['role_auth_ids'];
            $roleInfoA = D('Auth') -> where(array(array('auth_pid'=>0),'auth_id'=>array('in',$authIds)))->select();
            $roleInfoB = D('Auth') -> where(array(array('auth_pid'=>array('neq',0)),'auth_id'=>array('in',$authIds)))->select();
        }
       $this->assign('roleInfoA',$roleInfoA);
       $this->assign('roleInfoB',$roleInfoB);
        C('SHOW_PAGE_TRACE',false);
        $this->display();
    }
    public function main(){
        $this->display();
    }
    public function top(){
        C('SHOW_PAGE_TRACE',false);
        $this->display();
    }
    public function lgout(){
        session(null);
        $this->redirect('Index/login');
    }
}