
angular.module('ui.dropzone',[])
.service('dzconfig',function()
{
	//configuration service
	
	var config = {
			validMimeTypes : "image/jpeg, image/png, application/pdf",
	};

	return {
		get:function(key)
		{
			return config[key];
		},
		set:function(key, value)
		{
			config[key] = value;
		}

	}
})
.service('dzuploader',function()
{
	var url = '/';
	return {
		setUrl: function(a)
		{
			url = a;
		},
		get: function()
		{
			return url;
		},
		addFile : function(file)
		{
			alert('add file function called from dzuploader');
		}
	}
})
.service('dzfile',function(dzuploader, dzconfig, $rootScope)
{
	//check if FileApi is supported by the browser
	if (window.File && window.FileReader && window.FileList && window.Blob) {
	   var FileApiIsLoaded = true;
	} else {
		var FileApiIsLoaded = false;
	}


	return {

		addFile : function(file)
		{
			dzuploader.addFile(file);
		},

		isValidMimeType : function(mimeType, acceptedMimeTypes) {
  			
  			var baseMimeType, validMimeType, _i, _len;

		    if (!acceptedMimeTypes) {
		      return true;
		    }
		    acceptedMimeTypes = acceptedMimeTypes.split(",");
		    baseMimeType = mimeType.replace(/\/.*$/, "");
		    for (_i = 0, _len = acceptedMimeTypes.length; _i < _len; _i++) {
		      validMimeType = acceptedMimeTypes[_i];
		      validMimeType = validMimeType.trim();
		      if (/\/\*$/.test(validMimeType)) {
		        if (baseMimeType === validMimeType.replace(/\/.*$/, "")) {
		          return true;
		        }
		      } else {
		        if (mimeType === validMimeType) {
		          return true;
		        }
		      }
		    }
		    
		    return false;
		},

		makeThumbImage : function(file, src)
		{
			console.log('makeThumbImage Called');
			console.log(file);

			if(FileApiIsLoaded)
			{
				console.log('FileApiIsLoaded = true');
				//prepare thumbImage if file is image type
				var validMimeTypes = dzconfig.get('validMimeTypes');
				if(this.isValidMimeType(file.type, validMimeTypes))
				{
					//prepare image thumb
					console.log('calling createThumbnail');
					return this.createThumbnail(file, src);
				}
				else
				{
					//return default thumb
					alert('file is invalid');
					return null;
				}

			} else
			{
				console.log('FileApiIsLoaded = false');
				//alternative thumb image returned
			}
		},

		createThumbnail : function(file, src) {
			console.log(file);
			console.log('called createThumbnail');

			// var fileReader = new FileReader;
			// fileReader.onload = function() {
				var canvas = document.createElement("canvas");
				var thumbSize = 100;
				canvas.width = thumbSize;
				canvas.height = thumbSize;

				var ctx = canvas.getContext("2d");

				var img = new Image();
				var thumbnail;
				img.onload = function(e)
				{
					ctx.drawImage(this, 0, 0, thumbSize, thumbSize);
					thumbnail = canvas.toDataURL("image/png");
					$rootScope.$broadcast('thumbImgCreated', thumbnail);
					
				}

				img.src = src;
			// };

			//  var result = fileReader.readAsDataURL(file);
			//  console.log('result is');
			//  console.log(thumbnail);
			// return thumbnail;
	      	// var fileReader,
	       //  _this = this;

	      	// fileReader = new FileReader;
	      	// fileReader.onload = function() {
	       //  	var img;

		      //   img = new Image;
		      //   img.onload = function() {
		      //     	var canvas, ctx, resizeInfo, thumbnail, _ref, _ref1, _ref2, _ref3, _ref4, _ref5;

		      //     	file.width = img.width;
		      //     	file.height = img.height;
		      //     	resizeInfo = {
		      //     			trgWidth : 100,
		      //     			trgHeight : 100,
		      //     	};//_this.options.resize.call(_this, file);
		          
		      //     	if ((_ref = resizeInfo.trgWidth) == null) {
		      //       	resizeInfo.trgWidth = 100;
		      //     	}
		          
		      //     	if ((_ref1 = resizeInfo.trgHeight) == null) {
		      //       	resizeInfo.trgHeight = 100;
		      //     	}
		          
			     //    canvas = document.createElement("canvas");
			     //    ctx = canvas.getContext("2d");
			     //    canvas.width = resizeInfo.trgWidth;
			     //    console.log(canvas.width + ' is canvas width');
			     //    canvas.height = resizeInfo.trgHeight;
			     //    ctx.drawImage(img, (_ref2 = resizeInfo.srcX) != null ? _ref2 : 0, (_ref3 = resizeInfo.srcY) != null ? _ref3 : 0, resizeInfo.srcWidth, resizeInfo.srcHeight, (_ref4 = resizeInfo.trgX) != null ? _ref4 : 0, (_ref5 = resizeInfo.trgY) != null ? _ref5 : 0, resizeInfo.trgWidth, resizeInfo.trgHeight);
			     //    thumbnail = canvas.toDataURL("image/png");
			     //    console.log(thumbnail);
		      //     //return _this.emit("thumbnail", file, thumbnail);
		      //     return thumbnail;
		      //   };

	       //  	return img.src = fileReader.result;

	      	// };

	      	// return fileReader.readAsDataURL(file);
	    }
	}
})
.directive('dropzone',function(dzuploader, dzfile)
{
	return {

		restrict:"EA",
		templateUrl:"dz/panel",
		scope:{},
		controller: function($scope, $attrs)
		{
			$scope.title = "Dropzone - Drag and Drop Files";

			$scope.files = [];

			dzuploader.setUrl($attrs.url);

			this.addFile = function(newFile)
			{
				$scope.$apply(function()
				{
					dzfile.addFile(newFile);
					
					$scope.files.push(newFile);
					console.log('added new file');
					console.log($scope.files);
				});
				
			}
		},
		
		link:function(scope, element, attrs)
		{
			
				
		}
	}
})
.directive('dzFile',function(dzuploader)
{
	return {
		restrict:'E',
		templateUrl: 'dz/file'
	}
})
.directive('dzList',function(dzuploader)
{
	return {
		restrict:'EA',
		replace: true,
		templateUrl:'dz/list',
	}
})
.directive('dropper',function(dzfile)
{
	return {
		restrict:'EA',
		require:"^dropzone",
		scope:{
			dropText:'&'
		},
		transclude: true,
		templateUrl:'dz/dropper',
		link: function(scope, element,attr, dzCtrl)
		{
			//jQuery.event.props.push("dataTransfer");
			scope.dropText = 'Drop files here...';

			element.bind('click',function()
			{
				alert('needs to select files');
			});

			element.bind('dragover',function(e)
			{
				element.addClass('hover');
				e.stopPropagation();
        		e.preventDefault();
				
				scope.$apply(function(){
            		scope.dropText = 'Yes! Drop here now'
        		});

			});

			element.bind('dragleave',function(e)
			{
				element.removeClass('hover');
				e.stopPropagation();
        		e.preventDefault();

				scope.$apply(function(){
            		scope.dropText = 'Drop files here...';
        		});
			});

			element.bind('drop', function(e) {
				element.removeClass('hover');
                e.stopPropagation();
        		e.preventDefault();

		       	var files = e.originalEvent.dataTransfer.files;
		       	for (var i = 0, f; f = files[i]; i++) {
                    var reader = new FileReader();
                    //reader.readAsArrayBuffer(f);
                    reader.readAsDataURL(f);

                    reader.onload = (function(theFile) {
                        return function(e) {

                        	//thumbnail
                        	console.log('calling makeThumbImage');
                        	dzfile.makeThumbImage(theFile, e.target.result);

                        	scope.$on('thumbImgCreated',function(e, thumbSrc)
                        	{
                 				//set the thumb and add the file
                 				var newFile = { 
                 					name : theFile.name,
                               		type : theFile.type,
                                	size : ((theFile.size /1024/1024)).toFixed(2),
                                	lastModifiedDate : theFile.lastModifiedDate,
                                	thumb: thumbSrc
                            	}

                            	dzCtrl.addFile(newFile);
                        		
                        	});
                        };
                    })(f);
                    
                }

		        

		        return false;
            });
		}
	}
})
.run(function($templateCache)
{
	$templateCache.put('dz/panel',"<div class='dz-panel'><div class='title'>{{title}}</div><div dropper class='dropper'><div dz-list></div></div></div>");
	$templateCache.put('dz/list',"<div id='dz-list-files'><ul><li ng-repeat='file in files'><dz-file></dz-file></li></ul></div>"),
	$templateCache.put('dz/file',"<div class='dz-details'><div class='dz-filename'><span ng-bind='file.name'></span></div><div class='dz-size'><strong>{{file.size}}</strong> MB</div><div class='thumb-wrap'><img src='{{file.thumb}}' class='thumbnail'/></div></div>"),
	$templateCache.put('dz/dropper',"<div id='dz-dropper-text'><span>{{dropText}}</span><div ng-transclude ></div></div>");
})
;