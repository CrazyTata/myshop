<?php
namespace Home\Controller;
class MemberController extends CommonController
{
    public function login()
    {
        if (IS_POST) {
            $mem_name = I('post.username');
            $mem_pass = I('post.password');
            $res = D('Member')->where("mem_name='$mem_name'")->find();
            if (!$res) {
                $this->error('密码或用户名错误');
            } else {
                if ($res['mem_password'] == salt($mem_pass, $res['mem_salt'])) {
                    //将session入memcache
                    ini_set('session.save_handler','memcache');
                    ini_set('session.save_path','tcp://localhost:8888');
                    session('mem_name', $mem_name,240);
                    session('mem_salt', $res['mem_salt'],240);
                    session('mem_id', $res['mem_id'],240);
                    $a = I('get.ta') ? I('get.ta') : 'index';
                    $c = I('get.tc') ? I('get.tc') : 'Index';
                    $this->success('登录成功', U($c . '/' . $a));
                } else {
                    $this->error('密码或用户名错误');
                }
            }
        } else {
            $this->display();
        }
    }
    public function getSession(){
        ini_set('session.save_handler','memcache');
        ini_set('session.save_path','tcp:/localhost:8888');
        var_dump($_SESSION['mem_name']);
        echo '<br/>';
        var_dump($_SESSION['mem_salt']);
        echo '<br/>';
         var_dump($_SESSION['mem_id']);
        echo '<br/>';
        
    }
    public function register()
    {
        if (IS_POST) {
            $mem_name = I('post.username');
            $mem_pass = I('post.password');
            $mem_mail = I('post.checkcodemail');
            $mem_tel = I('post.telphone');
            $mem_code = I('post.checkcodetel');
            $code = $_SESSION['code'];
            //验证手机验证码
            if(!($mem_code==$code)){
                $this->error('验证码输入错误',U('register'));
            }
            $mem_salt = getSalt();
            $mem_password = salt($mem_pass, $mem_salt);
            $mem_arr = array(
                'mem_name' => $mem_name,
                'mem_password' => $mem_password,
                'mem_salt' => $mem_salt,
                'mem_mail' => $mem_mail,
                'mem_tel' => $mem_tel,
                'mem_create_time' => time(),
            );
            $res = D('Member')->add($mem_arr);
            if ($res) {
                //验证邮箱
                $rs = sendEmail($res,$mem_mail,$mem_salt);
//                echo $rs;
                echo "注册成功,请登录邮箱,激活后登录!";
            } else {
                $this->error('注册失败');
            }
        } else {
            $this->display();
        }
    }
    public function checkMailCode(){
        $code = I('get.id');
        $salt = I('get.salt');
        $data = array('mem_active'=>'激活');
        $res = D('Member')->where(array('mem_id'=>$code,'mem_salt'=>$salt))->save($data);
        if($res){
          $this->success('激活成功,请登录!', U('login'));
        }else{
            echo "激活失败!";
        }
    }
    public function sendMessage(){
        session_start();
        $code = rand(1000, 9999);
        $_SESSION['code'] = $code;
        include_once("./CCPRestSmsSDK.php");
        $telphone = $_POST['telphone'];
        $res = sendTemplateSMS($telphone, array($code, '1'), "1");//手机号码，替换内容数组，模板ID
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function lgout()
    {
        session(null);
        $this->redirect('Member/login');
    }

}