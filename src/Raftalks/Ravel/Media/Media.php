<?php namespace Raftalks\Ravel\Media;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Raftalks\Ravel\ServiceModel;
use Config;
use MediaModel;
use Image;

class Media extends ServiceModel
{
	protected $mediaTypes;

	protected $maxFileSize;

	protected $mediaStoragePath;

	protected $uploadPath = null;

	protected $thumbnailSize = array();

	protected $uploadFieldName = 'file';

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
			
			$this->mediaStoragePath = $findPath;
		}

		return $this->mediaStoragePath; 
	}



	private function thumbnailSize()
	{
		return array(
				'h' => Config::get('ravel::media.image_thumb_with'),
				'w' => Config::get('ravel::media.image_thumb_height'),
				'p'	=> Config::get('ravel::media.thumb_proportionate')
			);
	}

	private function mediumSizes()
	{
		return array(
				'h' => Config::get('ravel::media.medium_image_width'),
				'w' => Config::get('ravel::media.medium_image_height'),
				'p'	=> Config::get('ravel::media.medium_image_proportionate')
			);
	}




	private function mediaModel()
	{
		return new MediaModel();
	}


	public function insert($data, $callback=null)
	{
		$collection_id = (int)$data['collection_id'];
		
		if(isset($data[$this->uploadFieldName]))
		{
			$this->prepareMediaData($data);

			//check if media already exists
			if($this->mediaNotExists($data))
			{
				return parent::insert($data, $callback);
			} else
			{
				$this->mediaUpload($data);
			}
			
		}
		else
		{
			throw new Exception("No File Submitted", 406);
		}
		
	}

	protected function mediaNotExists($data)
	{
		$model = $this->model()->newInstance();
		$count = $model->where('media_type','=',$data['media_type'])
				->where('path','=',$data['path'])
				->where('file_name','=',$data['file_name'])
				->count();
		if($count > 0)
		{
			return false;
		}

		return true;
	}


	protected function afterInsert($model, $data)
	{
		$this->mediaUpload($data);
	}

	protected function beforeSave($model, $data)
	{
		//$this->mediaUpload($model, $data);
	}


	protected function prepareMediaData(&$data)
	{
		$file = $data[$this->uploadFieldName];
		if($file instanceof UploadedFile)
		{
			$subDirName = $data['collection_id'];
			$filename = $file->getClientOriginalName();
			$mediaType = $this->getMediaType($file);
			$uploadPath = $this->getUploadPath();

			$publicPath = app()->make('path.public');
			
			$path = $uploadPath . '/'.$subDirName.'/';

			$url = str_replace($publicPath, '', $path);

			$data['file_name'] = str_replace(' ','_', $filename);
			$data['media_type'] = $mediaType;
			$data['path'] = $path;
			$data['url'] = $url;
			$data['sub_dir'] = $subDirName;
			$data['user_id'] = $this->getAuthorId();
			$data['mcollection_id'] = $data['collection_id'];

		} else
		{
			throw new Exception("Invalid File Object", 406);
		}
	}


	/**
	 * Upload media files to the storage page
	 * @param  object $model 
	 * @param  array $data  form data
	 * @return boolean        
	 */
	protected function mediaUpload($data)
	{
		if(isset($data[$this->uploadFieldName]))
		{
			$file = $data[$this->uploadFieldName];
			$thumbFile = $data[$this->uploadFieldName];

			$pathToPublic = app()->make('path.public');

			$uploadPath = $this->getUploadPath();
			$sub_dir = $data['sub_dir'];
			$uploadRealPath = $data['path'];
			$filename = $data['file_name'];

			$thumb_path = $uploadRealPath . '/thumbs/';
			$thumb_filename = 'thumb_'.$filename;


			$origImagePath = $uploadRealPath . $filename;
			$thumbImgePath = $thumb_path.$thumb_filename;

			$targetFile = $file->move($uploadRealPath, $filename);
			
			if($data['media_type'] == 'image')
			{
				//create thumb dir if not exist
				if( ! app('files')->isDirectory($thumb_path))
				{
					app('files')->makeDirectory($thumb_path);
				}

				//copy source file to thumb dir
				app('files')->copy($origImagePath, $thumbImgePath);
					
				$ts = $this->thumbnailSize();

				$img = Image::make( $thumbImgePath)
						->resize($ts['w'],$ts['h'],$ts['p'])
						->save();


				$mediumImgUploadPath = $uploadRealPath . '/medium/';

				//create medium images dir if not exist
				if( ! app('files')->isDirectory($mediumImgUploadPath))
				{
					app('files')->makeDirectory($mediumImgUploadPath);
				}

				app('files')->copy($origImagePath, $mediumImgUploadPath . $filename);

				$ms = $this->mediumSizes();

				Image::make($mediumImgUploadPath . $filename)
						->resize($ms['w'],$ms['h'],$ms['p'])
						->save();

			}
			
			
		}
	}



	



	protected function mediaRemove($path)
	{

	}


	public function getUploadPath()
	{
		$storagePath = $this->mediaStorage();

		$username = $this->getAuthorName();

		return $storagePath . '/' . $username;
	}


	public function thumbWidth()
	{
		return $this->thumbnailSize['w'];
	}

	public function thumbHeight()
	{
		return $this->thumbnailSize['h'];
	}



	public function getMediaType($file)
	{
		$extension = $file->getClientOriginalExtension();
		
		$mediaTypes = Config::get('ravel::media.media_types');

		$mediaType = null;
		foreach($mediaTypes as $type => $validExts)
		{
			if(in_array($extension, $validExts))
			{
				$mediaType = $type;
				break;
			}
		}

		if(!is_null($mediaType))
		{
			return $mediaType;
		} else
		{
			return 'file';
		}
	}



}