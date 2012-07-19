<?php

class Election extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'election';
	}
	
	public function relations()
	{
		return array(
			'candidates' => array(self::HAS_MANY, 'Candidate', 'electionID'),
			'votes' => array(self::HAS_MANY, 'ElectionVote', 'electionID'),
		);
	}
	
	public static function findAllOngoing()
	{
		return Election::model()->findAll('startTime >= NOW() AND endTime < NOW()');
	}
	
	public static function countAllOngoing()
	{
		return Election::model()->count('startTime >= NOW() AND endTime < NOW()');
	}
}