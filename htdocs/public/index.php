<?php

ini_set('max_execution_time', 5);
ini_set('memory_limit', '16M');

define('BASEPATH', dirname(__FILE__, 2));
ignore_user_abort(true);

require_once BASEPATH.'/src/Config.php';
require_once BASEPATH.'/src/Logger.php';
require_once BASEPATH.'/src/MariaDb.php';
require_once BASEPATH.'/src/Crest.php';
Config::init();

$command = (isset($_GET['c'])?trim($_GET['c']):'');
$userId = (isset($_GET['id'])?(int)$_GET['id']:0);
$userHash = (isset($_GET['h'])?trim($_GET['h']):'');
$newCrest = (isset($_GET['cr'])?trim($_GET['cr']):'[]');

if ($userId <= 0) {
	Logger::info('UserID invalid', 'USER', ['userId' => $userId]);
	Crest::renderWarning();
	exit();
}

$crest = new Crest($userId);
if (!$crest->isValidHash($userHash)) {
	Logger::info('UserHash invalid', 'USER', ['userId' => $userId, 'userHash' => $userHash]);
	Crest::renderWarning();
	exit();
}

switch ($command) {
	case 'save':
		print $crest->save($newCrest);
		break;
	case 'get':
	default:
		$crest->render();
	break;
}