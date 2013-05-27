<?php namespace Raftalks\Ravel\Content;

use Raftalks\Ravel\ServiceModel;
use Config;
use Str;

abstract class Content extends ServiceModel
{

	protected $useContentCategories = false;

	protected $contentType = null;


	public function __construct()
	{
		parent::__construct();

		if(is_null($this->contentType))
		{
			$this->contentType = $this->contentTypes[0];
		}
	}


	protected function setup()
	{
		$this->model = $this->ContentModel();
		$this->contentTypes = $this->ContentTypes();
		
	}



	private function ContentTypes()
	{
		return Config::get('ravel::content.types');
	}



	public function getContentType()
	{
		return $this->contentType;
	}



	public function show($id, $callback = null)
	{

		if(is_null($callback))
		{
			$callback = function(&$model, $host)
			{
				$model = $model->where('content_type','=',$host->getContentType())
						->where('lang','=',$host->getLocale())
						->with(array('contentmetas','categories'));

				if($host->is_guest())
				{
					$model = $model->where('status','=','published');
				} else
				{
					if(!$host->is_moderator())
					{
						$model = $model->where('author_id','=',$host->getAuthorId());
					}
				}
			};
		}

		$item = parent::show($id, $callback);
		
		if($item)
		{
			$this->prepareContentItem($item);
		}
		

		return $item;

	}


	// public function edit($id, $callback = null)
	// {
		
	// 		if(is_null($callback))
	// 		{
	// 			$callback = function(&$model, $host)
	// 			{
	// 				if(!$host->is_moderator())
	// 				{
	// 					$model = $model->where('author_id','=',$host->getAuthorId());
	// 				}

	// 				$model = $model->where('content_type','=',$host->getContentType())
	// 					->with(array('contentmetas','categories'));

	// 				return $model;
	// 			};
	// 		}

	// 		return parent::edit($id, $callback);
		
	// }



	public function fetch($page = 1, $take=10, $callback=null)
	{

		if(is_null($callback))
		{
			$callback = function(&$model,$host)
			{
				
				$model = $model->with(array(
						'contentmetas',
						'categories',
						'author'	=> function($query)
						{
							$query->select('users.id','users.username');
						}
					))->where(function($query) use($host)
					{
						$query->where('content_type','=', $host->getContentType())
							  ->where('lang','=',$host->getLocale());

						if($host->is_guest())
						{
							
							$dateTime = new \DateTime;
							$now = $dateTime->format('Y-m-d H:i:s');

							// $query->where('status','=','published');
							$query->where('publish_date','<',$now);
							$query->where('status','=','published');
						} else
						{
							if(! $host->is_moderator())
							{
								//fetch only content belongs to user
								$query->where('author_id','=',$host->getAuthorId());
							}
							
							
						}
					});

			};
						
		}

		$result = parent::fetch($page, $take, $callback);
		if($result)
		{
			$host = $this;
			$result->each(function($item) use ($host)
			{
				$host->prepareContentItem($item);
			});

		}
		
		return $result;

	}




	public function getMyContents($callback = null)
	{
		$author_id = $this->getAuthorId();
		$model = $this->model();
		$host = $this;
		return $model->with(array('contentmeta'))
					->where(function($query) use($host, $callback)
					{
							if(is_closure($callback))
							{
								$callback($query, $host);
							}

							$query->where('author_id','=',$author_id);

					})->get();

	}


    /**
     * Returns content pending for moderator review
     * 
     * @access public
     *
     * @return mixed Value.
     */
	public function getContentSubmitted()
	{
		if($this->is_moderator())
		{
			return $this->get(function($query)
			{
				$query->where('status','=','submitted');
			});
		}
		else
		{
			$this->addErrorMessage('Action restricted',403);
		}

		return false;
	}


	protected function getFilteredMetaContent($data)
	{

		$type = strtolower($this->contentType);
		$customFields = Config::get('ravel::content.custom_fields.'.$type, array());
		$metaKeys = array_keys($customFields);
		$meta_data = array_intersect_key($data, array_flip($metaKeys));

		$rows = array();
		foreach($meta_data as $metakey => $metavalue)
		{
			$rows[] = array(
					"metakey"	=> $metakey,
					'metavalue'	=> $metavalue
				);
		}

		return $rows;
	}


