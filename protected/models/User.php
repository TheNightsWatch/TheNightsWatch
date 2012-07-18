<?php

class User extends CActiveRecord
{
	const TYPE_RANGER = 'RANGER';
	const TYPE_MAESTER = 'MAESTER';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user';
	}
	
	public function relations()
	{
		return array(
			'socialProfile' => array(self::HAS_ONE, 'SocialProfile', 'userID'),
		);
	}
	
	public function rules()
	{
		return array(
			array('joinDate','default','value'=>new CDbExpression('NOW()'),'on'=>'insert'),
		);
	}
	
	public function __get($var)
	{
		switch($var)
		{
			case 'title':
				return $this->_getTitle();
				
			case 'type':
				return (parent::__get('type') == null ? 'Member' : parent::__get('type'));
				
			default:
				return parent::__get($var);
		}
	}
	
	private function _getTitle()
	{
		switch($this->rank)
		{
			case 'COMMANDER':
				return 'Lord Commander';
			case 'COUNCIL':
				return 'Council Member';
			case 'HEAD':
				if($this->type == 'MAESTER') return 'Grand Maester';
				return 'Head ' . ucfirst(strtolower($this->type));
			default:
				return ucfirst(strtolower($this->type));
		}
	}
	
	public function headUrl($size = 16, $withHelm = true)
	{
		$part = $withHelm ? 'helm' : 'head';
		return "http://www.minotar.net/{$part}/".urlencode($this->ign)."/{$size}.png";
	}

	public function setPassword($password)
	{
		$bcrypt = new Bcrypt(15);
		$hash = $bcrypt->hash($password);
		$this->password = $hash;
	}
	
	public function updateLastLogin()
	{
		$this->lastLogin = new CDbExpression('NOW()');
		if(!$this->save()) throw new Exception('Couldn\'t save?');
	}
}