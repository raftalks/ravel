<?php 

class Media extends EloquentBaseModel
{

	protected 		$table 			='modules';
	protected	 	$fillable 		= array('module');

	protected $softDelete = true;

	

}