<?php

class CouncilFilter extends CFilter
{
	protected function preFilter($chain)
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		if(!$user || ($user->rank != 'COMMANDER' && $user->rank != 'HEAD' && $user->rank != 'COUNCIL')) throw new CHttpException(403,"You may not view this page.");
		return true;
	}
	protected function postFilter($chain)
	{

	}
}