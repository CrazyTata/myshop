<?php
/**
 * Created by PhpStorm.
 * User: MoganWang
 * Date: 2017/6/22
 * Time: 22:27
 */
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller{
    //构造方法
    public function _initialize(){
        //根据常量判断当前访问的控制器和方法,拼接成一个路径
        $now_path = CONTROLLER_NAME . '-' . ACTION_NAME;
        if (!session('?mg_name')) {
            $this->error('未登录,请先登录!', U('Index/login'));
        }
        //释放一些必须进入的页面权限
        $arr_pass = array('Main/index', 'Main/top');
        if (!session('mg_name') === 'Admin') {
            //根据session来连表查当前用于有的权限
            if (!in_array($now_path, $arr_pass)) {
                $mg_roleid = session('mg_roleid');
                $role_auth_ids = D('Role')->where('role_id=' . $mg_roleid)->find();
                $role_auth_path = explode(',', $role_auth_ids['role_auth_ids']);
                if (!in_array($now_path, $role_auth_path)) {
                    echo "对不起,你没有操作权限!";
                    die;
                }
            }
        }
    }
}