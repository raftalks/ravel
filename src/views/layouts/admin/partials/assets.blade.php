@section('assets_css')
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/reset.css');?>" type="text/css" media="screen" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/style.css');?>" type="text/css" media="screen" />
		
		<!-- world flags -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/flags/flags.css');?>" type="text/css" media="screen" />
		

		<!-- icons css style -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/fontawesome/css/font-awesome.min.css');?>" type="text/css" media="screen" />
	  
		<!-- jbar css style -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/jbar/css/style.css');?>" type="text/css" media="screen" />
	  
		<!-- angularjs ui -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/angularjsui/angular-ui.min.css');?>" type="text/css" media="screen" />
		
		<!--select2 -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/scripts/angularjsui/select2/select2.css');?>" type="text/css" media="screen" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/invalid.css');?>" type="text/css" media="screen" />	
		
		<!-- Dropzone css -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/dropzone/css/dropzone.css');?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo admin_asset('admin/dropzone/css/basic.css');?>" type="text/css" media="screen" />

		<!-- Colour Schemes
	  
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/blue.css');?>" type="text/css" media="screen" />
		-->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/red.css');?>" type="text/css" media="screen" />  

		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			
			<link rel="stylesheet" href="<?php echo admin_asset('admin/fontawesome/css/font-awesome-ie7.min.css');?>" type="text/css" media="screen" />
	  
			<link rel="stylesheet" href="<?php echo admin_asset('admin/css/ie.css');?>" type="text/css" media="screen" />
		<![endif]-->

		<!-- jquery ui -->
		<link rel="stylesheet" href="<?php echo admin_asset('admin/css/smoothness/jquery-ui-1.10.0.custom.min.css');?>" type="text/css" media="screen" />
		
@stop

@section('assets_js')		
		<!--                       Javascripts                       -->
  
		<!-- jQuery -->
		<script type="text/javascript" src="<?php echo admin_asset('admin/scripts/jquery.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo admin_asset('admin/scripts/jquery-ui-1.10.0.smoothness.min.js');?>"></script>
		<script type="text/javascript" src='<?php echo admin_asset('admin/scripts/angularjsui/select2/select2.min.js');?>'></script>
		<!-- angularjs -->
		<script type="text/javascript" src='<?php echo admin_asset('admin/scripts/angular.min.js');?>'></script>
		
		<script type="text/javascript" src='<?php echo admin_asset('admin/scripts/angular-resource.min.js');?>'></script>
		<script type="text/javascript" src='<?php echo admin_asset('admin/scripts/angularjsui/angular-select2.js');?>'></script>
		<script type="text/javascript" src='<?php echo admin_asset('admin/scripts/angularjsui/angular-ui.min.js');?>'></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="<?php echo admin_asset('admin/scripts/simpla.jquery.configuration.js');?>"></script>
		
		<!-- CKEditor -->
		<script type="text/javascript" src="<?php echo admin_asset('admin/scripts/ckeditor/ckeditor.js');?>"></script>
		<script type="text/javascript" src="<?php echo admin_asset('admin/scripts/angular-ckeditor.js');?>"></script>

		<!--jbar jquery plugin -->
		<script type="text/javascript" src="<?php echo admin_asset('admin/jbar/jquery.bar.js');?>"></script>
		
		<!--Dropzone -->
		<script type="text/javascript" src="<?php echo admin_asset('admin/dropzone/dropzone.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo admin_asset('admin/dropzone/angular-dropzone.js');?>"></script>
		
	
		


		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="<?php echo admin_asset('admin/scripts/DD_belatedPNG_0.0.7a.js');?>"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
@stop
