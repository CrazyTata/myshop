<?php
namespace Admin\Controller;
//use Think\Controller;
class RoleController extends CommonController {
    public function showlist(){
        $roleInfo = D('Role')->select();
        $this->assign('roleInfo',$roleInfo);
        $this->display();
    }
    public function add(){
        $this->display();
    }
    public function distribute(){
        if(IS_POST){
            $role_id = I('post.role_id');
            $role_auth_ids = implode(',',I('post.auth_id'));
            $data = D('Auth')->where(array('auth_id'=>array('in',($role_auth_ids))))->select();
            $arr = array();
            foreach ($data as $value){
                if(!$value['auth_pid'] == 0){
                    $arr[] = $value['auth_c'].'-'.$value['auth_a'];
                }
            }
            $role_auth_ac = implode(',',$arr);
            $roleData['role_auth_ids'] = $role_auth_ids;
            $roleData['role_auth_ac'] = $role_auth_ac;
//            dump($roleData);
            if(D('Role')->where('role_id='.$role_id)->save($roleData)){
                $this->success('修改权限成功',U('showlist'));
            }else{
                $this->error('修改权限失败',U('distribute?role_id='.$role_id));
            }
        }else{
            $role_id = I('get.role_id');
            $roleInfo = D('Role')->where('role_id='.$role_id)->find();
            $authInfoA = D('Auth')->where('auth_pid = 0')->select();
            $authInfoB = D('Auth')->where('auth_pid != 0')->select();
            $this->assign('authInfoB',$authInfoB);
            $this->assign('authInfoA',$authInfoA);
            $this->assign('roleInfo',$roleInfo);
            $this->display();
        }
        
    }

}