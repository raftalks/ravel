<?php 

class MediaModel extends EloquentBaseModel
{

	protected 		$table 			='medias';
	protected	 	$fillable 		= array(
										'media_type',
										'path',
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
			'title'				=> 'required'

		);

	protected $softDelete = false;

	

}