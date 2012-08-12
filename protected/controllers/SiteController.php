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
                'BanFilter + profile',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('profile'),
                'users' => array('@'),
            ),
            array('deny',
                'actions'=>array('profile'),
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
            'condition' => 'deserter = :desertion',
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

    public function actionProfile()
    {
        $user = User::model()->findByPk(Yii::app()->user->getId());
        $model = UserProfileForm::withUser($user);
        
        if(isset($_POST['UserProfileForm']))
        {
        	$model->attributes=$_POST['UserProfileForm'];
        	if($model->validate() && $model->save())
        	{
        		Yii::app()->user->setFlash('profile','Your profile has been updated.');
        		$this->refresh();
        	}
        }
         
        $this->render('profile',array('model' => $model));
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
                $this->redirect(Yii::app()->user->returnUrl);
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
                $this->redirect(Yii::app()->user->returnUrl);
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
        $this->redirect('ts3server://ts.tundrasofangmar.net?port=9991',301);
    }
}