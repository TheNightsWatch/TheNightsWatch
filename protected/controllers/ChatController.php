<?php

class ChatController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
			array(
				'BanFilter',
			),
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','view','new','post','ping'),
				'users' => array('@'),
			),
			array('deny',
				'actions'=>array('index','view','new','post','ping'),
				'users'=>array('*')
			),
		);
	}

	public function actionIndex()
	{
		// Until we actually make a multi-room system.
		$this->actionView('lobby');
	}

	public function actionView($room = 'lobby')
	{
		$messages = ChatMessage::model()->with('user')->findAllByAttributes(array('room' => $room),array(
			'condition' => 'timestamp > NOW()-60*60*6',
			'limit' => 10,
		));

		$this->render('index',array(
			'messages' => $messages,
		));
	}

	public function actionNew($since,$room = 'lobby')
	{
		$messages = ChatMessage::model()->with('user')->findAllByAttributes(array('room' => $room),'id > :since',array('since' => $since));
		$output = array();
		foreach($messages as $message)
		{
			$output[] = array(
				'id' => $message->id,
				'message' => $message->message,
				'user' => array(
					'id' => $message->user->id,
					'ign' => $message->user->ign,
					'type' => $message->user->type,
					'rank' => $message->user->rank,
				),
			);
		}
		$this->jsonOut($output);
	}
	
	public function actionPing($room = 'lobby')
	{
		$this->jsonOut('Not Supported',501);
	}

	public function actionPost($room = 'lobby')
	{
		$model = new ChatForm;
		if(isset($_POST['ChatForm']))
		{
			$model->attributes=$_POST['ChatForm'];
			if($model->validate())
			{
				$message = new ChatMessage;
				$message->userID = Yii::app()->user->getId();
				$message->message = $model->message;
				$message->room = $room;
				$success = $message->save();
				if(Yii::app()->request->isAjaxRequest) $this->jsonOut(array(
					'success' => $success,
					'message' => $success ? $message : null,
					'csrf' => array(
						'name' => Yii::app()->request->csrfTokenName,
						'value' => Yii::app()->request->csrfToken,
					),
				));
			}
		}
		$this->redirect(array('chat/index'));
	}
}