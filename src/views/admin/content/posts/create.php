<?php

echo Form::make('div',function($form)
{
	//$form->share('categories', $post_categories);

	$form->box_panel(trans('ravel::content.create_post'),function($form)
	{

		$form->div(function($div)
		{
			$div->text('title',trans('ravel::content.title'))->ng_model('item.title','ng-model')->class('large-input');

			$div->textarea('excerpt',trans('ravel::content.excerpt'))->ng_model('item.excerpt','ng-model')->class('excerpt-textarea');

			$div->textarea('content',trans('ravel::content.content'))->ng_model('item.content','ng-model')->class('content-textarea')->ckeditor('editorSettings','ck-editor');;

			$customfields = Config::get('ravel::content.custom_fields.post');
			$div->ng_custom_fields($customfields);

			$div->setClass('column span8');
		});

		$form->div(function($div)
		{
			$div->div(function($div)
			{

				$div->ng_datepicker('publish_date',trans('ravel::content.publish_date'),'item.publish_date');

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
				

				//author name can be set to display any name
				$div->text('author',trans('ravel::content.show_author_as'))->ng_model('item.author_name','ng-model');



				//allow comments submission to this post				
				$div->fieldset(function($div)
				{
					$div->legend(trans('ravel::content.comment_settings'));

					$div->checkbox('allow_comments')->ng_model('item.allow_comments','ng-model');
					$div->span(trans('ravel::content.allow_comments'));

					$div->div(function($div)
					{
						$div->number('comment_end',trans('ravel::content.comment_submission_end'))->ng_model('item.comment_end','ng-model')->class('text-input very-small-input')->min(1);
						$div->span(trans('ravel::content.comment_days'));
						$div->setRootAttr('ng-show','item.allow_comments');
					});

				});


				$div->fieldset(function($div)
				{
					$div->legend(trans('ravel::content.security'));

					$div->checkbox('locked_content')->ng_model('item.locked_content','ng-model');
					$div->span(trans('ravel::content.enable'));

					$div->div(function($div)
					{
						$div->password('content_password',trans('ravel::content.content_locked'))->ng_model('item.content_password');
						$div->setRootAttr('ng-show','item.locked_content');
					});

				});


				$div->fieldset(function($div)
				{
					$div->setClass('fill-up');
					$div->legend(trans('ravel::content.post_categories'));

					$div->ng_multi_select('post_categories',null, 'item.categories','post_categories',array('class'=>'fill-up'));
					
				});
				

				$div->br();
				$div->hr();

				$div->div(function($div)
				{
					$div->span(trans('ravel::content.content_language'));
					$div->span(langflag(current_lang()));
				});


				$div->br();
				$div->br();

				$div->button(trans('ravel::content.save'))->class('button')->ng_click('submit()','ng-click');
				$div->button(trans('ravel::content.cancel'))->class('button')->ng_click('cancel()','ng-click');

				$div->setClass('well');
			});

			$div->setClass('column span3');
		});

		$form->div()->class('clear');

		
	});

});

