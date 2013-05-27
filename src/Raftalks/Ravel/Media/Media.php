<?php namespace Raftalks\Ravel\Media;

use Raftalks\Ravel\ServiceModel;
use Config;
use MediaModel;

class Media extends ServiceModel
{
	protected $mediaTypes;

	protected $maxFileSize;

	protected $mediaStoragePath;

	protected $uploadPath = null;

	protected $thumbnailSize = array();

	protected function setup()
	{
		$this->model = $this->mediaModel();
		$this->mediaTypes = $this->mediaTypes();
		$this->maxFileSize = $this->mediaStorage();
		$this->mediaStoragePath = $this->mediaStorage();
		$this->thumbnailSize = $this->thumbnailSize();
	}


	private function mediaTypes()
	{
		return Config::get('ravel::media.media_types');
	}

	private function mediaMaxFileSize()
	{
		return Config::get('ravel::media.max_file_size');
	}

	private function mediaStorage()
	{
		if(is_null($this->mediaStoragePath))
		{
			$publicPath = app()->make('path.public');
			$ConfigUploadPath = Config::get('ravel::media.media_storage_path');

			$dirs = explode('/', $ConfigUploadPath);
			$findPath = $publicPath;
			$filesCreated = false;
			foreach($dirs as $dir)
			{
				if(!is_null($dir))
				{
					$findPath = $findPath . '/' . $dir;
					
				}
			}

			$this->uploadPath = $findPath;
		}

		return $this->mediaStoragePath;
		 
	}

	private function thumbnailSize()
	{
		return array(
				'h' => Config::get('ravel::media.image_thumb_with'),
				'w' => Config::get('ravel::media.image_thumb_height')
			);
	}

	private function mediaModel()
	{
		return new MediaModel();
	}


	protected function beforeInsert($model, $data)
	{
		$this->mediaUpload($model, $data);
	}

	protected function beforeSave($model, $data)
	{
		$this->mediaUpload($model, $data);
	}



	protected function mediaUpload($model, $data)
	{

	}

	protected function mediaRemove($path)
	{

	}


	public function uploadPath()
	{
		return action("MediaUploadApiController@index");	
	}


	public function thumbWidth()
	{
		return $this->thumbnailSize['w'];
	}

	public function thumbHeight()
	{
		return $this->thumbnailSize['h'];
	}



}