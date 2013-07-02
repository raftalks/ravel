<?php

use Raftalks\Ravel\Map\Map;

class MapsApiController extends ResourceApiBase {

	protected $moduleName = 'Maps';
	protected $resource = null;

	protected function setupResources() {
            $this->resource = new Map;
        }


}