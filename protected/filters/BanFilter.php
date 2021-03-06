<?php

class BanFilter extends CFilter
{
	protected function preFilter($chain)
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		if($user && ($user->deserter != User::DESERTER_NO && $user->deserter != User::DESERTER_ADMIN)) throw new CHttpException(403,"You may not view this page as you have left or deserted the Watch.");
		return true;
	}
	protected function postFilter($chain)
	{

	}
}
