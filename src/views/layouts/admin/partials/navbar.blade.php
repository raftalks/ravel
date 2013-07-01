@section('navbar')
<!-- layouts.partials.navbar -->
<div class="navbar navbar-fixed-top" style="-webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<div class="nav-collapse collapse">
				<ul class="nav">
					<li {{ (Request::is('/') ? 'class="active"' : '') }}><a href="{{ URL::to('') }}"><i class="icon-home"></i> Home</a></li>
				</ul>
				<ul class="nav">
					<li {{ (Request::is('/admin') ? 'class="active"' : '') }}><a href="{{ URL::to('/admin') }}"><i class="icon-th"></i> Dashboard</a></li>
				</ul>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Settings<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li {{ (Request::is('admin/settings/users/index') ? 'class="active"' : '') }}><a href="{{ URL::to('admin/settings/users/index') }}"><i class="icon-user"></i> Users</a></li>
						</ul>								
					</li>
				</ul>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Contents<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li {{ (Request::is('/admin/pages/index') ? 'class="active"' : '') }}><a href="{{ URL::to('/admin/pages/index') }}"><i class="icon-file"></i> Pages</a></li>
							<li {{ (Request::is('/admin/posts/index') ? 'class="active"' : '') }}><a href="{{ URL::to('/admin/posts/index') }}"><i class="icon-pencil"></i> Posts</a></li>
							<li {{ (Request::is('/admin/categories/index') ? 'class="active"' : '') }}><a href="{{ URL::to('/admin/categories/index') }}"><i class="icon-list"></i> Post Categories</a></li>
							<li {{ (Request::is('/admin/medias/index') ? 'class="active"' : '') }}><a href="{{ URL::to('/admin/medias/index') }}"><i class="icon-picture"></i> Media</a></li>
							<li {{ (Request::is('/admin/maps/index') ? 'class="active"' : '') }}><a href="{{ URL::to('/admin/maps/index') }}"><i class="icon-globe"></i> Maps</a></li>
						</ul>								
					</li>
				</ul>

				<ul class="nav pull-right">
					@if (Auth::check())
					<li class="navbar-text">Logged in as {{ Auth::user()->fullName() }}</li>
					<li class="divider-vertical"></li>
					<li {{ (Request::is('account') ? 'class="active"' : '') }}><a href="{{ URL::to('account') }}">Account</a></li>
					<li><a href="{{ URL::to('admin/logout') }}">Logout</a></li>
					@else
					<li {{ (Request::is('account/login') ? 'class="active"' : '') }}><a href="{{ URL::to('admin/login/index') }}">Login</a></li>
					{{-- <li {{ (Request::is('account/register') ? 'class="active"' : '') }}><a href="{{ URL::to('account/register') }}">Register</a></li> --}}
					@endif
				</ul>
			</div>
			<!-- ./ nav-collapse -->
		</div>
	</div>
</div>
<!-- ./ navbar -->
@stop