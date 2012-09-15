<?php

class IPLogFilter extends CFilter
{
	protected function preFilter($chain)
	{
	    return true;
	}
	public function postFilter($chain)
	{
	    $request = Yii::app()->request->getRequestUri();
	    $uid = Yii::app()->user->isGuest ? NULL : Yii::app()->user->getId();
	    $ip = Yii::app()->request->getUserHostAddress();
	    
	    $log = new LogActivity;
	    $log->attributes = array(
	    		'uid' => $uid,
	    		'uri' => $request,
	    		'ip' => $ip,
	    );
	    $log->save();
	}
}