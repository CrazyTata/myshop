<?php
namespace Admin\Controller;
//use Think\Controller;
class CateController extends CommonController {
    public function addcate(){
        $cate = D('Cate');
        if(IS_POST){
            //通过create方法达到字段映射,自动验证,自动完成
            $data = $cate->create();
            if($cate->add($data)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            S(array(
               'type' => 'memcache',
                'host' => 'localhost',
                'port' => '8888'
            ));
            if(isset(S('cateInfo'))){
                //如果缓存存在,就直接输出缓存
                $cateInfo = S('cateInfo');
            }else{
                //如果缓存不存在,就查询数据表,查出结果后,再进行缓存
                $cateInfo =$cate->select();
                //调用递归函数,将分类表中的数据进行树形结构处理
                $cateInfo = getTree($cateInfo);
                S('cateInfo',$cateInfo,3600);
            }
            $this->assign('cateInfo',$cateInfo);
            $this->display();
        }
    }
    public function catelist(){
        $cate = D('Cate');

        $cateInfo =$cate->select();
        $cateInfo = getTree($cateInfo);
        $this->assign('cateInfo',$cateInfo);
        $this->display();
    }




   
}