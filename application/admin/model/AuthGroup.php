<?php
namespace app\admin\model;
use think\Model;

class AuthGroup extends Model
{
	public function dataRule($dataRule){
		foreach ($dataRule as $k => $v) {
				$ruleres=db('auth_rule')->where('id',$v)->find();
				if($ruleres['level']!==0){
					if(!in_array($ruleres['pid'], $dataRule)){
						$dataRule[]=$ruleres['pid'];
						$dataRule=$this->dataRule($dataRule);
					}
				}
			}
		return $dataRule;
	}

	
}