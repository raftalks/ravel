<?php 

class ContentModel extends EloquentBaseModel
{
	protected $table = 'contents';

	protected $softDelete = true;

	protected $fillable = array('lang',
								'author_id',
								'author_name',
								'content_type',
								'content_mime_type',
								'title',
								'slug',
								'content',
								'excerpt',
								'status',
								'allow_comments',
								'comment_end',
								'content_locked',
								'content_password',
								'parent_id',
								'comment_count',
								'publish_date');

	protected $validation_rules = array(

			'title' 		=> 'required',
			'content'		=> 'required'

		);


	public function setPublishDateAttribute($date)
	{
		$timestamp = strtotime($date);
		$new_date = date("Y-m-d H:i:s", $timestamp);
		$this->attributes['publish_date'] = $new_date;
	}

	public function setContentPasswordAttribute($password)
	{
		$password = is_null($password) ? null : Hash::make($password);
		$this->attributes['content_password'] = $password;
	}


	public function contentmetas()
	{
		return $this->hasMany('Contentmeta','content_id');
	}


	public function author()
	{
		return $this->belongsTo('Usermodel','author_id');
	}


	public function comments()
	{
		return $this->hasMany('Comment');
	}



	/**
	 * Returns Posts related categories
	 * @return object CategoryModel
	 */
	public function categories()
	{	
		return $this->belongsToMany('CategoryModel','category_content','content_id','category_id');	
	}
	
}