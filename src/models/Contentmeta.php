<?php 

class Contentmeta extends EloquentBaseModel
{
	protected $table = 'contentmetas';

	protected $fillable = array('content_id','metakey','metavalue');

	public $timestamps = false;


	public function Content()
	{
		return $this->belongsTo('ContentModel','content_id');
	}
	
}