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
        <div class="formtitle"><span>基本信息</span></div>
        <form action="" method="post">
            <ul class="forminfo">
                <li>
                    <label>属性名称</label>
                    <input name="attr_name" placeholder="请输入属性名称" type="text" class="dfinput" />
                </li>

                <li>
                    <label>一级分类</label>
                    <select name="" id="level1" onchange="getCate(this.value,2)" class="dfinput" >
                        <option value="0">--请选择--</option>
                        <?php if(is_array($cateInfo)): foreach($cateInfo as $key=>$v): ?><option value="<?php echo ($v["cate_id"]); ?>"><?php echo ($v["cate_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </li>
                <li>
                    <label>二级分类</label>
                    <select name="" id="level2" onchange="getCate(this.value,3)" class="dfinput" >
                        <option value="0">--请选择--</option>
                    </select>
                </li>
                <li>
                    <label>三级分类</label>
                    <select name="attr_cate_id" id="level3" class="dfinput" >
                        <option value="0">--请选择--</option>
                    </select>
                </li>

                <li>
                    <label>值录入方式</label>
                    <cite>
                    <input type="radio" name="attr_type" value="手填" checked="checked">手填&emsp;
                    <input type="radio" name="attr_type" value="单选">单选
                    <input type="radio" name="attr_type" value="多选">多选
                    </cite>
                </li>
                <li>
                    <label>可选值</label>
                    <textarea name="attr_value" placeholder="请输入可选值，多个值之间请使用英文“,”分隔开" class="textinput"></textarea>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" rows='5' cols='20' type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
function getCate(cate_id,n){
    //还有一个功能没实现
//        if($('#level1').value == "0"){
//            $('#level2').empty();
//        }
    $('#level'+n).empty();
    $('#level'+(n+1)).empty();
    $('#level'+n).append("<option value='0'>--请选择--</option>");
    $('#level'+(n+1)).append("<option value='0'>--请选择--</option>");
    $.post("<?php echo U('getCate');?>",{'cate_id':cate_id},function(msg){
        $.each(msg,function(index,v){
            var str ='';
            str += "<option value="+v.cate_id+">"+v.cate_name+"</option>";
            $('#level'+n).append(str);
        })
    },'json')
}
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    });

});
</script>
</html>