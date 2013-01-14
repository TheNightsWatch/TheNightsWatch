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
            array('candidateID', 'equalToOrLessThanLimit'),
        );
    }

    // Ongoing Validator
    public function ongoing($attribute,$opts)
    {
        $election = $this->getElection();
        $start = $election->startTime->getTimestamp();
        $end = $election->endTime->getTimestamp();
        $now = time();
        if($now >= $start && $now < $end) return;
        $this->addError('electionID','Not a currently running election');
    }

    // Running validator
    public function running($attribute,$opts)
    {
        $election = $this->getElection();
        $availableCandidates = array();

        if($election->winnerCount == 1)
            $selectedCandidates = array($this->candidateID);
        else
            $selectedCandidates = $this->candidateID;

        foreach($election->candidates as $candidate)
        {
            $availableCandidates[] = $candidate->userID;
        }
        foreach($selectedCandidates as $candidate)
        {
            if(!in_array($candidate,$availableCandidates))
            {
                $this->addError('candidateID','Not one of the running candidates');
                return;
            }
        }
    }

    // Not too many validator
    public function equalToOrLessThanLimit($attribute,$opts)
    {
        $candidates = $this->candidateID;
        if(!is_array($candidates))
            $candidates = array($candidates);

        if(count($candidates) > $this->getElection()->winnerCount)
            $this->addError('candidateID','Too many candidates selected');
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
        $votes = ElectionVote::model()->findAllByAttributes(array(
            'electionID' => $election->id,
            'voterID' => $user->id,
        ));

        foreach($votes as $vote)
        {
            $self->voted = true;
            if($self->getElection()->winnerCount > 1)
                $self->candidateID[] = $vote->candidateID;
            else
                $self->candidateID = $vote->candidateID;
            $self->candidate = $vote->candidate;
        }

        return $self;
    }

    /**
     * @return array:int
     */
    public function getCandidateArray()
    {
        if(is_array($this->candidateID)) return $this->candidateID;
        else return array($this->candidateID);
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