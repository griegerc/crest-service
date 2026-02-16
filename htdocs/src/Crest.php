<?php

class Crest
{
	/** @var int */
	private $userId = 0;

	/** @var string */
	private $userHash = '';

	/** @var bool */
	private $userExists = false;

	/** @var array */
	private $crest = [];

	/** @var int */
	private $lastUpdate = 0;

	/** @var int */
	private $lastFetch = 0;

	/**
	 * @param int $userId
	 */
	public function __construct ($userId) {
		$this->userId = (int)$userId;
		$query = sprintf('SELECT * FROM `crests` WHERE `userId`=%d;', $this->userId);
		$dbRow = MariaDb::query($query, true);
		if (isset($dbRow['userId'])) {
			$this->userExists = true;
			$this->userHash = bin2hex($dbRow['userHash']);
			$this->crest = json_decode($dbRow['crest']);
			$this->lastUpdate = (int)$dbRow['lastUpdate'];
			$this->lastFetch = (int)$dbRow['lastFetch'];
		}
	}

	/**
	 * @param string $hash
	 * @return bool
	 */
	public function isValidHash ($hash) {
		return $this->userHash === $hash;
	}

	public static function renderWarning () {
		$img = imagecreatefromstring(base64_decode('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'));
		header('Content-Type: image/png');
		imagepng($img);
		imagedestroy($img);
	}

	public function render() {
		if (!$this->userExists) {
			Crest::renderWarning();
			return;
		}

		$this->lastFetch = time();
		$query = sprintf('UPDATE `crests` SET `lastFetch`=%d WHERE `userId`=%d;', $this->lastFetch, $this->userId);
		MariaDb::execute($query);

		$crestImage = imagecreatetruecolor(Config::$crestWidth, Config::$crestHeight);

		imagealphablending($crestImage, false);
		$transparent = imagecolorallocatealpha($crestImage, 0, 0, 0, 127);
		imagefill($crestImage, 0, 0, $transparent);
		imagesavealpha($crestImage, true);
		imagealphablending($crestImage, true);

		foreach ($this->crest as $layerId => $layerValue) {
			$layerPath = BASEPATH . '/public/data/l' . $layerId . '-' . $layerValue . '.png';
			if (!file_exists($layerPath)) {
				Logger::warn('Crest layer does not exist', 'CREST', ['path' => $layerPath]);
				continue;
			}
			$layerImage = imagecreatefrompng($layerPath);
			imagecopy($crestImage, $layerImage, 0, 0, 0, 0, Config::$crestWidth, Config::$crestHeight);
			imagedestroy($layerImage);
		}

		header('Content-Type: image/png');
		imagepng($crestImage);
		imagedestroy($crestImage);
	}

	/**
	 * @return bool
	 */
	public function isValid () {
		foreach (Config::$crestLayerAmount as $layerId => $maxAmount) {
			if (!isset($this->crest[$layerId]) || $this->crest[$layerId] < 0 || $this->crest[$layerId] >= $maxAmount) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param string $newCrest
	 * @return string
	 */
	public function save ($newCrest) {
		if ($this->userId <= 0) {
			Logger::info('Will not save crest for invalid UserID', 'CREST');
			return '';
		}

		$this->crest = json_decode($newCrest);
		if (!is_array($this->crest) || count($this->crest) < 1 || !$this->isValid()) {
			Logger::info('Will not save invalid crest', 'CREST');
			return '';
		}

		$this->lastUpdate = time();
		if ($this->userExists) {
			$query = sprintf('UPDATE `crests` SET `crest`="%s", `lastUpdate`=%d WHERE `userId`=%d;', $newCrest, $this->lastUpdate, $this->userId);
			MariaDb::execute($query);
			return '';
		} else {
			$userHash = substr(hash('sha256', time() . Config::$hashSalt), 0, 20);
			$query = sprintf('INSERT INTO `crests` (`userId`, `userHash`, `crest`, `lastUpdate`) VALUES (%d, "%s", "%s", %d);', $this->userId, hex2bin($userHash), $newCrest, $this->lastUpdate);
			MariaDb::execute($query);
			return $userHash;
		}
	}
}