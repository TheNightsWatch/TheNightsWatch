<?php

class ChatForm extends CFormModel
{
	public $message;

	public function rules()
	{
		return array(
			array('message','required'),
			array('message','length','min'=>1),	
		);
	}
}