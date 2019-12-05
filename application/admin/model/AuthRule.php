<?php
namespace app\admin\model;
use think\Model;

class AuthRule extends Model
{
	public function ruletree(){
		$ruleres=$this->order('sort desc')->select();
		return $this->sort($ruleres);
	}

	public function sort($data,$pid=0,$level=0){	
		static $arr=[];
		foreach ($data as $k => $v) {
			if($v['pid']==$pid){
				$v['level']=$level;
				$v['dataid']=$this->getparentid($v['id']);
				$arr[]=$v;
				$this->sort($data,$v['id'],$level+1);
			}
		}
		return $arr;
	}

	public function getchildids($authRuleId){
		$authruleres=$this->select();
		return $this->_getchirldids($authRuleId,$authruleres);
	}

	public function _getchirldids($id,$data){
		//静态变量---------当在某函数里定义一个静态变量后，这个变量不会消失，即使函数退出了，在下次调用这个函数时，它会使用前次被调用后留下的值。此外，虽然该变量不随函数的退出而继续存在，但函数的外部并不能使用它。
		static $arr=[];
		foreach ($data as $k => $v) {
			if($v['pid']==$id){
				$arr[]=$v['id'];
				$this->_getchirldids($v['id'],$data);
			}
		}
		return $arr;
	}


	public function getparentid($authRuleId){
		$AuthRuleRes=$this->select();
		return $this->_getparentid($AuthRuleRes,$authRuleId,True);
	}

	public function _getparentid($AuthRuleRes,$authRuleId,$clear=False){
		static $arr=array();
		if($clear){
			$arr=array();
		}
		foreach ($AuthRuleRes as $k => $v) {
			if($v['id']==$authRuleId){
				$arr[]=$v['id'];
				$this->_getparentid($AuthRuleRes,$v['pid']);
			}
		}
		asort($arr);
		
		return implode('-',$arr);
	}


}