<?php

class KOSController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            array('BanFilter'),
            array('VerifyFilter'),
            array('IPLogFilter'),
        );
    }

    public function accessRules()
    {
        return array(
        );
    }

    public function actionIndex()
    {
        $kos = KOS::model()->with(array(
            'reports' => array(
                'order' => 'date DESC',
            ),
        ))->findAll(array(
            'order' => 'status DESC, ign ASC',
        ));
        $this->render('index',array('kos' => $kos));
    }

    public function actionAdd()
    {
        $model = new KOSForm;
        if(!empty($_POST['KOSForm']))
        {
            $model->attributes=$_POST['KOSForm'];
            if($model->validate() && $model->save())
            {
                $this->redirect(array('kos/view','unique' => $model->ign));
            }
        }

        $this->render('add',array('model' => $model));
    }

    public function actionView($unique)
    {
        $this->layout = '//layouts/userColumn';
        $this->menu = array(
            array('label' => 'Return to List', 'url' => array('kos/index')),
            array('label' => 'Add a Report', 'url' => array('kos/add')),
        );
        $kos = KOS::model()->with('reports')->findByAttributes(array('ign' => $unique));
        $this->columnData = array('name' => $kos->ign);
        $this->render('view',array('kos' => $kos));
    }
}