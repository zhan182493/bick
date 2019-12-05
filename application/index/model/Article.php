<?php
namespace app\index\model;
use think\Model;
use app\index\model\Cate;

class Article extends Model
{
	public function getAllArticles($cateid){
		$cate=new Cate();
		$allCateId=$cate->getchilrenid($cateid);
		$allArticles=$this->where('cateid IN($allCateId)')->paginate(6);
	}
}