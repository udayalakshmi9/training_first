<?php
namespace Drupal\custom_user\Controller;
class CustomuserController
{
	public function content($user)
	{
		$users=array('1'=>
		array('id'=>1,'username'=>'udaya'),
		'2'=>array('id'=>2,'username'=>'udaya two'),
		'3'=>array('id'=>3,'username'=>'udaya three')
		);
		
		
	if(in_array($user, $users[$user]))
	{
		return array(
		'#theme'=>'user_list',
		'#users'=>$users[$user],
		'#title'=>$users[$user]['username']
		);
	}
	}
}

?>