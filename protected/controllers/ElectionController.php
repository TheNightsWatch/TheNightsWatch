<?php

class ElectionController extends Controller
{
	public function actionIndex()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->render('../site/error',array('message' => 'You must be logged in to vote.'));
			return;
		}
		
		$elections = Election::model()->findAll('startTime <= NOW() AND endTime > NOW()');
		$user = User::model()->findByPk(Yii::app()->user->getId());
		
		foreach($elections as $k => $election)
		{
			$time = strtotime($election->startTime);
			$joinTime = strtotime($user->joinDate);
			if($joinTime > $time) unset($elections[$k]);
		}
		
		if(!count($elections))
		{
			$this->render('../site/error',array('message' => 'In order to prevent election fraud, you are unable to participate in elections that started before you joined the Watch'));
			return;
		}
		
		$model = new ElectionForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// if its an actual submission
		if(isset($_POST['ElectionForm']))
		{
			$model->attributes=$_POST['ElectionForm'];
			if($model->validate())
			{
				// First, set the vote.
				ElectionVote::model()->deleteAllByAttributes(array(
					'electionID' => $model->electionID,
					'voterID' => Yii::app()->user->getId(),
				));

				$vote = new ElectionVote;
				$vote->electionID = $model->electionID;
				$vote->candidateID = $model->candidateID;
				$vote->voterID = Yii::app()->user->getId();
				$success = $vote->save();

				if(isset($_POST['ajax']))
				{
					$this->jsonOut(array('success' => $success));
				}
			}
		}

		$this->setPageTitle('Current Elections');
		//$elections = Election::model()->findAll('startTime <= NOW() AND endTime > NOW()');
		$this->render('index',array('elections' => $elections));
	}
	
	public function actionResults()
	{
		$elections = Election::model()->findAll(array('condition' => 'endTime <= NOW()', 'order' => 'endTime DESC'));
		
		$this->setPageTitle('Election Results');
		$this->render('result',array('elections' => $elections));
	}
}