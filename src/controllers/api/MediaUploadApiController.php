<?php

class MediaUploadApiController extends ResourceApiBase {

    protected $moduleName = 'Medias';

    protected function setupResources() {
        $this->resource = app('Media');
    }

    /**
     * POST Create new Resource
     */
    public function store() {
        $data = Input::all();

        $respond = $this->resource->insert($data);

        if (is_bool($respond) && !$respond) {
            $errors = $this->resource->getErrors();
            $status = $this->resource->getResponseStatus();
            return $this->errorResponse($errors, 400);
        }
        return Response::json(json_encode($respond), 200);
    }

}