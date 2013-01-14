<?php

class ElectionVote extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'election_vote';
	}
	
	public function relations()
	{
		return array(
			'candidate' => array(self::BELONGS_TO, 'Candidate', array('candidateID' => 'userID')),
			'election' => array(self::BELONGS_TO, 'Election', 'electionID'),
			'voter' => array(self::BELONGS_TO, 'User', 'voterID'),
		);
	}
}