<?php

class IPLogFilter extends CFilter
{
	protected function preFilter($chain)
	{
		$request = Yii::app()->request->getRequestUri();
		$uid = Yii::app()->user->isGuest ? NULL : Yii::app()->user->getId();
		$ip = Yii::app()->request->getUserHostAddress();
		$now = new CDbExpression('NOW()');

		$log = new LogActivity;
		$log->attributes = array(
		    'uid' => $uid,
		    'uri' => $request,
		    'ip' => $ip,
		    'time' => $now,
	    );
		$log->save();
		
		return true;
	}
	protected function postFilter($chain)
	{

	}
}