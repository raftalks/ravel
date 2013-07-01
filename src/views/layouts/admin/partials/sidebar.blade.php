<div id="sidebar" style="margin-top:50px;">
	<div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
	
	<h1 id="sidebar-title"><a href="#">CMS</a></h1>
  
	<!-- Sidebar Profile links -->
	<div id="profile-links">
		Hello, <a href="/account" title="Edit your profile"><?php echo ucfirst(currentUserName());?></a><br />
		<br />
		<a href="/" title="View the Site">View the Site</a> | <a href="<?php echo URL::route('ravellogout');?>" title="Sign Out">Sign Out</a>
	
		
	</div> 
	
	<?php
		echo Menu::build();
	?>
	
	</div>
</div> <!-- End #sidebar -->