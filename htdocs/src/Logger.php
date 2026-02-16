<?php

class Logger
{
    private function __construct() {}

    /**
     * Writes a message to the log destination.
     * @param string|array|Exception $message
     * @param string $level
     * @param string $prefix
     * @param array $context
     * @return void
     */
    private function log($message, $level, $prefix, $context) {
		if (!Config::$logEnabled) {
			return;
		}

		if ($message instanceof Exception) {
			$context['errorCode'] = $message->getCode();
			$messageText = $message->getMessage();
		} elseif (is_array($message) || is_object($message)) {
			$messageText = print_r($message, true);
		} else {
			$messageText = (string)$message;
		}

		$prefix = trim($prefix);
		if ($prefix == '') {
			$prefix = ' - [DEFAULT] - ';
		} else {
			$prefix = ' - [' . $prefix . '] - ';
		}

		$logTime = date('d.m.Y H:i:s', time()) . ' - ';
		$messageText = $logTime . '[' . $level . ']' . $prefix . $messageText;
		if (count($context) > 0) {
			$messageText .= ' - ' . json_encode($context);
		}

		switch (Config::$logTarget) {
			case 'FILE':
				$logHandle = fopen(Config::$logFile, 'a');
				break;
			case 'STDOUT':
			default:
				$logHandle = fopen('php://stdout', 'w');
				break;
		}
		if ($logHandle === false) {
			exit('Error: cannot write logfile "' . Config::$logFile . '"');
		}

		fwrite($logHandle, $messageText . PHP_EOL);
		fclose($logHandle);
    }

    /**
     * Writes an info log message
     * @param string|array|Exception|object $message
     * @param string $prefix
     * @param array $context
     */
	public static function info ($message, $prefix = 'DEFAULT', $context = []) {
		$log = new self();
		$log->log($message, 'INFO', $prefix, $context);
	}

    /**
     * Writes a warning log message
     * @param string|array|Exception $message
     * @param string $prefix
     * @param array $context
     */
	public static function warn ($message, $prefix = 'DEFAULT', $context = []) {
		$log = new self();
		$log->log($message, 'WARN', $prefix, $context);
	}

    /**
     * Writes an error log message
     * @param string|array|Exception $message
     * @param string $prefix
     * @param array $context
     */
	public static function error ($message, $prefix = 'DEFAULT', $context = []) {
		$log = new self();
		$log->log($message, 'ERROR', $prefix, $context);
	}
}