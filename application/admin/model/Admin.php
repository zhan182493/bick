<?php
namespace app\admin\model;
use app\admin\model\Common;

class Admin extends Common
{
	public function adminedit($data,$id){
		
		if(!$data['password']){
			if(db('admin')->where('id',$id)->update(array('username'=>$data['username']))!==false){
				return 1;
			}else{
				return 3;
			}
		}else{
			// dump(1);die;
			$data['password']=md5($data['password']);
			if(db('admin')->where('id',$id)->update(array('username'=>$data['username'],
				'password'=>$data['password']
				))){
				return 1;
			}else{
				return 3;
			}
		}
	}
}