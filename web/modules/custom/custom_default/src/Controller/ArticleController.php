<?php
namespace Drupal\custom_default\Controller;
class ArticleController
{
	public function page()
	{
		$items=array(
		array('title'=>'one'),
		array('title'=>'two'),
		array('title'=>'three'),
		);
		return array(
		'#theme'=>'article_list',
		'#items'=>$items,
		'#title'=>'article list'
		);
	}
}

?>
