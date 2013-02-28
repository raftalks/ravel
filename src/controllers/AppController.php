<?php

class AppController extends RavelBaseController
{

	protected $title = '';

	protected $moduleName = 'Global';


	//overide baseController method to include title in the layout
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);

			$this->layout->title = $this->title;
		}
	}


}