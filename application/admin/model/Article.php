<?php
namespace app\admin\model;
use think\Model;

class Article extends Model
{
	protected static function init()
	{
		Article::event('before_insert',function($data){
			if($_FILES['thumb']['tmp_name']){
				$file=request()->file('thumb');
				$info=$file->move(ROOT_PATH.'public'.DS.'uploads');
				// dump($info);die;
				if($info){
					$thumb='/uploads/'.$info->getSaveName();
					$data['thumb']=$thumb;
				}
			}
		});

		Article::event('before_delete',function($data){
			$res=Article::find($data->id);
			$thumbpath=$_SERVER['DOCUMENT_ROOT'].$res['thumb'];
			if(file_exists($thumbpath)){
                	@unlink($thumbpath);
                }
		});

		Article::event('before_update',function($data){
			if($_FILES['thumb']['tmp_name']){
				$artres=Article::find($data->id);
				$thumbpath=$_SERVER['DOCUMENT_ROOT'].$artres['thumb'];
				if(file_exists($thumbpath)){
                	@unlink($thumbpath);
                }
                $file=request()->file('thumb');
				$info=$file->move(ROOT_PATH.'public'.DS.'uploads');
				// dump($info);die;
				if($info){
					$thumb='/uploads/'.$info->getSaveName();
					$data['thumb']=$thumb;
				}
			}
		});
	}
}