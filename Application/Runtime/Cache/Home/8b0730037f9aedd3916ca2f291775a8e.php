<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>

<script type="text/javascript">

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


</script>
<body>
<form action="" class="none" name="address_form">
    <ul>
        <li>
            <label for=""><span>*</span>所在地区：</label>
            <select name="cgn_prov_id" id="province" onchange="getArea(this.value,2)">
                <option value="0">请选择</option>
                <?php if(is_array($provinceInfo)): foreach($provinceInfo as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["area_name"]); ?></option><?php endforeach; endif; ?>
            </select>
            <select name="city" id="level2" onchange="getArea(this.value,3)">
                <option value="">请选择</option>

            </select>
            <select name="area" id="level3">

                <option value="">请选择</option>
            </select>
        </li>
    </ul>
</form>
</body>
</html>