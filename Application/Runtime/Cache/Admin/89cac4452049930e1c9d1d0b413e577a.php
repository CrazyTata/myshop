<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息【<a href="javascript:;">返回</a>】</span></div>
        <form action="" method="post">
            <input type="hidden" name="role_id" value="<?php echo ($roleInfo["role_id"]); ?>">
            <span style="font-size: 16px">您正在给【<label style="color: red;font-weight: bolder;"><?php echo ($roleInfo["role_name"]); ?></label>】设置权限</span>
            <ul class="forminfo">
                <table class="tablelist">
                    <thead>
                        <tr>
                            <th>权限分类</th>
                            <th>权限</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($authInfoA)): foreach($authInfoA as $key=>$v): ?><tr>
                                <td>
                                    <input type="checkbox" name="auth_id[]" value="<?php echo ($v["auth_id"]); ?>"<?php if(in_array(($v["auth_id"]), is_array($roleInfo["role_auth_ids"])?$roleInfo["role_auth_ids"]:explode(',',$roleInfo["role_auth_ids"]))): ?>checked = 'checked'<?php endif; ?> ><?php echo ($v["auth_name"]); ?>
                                </td>
                                <td>
                                    <?php if(is_array($authInfoB)): foreach($authInfoB as $key=>$vv): if($v['auth_id'] == $vv['auth_pid']): ?><input type="checkbox" name="auth_id[]" value="<?php echo ($vv["auth_id"]); ?>" <?php if(in_array(($vv['auth_id']), is_array($roleInfo['role_auth_ids'])?$roleInfo['role_auth_ids']:explode(',',$roleInfo['role_auth_ids']))): ?>checked = 'checked'<?php endif; ?>><?php echo ($vv["auth_name"]); ?>&emsp;<?php endif; endforeach; endif; ?>
                                </td>
                            </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                <br/>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    })
});
</script>
</html>