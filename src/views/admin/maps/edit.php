<?php

//maps/create

echo Form::make('div',function($form)
{
	//$form->share('categories', $post_categories);

	$form->box_panel(trans('ravel::map.create_map'),function($form)
	{

		$form->div(function($div)
		{
			$div->div(function($div)
			{

        			$div->text('title',trans('ravel::map.title'))->ng_model('item.title','ng-model')->class('large-input');
        			$div->text('latitude',trans('ravel::map.latitude'))->ng_model('item.latitude','ng-model')->class('large-input');
        			$div->text('longitude',trans('ravel::map.longitude'))->ng_model('item.longitude','ng-model')->class('large-input');
				$div->ng_datepicker('publish_date',trans('ravel::map.publish_date'),'item.publish_date');

				$options = array(
					'draft' 	=> 'Draft',
					'Submitted'	=> 'Submitted'
				);

				if(is_moderator())
				{
					$options['published'] = 'published';
				}

				//status of the post
				$div->select('status',trans('ravel::content.status'))->options($options)->ng_model('item.status','ng-model');
				

				$div->button(trans('ravel::content.save'))->class('button')->ng_click('submit()','ng-click');
				$div->button(trans('ravel::content.cancel'))->class('button')->ng_click('cancel()','ng-click');

				$div->setClass('well');
			});

			$div->setClass('column span3');
		});

		$form->div()->class('clear');

		
	});

});

