<?php
/**
 * Created by PhpStorm.
 * User: MoganWang
 * Date: 2017/5/31
 * Time: 16:02
 */
namespace Common\Tools;
	class Page {
        private $total; //数据表中总记录数
        private $listRows; //每页显示行数
        private $limit;   //制作一个 "limit  偏移量,长度"  的字符串
        private $uri;  //唯一请求的资源地址，代表获得分页数据的请求地址
        private $pageNum; //总页数
        private $config=array('header'=>"个记录", "prev"=>"上一页", "next"=>"下一页", "first"=>"首 页", "last"=>"尾 页");
        private $listNum=8;  //限制页码列表的显示个数，具体为 “当前页码和其左右各四个页码显示”
        public $firstPage;  //当前页面的起始页码
        public function __construct($total, $listRows=10, $pa=""){
            $this->total=$total;
            $this->listRows=$listRows;
            $this->uri=$this->getUri($pa);

            $this->page=!empty($_GET["page"]) ? $_GET["page"] : 1;
            $this->pageNum=ceil($this->total/$this->listRows);
            $this->limit=$this->setLimit();
        }
        private function setLimit(){
            //把 "limit  偏移量，长度"  封装为字符串赋予给$this->limit成员
            $this->firstPage = ($this->page-1)*$this->listRows;
            return "Limit ".($this->page-1)*$this->listRows.", {$this->listRows}";
        }
        //获得分页的请求链接地址
        private function getUri($pa){
//            var_dump($_SERVER);
            $url=$_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"], '?')?'':"?").$pa;
            $parse=parse_url($url);
            if(isset($parse["query"])){
                parse_str($parse['query'],$params);
                unset($params["page"]);
                $url=$parse['path'].'?'.http_build_query($params);

            }
            return $url;
        }

        function __get($args){
            if($args=="limit")
                return $this->limit;
            else
                return null;
        }
        private function start(){
            if($this->total==0)
                return 0;
            else
                return ($this->page-1)*$this->listRows+1;
        }

        private function end(){
            return min($this->page*$this->listRows,$this->total);
        }

        private function first(){
            $html = "";
            if($this->page==1)
                $html.='';
            else
                $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=1'>{$this->config["first"]}</a>&nbsp;&nbsp;";

            return $html;
        }

        private function prev(){
            $html = "";
            if($this->page==1)
                $html.='';
            else
                $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=".($this->page-1)."'>{$this->config["prev"]}</a>&nbsp;&nbsp;";

            return $html;
        }

        private function pageList(){
            $linkPage="";
            $inum=floor($this->listNum/2);
            for($i=$inum; $i>=1; $i--){
                $page=$this->page-$i;
                if($page<1)
                    continue;
                $linkPage.="&nbsp;<a href='{$this->uri}&page={$page}'>{$page}</a>&nbsp;";
            }
            $linkPage.="&nbsp;{$this->page}&nbsp;";

            for($i=1; $i<=$inum; $i++){
                $page=$this->page+$i;
                if($page<=$this->pageNum)
                    $linkPage.="&nbsp;<a href='{$this->uri}&page={$page}'>{$page}</a>&nbsp;";
                else
                    break;
            }

            return $linkPage;
        }

        private function next(){
            $html = "";
            if($this->page==$this->pageNum)
                $html.='';
            else
                $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=".($this->page+1)."'>{$this->config["next"]}</a>&nbsp;&nbsp;";
            return $html;
        }
        private function last(){
            $html = "";
            if($this->page==$this->pageNum)
                $html.='';
            else
                $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=".($this->pageNum)."'>{$this->config["last"]}</a>&nbsp;&nbsp;";

            return $html;
        }

        private function goPage(){
            return '&nbsp;&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'&page=\'+page+\'\'}" value="'.$this->page.'" style="width:25px"><input type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'&page=\'+page+\'\'">&nbsp;&nbsp;';
        }

        //制作并返回 页码列表
        function fpage($display=array(0,1,2,3,4,5,6,7,8)){
            $html[0]="&nbsp;&nbsp;共有<b>{$this->total}</b>{$this->config["header"]}&nbsp;&nbsp;";
            $html[1]="&nbsp;&nbsp;每页显示<b>".($this->end()-$this->start()+1)."</b>条，本页<b>{$this->start()}-{$this->end()}</b>条&nbsp;&nbsp;";
            $html[2]="&nbsp;&nbsp;<b>{$this->page}/{$this->pageNum}</b>页&nbsp;&nbsp;";

            $html[3]=$this->first();
            $html[4]=$this->prev();
            $html[5]=$this->pageList();
            $html[6]=$this->next();
            $html[7]=$this->last();
            $html[8]=$this->goPage();
            $fpage='';
            foreach($display as $index){
                $fpage.=$html[$index];
            }
            return $fpage;

        }
    }

