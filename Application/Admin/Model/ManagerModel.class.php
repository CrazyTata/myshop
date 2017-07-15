<?php
/**
 * Created by PhpStorm.
 * User: MoganWang
 * Date: 2017/6/18
 * Time: 18:34
 */
namespace Admin\Model;
use Think\Model;
class ManagerModel extends Model{
    public function checkLogin($username,$password){
        $res = $this->where(array('mg_name'=>$username))->find();
        if(!$res){
            return "用户名不存在";
        }else{
            if($res['mg_passwd']==salt($password)){
                session('mg_name',$res['mg_name']);
                session('mg_time',$res['mg_time']);
                session('mg_roleid',$res['mg_roleid']);
                return true;
            }else{
                return "密码错误";
            }
        }
    }
    
}