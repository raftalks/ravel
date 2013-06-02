<!-- <nav class="">
    <ul  class="menu">
        <li >
            <a href="http://demo.mountainthemes.com/05/" data-history-set="true">Home Page</a>
            <ul class="sub-menu" style="top: -37px;">
            	<li class="menu-item "><a href="http://demo.mountainthemes.com/05/home-video/" data-history-set="true">Home Video</a></li>
            </ul>
		</li>
		<li><a >Page Examples</a>
		<ul class="sub-menu" style="top: -185px;">
			<li ><a href="http://demo.mountainthemes.com/05/contacts/" data-history-set="true">Contacts</a></li>
			<li ><a href="http://demo.mountainthemes.com/05/half-page/" data-history-set="true">Half Page</a></li>
			<li ><a href="http://demo.mountainthemes.com/05/full-page/" data-history-set="true">Full Page</a></li>
			<li ><a href="http://demo.mountainthemes.com/05/video-background/" data-history-set="true">Video Background</a></li>
			<li ><a href="http://demo.mountainthemes.com/05/sample-page/" data-history-set="true">Sample Page</a></li>
		</ul>
		</li>
		<li ><a href="http://demo.mountainthemes.com/05/gallery/" data-history-set="true">Gallery</a></li>
		<li ><a href="http://demo.mountainthemes.com/05/blog/" data-history-set="true">Blog</a></li>
		<li ><a href="http://demo.mountainthemes.com/05/video-page/" data-history-set="true">Video Page</a></li>
		<li ><a href="http://demo.mountainthemes.com/05/portfolio/" data-history-set="true">Portfolio</a></li>
	</ul>
</nav>  -->
<?php
	Menu::setTemplate('ravel::layouts.raveladmin.templates.mainmenu');
	echo Menu::build();
?>