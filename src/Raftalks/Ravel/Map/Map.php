<?php

namespace Raftalks\Ravel\Map;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Raftalks\Ravel\ServiceModel;
use Config;
use MediaModel;
use Image;
use McollectionMedia;
use MapModel;

class Map extends ServiceModel {

    public function setup() {
        $this->model = app('MapModel');
    }

    public function fetch($page = 1, $take = 10, $callback = null) {

        if (is_null($callback)) {
            $callback = function(&$model, $host) {
                        //$model = $model->mycollections();
                    };
        }

        $result = parent::fetch($page, $take, $callback);
        
        return $result;
    }

}