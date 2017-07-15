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
    <span class="formbody">
        <div class="formtitle"><span style="color: red;font-size: 18px;"><?php echo ($goodsInfo["goods_name"]); ?>的商品相册</span></div>
        <li style="border: 1px solid grey;margin-bottom: 20px;">
<?php if(is_array($picInfo)): foreach($picInfo as $key=>$v): ?><span>

            <img src="<?php echo (ltrim($v["pic_mid"],'.')); ?>" width="200">
            <label>[<a href="javascript:;"  data="<?php echo ($v["pic_id"]); ?>" class="minuss">-</a>]</label>

        </span><?php endforeach; endif; ?>

        </li>
        <form action="<?php echo U('showlist?goods_id='.$goodsInfo['goods_id']);?>" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品图片[<a href="javascript:;" class="add">+</a>]</label>
                    <input name="goods_pic[]" type="file" />
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
$(function(){
    $('#btnSubmit').on('click',function(){
        $('form').submit();
    });
    $('.add').click(function(){
        var str = "<li> <label>商品图片[<a href='javascript:;' class='minus'>-</a>]</label> <input name='goods_pic[]' type='file'' /> </li>";
        $(this).parent().parent().after(str);
    });
    $('.minus').live('click',function(){
        $(this).parent().parent().remove();
    })
    $('.minuss').bind('click',function(){
        var _this = $(this);
        $(this).parent().parent().remove();
        var pic_id = $(this).attr('data');
        $.post("<?php echo U('del');?>",{'pic_id':pic_id},function(msg){
            if(msg == 1){
                alert('删除成功!');
                _this.parent().parent().remove();
            }else{
                alert('删除失败!');
            }
        })
    })
})
</script>
</html>