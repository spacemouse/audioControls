<?PHP

function xspf_banners($xspf_filename) {
	$playlist = simplexml_load_file($xspf_filename);
	$i = 0;
	foreach ($playlist as $trackList):
		foreach ($trackList as $track):
			$image = $track->image;
			if ($i != 0) {
				echo ", ";
			}
			echo '"';
			echo $image;
			echo '"';
			$i++;
		endforeach;
	endforeach;
}

function xspf_playlist($xspf_filename) {
	$playlist = simplexml_load_file($xspf_filename);
	$i = 0;
	foreach ($playlist as $trackList):
		foreach ($trackList as $track):
			$location = $track->location;
			$title = $track->title;
			$image = $track->image;
			$i++;
			echo '<li data-src="';
			echo $location;
			echo '"><a href="#" title="';
			echo $title;
			echo '"><img src="';
			echo $image;
			echo '" alt="';
			echo $title;
			echo '"/>';
			echo $title;
			echo '</a></li>';
		endforeach;
	endforeach;
}

?>
