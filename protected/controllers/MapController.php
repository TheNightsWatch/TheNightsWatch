<?php 

class MapController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            array(
                'BanFilter + view',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('view','download'),
                'users' => array('@'),
            ),
            array('deny',
                'actions'=>array('view','download'),
                'users'=>array('*')
            ),
        );
    }
    public function actionView()
    {
        $this->layout = '//layouts/blank';
        $this->render('index');
    }
    public function actionDownload($path)
    {
        Yii::app()->session->close();
        // This should only be called for 404s.  It downloads the corresponding image from MineZ
        // and then adds it to our file structure.
        $ourFiles = Yii::app()->basePath . '/../external/map/MineZ/';
        $pathArray = explode("/",$path);
        $file = array_pop($pathArray);
        $url = "http://minez.net/map/MineZ/{$path}";

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 2,
            ),
        ));
        $contents = @file_get_contents($url,false,$context);
        if($contents)
        {
            mkdir($ourFiles . implode("/",$pathArray),0775,true);
            file_put_contents($ourFiles . implode("/",$pathArray) . "/" . $file,$contents);
            $this->refresh(true);
        } else {
            $this->redirect($url,true,302);
        }
    }
}