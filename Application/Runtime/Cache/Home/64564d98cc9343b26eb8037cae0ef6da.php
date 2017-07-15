<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>填写核对订单信息</title>
    <link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">
    <script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <?php if(session('?mem_name') ): ?><li>您好，欢迎<?php echo (session('mem_name')); ?>来到京西！ <a href="<?php echo U('Member/lgout');?>" target="_parent">退出</a></li>
                    <?php else: ?>
                    <li> [<a href="<?php echo U('Member/login');?>" target="_top">请登录</a> ][<a href="<?php echo U('Member/register');?>">免费注册</a>]</li><?php endif; ?>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
        <div <?php if($nowPath == 'Cart-flow1'): ?>class="flow fr"<?php elseif($nowPath == 'Cart-flow2'): ?>class="flow fr flow2" <?php else: ?>class="flow fr flow3"<?php endif; ?> >
            <ul>
                <li <?php if($nowPath == 'Cart-flow1'): ?>class="cur"<?php endif; ?>>1.我的购物车</li>
                <li <?php if($nowPath == 'Cart-flow2'): ?>class="cur"<?php endif; ?>>2.填写核对订单信息</li>
                <li <?php if($nowPath == 'Cart-flow4'): ?>class="cur"<?php endif; ?>>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->



<div style="clear:both;"></div>
<script type="text/javascript" src="/Public/Home/js/cart2.js"></script>
<link rel="stylesheet" href="/Public/Home/style/fillin.css" type="text/css">
<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
<form action="<?php echo U('flow3');?>"  method="post" >
    <div class="fillin_bd">
        <div class="address">
            <h3>收货人信息 <a href="javascript:;" id="address_modify">[修改]</a></h3>
            <div class="address_info">
                <input type="radio" name="order_cgn_id" checked="checked" value="<?php echo ($cgnInfo_default["cgn_id"]); ?>" /><?php echo ($cgnInfo_default["cgn_name"]); echo ($cgnInfo_default["cgn_tel"]); ?>
                <?php echo ($cgnInfo_default["cgn_address"]); ?>
            </div>

            <div class="address_select none">
                <ul>
                    <?php if(is_array($cgnInfo)): foreach($cgnInfo as $key=>$v): ?><li class="cur">
                        <input type="radio" name="order_cgn_id" value="<?php echo ($v["cgn_id"]); ?>" /><?php echo ($v["cgn_name"]); echo ($v["cgn_address"]); echo ($v["cgn_tel"]); ?>
                        <a href="javascript:;"  onclick="changeDefault(<?php echo ($v["cgn_id"]); ?>)" >设为默认地址</a>
                        <a href="">编辑</a>
                        <a href="">删除</a>
                    </li><?php endforeach; endif; ?>
                    <li><input type="radio" name="order_cgn_id" class="new_address"  />使用新地址</li>
                </ul>
                    <ul>
                        <li>
                            <label for=""><span>*</span>收 货 人：</label>
                            <input type="text" name="cgn_name" class="txt" />
                        </li>
                        <li>
                            <label for=""><span>*</span>所在地区：</label>
                            <select name="cgn_prov_id" id="province" onchange="getArea(this.value,2)">
                                <option value="0">请选择</option>
                                <?php if(is_array($provinceInfo)): foreach($provinceInfo as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["area_name"]); ?></option><?php endforeach; endif; ?>
                            </select>
                            <select name="cgn_city_id" id="level2" onchange="getArea(this.value,3)">
                                <option value="">请选择</option>

                            </select>
                            <select name="cgn_area_id" id="level3">
                                <option value="">请选择</option>
                            </select>
                        </li>
                        <li>
                            <label for=""><span>*</span>详细地址：</label>
                            <input type="text" name="cgn_address" class="txt address"  />
                        </li>
                        <li>
                            <label for=""><span>*</span>手机号码：</label>
                            <input type="text" name="cgn_tel" class="txt" />
                        </li>
                    </ul>
                <a href="javascript:;" class="confirm_btn"><span>保存收货人信息</span></a>
            </div>
        </div>
        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>
            <div class="delivery_info">
                <p><input type="radio" name="order_send_way" checked="checked" value="顺丰"/>顺丰</p>
                <p><input type="radio" name="order_send_way" checked="checked" value="EMS"/>EMS</p>
                <p><input type="radio" name="order_send_way" checked="checked" value="申通"/>申通</p>
                <p><input type="radio" name="order_send_way" checked="checked" value="韵达"/>韵达</p>
            </div>

        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>
            <div class="pay_info">
                <p><input type="radio" name="order_pay" checked="checked" value="支付宝"/>支付宝</p>
                <p><input type="radio" name="order_pay" value="微信"/>微信</p>
                <p><input type="radio" name="order_pay" value="银联卡"/>银联卡</p>
            </div>

        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <div class="receipt">
            <h3>发票信息 </h3>
            <div class="receipt_info">
                <p>
                    <label for="">发票抬头：</label>
                    <input type="radio" name="order_title" checked="checked" value="个人" class="personal"/>个人
                    <input type="radio" name="order_title" class="company" value="单位" />单位
                    <input type="text" name="order_company" class="company_input"  disabled="disabled"/>
                </p>
                <p>
                    <label for="">发票内容：</label>
                    <input type="radio" name="order_content" value="明细" checked="checked"/>明细
                    <input type="radio" name="order_content" value="办公用品" />办公用品
                    <input type="radio" name="order_content" value="体育休闲"  />体育休闲
                    <input type="radio" name="order_content" value="耗材" />耗材
                </p>
            </div>

        </div>
        <!-- 发票信息 end-->
        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col2">规格</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($cartInfo)): foreach($cartInfo as $key=>$v): ?><tr>
                    <td class="col1"><a href=""><img src="<?php echo ($v["goods_small_logo"]); ?>" alt=""/></a>
                        <strong><a href=""><?php echo ($v["goods_name"]); ?></a></strong></td>
                    <td class="col2"> <?php if(is_array($v['cart_goods_attr'])): foreach($v['cart_goods_attr'] as $k=>$vs): echo ($vs); endforeach; endif; ?></td>
                    <td class="col3">￥<?php echo ($v["goods_price"]); ?></td>
                    <td class="col4"> <?php echo ($v["cart_num"]); ?></td>
                    <td class="col5"><span>￥<?php echo ($v["total"]); ?></span></td>
                </tr><?php endforeach; endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span>4 件商品，总商品金额：</span>
                                <em>￥5316.00</em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<?php echo ($result_price); ?></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>
