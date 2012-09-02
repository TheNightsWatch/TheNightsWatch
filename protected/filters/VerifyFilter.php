<?php

class VerifyFilter extends CFilter
{
	protected function preFilter($chain)
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		if($user && !$user->verified) Yii::app()->getController()->redirect(array('site/verify'));
		return true;
	}
	protected function postFilter($chain)
	{

	}
}