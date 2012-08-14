<?php

class PremiumFilter extends CFilter
{
	protected function preFilter($chain)
	{
	    if(Yii::app()->user->isGuest) return false;
		$user = User::model()->findByPk(Yii::app()->user->getId());
		$url = "http://minecraft.net/haspaid.jsp?user=" . urlencode($user->ign);
		$data = file_get_contents($url);
		
		if($data == "true") return true;
		
		return false;
	}
	protected function postFilter($chain)
	{

	}
}