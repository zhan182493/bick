<?php
namespace app\index\controller;
use app\index\model\Article;
use app\index\controller\Common;

class Artlist extends Common
{
	
	public function artlist(){
		$cateRes=db('cate')->find(input('cateid'));
		$hotRes=db('article')->order('click desc')->limit(5)->select();
		$this->assign('hotRes',$hotRes);
		$this->assign('cateRes',$cateRes);
		
		return view();	
	}

}