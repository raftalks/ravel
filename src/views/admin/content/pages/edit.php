<?php

echo Xform::make('div',function($form)
{

	$form->box_panel(trans('ravel::content.update_page'),function($form)
	{

		$form->div(function($div)
		{
			$div->text('title',trans('ravel::content.title'))->ng_model('item.title','ng-model')->class('large-input');

			$div->textarea('excerpt',trans('ravel::content.excerpt'))->ng_model('item.excerpt','ng-model')->class('excerpt-textarea');

			$div->textarea('content',trans('ravel::content.content'))->ng_model('item.content','ng-model')->class('content-textarea')->ckeditor('','ck-editor');;

			$customfields = Config::get('ravel::content.custom_fields.page');
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

				//status of the page
				$div->select('status',trans('ravel::content.status'))->options($options)->ng_model('item.status','ng-model');
				

				//author name can be set to display any name
				$div->text('author',trans('ravel::content.show_author_as'))->ng_model('item.author_name','ng-model');



				//allow comments submission to this page				
				$div->fieldset(function($div)
				{
					$div->legend(trans('ravel::content.comment_settings'));

					$div->checkbox('allow_comments')->ng_model('item.allow_comments','ng-model')
						->ng_checked('item.allow_comments','ng-checked');
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

					$div->checkbox('locked_content')->ng_model('item.content_locked','ng-model')
						->ng_checked('item.content_locked','ng-checked');
					$div->span(trans('ravel::content.enable'));

					$div->div(function($div)
					{
						$div->password('content_password',trans('ravel::content.content_locked'))->ng_model('item.content_password');
						$div->setRootAttr('ng-show','item.content_locked');
					});

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
				$div->button(trans('ravel::form.delete'))->class('button')->ng_click('delete()','ng-click');

				$div->setClass('column-panel');
			});

			$div->setClass('column span4');
		});

		$form->div()->class('clear');

		
	});

});
