<?php 

class MapController extends Controller
{
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
            header("HTTP/1.1 404 NOT FOUND");
            Yii::app()->end();
        }
    }
}