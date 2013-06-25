@section('appcontainer')
@section('appcontainer')
{{ 
	Xform::make('div',function($div)
	{
		$div->form(function($form)
		{

			$form->p(function($p){
				$p->text('username','Username');
			});

			$form->div()->class('clear');

			$form->p(function($p){
				$p->password('password','Password');
			});

			$form->div()->class('clear');

			$form->p(function($p){
				$p->checkbox('remember');
				$p->span('Remember me');
				$p->setId('remember-password');
			});

			$form->div()->class('clear');

			$form->p(function($p)
			{
				$p->submit('submit')->class('button')->value('Sign In');
			});

			$form->setAction(action('AdminUserLoginController@postIndex'));
			$form->setMethod('POST');
		});

		$div->setId('login-content');

	});

}}
@stop