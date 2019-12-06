<?php
namespace app\index\controller;
use app\index\controller\Common;
use app\index\model\Article as ArticleModel;

class Article extends Common
{
	public function article(){
		dump(input('artid'));die;
		$artRes=db('article')->find(input('artid'));
		$this->assign('artRes',$artRes);
		return view();
	}
	
}