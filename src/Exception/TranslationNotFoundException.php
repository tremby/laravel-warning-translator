<?php namespace Tremby\WarningTranslator\Exception;

class TranslationNotFoundException extends \Exception {

	public function __construct($key, $tried) {
		parent::__construct(
			"No translation found in any locale for key '$key'; "
			. "rendering the key instead "
			. "(tried " . implode(", ", $tried) . ")"
		);
	}

}
