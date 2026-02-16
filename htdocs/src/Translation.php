<?php

class Translation
{
    /** @var string */
    private $texts;

    /** @var Translation */
	private static $instance = NULL;

	/**
	 * @param string $language
	 */
	private function __construct($language) {
		if (!in_array($language, Config::$validLanguages)) {
			$language = Config::$validLanguages[0];
		}

		$t = [];
		require_once BASEPATH . '/translations/' . $language . '.php';
		$this->texts = $t;
    }

	private function __clone() {}

	/**
	 * @param string $language
	 * @return Translation
	 */
    public static function getInstance($language) {
        if (NULL === self::$instance) {
            self::$instance = new self($language);
        }
        return self::$instance;
    }

    /**
     * @param string $translationKey
     * @return string
     */
    public function get($translationKey) {
        if (!isset($this->texts[$translationKey])) {
            return '!!'.$translationKey.'!!';
        }
        return $this->texts[$translationKey];
    }
}