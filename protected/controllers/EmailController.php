<?php 

class EmailController extends Controller
{
    public function actionView($id)
    {
        $this->redirect(array('announcement/view','id' => $id),true,301);
    }
}