<?php

class Election extends ActiveRecord
{
	private $winner = null;
	
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
		return Election::model()->findAll('startTime <= NOW() AND endTime > NOW()');
	}
	
	public static function countAllOngoing()
	{
		return Election::model()->count('startTime <= NOW() AND endTime > NOW()');
	}
	
	public function __get($var)
	{
		if($var == 'winner') return $this->_getWinner();
		return parent::__get($var);
	}
	
	/**
	 * @return User
	 */
	private function _getWinner()
	{
		if($this->winner === null)
		{
			$voteCounts = array();
			foreach($this->votes as $vote)
			{
				if(!isset($voteCounts[$vote->candidateID])) $voteCounts[$vote->candidateID] = 0;
				$voteCounts[$vote->candidateID]++;
			}
			
			$maxID = null;
			$maxCt = 0;
			foreach($voteCounts as $id => $count)
			{
				if($count > $maxCt)
				{
					$maxID = $id;
					$maxCt = $count;
				}
			}
			$this->winner = User::model()->findByPk($maxID);
		}
		return $this->winner;
	}
}