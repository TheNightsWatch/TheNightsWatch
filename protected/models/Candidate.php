<?php

class Candidate extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'election_candidate';
	}
	
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
			'election' => array(self::BELONGS_TO, 'Election', 'electionID'),
			'votes' => array(self::HAS_MANY, 'ElectionVote', 'candidateID', 'condition' => 'relationName.electionID = electionID'),
		);
	}
}