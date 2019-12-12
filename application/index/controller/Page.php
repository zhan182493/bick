<?php
namespace app\index\controller;
use app\index\controller\Common;

class Page extends Common
{
	public function page(){
		$pageArt=db('cate')->find(input('cateid'));
		$this->assign('pageArt',$pageArt);
		return view();
	}
}