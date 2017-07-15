<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize(){
        $cateInfo = D('Cate')->select();
        $cateInfo = getTree($cateInfo);
        $cateInfoA = array();
        $cateInfoB = array();
        $cateInfoC = array();
        foreach($cateInfo as $k=>$v){
            if($v['level']==0){
                $cateInfoA[$k] = $v;
            }else if($v['level']==1){
                $cateInfoB[$k] = $v;
            }else{
                $cateInfoC[$k] = $v;
            }
        }
        $now_path = CONTROLLER_NAME.'-'.ACTION_NAME;
        $this->assign('nowPath',$now_path);
        $this->assign('cateInfoA',$cateInfoA);
        $this->assign('cateInfoB',$cateInfoB);
        $this->assign('cateInfoC',$cateInfoC);
    }
}