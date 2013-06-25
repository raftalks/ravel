<div id="sidebar">
	<div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
	
	<h1 id="sidebar-title"><a href="#">Ravel CMS</a></h1>
  
	<!-- Logo (221px wide) -->
	<a href="#"><img id="logo" src="<?php echo admin_asset('admin/images/ravelcmslogo.png');?>" alt="Ravel CMS" /></a>
  
	<!-- Sidebar Profile links -->
	<div id="profile-links">
		Hello, <a href="#" title="Edit your profile"><?php echo ucfirst(currentUserName());?></a><br />
		<br />
		<a href="#" title="View the Site">View the Site</a> | <a href="<?php echo URL::route('ravellogout');?>" title="Sign Out">Sign Out</a>
	
		
	</div> 
	
	<?php
		echo Menu::build('admin.menu');
	?>
	
	</div>
</div> <!-- End #sidebar -->