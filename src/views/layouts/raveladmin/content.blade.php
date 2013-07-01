@include('ravel::layouts.raveladmin.partials.header')

@include('ravel::layouts.raveladmin.partials.sidebar')
	
<noscript> <!-- Show a notification if the user has disabled javascript -->
	<div class="notification error png_bg">
		<div>
			Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
		</div>
	</div>
</noscript>



<div id='app_panel'>
	<div class="container-fluid">
		<div class="row-fluid">
		  <div class="span10">
		  <h3>CONTENT LAYOUT</h3>
		  		@yield('appcontainer')
		  </div>
		</div>

	</div>
</div>


	

	@include('ravel::layouts.admin.partials.scripts')

	@yield('javascripts')

	@include('ravel::layouts.raveladmin.partials.footer')
	</div>
</body>
</html>