<?php

class UserProfileForm extends CFormModel
{
    public $reddit;
    public $skype;
    public $email;
    public $profession;

    public $user = null;

    public static function withUser($user)
    {
        $model = new self;
        if(is_int($user) > 0) $user = User::model()->findByPk($user);
        $model->user = $user;
        $model->profession = $user->type;
        if($user->socialProfile)
        {
            $model->reddit = $user->socialProfile->reddit;
            $model->skype = $user->socialProfile->skype;
        }
        if($user->settings)
        {
            $model->email = $user->settings->email;
        } else {
            $model->email = true;
        }
        return $model;
    }

    public function rules()
    {
        return array(
            array('email','boolean'),
            array('reddit, skype','length','min' => 1, 'allowEmpty' => true),
            array('profession','in','range'=>array(User::TYPE_MAESTER,User::TYPE_RANGER,User::TYPE_BUILDER)),
        );
    }

    public function save()
    {
        // On the User Model
        $this->user->type = $this->profession;

        // On the User Social Profile Model
        if($this->user->socialProfile == null)
        {
            $this->user->socialProfile = new SocialProfile;
            $this->user->socialProfile->userID = $this->user->id;
        }

        if(!empty($this->reddit))
            $this->user->socialProfile->reddit = $this->reddit;
        else
            $this->user->socialProfile->reddit = NULL;

        if(!empty($this->skype))
            $this->user->socialProfile->skype = $this->skype;
        else
            $this->user->socialProfile->skype = NULL;

        // On the User Settings Model
        if($this->user->settings == null)
        {
            $this->user->settings = new UserSetting;
            $this->user->settings->userID = $this->user->id;
        }
        $this->user->settings->email = $this->email;

        // Saves
        return ($this->user->socialProfile->save() && $this->user->save() && $this->user->settings->save());
    }
}