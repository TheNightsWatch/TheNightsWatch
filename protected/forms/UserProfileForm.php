<?php

class UserProfileForm extends CFormModel
{
    public $reddit;
    public $skype;
    public $email;

    public $user = null;

    public static function withUser($user)
    {
        $model = new self;
        if(is_int($user) > 0) $user = User::model()->findByPk($user);
        $model->user = $user;
        if($user->socialProfile)
        {
            $model->reddit = $user->socialProfile->reddit;
            $model->skype = $user->socialProfile->skype;
        }
        return $model;
    }

    public function rules()
    {
        return array(
            array('email','boolean'),
            array('reddit, skype','safe'),
        );
    }
    
    public function save()
    {
        if($this->user->socialProfile == null)
        {
            $this->user->socialProfile = new SocialProfile;
            $this->user->socialProfile->userID = $this->user->id;
        }
        $this->user->socialProfile->reddit = $this->reddit;
        $this->user->socialProfile->skype = $this->skype;
        return $this->user->socialProfile->save();
    }
}