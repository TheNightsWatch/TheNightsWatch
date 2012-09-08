<?php

/**
 * @author Navarr
 * @property int id
 * @property string ign
 * @property string password
 * @property string email
 * @property string type
 * @property string rank
 * @property string deserter
 * @property string minezDonor
 * @property DateTime joinDate
 * @property DateTime lastLogin
 * @property boolean verified
 */
class User extends CActiveRecord
{
	const TYPE_RANGER = 'RANGER';
	const TYPE_MAESTER = 'MAESTER';
	const TYPE_BUILDER = 'BUILDER';
	const TYPE_STEWARD = 'STEWARD';
	
	const RANK_MEMBER = 'MEMBER';
	// First Builder, First Ranger, Grand Maester
	const RANK_HEAD = 'HEAD';
	// Council Member
	const RANK_COUNCIL = 'COUNCIL';
	// Lord Commander
	const RANK_COMMANDER = 'COMMANDER';
	
	// Status for whether or not they've left
	const DESERTER_NO = 'NO';
	const DESERTER_DESERTER = 'DESERTER';
	const DESERTER_LEFT = 'LEFT';
	const DESERTER_DISABLED = 'DISABLED';
	const DESERTER_ADMIN = 'ADMIN'; // MineZ Admins
	
	const DONOR_NO = 'NO';
	const DONOR_SILVER = 'SILVER';
	const DONOR_GOLD = 'GOLD';
	const DONOR_PLATINUM = 'PLATINUM';
	
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
		    'settings' => array(self::HAS_ONE, 'UserSetting', 'userID'),
			'socialProfile' => array(self::HAS_ONE, 'SocialProfile', 'userID'),
			'chatViews' => array(self::HAS_MANY, 'ChatView', 'userID'),
		    'location' => array(self::HAS_ONE, 'UserLocation', 'userID'),
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
				return 'First ' . ucfirst(strtolower($this->type));
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