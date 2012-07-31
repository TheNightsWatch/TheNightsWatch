<?php

class User extends CActiveRecord
{
	const TYPE_RANGER = 'RANGER';
	const TYPE_MAESTER = 'MAESTER';
	
	private $regex = array(
		'donorLevel' => '/Showing stats for:.*\[([^]]+)\]/',
		'zombieRecord' => '/<b>Zombie Kill Count \(Record\):[^\d]+(\d+)/',
		'zombieCurrent' => '/<b>Zombie Kill Count \(Current\):[^\d]+(\d+)/',
		'lastOnline' => '/Last Online Date:[^p]*(\d{4}-\d{2}-\d{2} \d+:\d{2}:\d{2} AM|PM [^<]+)/',
		'serverJoin' => '/Server Join Date:[^p]*(\d{4}-\d{2}-\d{2} \d+:\d{2}:\d{2} AM|PM [^<]+)/',
	);
	
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
	
	public static function getHead($unique, $size = 16, $withHelm = true)
	{
		$part = $withHelm ? 'helm' : 'head';
		return "http://www.minotar.net/{$part}/".urlencode($unique)."/{$size}.png";
	}
	
	public function headUrl($size = 16, $withHelm = true)
	{
		return self::getHead($this->ign,$size,$withHelm);
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