<?php

class UserController extends Controller
{
	public function actionIndex()
	{
		$this->setPageTitle('Member List');
		$brothers = User::model()->findAllByAttributes(array('deserter' => 'NO'));
		$this->render('index',array('users' => $brothers));
	}
	
	public function actionHead($unique,$size = 16)
	{
		$this->redirect(User::getHead($unique,$size),true,301);
	}
	
	private function capeBailOrUser($user)
	{
	    $user = User::model()->findByAttributes(array('ign' => $user));
	    if(!$user)
	    {
	    	throw new CHttpException(404,"No Such User");
	    }
	    if($user->deserter != 'LEFT')
	    {
	    	throw new CHttpException(404,"No Longer a Member");
	    }
	    return $user;
	}
	
	public function actionCapeHead($unique)
	{
        $this->capeBailOrUser($unique);
    	header("HTTP/1.1 200 OK");
    	Yii::app()->end();
	}
	
	public function actionCape($unique)
	{
	    $user = $this->capeBailOrUser($unique);
		Yii::app()->session->close();
		header("Content-Type: image/png");
		$file = "";
		if($user->deserter == 'DESERTER') $file = 'deserter-cape';
		elseif($user->rank == 'COMMANDER') $file = 'commander-cape';
		elseif($user->rank == 'HEAD' && $user->type == 'RANGER') $file = 'firstRanger-cape';
		elseif($user->rank == 'HEAD' && $user->type == 'MAESTER') $file = 'grandMaester-cape';
		elseif($user->type == 'RANGER') $file = 'ranger-cape';
		elseif($user->type == 'MAESTER') $file = 'maester-cape';
		echo file_get_contents(Yii::app()->basePath."/data/{$file}.png");
		Yii::app()->end();
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
		if($user->deserter != 'NO')
		{
			if($user->deserter == 'LEFT') $verbbed = 'left';
			else $verbbed = 'deserted';
			throw new CHttpException(410,"{$user->ign} has {$verbbed} the Night's Watch.");
		}
		
		$this->setPageTitle($user->ign);
		
		Yii::app()->clientScript->registerLinkTag('shortcut icon','image/png',$user->headUrl(16));
		
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
