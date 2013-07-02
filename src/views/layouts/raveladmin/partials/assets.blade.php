@section('assets_css')

	<link rel="stylesheet" type="text/css" href="<?php echo admin_asset('raveladmin/assets/bootstrap/css/bootstrap.min.css');?>">
	
	<link rel="stylesheet" type="text/css" href="<?php echo admin_asset('raveladmin/assets/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_asset('raveladmin/assets/css/styles.css');?>">
	<!--[if lt IE 9]>
		<script src="<?php echo admin_asset('raveladmin/assets/js/html5shiv/html5shiv.js');?>"></script>
	<![endif]-->
	<!--[if lt IE 7]>
		<script src="<?php echo admin_asset('raveladmin/assets/font-awesome/css/font-awesome-ie.min.css');?>"></script>
	<![endif]-->

	<!-- Jquery Ui -->
	<link rel="stylesheet" href="<?php echo admin_asset('raveladmin/assets/jquery/smoothness/jquery-ui-1.10.0.custom.min.css');?>" type="text/css" media="screen" />
	

	<!-- world flags -->
	<link rel="stylesheet" href="<?php echo admin_asset('raveladmin/assets/css/flags/flags.css');?>" type="text/css" media="screen" />
	
	<!-- angularjs ui -->
	<link rel="stylesheet" href="<?php echo admin_asset('raveladmin/assets/angularjs/angularjsui/angular-ui.min.css');?>" type="text/css" media="screen" />
	
	<!--select2 -->
	<link rel="stylesheet" href="<?php echo admin_asset('raveladmin/assets/select2/select2.css');?>" type="text/css" media="screen" />
	
	
	<!-- Dropzone css -->
	<link rel="stylesheet" href="<?php echo admin_asset('raveladmin/assets/dropzone/css/dropzone.css');?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo admin_asset('raveladmin/assets/dropzone/css/basic.css');?>" type="text/css" media="screen" />

	

@stop

@section('assets_js')

	<!-- jQuery -->
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/jquery/jquery.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/jquery/jquery-ui-1.10.0.smoothness.min.js');?>"></script>
	
	<!--bootstrap -->
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/bootstrap/js/bootstrap.min.js');?>"></script>
	

	<!-- select2 -->
	<script type="text/javascript" src='<?php echo admin_asset('raveladmin/assets/select2/select2.min.js');?>'></script>
	
	<!-- angularjs -->
	<script type="text/javascript" src='<?php echo admin_asset('raveladmin/assets/angularjs/angular.min.js');?>'></script>
	<script type="text/javascript" src='<?php echo admin_asset('raveladmin/assets/angularjs/angular-resource.min.js');?>'></script>
	<script type="text/javascript" src='<?php echo admin_asset('raveladmin/assets/angularjs/angularjsui/angular-ui.min.js');?>'></script>
	
	<!-- select2 -->
	<script type="text/javascript" src='<?php echo admin_asset('raveladmin/assets/angularjs/angularjsui/angular-select2.js');?>'></script>
		

	<!-- CKEditor -->
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/ckeditor/ckeditor.js');?>"></script>
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/angularjs/angularjsui/angular-ckeditor.js');?>"></script>

	
	<!--Dropzone -->
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/dropzone/dropzone.min.js');?>"></script>
	
	<!-- app.js -->
	<script type="text/javascript" src="<?php echo admin_asset('raveladmin/assets/js/app.js');?>"></script>
@stop