	public function makeSlug($title, $count = 0, $checkedSlug=null)
	{
		if($count)
		{
			$affix_title = $title.' '.$count;
			$slug = Str::slug($affix_title);
		}
		else
		{
			$slug = Str::slug($title);
		}
		
		if($this->checkSlugExist($slug))
		{
			$count++;
			$slug = $this->makeSlug($title, $count);

		}
		
		return $slug;
		
	}
	

	function checkSlugExist($slug)
	{
		$content_type = strtolower($this->getContentType());

		$queryModel = $this->model()->newInstance();
		$result = $queryModel->where('slug','=',$slug)->where('content_type','=',$content_type)->get(array('id'));
		if($result->count())
		{
			return true;
		}

		return false;
	}



	public function insert($data, $callback=null)
	{
		if(is_null($callback))
		{
			$callback = function(&$model, $host)
			{
				$model->content_type = $host->getContentType();
				$model->author_id = $host->getAuthorId();
				$model->slug = $host->makeSlug($model->title);
				$model->lang = $host->getLocale();
				return $model;
			};
		}

		return parent::insert($data, $callback);
		
	}



	protected function afterInsert($model, $data)
	{
		$this->saveContentMeta($data, $model);
		$this->saveContentCategories($data, $model);
	}



	protected function saveContentMeta($data, $model)
	{
		$meta_data = $this->getFilteredMetaContent($data);
		if(count($meta_data))
		{
			$cid = $model->id;
			foreach($meta_data as $row)
			{
				$row['content_type'] = $this->getContentType();
				$meta = $model->contentmetas()
							->where('content_id','=',$cid)
							->where('content_type','=',$row['content_type'])
							->where('metakey','=',$row['metakey'])
							->first();

				if(is_null($meta))
				{
					$meta = new \Contentmeta($row);
					$model->contentmetas()->save($meta);
				}
				else
				{
					$meta->fill($row)->save();
				}

			}
			
		}
		
	}



	public function saveContentCategories($data, $model)
	{
		if($this->contentUseCategories())
		{
			if(isset($data['categories']))
			{
				$model->categories()->sync($data['categories']);	
			}
		}
		
	}


	public function save($data, $id, $callback=null)
	{

		if(is_null($callback))
		{
			
			$callback = function(&$model, $host)
			{
				$model->content_type = $host->getContentType();
				$current_title = $model->title;
				$original_title = $model->getOriginal('title');
				if($original_title !== $current_title)
				{
					$model->slug = $host->makeSlug($model->title);
				}
				return $model;
			};
		}

		return parent::save($data, $id, $callback);

	}

	protected function afterSave($model, $data)
	{
		$this->saveContentMeta($data, $model);
		$this->saveContentCategories($data, $model);
	}



	public function contentUseCategories()
	{
		return $this->useContentCategories === true;
	}


	public function prepareContentItem(&$item)
	{
		if(isset($item->contentmetas))
		{
			$customFields = $item->contentmetas;
			foreach($customFields as $citem)
			{
				$fieldname = $citem['metakey'];
				$value = $citem['metavalue'];
				$item->$fieldname = $value;
			}
			unset($item->contentmetas);
		}
		
		
		if($this->contentUseCategories())
		{

			$categories = $item->categories;
			//set only category ids
			$selectedCats = array();
			foreach($categories as $cat)
			{
				$selectedCats[] = $cat['id'];
			}
			unset($item->categories);
			$item->categories = $selectedCats;
		}
	}

	

	// public function insertComment($data, $content_id)
	// {
	// 	$this->comment->insert($data, $content_id);
	// }



	// public function updateComment($data, $id)
	// {
	// 	$this->comment->update($data, $id);
	// }




	// public function deleteComment($id)
	// {

	// 	$this->comment->delete($id);
	// }




	// public function getMedias($content_id)
	// {

	// 	$content = $this->show($content_id);
	// 	return $content->medias()->get();
	// }



	// public function insertMedia($data, $content_id)
	// {

	// 	$content = $this->show($content_id);
	// 	return $content->medias()->insert($data);
	// }




	// public function updateMedia($data, $id, $content_id)
	// {
	// 	$media = $this->model()->find($content_id)->medias()->find($id);
	// 	$media->fill($data);
	// 	return $media->save();
	// }



	// public function deleteMedia($id, $content_id)
	// {
	// 	$media = $this->model()->find($content_id)->medias()->find($id);
	// 	$media->delete();
	// }



	/**
	 * Sets the Model
	 * @return object Content Model
	 */
	abstract function ContentModel();


}