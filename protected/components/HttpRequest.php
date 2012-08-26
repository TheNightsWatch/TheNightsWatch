<?php
class HttpRequest extends CHttpRequest  {
    public $noCsrfValidationRoutes = array();

    protected function normalizeRequest()
    {
        parent::normalizeRequest();
        $route = Yii::app()->getUrlManager()->parseUrl($this);
        if($this->enableCsrfValidation && false!==array_search($url, $this->noCsrfValidationRoutes))
            Yii::app()->detachEventHandler('onBeginRequest',array($this,'validateCsrfToken'));
    }
}