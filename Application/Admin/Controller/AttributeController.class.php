<?php
namespace Admin\Controller;
//use Think\Controller;
class AttributeController extends CommonController {
    public function showlist(){
        $attr = D('Attribute');
        $attrInfo = $attr->alias('a')
            ->field('a.attr_id','a.attr_name','c.cate_name','a.attr_type','a.attr_value')
            ->join("left join  sp_cate c on c.cate_id = a.attr_cate_id")
            ->select();
        $this->assign('attrInfo',$attrInfo);
        $this->display();
    }
    public function add(){
        $attr = D('Attribute');
        if(IS_POST){
            $data = $attr->create();
            $data['attr_value']= str_replace('，',',',$data['attr_value']);
            if($attr->add($data)){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            };

        }else{
            $cate_id = 0;
            $cate = D('Cate');
            $cateInfo = $cate->where('cate_pid=' . $cate_id)->select();
            $this->assign('cateInfo', $cateInfo);
            $this->display();
        }
    }
    public function getCate($cate_id){
        $cate = D('Cate');
        $cateInfo = $cate->where('cate_pid=' . $cate_id)->select();
        echo json_encode($cateInfo);
    }
   
}