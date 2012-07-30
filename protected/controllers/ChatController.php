<?php

class ChatController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','new','post','ping'),
				'users' => array('@'),
			),
			array('deny',
				'actions'=>array('index','new','post','ping'),
				'users'=>array('*')
			),
		);
	}

	public function actionIndex()
	{

	}
}