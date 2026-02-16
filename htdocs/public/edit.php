<?php

define('BASEPATH', dirname(__FILE__, 2));
ignore_user_abort(true);

require_once BASEPATH.'/src/Config.php';
require_once BASEPATH.'/src/Logger.php';
require_once BASEPATH.'/src/Translation.php';
require_once BASEPATH.'/src/MariaDb.php';
require_once BASEPATH.'/src/Crest.php';
Config::init();

$userId = (isset($_GET['id'])?(int)$_GET['id']:0);
$language = (isset($_GET['l'])?trim($_GET['l']):'en');
$t = Translation::getInstance($language);
if ($userId > 0) {
	$crest = new Crest($userId);
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Crest editor</title>
		<style>
			.csrv {
				font-family: Tahoma, sans-serif;
			}

			.csrv .editor .preview {
				width: <?php print Config::$crestWidth ?>px;
				height: <?php print Config::$crestHeight ?>px;
				position: relative;
				margin-bottom: 20px;
			}

			.csrv .editor .preview img {
				position: absolute;
			}

			.csrv .editor .ranges {
				padding-left: 0;
				margin-bottom: 20px;
			}

			.csrv .editor .ranges li {
				list-style-type: none;
			}

			.csrv .editor .user {
				margin-bottom: 20px;
			}
		</style>
		<script type="text/javascript">

			const LAYERS = <?php print json_encode(Config::$crestLayerAmount); ?>;

			function changeLayer (layer, amount = -1) {
				let slider = document.getElementById("crestLayer" + layer);
				if (amount > -1) {
					slider.value = amount;
				}
				let img = document.getElementById("imageLayer" + layer);
				img.src = "/data/l" + layer + "-" + slider.value + ".png";
			}

			function shuffleLayers () {
				for (let layer = 0; layer < LAYERS.length; layer++) {
					changeLayer(layer, Math.floor(Math.random() * LAYERS[layer]));
				}
			}

			function saveCrest () {
				const baseUrl = "<?php print $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'; ?>";
				const userId = parseInt(document.getElementById("userId").value, 10);
				if (Number.isNaN(userId) || userId <= 0) {
					alert("Invalid userId");
				} else {
					let crestData = [];
					for (let layer = 0; layer < LAYERS.length; layer++) {
						crestData[layer] = parseInt(document.getElementById("crestLayer"+layer).value, 10);
					}
					window.location.replace(baseUrl + "?c=save&id=" + userId + "&cr=" + JSON.stringify(crestData));
				}
			}

			document.addEventListener("DOMContentLoaded", function () {
				for (let layer = 0; layer < LAYERS.length; layer++) {
					document.getElementById("crestLayer" + layer).addEventListener("change", () => changeLayer(layer));
					changeLayer(layer);
				}
				document.getElementById("buttonShuffle").addEventListener("click", shuffleLayers);
				document.getElementById("buttonSave").addEventListener("click", saveCrest);
			});

		</script>
	</head>
	<body class="csrv">
		<div class="editor">
			<div class="preview">
				<?php
					foreach (Config::$crestLayerAmount as $layer => $amount) {
						print '<img id="imageLayer' . $layer . '" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKAQMAAAC3/F3+AAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjwAsAAB4AAdpxxYoAAAAASUVORK5CYII=" alt=""/>';
					}
				?>
			</div>
			<ul class="ranges">
				<?php
					foreach (Config::$crestLayerAmount as $layer => $amount) {
						printf('<li><label for="crestLayer%d">%s</label><input type="range" min="0" max="%d" value="0" id="crestLayer%d"/></li>',
							$layer,
							$t->get('layer' . $layer),
							($amount - 1),
							$layer);
					}
				?>
			</ul>
			<div class="user">
				<label for="userId"><?php print $t->get('userId'); ?></label>
				<input type="number" id="userId"/>
			</div>
			<div class="buttons">
				<button id="buttonShuffle"><?php print $t->get('shuffle'); ?></button>
				<button id="buttonSave"><?php print $t->get('save'); ?></button>
			</div>
		</div>
	</body>
</html>