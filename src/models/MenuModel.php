<?php 

class MenuModel extends EloquentBaseModel
{
	protected $table = 'menus';

	protected $fillable = array('name','lang');



	public function Links()
	{
		return $this->belongsTo('LinkModel','menu_id');
	}
	
}