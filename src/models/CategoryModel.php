<?php 

class CategoryModel extends EloquentBaseModel
{
	protected $table = 'categories';

	protected $softDelete = true;

	protected $fillable = array('name',
								'list_layout',
								'item_layout',
								'lang');
	protected $hidden = array(
			'lang',
			'pivot'
		);

	protected $validation_rules = array(

			'name'				=> 'required',
			'list_layout' 		=> 'required',
			'item_layout'		=> 'required'

		);

	
}