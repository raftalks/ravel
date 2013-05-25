<?php

class Comment extends EloquentBaseModel
{

	protected $table='comments';

	protected $fillable = array();

	protected $softDelete = true;

	public function content()
	{
		return $this->belongsTo('ContentModel','content_id');
	}

}