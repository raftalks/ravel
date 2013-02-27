@include('ravel::layouts.admin.partials.header')
  
<body>

	<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		@include('ravel::layouts.admin.partials.sidebar')
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<div ng-show='nowloading' ><i class="icon-spinner icon-spin"></i></div>
			
			@yield('appcontainer')


			@include('ravel::layouts.admin.partials.scripts')
			
			@yield('javascripts')

			@include('ravel::layouts.admin.partials.footer')
			
		</div> <!-- End #main-content -->
		
	</div>

</body>
  
</html>
