<?php
namespace app\index\controller;
use app\index\controller\Common;
use app\index\model\Article as ArticleModel;

class Article extends Common
{
	public function article(){
		// dump(input('artid'));die;
		db('article')->where('id',input('artid'))->setInc('click');
		$artRes=db('article')->find(input('artid'));
		$hotArt=db('article')->order('click desc')->limit(6)->select();
		$this->assign('hotArt',$hotArt);
		$this->assign('artRes',$artRes);
		return view();
	}
	
}