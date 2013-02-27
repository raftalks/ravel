@include('ravel::layouts.admin.partials.header')
<body id="login">	
	<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<h1>Ravel CMS Admin</h1>
				<!-- Logo (221px width) -->
				<img id="logo" src="<?php echo admin_asset('admin/images/ravelcmslogo.png');?>" alt="Ravel CMS" />
			</div> 

			@yield('appcontainer')	
	</div> <!-- End #login-wrapper -->
		
</body>
</html>
