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
}