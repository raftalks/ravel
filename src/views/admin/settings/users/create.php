<?php

echo Xform::make(function($form) use($usergroups, $errors)
{
	// $usrgroups = array();
	// foreach($usergroups as $group)
	// {
	// 	$id = $group->id;
	// 	$usrgroups[$id] = $group->group;
	// }

	//$form->share('user',$user);

	$form->share('usergroups',$usergroups);

	$form->share_errors($errors);


	$form->box_panel(trans('ravel::user.new_user_form_legend'),function($form)
	{
		
		$form->div(function($form)
		{
			$form->div(function($form)
			{
				$form->div(function($form)
				{

					$form->div(function($form)
					{
						//columnA
						$user = $form->get('user');
						$form->input_text('username',
											trans('ravel::user.username'),
											is_null($user) ? Input::old("username") : $user->username,
											array('required'=>true,'ng-model'=>'item.username'));

						$form->input_text('email',
											trans('ravel::user.email'),
											is_null($user) ? Input::old("email") : $user->email,
											array('required'=>true, 'ng-model'=>'item.email'));

						$usergroups = $form->get('usergroups');
						$selectedUsergroup = is_null($user) ? Input::old("usergroup_id") : $user->usergroup_id;//is_null(Input::get("usergroup_id")) ? Input::old("usergroup_id") : Input::get("usergroup_id");

						$form->select('usergroup_id',trans('ravel::user.usergroup'))->options($usergroups, $selectedUsergroup)->ng_model('item.usergroup_id','ng-model')->ui_select2(null,'ui-select2');

						

						$form->setClass('span6');
					});

					$form->div(function($form)
					{
						//columnB
						
							$form->input_password('password',
											trans('ravel::user.password'),
											array('ng-model'=>'item.password'));


							$form->input_password('password_confirmation',
											trans('ravel::user.confirmpassword'),
											array('ng-model'=>'item.password_confirmation'));


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
	
