@extends('ravel::layouts.admin.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Account Login
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>Login into your account</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />

	<!-- Username -->
	<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
		<label class="control-label" for="username">Username</label>
		<div class="controls">
			<input type="text" name="username" id="username" value="{{ Input::old('username') }}" />
			{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ email -->

	<!-- Password -->
	<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
		<label class="control-label" for="password">Password</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ password -->

        <!-- Remember Me -->
	<div class="control-group {{ $errors->has('remember') ? 'error' : '' }}">
		<label class="control-label" for="remember">Remember Me</label>
		<div class="controls">
			<input type="checkbox" name="remember" id="remember-password" value="" />
			{{ $errors->first('remember', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ Remember Me -->

	<!-- Login button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Login</button>
		</div>
	</div>
	<!-- ./ login button -->
</form>
@stop
