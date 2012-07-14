<?php

class UserController extends Controller
{	
	public function actionIndex()
	{
		$brothers = User::model()->findAll();
		$this->render('index',array('users' => $brothers));
	}
	
	public function actionHead($unique,$refresh = false)
	{
		$head = imagecreatetruecolor(16,16);
		imagealphablending($head,false);
		imagesavealpha($head,true);
		$data = @file_get_contents("http://s3.amazonaws.com/MinecraftSkins/".urlencode($unique).".png");
		if($data)
		{
			$skin = imagecreatefromstring($data);
			imagesavealpha($skin,true);
			imagealphablending($skin,false);
		
			imagecopyresampled($head,$skin,0,0,8,8,16,16,8,8);
		}
		header("Content-Type: image/png");
		imagepng($head);
	}
	
	public function actionView($unique)
	{
		$user = User::model()->findByAttributes(array('ign' => $unique));
		if(!$user)
		{
			$this->layout = '//layouts/column1';
			$this->render('notAMember',array('name' => $unique));
			return;
		}
		
		$this->layout = '//layouts/userColumn';
		
		$this->columnData['name'] = $user->ign;
		
		$this->menu[] = array(
			'label' => 'MineZ Profile',
			'url' => 'http://www.minez.net/?action=playersearch&player=' . urlencode($user->ign),
		);
		
		if($user->socialProfile && $user->socialProfile->reddit) $this->menu[] = array(
			'label' => 'Reddit Profile',
			'url' => 'http://www.reddit.com/user/' . urlencode($user->socialProfile->reddit),
		);
		
		if($user->socialProfile && $user->socialProfile->skype) $this->menu[] = array(
			'label' => 'Skype Profile',
			'url' => 'skype:' . urlencode($user->socialProfile->skype) . '?userinfo',
		);
		
		$this->render('view',array(
			'user' => $user,
		));
	}
}