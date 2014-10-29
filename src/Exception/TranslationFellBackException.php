<?php namespace Tremby\WarningTranslator\Exception;

class TranslationFellBackException extends \Exception {

	public function __construct($locale, $key, $tried) {
		parent::__construct(
			"Fell back to $locale locale for translation key '$key' "
			. "(tried " . implode(", ", $tried) . ")"
		);
	}

}
