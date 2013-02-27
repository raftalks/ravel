@section('appcontainer')

{{

	Form::make(function($form)
	{
		$form->text('test','Test');

	})
}}
<?php

if(isset($data))
{

	print_r($data);

}
?>
@stop