<?php
namespace app\admin\validate;
use think\validate;
class Link extends validate
{
	protected $rule=[
		'title'=>'require|max:20|unique:link',
		'url'=>'url|unique:link',
		'desc'=>'require',
	];

	protected $message=[
		'title.max'=>'标题不能超过20个字',
		'title.unique'=>'标题名称不得重复！',
		'url.url'=>'链接格式不正确！',
		'url.unique'=>'链接不能重复！'
	];

	protected $scenc=[
		'add'=>['title'=>'require|unique:link|max:20','url','desc'],
	];




}