<?php
//命名空间
namespace Home\Controller;// Home 命名空间
use Think\Controller;
class AjaxController extends Controller {
	public function newmessage(){
		$db=M('atricle');
		$content=I('post.content');
		$data=array(
			'content'=>$content,
			'create_time'=>time()
		);
		$rs=$db->add($data);
		$this->ajaxReturn($rs);
	} 
	public function del(){
		$db=M('atricle');
		$id=I('post.id');
		$db->is_del='0';
		$rs=$db->where('id="'.$id.'"')->save();
		$this->ajaxReturn($rs);
	}
	public function hits(){
		$db=M('atricle');
		$id=I('post.id');
		$rs=$db->where('id="'.$id.'"')->setInc('hits');
		$this->ajaxReturn($rs);
	}
	public function newreviews(){
		$db=M('reviews');
		$id=I('post.aid');
		$rcontent=I('post.rcontent');
		$rname=I('post.rname');
		$tmp=time();
		$data=array(
			'aid'=>$id,
			'rcontent'=>$rcontent,
			'rname'=>$rname,
			'rtime'=>$tmp
		);
		$rs=$db->add($data);
		if($rs){
			$rs=date('Y-m-d H:m',$tmp);
		}
		$this->ajaxReturn($rs);
	}
	public function getmore(){
		$addlist=I('post.list');
		$page=I('post.page')+1;
		$page_size=2;
		$start=($page-1)*$page_size+$addlist;
		$atricle=M('atricle');
		$reviews=M('reviews');
		$rs=$atricle->where('is_del="1"')->order('id desc')->limit('"'.$start.','.$page_size.'"')->select();
		if($rs){
			foreach($rs as $k=>$v){
			$tmp=$reviews->where('aid="'.$v['id'].'"')->order('id desc')->select();
			$rs[$k]['reviews']=$tmp;
			}
		}
		$this->ajaxReturn($rs);
	}
}