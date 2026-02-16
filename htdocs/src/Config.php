<?php

class Config
{
	public static $hashSalt = 'xBEHGDpVwG0O3qdL7Jr2';

	// MariaDB
	public static $mariadbHost     = 'mariadb';
	public static $mariadbUsername = 'root';
	public static $mariadbPassword = 'root';
	public static $mariadbDatabase = 'csrv';

	// Logging
	public static $logEnabled = true;
	public static $logTarget  = 'STDOUT'; // Valid targets: "FILE", "STDOUT"
	public static $logFile    = '/var/log/csrv.log'; // Valid levels: "DEBUG", "INFO", "WARN", "ERROR"

	// Translations
	public static $validLanguages = ['en', 'de'];

	// Crest
	public static $crestWidth = 149;
	public static $crestHeight = 171;
	public static $crestLayerAmount = [3, 3, 3];

	public static function init () {
		foreach (getenv() as $key => $value) {
			if (property_exists('Config', $key)) {
				self::$$key = $value;
			}
		}
	}

	private function __construct () { }
	private function __clone () { }
}