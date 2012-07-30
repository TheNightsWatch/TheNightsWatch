<?php

class ElectionForm extends CFormModel
{
	public $electionID;
	public $candidateID;
	public $candidate;
	public $voted = false;
	
	private $_election = null;
	
	public function rules()
	{
		return array(
			array('electionID, candidateID', 'safe'),
			array('electionID', 'ongoing'),
			array('candidateID', 'running'),
		);
	}
	
	// Ongoing Validator
	public function ongoing($attribute,$opts)
	{
		$election = $this->getElection();
		$start = strtotime($election->startTime);
		$end = strtotime($election->endTime);
		$now = time();
		if($now >= $start && $now < $end) return;
		$this->addError('electionID','Not a currently running election');
	}
	
	// Running validator
	public function running($attribute,$opts)
	{
		$election = $this->getElection();
		foreach($election->candidates as $candidate)
		{
			if($candidate->userID == $this->candidateID) return;
		}
		$this->addError('candidateID','Not one of the running candidates');
	}
	
	/**
	 * @return ElectionForm
	 */
	public static function fromElection($election)
	{
		$self = new self();
		$self->_election = $election;
		$self->electionID = $election->id;
		
		$user = User::model()->findByPk(Yii::app()->user->getId());
		$vote = ElectionVote::model()->findByAttributes(array(
			'electionID' => $election->id,
			'voterID' => $user->id,
		));
		
		if($vote)
		{
			$self->voted = true;
			$self->candidateID = $vote->candidateID;
			$self->candidate = $vote->candidate;
		}
		
		return $self;
	}
	
	/**
	 * @return Election
	 */
	public function getElection()
	{
		if($this->_election === null)
			$this->_election = Election::model()->findByPk($this->electionID);
		
		return $this->_election;
	}
	
	public function getCandidateDropdownArray()
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		$array = array(null => '');
		foreach($this->getElection()->candidates as $candidate)
		{
			$array[$candidate->user->id] = $candidate->user->ign . ($user->rank == 'COMMANDER' ? ' (' . ElectionVote::model()->countByAttributes(array('candidateID' => $candidate->user->id, 'electionID' => $this->electionID)) . ')' : null);
		}
		return $array;
	}
}