<!--</form>-->
    <div class="fillin_ft">
        <a href="javascript:;" class="submit"><span>提交订单</span></a>
        <p>应付总额：<strong>￥<?php echo ($result_price); ?>元</strong></p>

    </div>
</div>
<!-- 主体部分 end -->
<script type="text/javascript">
    //表单提交事件
    $('.submit').click(function(){
        $('form').submit();
    });
    $('.confirm_btn').click(function(){
        var cgn_name = $("[name='cgn_name']").val();
        var cgn_prov_id = $("[name='cgn_prov_id']").val();
        var cgn_city_id = $("[name='cgn_city_id']").val();
        var cgn_area_id = $("[name='cgn_area_id']").val();
        var cgn_address = $("[name='cgn_address']").val();
        var cgn_tel = $("[name='cgn_tel']").val();
        var data = {
            'cgn_name': cgn_name,
            'cgn_prov_id': cgn_prov_id,
            'cgn_city_id': cgn_city_id,
            'cgn_area_id': cgn_area_id,
            'cgn_address': cgn_address,
            'cgn_tel': cgn_tel
    };
        $.post("<?php echo U('Cart/deal_cgn');?>",data,function(msg){

            var str = "<li class='cur'> <input type='radio' name='order_cgn_id' value='"+msg.id+"' /> "+cgn_name+msg.address+cgn_tel+"<a href='javascript:;'  onclick='changeDefault("+msg.id+")' >设为默认地址</a> <a href=''>编辑</a> <a href=''>删除</a> </li>" ;
            $('.new_address').parent().before(str);
        },'json')
    })
    //三级联动地区
    function getArea(pid,n){
        $('#level'+n).empty();
        $('#level'+n).append("<option value='0'>--请选择--</option>");
        $('#level'+(n+1)).empty();
        $('#level'+(n+1)).append("<option value='0'>--请选择--</option>");
        $.post("<?php echo U('Cart/getarea');?>",{'parent_id':pid},function(msg){
            var str = '';
            $.each(msg,function(k,v){
                str += "<option value='"+v.id+"'>"+v.area_name+"</option>";
            })
            $('#level'+n).append(str);
        },'json')
    }
    //修改是否为默认地址
    function changeDefault(id){
        $.post("<?php echo U('Cart/changeDefault');?>",{'id':id},function(msg){
            alert(msg);
        })
    }
</script>
<div style="clear:both;"></div>

<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。 ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/Public/Home/images/xin.png" alt=""/></a>
        <a href=""><img src="/Public/Home/images/kexin.jpg" alt=""/></a>
        <a href=""><img src="/Public/Home/images/police.jpg" alt=""/></a>
        <a href=""><img src="/Public/Home/images/beian.gif" alt=""/></a>
    </p>
</div>
<!-- 底部版权 end -->
</body>
</html>