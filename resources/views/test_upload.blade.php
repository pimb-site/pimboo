<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

	<title>jQuery plugin for FileAPI</title>


	<link href="test/statics/main.css" rel="stylesheet" type="text/css"/>
	<link href="test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>

	<script>
		var examples = [];
	</script>

</head>
<body>
<div class="testrep">
         <span class="btn-txt">Choose</span>
         <input type="file" name="filedata">
</div>

	<div id="popup" class="popup" style="display: none;">
		<div class="popup__body"><div class="js-img"></div></div>
		<div style="margin: 0 0 5px; text-align: center;">
			<div class="js-upload btn btn_browse btn_browse_small">Upload</div>
		</div>
	</div>

	<script src="//code.jquery.com/jquery-1.8.2.min.js"></script>
	<script>window.FileAPI = { /* options */ };</script>

	<script src="test/FileAPI/FileAPI.min.js"></script>
	<script src="test/FileAPI/FileAPI.exif.js"></script>
	<script src="test/jquery.fileapi.js"></script>
	<script src="test/jcrop/jquery.Jcrop.min.js"></script>
	<script src="test/statics/jquery.modal.js"></script>
	<script>
$('.testrep').fileapi({
   url: 'test_upload_end',
   autoUpload: false,
   accept: 'image/*',
   data: {'_token': '{!! csrf_token() !!}'},
   onFileComplete: function (evt, uiEvt){
	   var result = uiEvt.result; // server response
	   alert(result.success);
   },
   imageSize: { minWidth: 320, minHeight: 240, maxWidth: 3840, maxHeight: 2160},
   
   onSelect: function (evt, ui){
      var file = ui.files[0];

      if( !FileAPI.support.transform ) {
         alert('Your browser does not support Flash :(');
      }
      else if( file ){
         $('#popup').modal({
            closeOnEsc: true,
            closeOnOverlayClick: false,
            onOpen: function (overlay){
               $(overlay).on('click', '.js-upload', function (){
                  $.modal().close();
                  $('.testrep').fileapi('upload');
               });
               $('.js-img', overlay).cropper({
                  file: file,
                  bgColor: '#fff',
                  maxSize: [$(window).width()-100, $(window).height()-100],
                  minSize: [200, 200],
                  selection: '1%',
                  onSelect: function (coords){
                     $('.testrep').fileapi('crop', file, coords);
                  }
               });
            }
         }).open();
      }
   },
});
	</script>

</body>
</html>
