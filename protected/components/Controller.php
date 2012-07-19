<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $columnData=array();

	private $_pageTitle = null;

	public function setPageTitle($string = null)
	{
		$this->_pageTitle = ($string !== null ? $string . ' - ' : '') . Yii::app()->name;
	}
	
	public function clearPageTitle()
	{
		$this->setPageTitle(null);
	}

	public function getPageTitle()
	{
		if($this->_pageTitle !== null)
			return $this->_pageTitle;
		else
		{
			$name=ucfirst(basename($this->getId()));
			if($this->getAction()!==null && strcasecmp($this->getAction()->getId(),$this->defaultAction))
				return $this->_pageTitle=ucfirst($this->getAction()->getId()).' '.$name.' - '.Yii::app()->name;
			else
				return $this->_pageTitle=$name.' - '.Yii::app()->name;
		}
	}
	
	public function jsonOut($array,$status = 200)
	{
		header("Content-Type: application/json");
		echo json_encode($array);
		Yii::app()->end($status);
	}
}