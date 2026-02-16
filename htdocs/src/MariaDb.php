<?php

class MariaDb
{
    /** @var PDO */
    private $db;

    /** @var MariaDb */
    private static $instance = NULL;

    /**
     * Instance of the database
     * @return MariaDb
     */
	public static function getInstance () {
		if (!self::$instance instanceof MariaDb) {
			self::$instance = new self(Config::$mariadbHost, Config::$mariadbUsername, Config::$mariadbPassword, Config::$mariadbDatabase);
		}
		return self::$instance;
	}

    /**
     * Connect to an ODBC database using driver invocation.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     */
	private function __construct ($host, $username, $password, $database) {
		$dsn = sprintf('mysql:dbname=%s;host=%s;charset=utf8', $database, $host);
		$this->db = new PDO($dsn, $username, $password);
		$this->db->exec("SET NAMES 'utf8';");
	}

    /**
     * @return void
     */
    private function __clone() {}

    /**
     * Shutdown the database connection and release resources.
     * @return void
     */
	public function __destruct () {
		$this->db = null;
	}

    /**
     * Execute an SQL statement and return the number of affected rows.
     * @param string $sql
     * @return bool|int
     */
    public static function execute($sql) {
        return self::getInstance()->db->exec($sql);
    }

    /**
     * Executes an SQL statement, returning the result as an array
     * @param string $sql
     * @param bool $firstEntryOnly
     * @param bool $fetchColumns
     * @return array
     */
	public static function query ($sql, $firstEntryOnly = false, $fetchColumns = false) {
		$db = self::getInstance()->db;

		/* @var PDOStatement $sqlStatement */
		$sqlStatement = $db->query($sql);
		if ($sqlStatement === false) {
			Logger::error('SQL statement invalid', 'MARIADB', ['error' => $db->errorInfo()[2]]);
			return [];
		}

		if ($fetchColumns === true) {
			return $sqlStatement->fetchAll(PDO::FETCH_COLUMN);
		}

		if ($firstEntryOnly === true) {
			return $sqlStatement->fetch(PDO::FETCH_ASSOC);
		} else {
			return $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
		}
	}
}