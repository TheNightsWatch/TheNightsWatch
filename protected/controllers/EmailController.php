<?php 

class EmailController extends Controller
{
    public function filters()
    {
        return array('accessControl',array('BanFilter'));
    }
    
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('view'),
                'users'=>array('@'),
            ),
            array('deny',
                'actions'=>array('view'),
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionView($id)
    {
        $model = Email::model()->findByPk($id);
        if(!$model) throw new CHttpException(404,"No Such Email");
        $this->render('view',array('model' => $model));
    }
}