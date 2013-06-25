<div id='fileuploader'>

	<h3><?php echo trans('ravel::media.fileuploader');?></h3>
	
	<div id='dropzonefiles' class="dropzone">
	<div class='notice-successful hidden'>Files Uploaded successfully</div>
	</div>
	
	<div class='dropzone-toolbar'>
		<div class='align-left'>
			<span>Upload to:</span>
			<select id='collection_name' 
					name='set_collection' 
					>
		      	<option ng-repeat='folder in collections | filter:{type:"private"}' ng-selected='folder.id == activeCollection.id' value='{{ folder.id }}' ng-bind='folder.name'></option>
		    </select>
		<button id='uploadAll' class='button'>Upload Files</button>
		</div>

		<div class='align-right'>
			<button onclick='emptyDropZone()' class='button'>Empty</button>
		</div>
		<div class='clear'></div>
	</div>
	
	<!-- <div ng-repeat='selectedFiles'>
		<input name='filename' type='text' />
	</div> -->
</div>

</div>

<div id='preview_template' style="display:none">

</div>

<script type="text/javascript">
	
	Dropzone.autoDiscover = false;
	var myDropzone = '';
	
	$(function()
	{
		var FilesToUpload = [];

		function dropZoneInit()
		{
			myDropzone = new Dropzone("#dropzonefiles", {
				url: "<?php echo action("MediaUploadApiController@index");?>",
				paramName: "file", // The name that will be used to transfer the file
				maxFilesize: <?php echo config::get('ravel::media.max_file_size');?>, // MB
				enqueueForUpload : false
				
			});

			myDropzone.on("addedfile", function(file) {
			 	FilesToUpload.push(file);
			  	$(file.previewElement).dblclick(function() 
			  	{ 
			  		FilesToUpload.splice(FilesToUpload.indexOf(file),1);
			  		myDropzone.removeFile(file); 
			  	});
			});

			myDropzone.on("sending", function(file, xhr, formData) {
					var collectionName = $('#collection_name').val();
	  				formData.append("collection_id", collectionName); 
			});

			myDropzone.on("success",function(file)
			{
				$('.notice-successful').fadeIn(function()
				{
					$('.notice-successful').delay(1000).fadeOut();
				});

			});

			myDropzone.on("complete", function(file) {
				FilesToUpload.splice(FilesToUpload.indexOf(file),1);
	 			myDropzone.removeFile(file);
			});

			$('#uploadAll').click(function()
			{
				for (var inx in FilesToUpload)
				{
					myDropzone.filesQueue.push(FilesToUpload[inx]);
				}

				myDropzone.processQueue();
			});
		}

		dropZoneInit();

	
	});

	function emptyDropZone()
	{
		myDropzone.removeAllFiles();
		//myDropzone.length = 0;
		FilesToUpload.length =0;
		FilesToUpload = [];
		//dropZoneInit();
	}

	function uploadFiles()
	{

		myDropzone.processQueue();
	}

	
</script>