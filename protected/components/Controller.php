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

	/**
	 * Sets the page title to "$string - App Name"
	 */
	public function setPageTitle($string = null)
	{
		$this->_pageTitle = ($string !== null ? $string . ' - ' : '') . Yii::app()->name;
	}

	/**
	 * Clears the page title
	 */
	public function clearPageTitle()
	{
		$this->setPageTitle(null);
	}

	/**
	 * Returns the page title
	 * @return string
	 */
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

	/**
	 * Output JSON Data instead of a View
	 *
	 * @param mixed $info Information to JSON Encode.
	 * @param int $status Status code to send.  Defaults to 200.
	 * @param boolean $end Whether or not to end the request.  Defaults to true.
	 */
	public function jsonOut($info,$status = 200,$end = true)
	{
	    if (isset($_GET['jsonp'])) {
	        header("Content-Type: application/javascript",true,$status);
	        echo $_GET['jsonp'].'('.CJSON::encode($info).');';
	    } else {
		    header("Content-Type: application/json",true,$status);
		    echo CJSON::encode($info);
		}
		Yii::app()->end(0,$end);
	}
}
