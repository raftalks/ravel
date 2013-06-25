<div id='file_list'>
<h3>Collection: {{activeCollection.name}}</h3>


	<div class="media_collection_list">
	  <div class="media_file_thumbs" ng-repeat='file in activeCollectionItems'>
	    <div class="media_file" ng-dblclick='editMedia(file)'>
	    	<img ng-src="{{file.thumb_url}}" />
	    	<div class='media_filename' ng-bind='file.file_name'></div>
	    </div>
	    <div class='clear'></div>
	  </div>
	 	<div class='clear'></div>
	</div>
	

</div>