<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>:: Audio Control :: Theme - 1</title>
		<link href="assets/css/jquery-ui.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="assets/css/theme-1.css" />
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/jquery-ui.min.js"></script>
		<script src="assets/js/jquery.audioControls.min.js"></script>
		<?PHP
			include 'xspf_playlists.php';
			$filename = 'example.xspf';
		?>
		<script>
			$(document).ready(function(){
				
				var audioInitialVolume = 30;
				var $sliderObj = $("#volumeSlider");
				var $toolTipObj = $(".tooltip");
				var volRange = $("input[type='range']");
				
				volRange.attr("value",(audioInitialVolume / 100));
				
				var getBGImage = function(index){
					var backgroundBanners = [<?PHP xspf_banners($filename); ?>];
					return backgroundBanners[index];
				}
				
				$sliderObj.slider({
					range: "min",
					min: 10,
					max : 100,
					value: audioInitialVolume,
					start: function (event, ui) {
						$toolTipObj.fadeIn('fast');
					},
					stop: function (event, ui) {
						$toolTipObj.fadeOut('fast');
					},
					slide: function(eve, ui){
						var value = $sliderObj.slider('value');
						$toolTipObj.css('left', value).text(ui.value);
					},
					change: function(eve, ui){
						volRange.attr("value",(ui.value / 100));
						volRange.trigger("change");
					}
				});
				
				$("#playlist").audioControls({
					audioVolume: (audioInitialVolume / 100),
					shuffled: true,
					onAudioChange: function(response){
						if(response.title.length > 0){
							$(".titleContainer p").text(response.title);
							$("body").css({
								"background-image": "url(" + getBGImage(response.index) + ")",
								"background-size": "cover",
								"background-repeat": "no-repeat",
								"background-attachment": "fixed",
								"background-position": "center center"
							});
						}
					},
					onPlay: function(){
						$("p.title").addClass("animated pulse");
					},
					onPause: function(){
						$("p.title").removeClass("animated pulse");
					},
					onVolumeChange: function(value){
						volume = $('.volume');
						if (value <= 5) {
							volume.css('background-position', '0 0');
						} else if (value <= 25) {
							volume.css('background-position', '0 -25px');
						} else if (value <= 75) {
							volume.css('background-position', '0 -50px');
						} else {
							volume.css('background-position', '0 -75px');
						}
					}
				});
				$("span.playlist").on("click", function(eve){
					eve.preventDefault();
					$(".playlistContainer").slideToggle("fast");
				});
			});
		</script>
	</head>
	<body>
		<div class="mainContainer">
			<div class="twoColumn">
				<div class="col-1 toolsPane">
					<a href="#" title="Show/Hide Playlist" alt="Show/Hide Playlist"><span class="ctrls playlist"></span></a>
					<a href="#" title="Previous Song" alt="Previous Song"><span data-attr="prevAudio" class="ctrls previous"></span></a>
					<a href="#" title="Play/Pause" alt="Play/Pause"><span data-attr="playPauseAudio" class="ctrls playAudio"></span></a>
					<a href="#" title="Next Song" alt="Next Song"><span data-attr="nextAudio" class="ctrls next"></span></a>
					<a href="#" title="Repeat Song" alt="Repeat Song"><span data-attr="repeatSong" class="ctrls replay"></span></a>
				</div>
				<div id="audioPlayer" class="col-2 container">
					<div class="playlistContainer">
						<ul id="playlist">
							<?PHP xspf_playlist($filename); ?>
						</ul>
					</div>
					<div class="progress">
			        	<div data-attr="seekableTrack" class="seekableTrack"></div>
						<div class="updateProgress"></div>
					</div>
					<div class="volumeControlContainer">
						<span class="tooltip"></span>
						<div id="volumeSlider"></div>
						<span class="volume"></span>
					</div>
					<div class="titleContainer">
						<p class="title"></p>
					</div>
					<input style="display:none;" data-attr="rangeVolume" type="range" min="0" max="1" step="0.1" />
				</div>
			</div>
		</div>
	</body>
</html>
