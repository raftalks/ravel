<?php 

class MediaModel extends EloquentBaseModel
{

	protected 		$table 			='medias';
	protected	 	$fillable 		= array(
										'mcollection_id',
										'media_type',
										'path',
										'url',
										'file_name',
										'user_id',
										'caption',
										'publish',
										'approved',
										'filedata',
										'keywords',
										'title'
									);

	protected $validation_rules = array(

			'media_type' 		=> 'required',
			'path'				=> 'required',
			'file_name'				=> 'required'

		);

	protected $softDelete = false;

	// public function collections()
	// {
	// 	return $this->belongsToMany('Mcollection');
	// }

	// public function contents()
	// {
	// 	return $this->belongsToMany('ContentModel');
	// }

	

}