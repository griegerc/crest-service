<?php

define('BASEPATH', dirname(__FILE__, 2));
ignore_user_abort(true);

require_once BASEPATH.'/src/Config.php';
require_once BASEPATH.'/src/Logger.php';
require_once BASEPATH.'/src/MariaDb.php';
require_once BASEPATH.'/src/Crest.php';
Config::init();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Crest testing page</title>
		<style>
			body {
				font-family: Tahoma, sans-serif;
			}
			#crestImg {
				width: <?php print Config::$crestWidth ?>px;
				height: <?php print Config::$crestHeight ?>px;
			}
			th {
				text-align: right;
			}
		</style>
		<script type="text/javascript">
			function changeImage() {
				const baseUrl = "<?php print $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'; ?>";
				const userId = document.getElementById("userId").value;
				const userHash = document.getElementById("userHash").value;
				const crestCaption = document.getElementById("crestCaption");
				const crestImg = document.getElementById("crestImg");

				crestImg.src = baseUrl + "?id=" + userId + "&h=" + userHash;
				crestCaption.innerHTML = "Crest of userId #" + userId;
			}

			document.addEventListener("DOMContentLoaded", function () {
				const button = document.getElementById("button");
				button.addEventListener("click", changeImage);
			});
		</script>
	</head>
	<body>
		<h1>Crest testing page</h1>
		<table>
			<tr>
				<th><label for="userId">UserID:</label></th>
				<td><input id="userId" type="number"/></td>
			</tr>
			<tr>
				<th><label for="userHash">UserHash:</label></th>
				<td><input id="userHash" type="text"/></td>
			</tr>
			<tr>
				<th></th>
				<td><button id="button">show</button></td>
			</tr>
		</table>
		<figure>
			<img id="crestImg" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKAQMAAAC3/F3+AAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjwAsAAB4AAdpxxYoAAAAASUVORK5CYII=" alt=""/>
			<figcaption id="crestCaption"></figcaption>
		</figure>
	</body>
</html>