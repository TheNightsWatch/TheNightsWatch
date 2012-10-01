<?php 

class ForgotForm extends CFormModel
{
    public $mojang;
    public $minecraftPassword;
    public $password;
    public $password2;
    public $rememberMe;
    public $ign = null;

    public function rules()
    {
        return array(
            array('mojang, password, password2, minecraftPassword','required'),
            array('rememberMe', 'boolean'),
            array('minecraftPassword','validateMinecraft'),
            array('ign','validateExists'),
            array('password2','compare','compareAttribute'=>'password'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'mojang' => 'Minecraft Login',
            'password' => 'New Password',
            'password2' => 'Repeat New Password',
        );
    }

    public function validateExists($attribute,$params)
    {
        $user = User::model()->findByAttributes(array('ign' => $this->ign));
        if($this->ign != null && ($user == null || $user->password == null))
        {
            $this->addError('mojang','You have not registered.');
        }
    }

    public function validateMinecraft($attribute,$params)
    {
        try {
            $api = new MinecraftAPI($this->mojang,$this->minecraftPassword);
            $this->ign = $api->username;
        } catch(MinecraftBadLoginException $e) {
            $this->addError('mojang','Wrong Minecraft username or password.');
        } catch(MinecraftMigrationException $e) {
            $this->addError('mojang','Please enter your Mojang account username and password.');
        } catch(MinecraftBasicException $e) {
            $this->addError('mojang','You do not have a premium Minecraft account.  You will be unable to use this website.');
        }
    }

    public function changePassword()
    {
        try {
            $user = User::model()->findByAttributes(array('ign' => $this->ign));
            $user->setPassword($this->password);
            if(!$user->verified)
            {
                $user->verified = true;
                $user->joinDate = new CDbExpression('NOW()');
            }
            $user->save();
        } catch(Exception $e) {
            return false;
        }
        $ident = new UserIdentity($this->ign,$this->password);
        $ident->forceLogin();
        $duration = $this->rememberMe ? 3600*24*30 : 0;
        Yii::app()->user->login($ident,$duration);
        return true;
    }
}