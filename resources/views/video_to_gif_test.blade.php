@extends('tools.view')
@section('css')
	<link href="/css/videoToGIF.css" rel="stylesheet">
@endsection
@section('content')
<div class="video_to_gif"> 		
	<h1> Your Video </h1>
	<div class="button-for-video">
		<button class="select-file" onclick="document.querySelector('input').click()">SELECT VIDEO</button>
		<input accept="video/mp4" style="visibility: collapse; width: 0px;" type="file" onchange="upload(this.files[0])">
		<button id="start-button">start GIF frames</button>
		<button id="end-button">End GIF frames</button>
		<button id="sample-button">Try Sample File</button>
		<input type="range" style="display: none;" id="speed" min="30" max="1000" step="1" value="100">
	</div>
	<div class="status"> STATUS: <div id="output">Video not uploaded</div></div>
	<canvas id="c" style="display:none;"></canvas>
	<video id="v" controls="" loop="" autoplay="" ></video>
	<h1> GIF RESULT </h1>
	<img class="result-gif" id="image" src="" alt="">
</div>
@endsection
@section('script')
	<script>
	var worker = new Worker('/js/video_to_gif.js');

	var URL = window.URL || window.webkitURL;
	if (!URL) {
		document.getElementById("output").innerHTML = 'Your browser is not <a href="http://caniuse.com/bloburls">supported</a>!';
	} else {



	worker.addEventListener('message', function(e) {
		document.getElementById("output").innerHTML = "Done. Look below.";
		image.src = e.data;
		alert(e.data);
	}, false);


	var start = document.getElementById("start-button");
	var end = document.getElementById("end-button");
	var sample = document.getElementById("sample-button");
	var image = document.getElementById('image');
	var speed = document.getElementById("speed");
	var speedrate = document.getElementById("speedrate");

	var flag = false;
	var delay = 100; //default speed

	//control play speed
	speed.addEventListener('change', function(){
		var s = this.value;
		delay = s;
		speedrate.innerHTML = s;
	}, false);


	var v = document.getElementById("v");
	var canvas = document.getElementById('c');
	var context = canvas.getContext('2d');
	var cw,ch;

	v.addEventListener('play', function(){
		cw = v.clientWidth;
		ch = v.clientHeight;
		canvas.width = cw;
		canvas.height = ch;
		draw(v,context,cw,ch);
	},false);

	function draw(v,c,w,h) {
		if(v.paused || v.ended)	return false;
		c.drawImage(v,0,0,w,h);
		if(flag == true){
			var imdata = c.getImageData(0,0,w,h);
			worker.postMessage({frame: imdata});
		}
		setTimeout(draw,delay,v,c,w,h);
	}

	sample.addEventListener('click', function(){
		v.src = 'small.webm';
	},false);

	start.addEventListener('click', function(){
		flag = true;
		worker.postMessage({delay:delay,w:cw,h:ch});
		document.getElementById("output").innerHTML = "Capturing video frames.";
	},false);

	end.addEventListener('click', function(){
		flag = false;
		worker.postMessage({});
		document.getElementById("output").innerHTML = "Processing the GIF.";
	},false);


		/* Drag drop stuff */
		window.ondragover = function(e) {e.preventDefault()}
		window.ondrop = function(e) {
			e.preventDefault();
			document.getElementById("output").innerHTML = "Reading...";
			var length = e.dataTransfer.items.length;
			if(length > 1){
				document.getElementById("output").innerHTML = "Please only drop 1 file.";
			} else {
				upload(e.dataTransfer.files[0]);
			}
		}

		/* main upload function */
		function upload(file) {

			//check if its a video file
			if(file.type.match(/video\/*/)){
				/*
				oFReader = new FileReader();
				oFReader.onloadend = function() {

					document.getElementById("output").innerHTML = "";

					var blob = new Blob([this.result], {type: file.type});
					var url = URL.createObjectURL(blob);

					v.src = url;
				};
				//oFReader.readAsBinaryString(file);
				oFReader.readAsArrayBuffer(file);
				*/

				//why read the whole video into memory when you can stream!!
				document.getElementById("output").innerHTML = "";
				var url = URL.createObjectURL(file);
				v.src = url;

			} else {
				document.getElementById("output").innerHTML = "This file does not seem to be a video.";
			}
		}
	}
	</script>
@endsection