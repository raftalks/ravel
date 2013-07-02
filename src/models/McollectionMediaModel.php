<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of McollectionMediaModel
 *
 * @author Victor
 */
class McollectionMedia extends EloquentBaseModel {
    
	protected $table = 'mcollection_media';

	protected $fillable = array('media_id', 'mcollection_id');

}

?>
