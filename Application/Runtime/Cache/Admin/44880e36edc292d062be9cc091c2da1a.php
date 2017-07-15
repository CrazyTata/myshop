<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <a href="<?php echo U('Goods/add');?>"><li><span><img src="/Public/Admin/images/t01.png" /></span>添加</li></a>
                <li><span><img src="/Public/Admin/images/t02.png" /></span>修改</li>
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>产品标题</th>
                    <th>产品价格</th>
                    <th>会员价格</th>
                    <th>添加时间</th>
                    <th>是否上架</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($goodsInfo)): foreach($goodsInfo as $key=>$v): ?><tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo ($v["goods_id"]); ?></td>
                    <td><?php echo ($v["goods_name"]); ?></td>
                    <td><?php echo ($v["goods_price"]); ?></td>
                    <td><?php echo ($v["goods_vip_price"]); ?></td>
                    <td><?php echo (date("Y-m-d",$v["goods_add_time"])); ?></td>
                    <td><?php echo ($v["goods_is_del"]); ?></td>
                    <td><a href="<?php echo U('Picture/showlist?goods_id='.$v['goods_id']);?>" class="tablelink">图片管理</a>&nbsp;&nbsp;
                        <a href="<?php echo U('Goods/upd?goods_id='.$v['goods_id']);?>" class="tablelink">商品编辑</a>&nbsp;&nbsp;
                        <a href="javascript:;" data="<?php echo ($v["goods_id"]); ?>" class="tablelink del"><?php if($v['goods_is_del'] == '上架'): ?>下架<?php else: ?>上架<?php endif; ?></a>
                    </td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
        <div class="pagin">
            <div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
            <ul class="paginList">
                <li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>
                <li class="paginItem"><a href="javascript:;">1</a></li>
                <li class="paginItem current"><a href="javascript:;">2</a></li>
                <li class="paginItem"><a href="javascript:;">3</a></li>
                <li class="paginItem"><a href="javascript:;">4</a></li>
                <li class="paginItem"><a href="javascript:;">5</a></li>
                <li class="paginItem more"><a href="javascript:;">...</a></li>
                <li class="paginItem"><a href="javascript:;">10</a></li>
                <li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>
            </ul>
        </div>
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="/Public/Admin/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
        $('.del').click(function(){
            var goods_id = $(this).attr('data');
            var _this = $(this);
            $.post("<?php echo U('Goods/del');?>",{"goods_id":goods_id},function(msg){
               if(msg == 0){
                   alert('修改失败');
               }else{
                   _this.parent().prev().html(msg);
                   if(msg == '上架'){
                       _this.html('下架');
                   }else{
                       _this.html('上架');
                   }
                   alert('修改成功');

               }
            })
        })
    </script>
</body>

</html>