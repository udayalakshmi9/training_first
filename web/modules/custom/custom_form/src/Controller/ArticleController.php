<?php
namespace Drupal\custom_form\Controller;
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
