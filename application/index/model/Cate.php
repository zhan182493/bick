<?php
namespace app\index\model;
use think\Model;

/**
* 
*/
class Cate extends Model
{
	
	public function getchilrenid($cateid){
		$cateres=$this->select();
		$sonids= $this->_getchilrenid($cateid,$cateres);
		$sonids[]=$cateid;
		$strId=implode(',',$sonids);
		return $strId;
	}

	public function _getchilrenid($cateid,$cateres){
		static $sonids=array();
		foreach ($cateres as $k => $v) {
			if($v['pid']==$cateid){
				$sonids[]=$v['id'];
				$this->_getchilrenid($v['id'],$cateres);
			}
		}

		return $sonids;
	}

	public function getParentCname($cateid){
		$cateRes=$this->select();
		$cateOne=$this->find($cateid);
		$parentCname=$this->_getParentCname($cateid,$cateRes);
		$parentCname[]=array(
				'catename'=>$cateOne['catename'],
				'id'=>$cateOne['id'],
				'type'=>$cateOne['type'],
			);
		return $parentCname;
	}

	public function _getParentCname($cateid,$cateRes){
		static $arr=array();
		static $arrP=array();
		$cateOne=$this->find($cateid);

		foreach ($cateRes as $k => $v) {
			if($cateOne['pid']==$v['id']){
				$arr['catename']=$v['catename'];
				$arr['type']=$v['type'];
				$arr['id']=$v['id'];
				$arrP[]=$arr;
				$this->_getParentCname($v['id'],$cateRes);
			}
		}
		return $arrP;
	}
}