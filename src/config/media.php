<?php

return array(

	'media_types'			=> array(
								'image' 		=> array('jpg','bmp','png'),
								'archive' 		=> array('zip','rar','7z','tar','tar.gz','gzip'),
								'document'		=> array('docx','doc','pdf'),
								'video'			=> array('mp4','mpeg','mov','avi','flv'),
								'file'			=> array('txt','xml')
								),

	'max_file_size'			=> 10, //in mb

	'media_storage_path'	=> 'uploads/ravel',


	//medium Image Size
	'medium_image_width'			=> 600, //pixels
	'medium_image_height'   		=> 400,
	'medium_image_proportionate'	=> true,



	//thumb Image Size
	'image_thumb_width'				=> 100, // in px
	'image_thumb_height'			=> 100, // in px
	'thumb_proportionate'			=> true

);