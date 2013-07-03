<?php

class DashboardAdminController extends AdminController
{
	protected $title = "Dashboard";



	public function getIndex()
	{

		$data = array();
		$this->layout->nest('content','ravel::admin.dashboard.home',$data);
	}
        
        public function getDashboard() {
            $this->getIndex();
        }
}