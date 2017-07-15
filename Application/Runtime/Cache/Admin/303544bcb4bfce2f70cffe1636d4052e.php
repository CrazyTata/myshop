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
                    <input name="name"  value="<?php echo ($goodsInfo["goods_name"]); ?>" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                <label>商品价格</label>
                <input name="price" value="<?php echo ($goodsInfo["goods_price"]); ?>"  type="text" class="dfinput" /><i></i></li>
                <li>
                <label>会员价格</label>
                <input name="vip"  value="<?php echo ($goodsInfo["goods_vip_price"]); ?>"  type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>商品数量</label>
                    <input name="num"  value="<?php echo ($goodsInfo["goods_num"]); ?>"  type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品重量</label>
                    <input name="weight"  value="<?php echo ($goodsInfo["goods_weight"]); ?>"  type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品logo</label>
                    <input name="logo" type="file" />
                    <img src="<?php echo (ltrim($goodsInfo["goods_logo"],'.')); ?>" alt="没有图片" />
                </li>

                <li><label>是否售卖</label><cite>
                    <input name="del" type="radio" value="上架"   <?php if($goodsInfo['goods_is_del'] == '上架' ): ?>checked="checked"<?php endif; ?> />上架&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="del" type="radio" value="下架"   <?php if($goodsInfo['goods_is_del'] == '下架' ): ?>checked="checked"<?php endif; ?>  />下架</cite>
                </li>
                <li>
                    <label>商品描述
                    <textarea name="introduce" id="cont1" style="width: 800px;height: 300px;" class="textinput"> <?php echo ($goodsInfo["goods_introduce"]); ?></textarea>
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
    $('#btnSubmit').click(function(){
        $('form').submit();
    });
    var um = UM.getEditor('cont1');
</script>
</html>