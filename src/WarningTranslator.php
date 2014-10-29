<?php namespace Tremby\WarningTranslator;

use Illuminate\Translation\Translator;
use Tremby\WarningTranslator\Exception\TranslationNotFoundException;
use Tremby\WarningTranslator\Exception\TranslationFellBackException;

class WarningTranslator extends Translator {

	/**
	 * Get the translation for the given key. Log a warning if we have to fall 
	 * back to the fallback locale and log an error if the fallback doesn't 
	 * exist either.
	 *
	 * @param  string  $key
	 * @param  array   $replace
	 * @param  string  $locale
	 * @return string
	 */
	public function get($key, array $replace = array(), $locale = null) {
		list($namespace, $group, $item) = $this->parseKey($key);

		$locales = $this->parseLocale($locale);
		$tried = array();
		foreach ($locales as $locale) {
			$this->load($namespace, $group, $locale);
			$line = $this->getLine(
				$namespace, $group, $locale, $item, $replace
			);
			if ($line !== null) {
				break;
			}
			$tried[] = $locale;
		}

		if ($line === null) {
			// Not found
			\Log::error(new TranslationNotFoundException($key, $tried));
			return $key;
		}

		if (count($tried)) {
			\Log::warning(new TranslationFellBackException($locale, $key, $tried));
		}

		return $line;
	}

}
