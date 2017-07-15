<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>

    <link href="/Public/Common/Umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/Common/Umeditor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Common/Umeditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Common/Umeditor/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/Common/Umeditor/lang/zh-cn/zh-cn.js"></script>
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
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品名称</label>
                    <input name="name" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                <label>商品价格</label>
                <input name="price" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i></li>
                <li>
                <label>会员价格</label>
                <input name="vip" placeholder="请输入会员价格" type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>商品数量</label>
                    <input name="num" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品重量</label>
                    <input name="weight" placeholder="请输入商品重量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品logo</label>
                    <input name="logo" type="file" />
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
                    <select name="goods_cate_id" id="level3" class="dfinput" onchange="getAttr(this.value)">
                        <option value="0">--请选择--</option>
                    </select>
                </li>

                <li><label>是否售卖</label><cite>
                    <input name="del" type="radio" value="上架" checked="checked" />上架&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="del" type="radio" value="下架" />下架</cite>
                </li>
                <li>
                    <label>商品描述
                    <textarea name="introduce" id="cont1" placeholder="请输入商品描述" style="width: 800px;height: 300px;" class="textinput"></textarea>
                    </label>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="application/javascript">
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
    };
    function getAttr(cate_id){
        $.post("<?php echo U('getAttr');?>",{'cate_id':cate_id},function(msg){
            $('#cel').remove();
            $.each(msg,function(index,v){
                var str ='';
                if(v.attr_type=="单选"){
                    var cont = '';
                    var arr_value = v.attr_value.split(',');
                    for(i=0;i<arr_value.length;i++){
                        cont += "<option>"+arr_value[i]+"</option>";
                    }
                    str += "<li  id='cel' ><label>"+v.attr_name+"</label><select name='attr_value["+v.attr_id+"][]' id='' class='dfinput' ><option value='0'>--请选择--</option> "+cont+"</select></li>";
                }else if(v.attr_type=="手填"){
                    str += "<li  id='cel' ><label>"+v.attr_name+"</label><input type='text' class='dfinput' name='attr_value["+v.attr_id+"][]' /></li>";
                }else{
                    var cont = '';
                    var arr_value = v.attr_value.split(',');
                    for(i=0;i<arr_value.length;i++){
                        cont += "<input type='checkbox' name='attr_value["+v.attr_id+"][]' value='"+arr_value[i]+"' />"+arr_value[i];
                    }
                    str += "<li  id='cel' ><label>"+v.attr_name+"</label>"+cont+"</li>";
                }
                $('#level3').parent().after(str);
            })
        },'json')
    };
//    $(document).on('click','.addselect',function(){
//            $(this).
//        });
    $('#btnSubmit').click(function(){
        $('form').submit();
    });
    var um = UM.getEditor('cont1');
</script>
</html>