<?php 

return array(

	'types' => array('post','page','attachement'),

	'status'	=> array('draft','submitted','published'),


	'custom_fields' => array(

			//'example'
			//'post'		=> array(
							// 		"{metakey}" => array('label'=>'{name}','type'=>'{text}', 'attr'=>array(), 'options'=>array())
							// )

			'post'			=> array(
								'somefield' => array('label'=>'custom field','type'=>'text'),
								'custom_field3' => array('label'=>'custom field','type'=>'ng_datepicker'),
								'custom_field2' => array('label'=>'custom field2','type'=>'select','options'=>array(1=>'test',2=>'two',3=>'three',4=>'foour'))
								),

			'page'			=> array(
								'somefield' => array('label'=>'custom field','type'=>'input_text'),
							),

			'attachement'	=> array(),

		),

);