<?php
namespace app\admin\model;
use app\admin\model\Common;
use app\admin\model\Article as ArticleModel;
class Cate extends Common
{
	public function catetree(){
		$cateres=$this->order('sort desc')->select();
		return $this->sort($cateres);
	}

	public function sort($data,$pid=0,$level=0){
		static $arr=[];
		foreach ($data as $k => $v) {
			if($v['pid']==$pid){
				$v['level']=$level;
				$arr[]=$v;
				$this->sort($data,$v['id'],$level+1);
			}
		}
		return $arr;
	}

	public function getchilrenid($id){
		$cateres=$this->select();
		return $this->_getchilrenid($id,$cateres);
	}

	public function _getchilrenid($id,$cateres){
		static $sonids=array();
		foreach ($cateres as $k => $v) {
			if($v['pid']==$id){
				$sonids[]=$v['id'];
				$this->_getchilrenid($v['id'],$cateres);
			}
		}

		return $sonids;
	}

}