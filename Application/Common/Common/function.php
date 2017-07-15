<?php
function filterXSS($string){
    //相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Common/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}
//无限分类,并添加深度字段level
function getTree($arr,$pid=0,$level=0){
    static $result = array();
    foreach($arr as $v){
        if($v['cate_pid']==$pid){
            $v['level']=$level;
            $result[] = $v;
            getTree($arr,$v['cate_id'],$level+1);
        }
    }
    return $result;
}
//分类
function getAuthTree($arr,$pid=0,$level=0){
    static $result = array();
    foreach($arr as $v){
        if($v['auth_pid']==$pid){
            $v['level']=$level;
            $result[] = $v;
            getAuthTree($arr,$v['auth_id'],$level+1);
        }
    }
    return $result;
}
function salt ($password,$str='wang'){
    $salt = substr(sha1(substr(md5($str),10,9)),8,8);
    return(md5($salt.$password));
}
//获取盐
function getSalt (){
    $salt = '';
    $length = rand(4,8);
    for ($i=0;$i<$length;$i++){
        $tmp = rand(1,3);
        switch($tmp){
            case 1:
                $salt.=sprintf('%c',rand(48,57));
                break;
            case 2:
                $salt.=sprintf('%c',rand(97,122));
                break;
            case 3:
                $salt.=sprintf('%c',rand(65,90));
                break;
        }
    }
    return $salt;
}
function request($url,$https=true,$method='get',$data=null){
    //初始化开启url
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    if($https === true){
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    }
    if($method == 'post'){
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);

    }
    $str = curl_exec($ch);
    curl_close($ch);
    return $str;
}
function sendEmail($mem_id,$to,$salt){
    $project = '注册激活邮件';
    $content = "http://www.itshop.com/index.php/Home/Member/checkMailCode/id/".$mem_id."/salt/".$salt;
    $res = sendMail($project,$content,$to);
    if($res === true){
        echo "邮件发送成功!";
    }else{
        echo "失败原因!",$res;
    }
}
//发送邮件
//function sendMail($subject,$msghtml,$to){
//    include_once "./PHPMailer/class.phpmailer.php";
//        $mail = new PHPMailer(true); //New instance, with exceptions enabled
////        $body             = file_get_contents('contents.html');
////        $body             = preg_replace('/\\\\/','', $body); //Strip backslashes
//        $mail->IsSMTP();                           // tell the class to use SMTP
//        $mail->SMTPAuth   = true;                  // enable SMTP authentication
//        $mail->Port       = 25;                    // set the SMTP server port
////        $mail->Host       = "mail.yourdomain.com"; // SMTP server
//        $mail->Host       = "smtp.126.com"; // SMTP server
//        $mail->Username   = "crazytata@126.com";     // SMTP server username
//        $mail->Password   = "qwefghm12587";            // SMTP server password
//
//        $mail->IsSendmail();  // tell the class to use Sendmail
//
//        $mail->AddReplyTo("crazytata@126.com","crazytata");
//
//        $mail->From       = "crazytata@126.com";
//        $mail->FromName   = "crazytata";
//        $mail->AddAddress($to);
//
//        $mail->Subject  = $subject;
//
//        $mail->AltBody    = $msghtml; // optional, comment out and test
//        $mail->WordWrap   = 80; // set word wrap
//
//        $mail->MsgHTML($body);
//
//        $mail->IsHTML(true); // send as HTML
//
//        $re = $mail->Send();
//        if($re){
//            echo 'Message has been sent.';
//        }else{
//            echo $e->errorMessage();
////        }
//    $mail = new PHPMailer();
//    $mail -> IsSMTP();
//    //服务器相关数据
//    $mail -> SMTPAuth = true;
//    $mail -> Host     = 'smtp.126.com';
//    $mail -> Username = 'crazytata@126.com';
//    $mail -> Password = 'qwefghm12587';
//    //内容信息
//    $mail -> IsHTML(true);
//    $mail -> CharSet  = 'UTF-8';
//    $mail -> From     = 'crazytata@126.com';
//    $mail -> FromName = 'crazytata';
//    $mail -> Subject  = $subject;
//    $mail -> MsgHTML($msghtml);
//    $mail->AddAddress($to);
//    if($mail->send()){
//        return true;
//    }else{
//        return $mail->ErrorInfo;
//    }
//}
function sendMail($subject,$msghtml,$sendAddress){
    //引入发送类phpmailer.php
    require './PHPMailer/class.phpmailer.php';
    //实列化对象
    $mail             = new PHPMailer();
    /*服务器相关信息*/
    $mail->IsSMTP();                        //设置使用SMTP服务器发送
    $mail->SMTPAuth   = true;               //开启SMTP认证
    $mail->Host       = 'smtp.163.com';         //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Username   = 'woai281';      //发信人的邮箱用户名
    $mail->Password   = 'itcastphp2016';          //发信人的邮箱密码
    /*内容信息*/
    $mail->IsHTML(true);               //指定邮件内容格式为：html
    $mail->CharSet    ="UTF-8";          //编码
    $mail->From       = 'woai281@163.com';       //发件人完整的邮箱名称
    $mail->FromName   ="itcast_php";      //发信人署名
    $mail->Subject    = $subject;         //信的标题
    $mail->MsgHTML($msghtml);           //发信主体内容
    // $mail->AddAttachment("fish.jpg");      //附件
    /*发送邮件*/
    $mail->AddAddress($sendAddress);        //收件人地址
    //使用send函数进行发送
    if($mail->Send()) {
        //发送成功返回真
        return true;
        // echo '您的邮件已经发送成功！！！';
    } else {
        return  $mail->ErrorInfo;//如果发送失败，则返回错误提示
    }
}
//发送验证短信
function sendTemplateSMS($to, $datas, $tempId)
{
    // 初始化REST SDK
    $accountSid = '8a216da85cf298b3015cf732b00901a7';
    $accountToken = '801066fcf20b49c1926aace419d88ee1';
    $appId = '8a216da85cf298b3015cf732b16601ae';
    $serverIP = 'app.cloopen.com';
    $serverPort = '8883';
    $softVersion = '2013-12-26';
    $rest = new REST($serverIP, $serverPort, $softVersion);
    $rest->setAccount($accountSid, $accountToken);
    $rest->setAppId($appId);

    $result = $rest->sendTemplateSMS($to, $datas, $tempId);
    if ($result == NULL) {
        return false;
    }
    if ($result->statusCode != 0) {
        return false;
    } else {
        return true;
    }
}