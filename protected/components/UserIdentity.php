<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_NO_PASSWORD = 3;
	const ERROR_DESERTION = 4;
	
	private $_id = null;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('ign' => $this->username));
		
		// User doesn't exist
		if($user === null)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			return !$this->errorCode;
		}
		
		// User left or deserted
		if($user->deserter != 'NO')
		{
			$this->errorCode = self::ERROR_DESERTION;
			return !$this->errorCode;
		}
		
		// No Password
		if($user->password === null)
		{
			$this->errorCode = self::ERROR_NO_PASSWORD;
			return !$this->errorCode;
		}
		
		// Wrong Password
		$bcrypt = new Bcrypt(15);
		if(!$bcrypt->verify($this->password,$user->password))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			return !$this->errorCode;
		}

		$this->_id = $user->id;
		$this->errorCode = self::ERROR_NONE;
		return !$this->errorCode;
	}
	
	public function getID()
	{
		return $this->_id;
	}
}