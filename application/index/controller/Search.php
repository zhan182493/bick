<?php
namespace app\index\controller;
use app\index\controller\Common;

class Search extends Common
{
	public function search(){
		$keywords=input('keywords');
		if(input('keywords')){
			$searchRes=db('article')->where('title','like','%'.$keywords.'%')->paginate(5);
			// dump($searchRes);die;
			$this->assign(['searchRes'=>$searchRes,'keywords'=>$keywords]);
			
		}
		$hotRes=db('article')->order('click desc')->limit(5)->select();

			$this->assign('hotRes',$hotRes);
			$this->assign('keywords',$keywords);
			return view();
	}
}