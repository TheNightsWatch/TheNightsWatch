<?php

class RegisterForm extends CFormModel
{
	public $ign;
	public $password;
	public $password2;
	public $email;
	public $rememberMe;
	public $type;
	
	private $_ident = null;
	
	public function rules()
	{
		return array(
			array('ign, password, password2, email, type','required'),
			array('rememberMe','boolean'),
			array('password2','compare','compareAttribute' => 'password'),
			array('ign','uniqueOrNull'),
			array('type','in','range'=>array(User::TYPE_MAESTER,User::TYPE_RANGER)),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
			'password2' =>'Re-type Password',
			'ign' => 'In Game Name',
		);
	}
	
	public function uniqueOrNull($attribute,$params)
	{
		if($this->hasErrors()) return;
		$user = User::model()->findByAttributes(array('ign' => $this->ign));
		if($user !== null && $user->password !== null)
		{
			// First, attempt login.
			$this->_ident = new UserIdentity($this->ign,$this->password);
			$this->_ident->authenticate();
			if($this->_ident->errorCode===UserIdentity::ERROR_NONE)
			{
				// Then this is okay.
			} else {
				$this->addError('ign','This user is already registered.');
			}
		}
	}
	
	public function register()
	{
		$user = User::model()->findByAttributes(array('ign'=>$this->ign));
		
		if($user != null && $this->_ident != null && $this->_ident->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*30 : 0;
			Yii::app()->user->login($this->_ident,$duration);
			return true;
		}
		
		if($user === null) $user = new User;
		
		$user->ign = $this->ign;
		$user->setPassword($this->password);
		$user->email = $this->email;
		$user->type = $this->type;
		return $user->save();
	}
}