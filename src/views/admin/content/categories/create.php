<?php

echo Xform::make(function($form) use($ravel_list_layouts, $ravel_item_layouts)
{
	$form->share('ravel_item_layouts',$ravel_item_layouts);
	$form->share('ravel_list_layouts',$ravel_list_layouts);

	$form->box_panel(trans('ravel::content.new_category'),function($form)
	{
		
		$form->div(function($form)
		{
			$form->div(function($form)
			{
				$form->div(function($form)
				{

					$form->div(function($form)
					{

						$form->input_text('name',
											trans('ravel::content.category_name'),
											null,
											array('required'=>true,'ng-model'=>'item.name'));

						$ravel_item_layouts = $form->get('ravel_item_layouts');
						$ravel_list_layouts = $form->get('ravel_list_layouts');
						
						$form->select('list_layout',trans('ravel::content.list_layout'))->options($ravel_list_layouts,null)->ng_model('item.list_layout','ng-model');

						$form->select('item_layout',trans('ravel::content.item_layout'))->options($ravel_item_layouts,null)->ng_model('item.item_layout','ng-model');


						$form->setClass('span6');
					});

					$form->setClass('span12');
				});


				$form->setClass('row-fluid');
			});
			
			$form->setClass('column span8');
			
		});	

		$form->div(function($div)
		{
			$div->div(function($div)
			{
				$div->button(trans('ravel::form.save'))->class('button')->ng_click('submit()','ng-click');
				$div->button(trans('ravel::form.cancel'))->class('button')->ng_click('cancel()','ng-click');

				$div->setClass('column-panel');
			});

			$div->setClass('column span4');
		});

		$form->div()->class('clear');

	});

	$form->setRootAttr('ng-submit','save()');	
});

?>

</div>
	
