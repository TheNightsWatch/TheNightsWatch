<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    public function filters()
    {
        return array(
            'accessControl',
            array(
                'BanFilter + profile, KOS, magicDownload, modDownload, mods',
            ),
            array(
                'VerifyFilter + profile, KOS, magicDownload, modDownload, mods',
            ),
            array(
                'IPLogFilter'
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('profile','KOS','modDownload','mods','verify'),
                'users' => array('@'),
            ),
            array('deny',
                'actions'=>array('profile','KOS','modDownload','mods','verify'),
                'users'=>array('*')
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->clearPageTitle();

        $last15 = User::model()->findAll(array(
            'condition' => 'deserter = :desertion AND verified=1',
            'params' => array('desertion' => 'NO'),
            'order' => 'IF(rank != \'MEMBER\',1,0) DESC, IF(rank = \'COMMANDER\',1,0) DESC, id DESC',
            'limit' => 15
        ));

        for($i = 0;$i < 5;++$i)
        {
            $temp = array_shift($last15);
            if($temp->rank == 'MEMBER')
            {
                array_unshift($last15,$temp);
                continue;
            }
            array_push($last15,$temp);
        }

        $this->render('index',array(
            'last15' => $last15,
        ));
    }

    public function actionRules()
    {
        $this->render('rules');
    }

    public function actionMods()
    {
        $this->render('mods');
    }

    public function actionMagicDownload()
    {
        Yii::app()->session->close();
        if(file_exists(Yii::app()->basePath.'/data/magicLauncher.zip'))
        {
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=TWN_Windows.zip");
            echo file_get_contents(Yii::app()->basePath.'/data/magicLauncher.zip');
            die();
        }
        throw new CHttpException(404,"Minecraft Modification does not exist.");
    }
    
    public function actionModDownload()
    {
        /*
         * This actively filters out non-logged in users, banned users, and non-premium users.
        *
        * Unfortunately, we can't verify that the person they've claimed is their own minecraft account.
        *
        * Well, fuck.
        */
        Yii::app()->session->close();
        if(file_exists(Yii::app()->basePath.'/data/minecraft.jar'))
        {
            header("Content-Type: application/java-archive");
            header("Content-Disposition: attachment; filename=minecraft.jar");
            echo file_get_contents(Yii::app()->basePath.'/data/minecraft.jar');
            die();
        }
        throw new CHttpException(404,"Minecraft Modification does not exist.");
    }

    public function actionProfile()
    {
        $user = User::model()->findByPk(Yii::app()->user->getId());
        $model = UserProfileForm::withUser($user);

        if(isset($_POST['UserProfileForm']))
        {
            $model->attributes=$_POST['UserProfileForm'];
            if($user->rank != User::RANK_MEMBER) $model->profession = $user->type;
            if($model->validate() && $model->save())
            {
                Yii::app()->user->setFlash('profile','Your profile has been updated.');
                $this->refresh();
            }
        }
         
        $this->render('profile',array('model' => $model, 'user' => $user));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $headers="From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(!Yii::app()->user->isGuest) $this->redirect(array('site/index'));

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
            {
                $user = User::model()->findByAttributes(array('ign' => $model->username));
                $user->updateLastLogin();
                if($user->verified)
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect(array('site/verify'));
            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    public function actionRegister()
    {
        $model=new RegisterForm;

        if(isset($_POST['ajax']) && $_POST['ajax']=='register-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(!Yii::app()->user->isGuest) $this->redirect(array('site/index'));

        if(isset($_POST['RegisterForm']))
        {
            $model->attributes=$_POST['RegisterForm'];
            if($model->validate() && $model->register())
            {
                $user = User::model()->findByAttributes(array('ign' => $model->ign));
                $user->updateLastLogin();
                if($user->verified)
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect(array('site/verify'));
            }
        }

        $this->render('register',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Connects the user to Teamspeak
     */
    public function actionTeamspeak()
    {
        $this->render('teamspeak',array('teamspeak' => 'ts3server://ts.tundrasofangmar.net?port=9991&channel=The Night\'s Watch'));
    }

    public function actionKOS()
    {
        $this->redirect(Yii::app()->params['kos'],301);
    }

    public function actionForgot()
    {
        $model = new ForgotForm();
        if(isset($_POST['ForgotForm']))
        {
            $model->attributes = $_POST['ForgotForm'];
            if($model->validate() && $model->changePassword())
            {
                $user = User::model()->findByAttributes(array('ign' => $model->ign));
                $user->updateLastLogin();
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('forgot',array('model' => $model));
    }

    public function actionVerify()
    {
        if(!empty($_POST))
        {
            try {
                $api = new MinecraftAPI($_POST['user'],$_POST['pass']);
                $user = User::model()->findByPk(Yii::app()->user->getId());
                if(strtolower($user->ign) == strtolower($api->username))
                {
                    $user->ign = $api->username;
                    if(!$user->verified)
                    {
                        $user->joinDate = new CDbExpression('NOW()');
                        $user->lastLogin = new CDbExpression('NOW()');
                    }
                    $user->verified = true;
                    $user->save();
                    Yii::app()->user->setFlash('verify','Your Minecraft account has been verified.');
                }
                Yii::app()->user->setFlash('verify_error','The account you attempted to verify with does not match your IGN.');
            } catch(MinecraftBadLoginException $e) {
                Yii::app()->user->setFlash('verify_error','Wrong username or password.');
            } catch(MinecraftMigrationException $e) {
                Yii::app()->user->setFlash('verify_error','Please enter your Mojang account username and password.');
            } catch(MinecraftBasicException $e) {
                Yii::app()->user->setFlash('verify_error','You do not have a premium Minecraft account.  You will be unable to use this website.');
            }
        }
        $this->render('verify');
    }
}
