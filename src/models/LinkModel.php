<?php 

class LinkModel extends EloquentBaseModel
{
	protected $table = 'links';

	protected $fillable = array('menu_id','label','slug','content_type','content_id','weight','parent_id','publish');

	
}